<?php

if (!function_exists('mapdl_initialize_extension')) :
    /**
     * Creates the extension's main class instance.
     *
     * @since 1.0.0
     */
    function mapdl_initialize_extension() {
        require_once plugin_dir_path(__FILE__) . 'includes/DiviMyAccountModules.php';
    }
    add_action('divi_extensions_init', 'mapdl_initialize_extension');
endif;
