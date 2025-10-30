<?php

/**
 * HTML template tags
 *

 */

use MAPDL\DiviAccountPageLite\Icon;

defined('ABSPATH') || exit;
?>
<template id='add-endpoint-template'>
    <div class="divi_map-dialog-input">
        <h3>%%flag%% Label</h3>
        <input type="text" name="%%flag%%">
        <p class="error"></p>
    </div>
    <div class="divi_map-dialog-action">
        <button type="button" class="divi_map-button" data-type="%%flag%%">OK</button>
    </div>
</template>
<template id="endpoint-li-template">
    <?php $endpoint = [
        'label'         => '%%label%%',
        'slug'          => '%%slug%%',
        'type'          => 'endpoint',
        'icon'          => '',
        'user_role'     => [],
        'enable'        => true,
        'before'        => [
            'id'        => '',
            'title'     => ''
        ],
        'content_enable' => true,
        'after'         => [
            'id'        => '',
            'title'     => ''
        ],
    ];
    $key = $endpoint['slug'];
    $label = $endpoint['label'];
    require MAPDL_TEMPLATE_PATH_LITE . 'admin/endpoints/endpoint.php';
    ?>
</template>