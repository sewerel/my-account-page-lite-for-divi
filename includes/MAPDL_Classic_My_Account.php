<?php

/**
 * Singleton Class 
 * outputs my account Divi Module content:
 * changes few woocommerce hooks before output and reasign them afterwords
 * filers my-account.php only for the needs of the Module adding wrap for styling purposes
 */

class MAPDL_Classic_My_Account {

    protected static $instance = null;
    protected $is_running = false;

    protected  $woocommrece_hooks = [
        [
            'hook'     => 'woocommerce_account_navigation',
            'callback' => 'woocommerce_account_navigation',
            'priority' => 0
        ],
        [
            'hook'     => 'woocommerce_account_content',
            'callback' => 'woocommerce_output_all_notices',
            'priority' => 0
        ],
        [
            'hook'     => 'woocommerce_account_content',
            'callback' => 'woocommerce_account_content',
            'priority' => 0
        ]
    ];
    protected  $inner_hooks = [
        [
            'hook'     => 'woocommerce_account_navigation',
            'callback' => 'account_navigation',
            'priority' => 10
        ],
        [
            'hook'     => 'woocommerce_account_content',
            'callback' => 'account_content',
            'priority' => 10
        ],
        [
            'hook'     => 'mapdl_my_account_menu_item',
            'callback' => 'display_myaccount_menu_item',
            'priority' => 10
        ]
    ];

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct() {
    }




    public function init_hooks() {
        $this->is_running = true;
        foreach ($this->woocommrece_hooks as $key => &$value) {
            $priority = has_action($value['hook'], $value['callback']);
            if (false !== $priority) {
                remove_action($value['hook'], $value['callback'], $priority);
                $value['priority'] = $priority;
            }
        }
        foreach ($this->inner_hooks as $key => &$value) {
            add_action($value['hook'], [$this, $value['callback']], $value['priority']);
        }
        add_filter('wc_get_template', [$this, 'change_my_account_template'], 100, 5);
    }

    private function redo_hooks() {
        foreach ($this->woocommrece_hooks as $key => &$value) {
            add_action($value['hook'], $value['callback'], $value['priority']);
        }
        foreach ($this->inner_hooks as $key => &$value) {
            remove_action($value['hook'], [$this, $value['callback']], $value['priority']);
        }
        remove_filter('wc_get_template', [$this, 'change_my_account_template'], 100);
        $this->is_running = false;
    }
    function change_my_account_template($template, $template_name, $args, $template_path, $default_path) {
        if (strstr($template, 'my-account.php')) {
            return MAPDL_TEMPLATE_PATH_LITE . 'frontend/account.php';
        }
        return $template;
    }

    function account_navigation() {
        $settings = MAPDL_LITE()->get_settings()->get_settings();

        $settings['nav_class'] = array(
            'divi_map-woocommerce-MyAccount-navigation',
        );

        $settings['nav_class'] = apply_filters('mapdl_nav_class', $settings['nav_class']);
        $settings['nav_class'] = implode(' ', $settings['nav_class']);

        wc_get_template(
            'frontend/navigation.php',
            $settings,
            MAPDL_TEMPLATE_PATH_LITE,
            MAPDL_TEMPLATE_PATH_LITE
        );
    }

    function display_myaccount_menu_item($slug) {
        $endpoint = mapdl_get_endpoint($slug);

        if (
            false === $endpoint
        ) {
            return;
        }

        $account_menu_types = array(
            'endpoint',
            'link',
        );

        $type = $endpoint['type'];

        if (in_array($type, $account_menu_types, true)) {
            $endpoint['slug']  = $slug;
            $endpoint['label'] = $endpoint['label'];
            wc_get_template(
                "frontend/{$type}-item.php",
                $endpoint,
                MAPDL_TEMPLATE_PATH_LITE,
                MAPDL_TEMPLATE_PATH_LITE
            );
        }
    }

    function account_content() {
        global $wp;
        if (!empty($wp->query_vars)) {
            foreach ($wp->query_vars as $slug => $value) {

                // TODO: Inform the user that the following text cannot be used as slugs.
                if (in_array($slug, array('pagename', 'page', 'page_id', 'preview', 'dashboard'), true)) {
                    continue;
                }

                if (has_action('woocommerce_account_' . $slug . '_endpoint')) {
                    $filtered_slug = apply_filters('mapdl_before_endpoint_slug', $slug);
                    $endpoint = mapdl_get_endpoint($filtered_slug);
                    do_action('mapdl_before_endpoint_content', $endpoint);
                    if ($endpoint) {
                        do_action('woocommerce_account_' . $slug . '_endpoint', $value);
                    }
                    if (!$endpoint) {
                        echo '<div class="divi_map-endpoint-content">';
                        woocommerce_output_all_notices();
                        do_action('woocommerce_account_' . $slug . '_endpoint', $value);
                        echo '<div><!--!$endpoint => do_action -->';
                    }
                    do_action('mapdl_after_endpoint_content', $endpoint);
                    return;
                }
            }
        }
        // Maybe is a dashboart
        $default_endpoint = mapdl_get_default_endpoint();
        if (
            !isset($wp->query_vars['dashboard'])
            && has_action('woocommerce_account_' . $default_endpoint . '_endpoint')
        ) {
            $endpoint = mapdl_get_endpoint($default_endpoint);
            do_action('mapdl_before_endpoint_content', $default_endpoint);
            do_action('woocommerce_account_' . $default_endpoint . '_endpoint');
            do_action('mapdl_after_endpoint_content', $default_endpoint);
        } elseif (isset($wp->query_vars['dashboard']) || 'dashboard' === $default_endpoint) {
            do_action('mapdl_before_endpoint_content', $default_endpoint);
            mapdl_display_dashboard();
            do_action('mapdl_after_endpoint_content', $default_endpoint);
        } else {
            do_action('mapdl_before_endpoint_content', $default_endpoint);
            do_action('mapdl_after_endpoint_content', $default_endpoint);
            mapdl_display_account_content($default_endpoint);
        }
    }


    function my_account($endpoint = '') {
        global $wp, $wp_query;
        if ($this->is_running) {
            return '<div class="divi_map-layout-preview"><p>Classic Myaccount module cannot be displayed in itself. Plese use Endpoint Content Module!</p></div>';
        }
        if (!empty($endpoint)) {
            $wp->query_vars[$endpoint] = '';
            $wp_query->query[$endpoint] = '';
        }
        $this->init_hooks();
        $my_account = WC_Shortcodes::my_account([]);
        $this->redo_hooks();
        return $my_account;
    }
}
