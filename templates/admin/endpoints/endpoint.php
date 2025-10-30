<?php

/**
 * Endpoint template.
 *
 * @since 0.1.0
 */

use MAPDL\DiviAccountPageLite\Icon;

defined('ABSPATH') || exit;


?>
<li class="endpoints-li">
	<h3><span class="handle"><?php Icon::get_svg_icon('sort', true); ?></span><?php echo esc_html($label); ?></h3>
	<div class="endpoints-content">
		<input type="hidden" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][type]" value="<?php echo esc_attr($endpoint['type']); ?>" />
		<?php if (!empty($endpoint['slug'])) { ?>
			<div class="divi_map-control-box">
				<div class="divi_map-control-box-title">
					<h3>Delete Endpoint</h3>
				</div>
				<div class="divi_map-control-box-control">
					<button class="divi_map-button danger small" type="button" data-type="endpoint-remove">Delete</button>
				</div>
			</div>
		<?php } ?>
		<div class="divi_map-control-box pro-feature">
			<div class="divi_map-control-box-title">
				<h3>Enable Endpoint</h3>
			</div>
			<div class="divi_map-control-box-control">

				<input class="enable-disable-checkbox" type="checkbox" id="mapdl_endpoints[<?php echo esc_attr($key); ?>][enable]" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][enable]" <?php checked($endpoint['enable']); ?> value="1" />
				<label for="mapdl_endpoints[<?php echo esc_attr($key); ?>][enable]" class="enable-disable-label">
					<span class="enable-disable-on">Enable</span>
					<span class="enable-disable-slide"></span>
					<span class="enable-disable-off">Disable</span>
				</label>
			</div>
		</div>
		<div class="divi_map-control-box">
			<div class="divi_map-control-box-title">
				<h3>Endpoint Label</h3>
			</div>
			<div class="divi_map-control-box-control">
				<input type="text" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][label]" value="<?php echo esc_attr($endpoint['label']); ?>" />
			</div>
		</div>
		<?php if (!empty($endpoint['slug'])) { ?>
			<div class="divi_map-control-box pro-feature">
				<div class="divi_map-control-box-title">
					<h3>Endpoint Slug</h3>
				</div>
				<div class="divi_map-control-box-control">
					<input type="text" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][slug]" value="<?php echo esc_attr($key); ?>" />
				</div>
			</div>
		<?php } ?>
		<div class="divi_map-control-box">
			<div class="divi_map-control-box-title">
				<h3>Select Icon</h3>
			</div>
			<div class="divi_map-control-box-control">
				<div class="divi_map-aligner">
					<input type="hidden" class="" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][icon]" value="<?php echo esc_attr($endpoint['icon']); ?>">
					<span class="divi_map-icon-preview"><?php Icon::get_svg_icon($endpoint['icon'], true); ?></span>
					<button type="button" class="divi_map-button small" data-type="icon-select">Select</button>
					<button type="button" class="divi_map-button small danger" data-type="icon-remove"><?php Icon::get_svg_icon('times', true); ?></button>
				</div>
			</div>
		</div>
		<div class="divi_map-control-box pro-feature">
			<div class="divi_map-control-box-title">
				<h3>User Roles</h3>
			</div>
			<div class="divi_map-control-box-control">
				<select multiple data-selected="<?php echo esc_attr(wp_json_encode($endpoint['user_role'])); ?>" class="divi_map-select" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][user_role][]">
				</select>
			</div>
		</div>
		<div class="divi_map-control-box pro-feature">
			<div class="divi_map-control-box-title">
				<h3>Before content</h3>
			</div>
			<div class="divi_map-control-box-control">
				<input type="hidden" value="<?php echo esc_attr($endpoint['before']['title']); ?>" name=" mapdl_endpoints[<?php echo esc_attr($key); ?>][before][title]" value="<?php echo esc_attr($endpoint['before']['title']); ?>" />
				<input type="hidden" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][before][id]" value="<?php echo esc_attr($endpoint['before']['id']); ?>" />
				<button type="button" class="divi_map-button small" data-type="layout-select">Select</button>
				<button type="button" class="divi_map-button small danger" data-type="layout-remove"><?php Icon::get_svg_icon('times', true); ?></button>
				<div class="divi_map-layout-preview"><?php echo esc_attr($endpoint['before']['title']); ?></div>
			</div>
		</div>
		<div class="divi_map-control-box pro-feature">
			<div class="divi_map-control-box-title">
				<h3>Enable Endpoint Content</h3>
			</div>
			<div class="divi_map-control-box-control">

				<input class="enable-disable-checkbox" type="checkbox" id="mapdl_endpoints[<?php echo esc_attr($key); ?>][content_enable]" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][content_enable]" <?php checked($endpoint['content_enable']); ?> value="1" />
				<label for="mapdl_endpoints[<?php echo esc_attr($key); ?>][content_enable]" class="enable-disable-label">
					<span class="enable-disable-on">Enable</span>
					<span class="enable-disable-slide"></span>
					<span class="enable-disable-off">Disable</span>
				</label>
			</div>
		</div>
		<div class="divi_map-control-box pro-feature">
			<div class="divi_map-control-box-title">
				<h3>After content</h3>
			</div>
			<div class="divi_map-control-box-control">
				<input type="hidden" name=" mapdl_endpoints[<?php echo esc_attr($key); ?>][after][title]" value="<?php echo esc_attr($endpoint['after']['title']); ?>" />
				<input type="hidden" name="mapdl_endpoints[<?php echo esc_attr($key); ?>][after][id]" value="<?php echo esc_attr($endpoint['after']['id']); ?>" />
				<button type="button" class="divi_map-button small" data-type="layout-select">Select</button>
				<button type="button" class="divi_map-button small danger" data-type="layout-remove"><?php Icon::get_svg_icon('times', true); ?></button>
				<div class="divi_map-layout-preview"><?php echo esc_attr($endpoint['after']['title']); ?></div>
			</div>
		</div>
</li>