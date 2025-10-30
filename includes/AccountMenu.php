<?php

namespace MAPDL\DiviAccountPageLite;

defined('ABSPATH') || exit;

class AccountMenu {

    private $default_endpoints = array();


    public function __construct() {
        // Get WooCommerce My Account page ID
        $this->init();
    }


    private function init() {
        $this->init_hooks();
    }
    private function init_hooks() {
        add_action('init', array($this, 'init_default_endpoints'), 20);
        add_action('init', array($this, 'add_endpoints'), 21);
        add_action('init', array($this, 'flush_rewrite_rules'), 21);
        add_action('init', array($this, 'custom_endpoint_title'), 21);
        add_filter('woocommerce_get_endpoint_url', array($this, 'modify_endpoint_url'), PHP_INT_MAX, 4);
        add_filter('woocommerce_account_menu_item_classes', array($this, 'add_classes'), PHP_INT_MAX - 10, 2);
        //add_filter('woocommerce_get_query_vars', array($this, 'add_custom_query_vars'));
        add_filter('the_title', array($this, 'change_the_title'), 11);
    }
    public function init_default_endpoints() {

        if (!empty($this->default_endpoints)) {
            return;
        }

        $endpoints_slugs = array(
            'orders'          => get_option('woocommerce_myaccount_orders_endpoint', 'orders'),
            'downloads'       => get_option('woocommerce_myaccount_downloads_endpoint', 'downloads'),
            'edit-address'    => get_option('woocommerce_myaccount_edit_address_endpoint', 'edit-address'),
            'payment-methods' => get_option('woocommerce_myaccount_payment_methods_endpoint', 'payment-methods'),
            'edit-account'    => get_option('woocommerce_myaccount_edit_account_endpoint', 'edit-account'),
            'customer-logout' => get_option('woocommerce_logout_endpoint', 'customer-logout'),
        );

        $endpoints = array(
            'dashboard'       => __('Dashboard', 'my-account-page-lite-for-divi'),
            'orders'          => __('Orders', 'my-account-page-lite-for-divi'),
            'downloads'       => __('Downloads', 'my-account-page-lite-for-divi'),
            'edit-address'    => __('Addresses', 'my-account-page-lite-for-divi'),
            'payment-methods' => __('Payment Methods', 'my-account-page-lite-for-divi'),
            'edit-account'    => __('Account Details', 'my-account-page-lite-for-divi'),
            'customer-logout' => __('Logout', 'my-account-page-lite-for-divi'),
        );

        $mapdl_endpoints = apply_filters('woocommerce_account_menu_items', $endpoints, $endpoints_slugs);
        $endpoints      = array_merge($endpoints, is_array($mapdl_endpoints) ? $mapdl_endpoints : array());

        if (class_exists('WC_Memberships')) {
            $endpoints_slugs['members-area'] = wc_memberships_get_members_area_endpoint();
            $endpoints['members-area']       = __('Memberships', 'my-account-page-lite-for-divi');
        }

        if (class_exists('WC_Subscriptions')) {
            $endpoints_slugs['subscriptions'] = get_option('woocommerce_myaccount_subscriptions_endpoint', 'subscriptions');
            $endpoints['subscriptions']       = __('Subscriptions', 'my-account-page-lite-for-divi');
        }

        if (is_admin() && function_exists('wc_memberships_for_teams')) {
            $endpoints_slugs['teams'] = get_option('woocommerce_myaccount_teams_area_endpoint', 'teams');
            $endpoints['teams']       = __('Team', 'my-account-page-lite-for-divi');
        }

        $this->default_endpoints = apply_filters('mapdl_default_endpoints', $endpoints, $endpoints_slugs);
    }

    public function add_endpoints() {
        $endpoints = mapdl_get_endpoints_flat();

        $default_endpoint_slugs = MAPDL_LITE()->account_menu->get_default_endpoints();

        // Rewrite rule for endpoint.
        foreach ($endpoints as $slug => $endpoint) {
            if (
                !isset($default_endpoint_slugs[$slug])
            ) {
                $slug = !empty($endpoint['slug']) ? $endpoint['slug'] : $slug;
                add_rewrite_endpoint($slug, EP_ROOT | EP_PAGES);
            }
        }

        $default_endpoint = \mapdl_get_default_endpoint();
        if (
            'dashboard' !== $default_endpoint
        ) {
            add_rewrite_endpoint('dashboard', EP_ROOT | EP_PAGES);
        }
    }
    public function get_default_endpoints() {
        return apply_filters('mapdl_get_default_endpoints', $this->default_endpoints);
    }

