<?php
/* 
*   Settings tab
*
*/

defined('ABSPATH') || exit;

?>

<div id="divi_map-endpoints">
    <div class="divi_map-endpoints-header">
        <h3>Manage Settings</h3>
    </div>
    <div class="divi_map-settings-container">
        <div class="divi_map-control-box">
            <div class="divi_map-control-box-title">
                <h3>Default Endpoint</h3>
            </div>
            <div class="divi_map-control-box-control">

                <select name="mapdl_settings[default_endpoint]">
                    <?php
                    foreach (mapdl_get_endpoints_by_type('endpoint') as $endpoint_key => $endpoint) {
                        $selected = selected($endpoint_key, $settings['default_endpoint'], false);
                        printf(
                            '<option %s value=%s>%s</option>',
                            esc_attr($selected),
                            esc_attr($endpoint_key),
                            esc_html($endpoint['label'])
                        );
                    }
                    ?>
                </select>
            </div>
        </div>

    </div>
</div>