<?php
/**
 * @package snow-monkey-dropdown-navigation
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\DropdownNavigation\App\Controller;

use Framework\Helper;

class Front {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, '_wp_enqueue_scripts' ] );
		add_action( 'inc2734_wp_customizer_framework_load_styles', [ $this, '_load_styles' ], 11 );
		add_filter( 'snow_monkey_template_part_render_template-parts/nav/drawer', [ $this, '_template_part_render' ] );
		add_action( 'snow_monkey_prepend_drawer_nav', [ $this, '_add_hamburger_btn' ] );
		add_action( 'theme_mod_drawer-nav-type', '__return_false' );
	}

	/**
	 * Enqueue assets.
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
	 * Load PHP files for styles.
	 *
	 * @return void
	 */
	public function _load_styles() {
		Helper::include_files( SNOW_MONKEY_DROPDOWN_NAVIGATION_PATH . '/dist/css' );
	}

	/**
	 * .c-drawer to .c-dropdown
	 *
	 * @param string $html The template HTML.
	 * @return string
	 */
	public function _template_part_render( $html ) {
		return str_replace( 'c-drawer', 'c-dropdown', $html );
	}

	/**
	 * Add hamburger btn to .c-dropdown.
	 *
	 * @return void
	 */
	public function _add_hamburger_btn() {
		$hamburger_btn_position = get_theme_mod( 'hamburger-btn-position' );
		$classes                = array_filter(
			[
				'c-dropdown__controls',
				'left' === $hamburger_btn_position ? 'c-dropdown__controls--left' : '',
			],
			'strlen'
		);
		?>
		<div class="<?php echo esc_attr( join( ' ', $classes ) ); ?>">
			<div class="c-drawer__control">
				<?php Helper::get_template_part( 'template-parts/header/hamburger-btn' ); ?>
			</div>
		</div>
		<?php
	}
}
