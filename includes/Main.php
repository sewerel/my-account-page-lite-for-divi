<?php

namespace MAPDL\DiviAccountPageLite;

defined('ABSPATH') || exit;


final class Main {

    public $settings      = null;
    public $account_menu  = null;
    public $current_id     = null;
    public $current_endpoint  = null;
    public $current_endpoint_hash  = '';
    public $current_endpoint_check  = null;

    public $debug  = [];

    protected static $instance = null;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        $this->init_hooks();
    }
    private function init_hooks() {
        //add_action('init', [$this, 'init'], 0);
        //add_action('admin_init', array($this, 'deactivate_plugin'));
        $this->init();
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        add_action('admin_footer', array($this, 'admin_footer'));
    }


    public function init() {
        //$this->suffix = ((defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) || dmap_is_debug_enabled()) ? '' : '.min';

        // Before init action.
        do_action('mapdl_before_init');

        // Set up localization.
        //$this->load_plugin_textdomain();

        // Update the plugin version.
        //$this->update_plugin_version();

        // Load class instances.
        $this->settings      = new Settings();
        $this->account_menu = new AccountMenu();

        // After init action.
        do_action('mapdl_init');
    }
    public function get_settings() {
        return $this->settings;
    }

    public function enqueue_admin_scripts() {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if (!(isset($_GET['page']) && 'mapdl-account-page-settings' === $_GET['page'])) {
            return;
        }
        $roles = array();
        if (is_admin()) {
            $roles = \get_editable_roles();
            $roles = array_reduce(
                array_keys($roles),
                function ($result, $key) use ($roles) {
                    $result[] = array(
                        'id'   => $key,
                        'text' => $roles[$key]['name'],
                    );

                    return $result;
                },
                array()
            );
        }
        $diviLayouts = [];
        $posts = get_posts([
            'numberposts'  => -1,
            'post_type'    => 'et_pb_layout',
            'fields'       => ['post_title']
        ]);
        foreach ($posts as $divi) {
            $diviLayouts[] = [
                'id' => $divi->ID,
                'title' => $divi->post_title
            ];
        }

        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('mapdl_admin_script', MAPDL_URL_LITE . '/assets/js/admin.js', ['jquery-ui-accordion'], MAPDL_VERSION_LITE, true);
        wp_enqueue_script('select2');
        //wp_enqueue_script('jquery-ui-tooltip');
        wp_localize_script(
            'mapdl_admin_script',
            'mapdl_data',
            array(
                'ajaxURL'          => admin_url('admin-ajax.php'),
                'roles'            => $roles,
                'icons'            => Icon::get_svg_icons(),
                'diviLayouts'      => $diviLayouts
            )
        );
    }
    public function enqueue_admin_styles() {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if (!(isset($_GET['page']) && 'mapdl-account-page-settings' === $_GET['page'])) {
            return;
        }

        wp_enqueue_style('mapdl_admin_style', MAPDL_URL_LITE . '/assets/css/admin.css', [], MAPDL_VERSION_LITE);
    }
    public function admin_footer() {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if (!(isset($_GET['page']) && 'mapdl-account-page-settings' === $_GET['page'])) {
            return;
        }
        ob_start();
        require MAPDL_TEMPLATE_PATH_LITE . 'admin/dialogs/endpoint.php';
        require MAPDL_TEMPLATE_PATH_LITE . 'admin/dialogs/icons.php';
        require MAPDL_TEMPLATE_PATH_LITE . 'admin/dialogs/layouts.php';
        require MAPDL_TEMPLATE_PATH_LITE . 'admin/templates.php';
        // phpcs:ignore
        echo ob_get_clean();
    }
}
