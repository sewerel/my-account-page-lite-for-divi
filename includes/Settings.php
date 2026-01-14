<?php

namespace MAPDL\DiviAccountPageLite;

defined('ABSPATH') || exit;

class Settings {

    private $tab = '';

    public function __construct() {
        $this->tab = isset($_GET['tab']) ? sanitize_text_field(wp_unslash($_GET['tab'])) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $this->init();
    }


    private function init() {
        $this->init_hooks();
    }
    private function init_hooks() {
        add_action('admin_menu', array($this, 'register_menu'));
        add_action('admin_init', array($this, 'register_setting'));
        add_action('mapdl_admin_tabs_menu', array($this, 'display_tabs'));
        add_action('mapdl_admin_tab_content', array($this, 'display_tab_content'));
    }
    public function register_menu() {
        $menu_title = apply_filters(
            'mapdl_menu_title',
            esc_html__('Divi MyAccount Page', 'my-account-page-lite-for-divi')
        );
        add_menu_page(
            $menu_title,
            $menu_title,
            'manage_options',
            'mapdl-account-page-settings',
            array($this, 'display_settings_page'),
            'dashicons-admin-settings'
        );
    }

    public function register_setting() {
        /**
         * This part of the code is left over of earlier implementation
         * it is not nesesery but will stay commented for now
         */
        // if (
        //     isset($_POST['_wpnonce'])
        // ) {
        //     $nonce = sanitize_text_field(wp_unslash($_POST['_wpnonce']));
        //     $valid = wp_verify_nonce($nonce, 'mapdl-options');
        // }



        register_setting(
            'mapdl',
            'mapdl_settings',
            array(
                'sanitize_callback' => array($this, 'process_settings'),
            )
        );

        register_setting(
            'mapdl',
            'mapdl_endpoints',
            array(
                'sanitize_callback' => array($this, 'process_endpoints'),
            )
        );
    }

