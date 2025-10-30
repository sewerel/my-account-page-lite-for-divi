<?php

/**
 * Link template.
 *
 * Still not in use
 */

defined('ABSPATH') || exit;


?>
<li class="item">
	<h3><span class="handle">+</span><?php echo esc_html($label); ?></h3>
	<div>
		<input type="hidden" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][type]" value="<?php echo esc_attr($endpoint['type']); ?>" />
		<p>
		<h3>Enable Endpoint</h3><input type="checkbox" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][enable]" value="<?php echo esc_attr($endpoint['enable']); ?>" <?php echo $endpoint['enable'] ? 'checked' : ''; ?> /></p>
		<p>
		<h3>Endpoint Label</h3><input type="text" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][label]" value="<?php echo esc_attr($endpoint['label']); ?>" /></p>
		<?php if (isset($endpoint['slug'])) { ?>
			<h3>Endpoint Slug</h3><input type="text" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][slug]" value="<?php echo esc_attr($key); ?>" /></p>
		<?php } ?>
		<h3>URL</h3><input type="text" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][url]" value="<?php echo esc_attr($key); ?>" /></p>
		<h3>New tab?</h3>
		<input type="checkbox" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][new_tab]" <?php echo $endpoint['new_tab'] ? 'checked' : ''; ?>" /></p>
	</div>

</li>

<?php
