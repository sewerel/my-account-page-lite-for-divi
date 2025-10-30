<?php
/* 
*   Admin tabs menu 
*
*/

defined('ABSPATH') || exit;

?>
<ul id="divi_map-tabs-menu">
    <li class="endpoints">
        <a href="<?php echo esc_attr(admin_url('admin.php?page=mapdl-account-page-settings')); ?>">Endpoints</a>
    </li>
    <li class="settings">
        <a href="<?php echo esc_attr(admin_url('admin.php?page=mapdl-account-page-settings&tab=settings')); ?>">Settings</a>
    </li>
</ul>