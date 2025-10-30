<?php

/**
 * Frontend link item.
 *
 * @since 0.1.0
 */


defined('ABSPATH') || exit;



$target = $new_tab ? ' target="_blank"' : '';
?>
<li class="<?php echo esc_attr(wc_get_account_menu_item_classes($slug)); ?>">
	<a href="<?php echo esc_url(wc_get_account_endpoint_url($slug)); ?>" data-endpoint="<?php echo esc_attr($slug); ?>" <?php echo esc_attr($target); ?>>
		<?php echo esc_html($label); ?>

		<?php
		// if ( tgwc_is_endpoint_icon_enabled() ) {
		// 	$icon = str_replace( 'fas fa-', '', $icon );
		// 	Icon::get_svg_icon( $icon, true );
		// }
		?>
	</a>
</li>
<?php