    public function flush_rewrite_rules() {
        if (
            \get_option('mapdl_flush_rewrite')
        ) {
            //flush_rewrite_rules();
            // force rewrite rules to be recreated at the right time to avoid 404 errors
            \delete_option('rewrite_rules');


            \update_option('mapdl_flush_rewrite', false);
        }
    }

    public function custom_endpoint_title() {
        foreach (mapdl_get_endpoints_by_type('endpoint') as $slug => $endpoint) {
            add_filter(
                "woocommerce_endpoint_{$slug}_title",
                function ($title, $endpoint) {
                    $endpoint = \mapdl_get_endpoint($endpoint);

                    if (isset($endpoint['label'])) {
                        $title = $endpoint['label'];
                    }

                    return $title;
                },
                20,
                2
            );
        }
    }

    public function modify_endpoint_url($url, $endpoint, $value, $permalink) {
        // Compatible with WooCommerce Membership by SkyVerge.
        if (
            class_exists('WC_Memberships') && 'members-area' === $endpoint
        ) {
            $members_area_endpoint = wc_memberships_get_members_area_endpoint();
            $url                   = str_replace($endpoint, $members_area_endpoint, $url);
        }

        $link_url = mapdl_get_link_url($endpoint);
        if (
            !empty($link_url)
        ) {
            $url = $link_url;
        }

        return $url;
    }
    public function add_classes($classes, $endpoint) {
        global $wp_query;
        $query = $wp_query->query;

        if (isset($query[$endpoint])) {
            $classes[] = 'tab_selected';
        }

        // Set the tab selected and is-active for default endpoint set in the settings.
        if (
            isset($query['page']) && empty($query['page'])
            && mapdl_get_default_endpoint() === $endpoint
        ) {
            $classes[] = 'tab_selected';
        }

        // Remove the is-active for dashboard if it is not default endpoint.
        if (isset($query['page']) && empty($query['page']) && 'dashboard' === $endpoint) {
            $index = array_search('is-active', $classes, true);
            unset($classes[$index]);
        }
        if (in_array('is-active', $classes)) {
            $classes[] = 'tab_selected';
        }

        return apply_filters('mapdl_account_menu_item_classes', array_unique($classes), $endpoint);
    }
    public function add_custom_query_vars($query_vars) {
        $endpoints = \mapdl_get_endpoints_by_type('endpoint');
        $endpoints = array_keys($endpoints);
        $endpoints = array_reduce(
            $endpoints,
            function ($result, $endpoint) {
                $result[$endpoint] = $endpoint;
                return $result;
            },
            array()
        );

        return array_merge($endpoints, $query_vars);
    }

    public function change_the_title($title) {
        global $wp;

        if (
            'dashboard' !== mapdl_get_default_endpoint() || !in_the_loop() || !is_account_page()
        ) {
            return $title;
        }

        $default_endpoint = \mapdl_get_default_endpoint();
        $endpoint         = \mapdl_get_endpoint($default_endpoint);

        if (
            !isset($wp->query_vars['page'], $endpoint['label'])
        ) {
            return $title;
        }

        if (
            empty($endpoint['label'])
        ) {
            return $title;
        }

        // unhook after we've returned our title to prevent it from overriding others
        remove_filter('the_title', array($this, __FUNCTION__), 11);

        return $endpoint['label'];
    }

    public function custom_nav_menu_items($items) {
        $endpoints = mapdl_get_endpoints_flat();
        return wp_parse_args(
            array_reduce(
                array_keys($endpoints),
                function ($acc, $curr) use ($endpoints) {
                    if ($endpoints[$curr]['enable']) {
                        $acc[$curr] = $endpoints[$curr]['label'];
                    }
                    return $acc;
                },
                array()
            ),
            $items
        );
    }
}
