<?php

/**
 * My Account page
 */

defined('ABSPATH') || exit;
?>
<div class="divi_map-MyAccount-wrap">
    <?php do_action('woocommerce_account_navigation'); ?>

    <div class="woocommerce-MyAccount-content">
        <?php
        do_action('woocommerce_account_content');
        ?>
    </div><!-- woocommerce-MyAccount-content -->

</div><!--divi_map-MyAccount-wrap -->