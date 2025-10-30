<?php

/**
 * Frontend link item.
 *
 * @since 0.1.0
 */

defined('ABSPATH') || exit;

use MAPDL\DiviAccountPageLite\Icon;

$default_endpoint = mapdl_get_default_endpoint();
$dashboard_url    = '';
if ('dashboard' !== $default_endpoint && 'dashboard' === $slug) {
	$dashboard_url = 'dashboard';
}
?>
<li class="<?php echo esc_attr(wc_get_account_menu_item_classes($slug)); ?>">
	<a href="<?php echo esc_url(wc_get_account_endpoint_url($slug) . $dashboard_url); ?>" data-endpoint="<?php echo esc_attr($slug); ?>">
		<?php echo esc_html($label); ?>
		<span class="divi_map-icon-wrap">
			<?php
			Icon::get_svg_icon($icon, true);
			?>
		</span>
	</a>
</li>
<?php
