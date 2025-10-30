<?php
/* 
*   Endpoints ul 
*
*/

defined('ABSPATH') || exit;

?>
<div id="divi_map-endpoints">
    <div class="divi_map-endpoints-header">
        <h3>Manage Endpoints</h3>
        <button type="button" class="divi_map-button" data-type="endpoint">
            Add Endpoint
        </button>
    </div>
    <ul id="endpoints-ul">
        <?php
        foreach ($endpoints as $key => $endpoint) {
            //phpcs:ignore
            $type = $endpoint['type'];
            $label = $endpoint['label'];
            $enable = $endpoint['enable'];
            $slug = $endpoint['slug'];
            if ('endpoint' === $endpoint['type']) {
                require MAPDL_TEMPLATE_PATH_LITE . 'admin/endpoints/endpoint.php';
            } elseif ('link' === $endpoint['type']) {
                require MAPDL_TEMPLATE_PATH_LITE . 'admin/endpoints/link.php';
            }
        } ?>

    </ul>
</div>