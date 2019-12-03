<?php
/**
 * @package snow-monkey-dropdown-navigation
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\DropdownNavigation\App\Controller;

use Framework\Helper;

class Front {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, '_wp_enqueue_scripts' ] );
		add_action( 'inc2734_wp_customizer_framework_load_styles', [ $this, '_load_styles' ], 11 );
		add_filter( 'snow_monkey_template_part_render', [ $this, '_snow_monkey_template_part_render' ], 10, 2 );
		add_action( 'snow_monkey_prepend_drawer_nav', [ $this, '_add_hamburger_btn' ] );
	}

	/**
	 * Enqueue assets
	 *
	 * @return void
	 */
	public function _wp_enqueue_scripts() {
		wp_enqueue_style(
			'snow-monkey-dropdown-navigation',
			SNOW_MONKEY_DROPDOWN_NAVIGATION_URL . '/dist/css/app.css',
			[ Helper::get_main_style_handle() ],
			filemtime( SNOW_MONKEY_DROPDOWN_NAVIGATION_PATH . '/dist/css/app.css' )
		);
	}

	/**
	 * Load PHP files for styles
	 *
	 * @return void
	 */
	public function _load_styles() {
		Helper::include_files( SNOW_MONKEY_DROPDOWN_NAVIGATION_PATH . '/dist/css' );
	}

	/**
	 * .c-drawer to .c-dropdown
	 *
	 * @param string $html
	 * @param string $slug
	 * @return string
	 */
	public function _snow_monkey_template_part_render( $html, $slug ) {
		if ( 'template-parts/nav/drawer' !== $slug ) {
			return $html;
		}

		$html = str_replace( 'c-drawer', 'c-dropdown', $html );
		return $html;
	}

	/**
	 * Add hamburger btn to .c-dropdown
	 *
	 * @return void
	 */
	public function _add_hamburger_btn() {
		?>
		<ul class="c-dropdown__menu">
			<li class="c-dropdown__item u-text-right">
				<?php \Framework\Helper::get_template_part( 'template-parts/header/hamburger-btn' ); ?>
			</li>
		</ul>
		<?php
	}
}
