<?php

/**
 * Layout select modal
 *
 */

use MAPDL\DiviAccountPageLite\Icon;

defined('ABSPATH') || exit;
?>
<div id="divi_map-layouts-overlay">
    <div id="divi_map-layouts-window">
        <div id="divi_map-layouts-header">
            <input placeholder="Search" id="divi_map-layouts-search" type="text">
            <span class="heading"> in Divi Library</span>
            <span class="close" data-type="close"><?php Icon::get_svg_icon('times', true); ?></span>
        </div>
        <div id="divi_map-layouts-content">

        </div>
        <div id="divi_map-layouts-action">
            <button type="button" class="divi_map-button" data-type="layout">OK</button>
        </div>
    </div>
</div>