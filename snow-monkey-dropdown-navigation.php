<?php
/**
 * Plugin name: Snow Monkey Dropdown Navigation
 * Description: Activating this plug-in changes the drawer navigation to drop navigation.
 * Version: 0.1.0
 *
 * @package snow-monkey-dropdown-navigation
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\DropdownNavigation;

use Snow_Monkey\Plugin\DropdownNavigation\App\Controller;

define( 'SNOW_MONKEY_DROPDOWN_NAVIGATION_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'SNOW_MONKEY_DROPDOWN_NAVIGATION_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

class Bootstrap {

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, '_plugins_loaded' ] );
	}

	public function _plugins_loaded() {
		load_plugin_textdomain( 'snow-monkey-dropdown-navigation', false, basename( __DIR__ ) . '/languages' );

		add_action( 'init', [ $this, '_activate_autoupdate' ] );

		new Controller\Front();
		new Controller\Admin();
	}

	/**
	 * Activate auto update using GitHub
	 *
	 * @return void
	 */
	public function _activate_autoupdate() {
		new \Inc2734\WP_GitHub_Plugin_Updater\Bootstrap(
			plugin_basename( __FILE__ ),
			'inc2734',
			'snow-monkey-dropdown-navigation'
		);
	}
}

require_once( SNOW_MONKEY_DROPDOWN_NAVIGATION_PATH . '/vendor/autoload.php' );
new Bootstrap();
