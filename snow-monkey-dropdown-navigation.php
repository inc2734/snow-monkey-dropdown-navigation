<?php
/**
 * Plugin name: Snow Monkey Dropdown Navigation
 * Description: Activating this plug-in changes the drawer navigation to drop navigation.
 * Version: 1.0.0
 * Tested up to: 5.7
 * Requires at least: 5.5
 * Requires PHP: 5.6
 * Requires Snow Monkey: 14.3.0
 *
 * @package snow-monkey-dropdown-navigation
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\DropdownNavigation;

use Snow_Monkey\Plugin\DropdownNavigation\App\Controller;
use Inc2734\WP_GitHub_Plugin_Updater\Bootstrap as Updater;

define( 'SNOW_MONKEY_DROPDOWN_NAVIGATION_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'SNOW_MONKEY_DROPDOWN_NAVIGATION_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

class Bootstrap {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, '_plugins_loaded' ] );
	}

	/**
	 * Plugins loaded.
	 */
	public function _plugins_loaded() {
		load_plugin_textdomain( 'snow-monkey-dropdown-navigation', false, basename( __DIR__ ) . '/languages' );

		add_action( 'init', [ $this, '_activate_autoupdate' ] );

		$theme = wp_get_theme( get_template() );
		if ( 'snow-monkey' !== $theme->template && 'snow-monkey/resources' !== $theme->template ) {
			add_action(
				'admin_notices',
				function() {
					?>
					<div class="notice notice-warning is-dismissible">
						<p>
							<?php esc_html_e( '[Snow Monkey Dropdown Navigation] Needs the Snow Monkey.', 'snow-monkey-dropdown-navigation' ); ?>
						</p>
					</div>
					<?php
				}
			);
			return;
		}

		$data = get_file_data(
			__FILE__,
			[
				'RequiresSnowMonkey' => 'Requires Snow Monkey',
			]
		);

		if (
			isset( $data['RequiresSnowMonkey'] ) &&
			version_compare( $theme->get( 'Version' ), $data['RequiresSnowMonkey'], '<' )
		) {
			add_action(
				'admin_notices',
				function() use ( $data ) {
					?>
					<div class="notice notice-warning is-dismissible">
						<p>
							<?php
							echo esc_html(
								sprintf(
									// translators: %1$s: version
									__(
										'[Snow Monkey Dropdown Navigation] Needs the Snow Monkey %1$s or more.',
										'snow-monkey-dropdown-navigation'
									),
									'v' . $data['RequiresSnowMonkey']
								)
							);
							?>
						</p>
					</div>
					<?php
				}
			);
			return;
		}

		add_action(
			'after_setup_theme',
			function() {
				new Controller\Front();
			}
		);
	}

	/**
	 * Activate auto update using GitHub
	 *
	 * @return void
	 */
	public function _activate_autoupdate() {
		new Updater(
			plugin_basename( __FILE__ ),
			'inc2734',
			'snow-monkey-dropdown-navigation',
			[
				'homepage' => 'https://snow-monkey.2inc.org',
			]
		);
	}
}

require_once( SNOW_MONKEY_DROPDOWN_NAVIGATION_PATH . '/vendor/autoload.php' );
new Bootstrap();