    public function display_settings_page() {
        global $pagenow, $current_screen;

        $current = $current_screen->id;
        $selected_tab = !empty($this->tab) ? $this->tab : 'endpoints';

        if (
            'admin.php' !== $pagenow || 'toplevel_page_mapdl-account-page-settings' !== $current
        ) {
            return;
        }
        require_once MAPDL_TEMPLATE_PATH_LITE . 'admin/settings-form.php';

        // $endpoints = $this->get_endpoints();
        // $default_endpoints = MAPDL_LITE()->account_menu->get_default_endpoints();
    }
    public function display_tabs() {
        require_once MAPDL_TEMPLATE_PATH_LITE . 'admin/tabs.php';
    }
    public function display_tab_content() {
        $tab_selected = !empty($this->tab) ? $this->tab : 'endpoints';
        $settings     = $this->get_settings();
        $endpoints    = $this->get_endpoints();

        switch (true) {
            case 'endpoints' === $tab_selected:
                require_once MAPDL_TEMPLATE_PATH_LITE . 'admin/endpoints-tab.php';
                break;
            case 'settings' === $tab_selected:
                require_once MAPDL_TEMPLATE_PATH_LITE . 'admin/settings-tab.php';
                break;
            default:
                require_once MAPDL_TEMPLATE_PATH_LITE . 'admin/endpoints-tab.php';
        }
    }
    public function process_settings($settings) {

        // Bail early if the nonce verification fails.
        if (isset($_POST['_wpnonce'])) {
            $nonce = sanitize_text_field(wp_unslash($_POST['_wpnonce']));
            $valid = wp_verify_nonce($nonce, 'mapdl-options');
            if (false === $valid) {
                return;
            }
        }

        // Remove the customization as well.
        if (isset($_POST['mapdl_reset'])) {
            add_settings_error(
                'mapdl',
                'mapdl-reset-settings',
                esc_html__('Settings reset successfully.', 'my-account-page-lite-for-divi'),
                'success'
            );
            return false;
        }

        // Bail early with settings if the page is not settings.
        if (!isset($_POST['mapdl_page']) || 'settings' !== $_POST['mapdl_page']) {
            return MAPDL_LITE()->get_settings()->get_settings();
        }


        $settings = apply_filters('mapdl_before_process_settings', $settings);

        if (!\is_array($settings) || empty($settings)) {
            return MAPDL_LITE()->get_settings()->get_settings();
        }

        $settings['default_endpoint'] = !empty($settings['default_endpoint']) ? sanitize_title($settings['default_endpoint']) : '';

        $settings = apply_filters('mapdl_after_process_settings', $settings);

        add_settings_error(
            'mapdl',
            'mapdl_endpoints_saved',
            esc_html__('Settings saved successfully', 'my-account-page-lite-for-divi'),
            'success'
        );

        return $settings;
    }
    public function process_endpoints($endpoints) {

        // Bail early if the nonce is not set.
        if (!isset($_POST['_wpnonce'])) {
            add_settings_error(
                'mapdl',
                'mapdl_nonce_required',
                esc_html__('Nonce is required.', 'my-account-page-lite-for-divi')
            );
            return false;
        }

        // Bail early if the nonce verification fails.
        $nonce = sanitize_text_field(
            wp_unslash($_POST['_wpnonce'])
        );
        if (false === wp_verify_nonce($nonce, 'mapdl-options')) {
            add_settings_error(
                'mapdl',
                'mapdl_invalid-nonce',
                esc_html__('Invalid nonce.', 'my-account-page-lite-for-divi')
            );
            return false;
        }

        // Reset settings if the options is so.
        if (isset($_POST['mapdl_reset'])) {
            return false;
        }

        // Bail early with settings if the page is not settings.
        if (!isset($_POST['mapdl_page']) || 'endpoints' !== $_POST['mapdl_page']) {
            return MAPDL_LITE()->get_settings()->get_endpoints();
        }

        if (!\is_array($endpoints) || empty($endpoints)) {
            return MAPDL_LITE()->get_settings()->get_endpoints();
        }


        $endpoints         = apply_filters('mapdl_before_process_endpoints', $endpoints);
        $default_endpoints = MAPDL_LITE()->account_menu->get_default_endpoints();

        // Update the endpoints key to the slugs.
        foreach ($endpoints as $key => $endpoint) {

            $endpoints[$key]['enable'] = true;
            $endpoints[$key]['content_enable'] = true;

            if (isset($default_endpoints[$key])) {
                continue;
            }

            if ('endpoint' !== $endpoint['type']) {
                continue;
            }

            // Get slug.
            $slug = isset($endpoint['slug']) ? $endpoint['slug'] : '';
            $slug = empty($slug) ? $key : $slug;
            $slug = sanitize_title($slug);

            // No need to update the key if the slug and key of the endpoint are the same.
            if ($key === $slug) {
                continue;
            }

            $endpoints[$slug] = $endpoint;
            unset($endpoints[$key]);
        }


        // Set flag to flush the rewrite rules on next page load.
        update_option('mapdl_flush_rewrite', true);

        // Don't add endpoints saved message when the design customization reset is being performed.

        return apply_filters('mapdl_after_process_endpoints', $endpoints);
    }

    public function get_settings() {
        $settings = get_option('mapdl_settings');

        $settings = wp_parse_args(
            $settings,
            array(
                'default_endpoint' => 'dashboard',
            )
        );

        return apply_filters('mapdl_settings', $settings);
    }

    public function get_endpoints() {
        $endpoints         = get_option('mapdl_endpoints');
        $default_endpoints = MAPDL_LITE()->account_menu->get_default_endpoints();

        // Get default WooCommerce endpoints,if not endpoints are in database.
        if (empty($endpoints)) {
            $endpoints = array();
            foreach ($default_endpoints as $key => $endpoint) {
                $endpoints[$key] = mapdl_get_default_endpoint_options($endpoint);
            }
        } else {
            $flat_endpoints = mapdl_get_endpoints_flat($endpoints);
            $diff_endpoints = array_diff_key($default_endpoints, $flat_endpoints);
            if (!empty($diff_endpoints)) {
                foreach ($diff_endpoints as $key => $endpoint) {
                    $endpoints[$key] = mapdl_get_default_endpoint_options($endpoint);
                }
            }
        }

        foreach ($endpoints as $key => $endpoint) {
            if (isset($default_endpoints[$key])) {
                $endpoints[$key]['slug'] = '';
            } else {
                $endpoints[$key]['slug'] = $key;
            }
        }

        // Add default value to endpoints, link and group items.
        foreach ($endpoints as $key => $endpoint) {
            if ('endpoint' === $endpoint['type']) {
                $endpoints[$key] = wp_parse_args(
                    $endpoint,
                    mapdl_get_default_endpoint_options()
                );
            } elseif ('link' === $endpoint['type']) {
                $endpoints[$key] = wp_parse_args(
                    $endpoint,
                    mapdl_get_default_link_options()
                );
            }
        }

        return apply_filters('mapdl_get_endpoints', $endpoints);
    }
}
