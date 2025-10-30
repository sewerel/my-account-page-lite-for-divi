<?php
class DICM_DiviMyAccountModules extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'divi-my-account-modules';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'divi-my-account-modules';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.1';

	/**
	 * DICM_DiviMyAccountModules constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct($name = 'divi-my-account-modules', $args = array()) {
		$this->plugin_dir              = plugin_dir_path(__FILE__);
		$this->plugin_dir_url          =  MAPDL_URL_LITE . '/divi-my-account-modules/';

		parent::__construct($name, $args);
	}
}

new DICM_DiviMyAccountModules;
