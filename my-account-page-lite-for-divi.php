<?php

/**
 * Plugin Name:My Account Page Lite for Divi
 * Plugin URI: https://powdithemes.com/divi-my-account-page-lite/
 * Description: Adds custom endpoints to the WooCommerce My Account page.Supports renaming, reordering, and adding menu icons. Fully compatible with the Divi Builder for a seamless design experience.
 * Author: PowdiThemes
 * Author URI: https://powdithemes.com
 * Version: 1.0.2
 * Text Domain: my-account-page-lite-for-divi
 * Requires at least: 5.2
 * Requires PHP: 7.4
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

use MAPDL\DiviAccountPageLite\Main;

defined('ABSPATH') || exit;

// This plugin uses MAPDL and mapdl as prefix to avoid conflicts with other plugins

if (!defined('MAPDL_URL_LITE')) {
    define('MAPDL_URL_LITE', plugin_dir_url(__FILE__));
}
if (!defined('MAPDL_PLUGIN_DIR_LITE')) {
    define('MAPDL_PLUGIN_DIR_LITE', __DIR__);
}
if (!defined('MAPDL_TEMPLATE_PATH_LITE')) {
    define('MAPDL_TEMPLATE_PATH_LITE', MAPDL_PLUGIN_DIR_LITE . '/templates/');
}

if (!defined('MAPDL_VERSION_LITE')) {
    define('MAPDL_VERSION_LITE', '1.0.2');


    foreach (glob(__DIR__ . "/includes/*.php") as $filename) {
        include_once $filename;
    }

    function MAPDL_LITE() {
        return Main::instance();
    }

    add_action('woocommerce_init', function () {
        if (defined('DIVI_MAP_VERSION')) {
            return;
        }
        if (file_exists(MAPDL_PLUGIN_DIR_LITE . '/divi-my-account-modules/divi-my-account-modules.php')) {
            include_once MAPDL_PLUGIN_DIR_LITE . '/divi-my-account-modules/divi-my-account-modules.php';
        }
        MAPDL_LITE();
    });
}
