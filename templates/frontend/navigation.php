<?php

/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if (!defined('ABSPATH')) {
	exit;
}

do_action('mapdl_before_account_navigation');
?>


<nav class="<?php echo esc_attr($nav_class); ?>">

	<?php do_action('mapdl_before_account_items_list'); ?>
	<ul>
		<?php
		$items = mapdl_get_account_menu_items();
		foreach ($items as $slug => $label) {
			do_action("mapdl_myaccount_menu_item_{$slug}", $slug);
			do_action('mapdl_my_account_menu_item', $slug);
		}
		?>
	</ul>
	<?php do_action('mapdl_after_account_items_list'); ?>

</nav>
<?php
do_action('mapdl_after_account_navigation');
