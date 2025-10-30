<?php

/**
 * Uninstall.php
 * Delete options created by the plugin
 */
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

delete_option('mapdl_flush_rewrite');
delete_option('mapdl_settings');
delete_option('mapdl_endpoints');
