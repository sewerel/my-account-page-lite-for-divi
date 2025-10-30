<?php

/**
 * Icon select modal
 *
 */

use MAPDL\DiviAccountPageLite\Icon;

defined('ABSPATH') || exit;
?>
<div id="divi_map-icons-overlay">
    <div id="divi_map-icons-window">
        <div id="divi_map-icons-header">
            <input placeholder="Search" id="divi_map-icons-search" type="text">
            <span class="selected-icon" data-type="selected-icon"></span>
            <span class="close" data-type="close"><?php Icon::get_svg_icon('times', true); ?></span>
        </div>
        <div id="divi_map-icons-content">

        </div>
        <div id="divi_map-icons-action">
            <button class="divi_map-button" data-type="icon">OK</button>
        </div>
    </div>
</div>