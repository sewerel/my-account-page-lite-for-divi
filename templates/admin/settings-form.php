<?php
/* 
*   Settings page 
*
*/

defined('ABSPATH') || exit;

?>
<div id="divi_map-panel">
    <form method="post" action="options.php" id="divi_map-customization-form">
        <input type="hidden" name="mapdl_page" value="<?php echo esc_attr($selected_tab); ?>" />
        <?php
        /**
         * Nonces, actions and referrers.
         */
        settings_fields('mapdl');
        ?>
        <div id="divi_map-top-header">
            <button type="submit" name="submit" class="divi_map-button">
                Save Changes
            </button>
            <button type="button" class="divi_map-button danger" data-type="reset">
                Reset
            </button>
        </div>
        <div id="divi_map-header">
            <h1><?php echo esc_html(apply_filters('mapdl_menu_title', 'Divi Myaccount Page')); ?></h1>
        </div>
        <div id="divi_map-tabs" data-tab="<?php echo esc_attr($selected_tab) ?>">
            <?php do_action('mapdl_admin_tabs_menu'); ?>
            <?php do_action('mapdl_admin_tab_content'); ?>
        </div>
        <p>
            <button type="submit" name="submit" class="divi_map-button">
                <?php esc_html_e('Save Changes', 'my-account-page-lite-for-divi'); ?>
            </button>
        </p>
    </form>
</div>