<?php
/**
 * Tests for the dropdown navigation integration.
 *
 * @package snow-monkey-dropdown-navigation
 */

use Framework\Helper;
use Snow_Monkey\Plugin\DropdownNavigation\App\Controller\Front;

class Front_Test extends WP_UnitTestCase {

	/**
	 * The drawer template must be expanded before its markup is filtered.
	 */
	public function test_drawer_template_is_expanded() {
		$this->assertTrue(
			apply_filters(
				'inc2734_wp_view_controller_expand_get_template_part',
				false,
				array( 'slug' => 'template-parts/nav/drawer' )
			)
		);
	}

	/**
	 * Other templates must retain the caller's expansion setting.
	 */
	public function test_other_templates_preserve_expansion_setting() {
		$front = new Front();
		foreach ( array( false, true ) as $expand ) {
			$this->assertSame(
				$expand,
				$front->_expand_get_template_part(
					$expand,
					array( 'slug' => 'template-parts/header/site-branding' )
				)
			);
		}
	}

	/**
	 * Nested menus retain their content and accessibility attributes.
	 */
	public function test_nested_drawer_markup_becomes_dropdown_markup() {
		$html = '<nav id="drawer-nav" class="c-drawer"><button class="c-drawer__toggle" aria-expanded="false" aria-controls="submenu">Menu</button><ul id="submenu" class="c-drawer__submenu" aria-hidden="true"><li class="c-drawer__subitem"><a href="/child/">Child</a></li></ul></nav>';

		$this->assertSame(
			'<nav id="drawer-nav" class="c-dropdown"><button class="c-dropdown__toggle" aria-expanded="false" aria-controls="submenu">Menu</button><ul id="submenu" class="c-dropdown__submenu" aria-hidden="true"><li class="c-dropdown__subitem"><a href="/child/">Child</a></li></ul></nav>',
			apply_filters( 'snow_monkey_template_part_render_template-parts/nav/drawer', $html )
		);
	}

	/**
	 * Unrelated markup must remain intact.
	 */
	public function test_unrelated_markup_is_preserved() {
		$html = '<nav class="other-menu"><a href="/">Home</a></nav>';
		$this->assertSame( $html, apply_filters( 'snow_monkey_template_part_render_template-parts/nav/drawer', $html ) );
	}

	/**
	 * Dropdown navigation overrides the theme's drawer type setting.
	 */
	public function test_drawer_type_is_disabled() {
		$this->assertFalse( apply_filters( 'theme_mod_drawer-nav-type', 'overlay' ) );
	}

	/**
	 * The stylesheet depends on the active Snow Monkey stylesheet.
	 */
	public function test_stylesheet_is_enqueued_with_theme_dependency() {
		$front = new Front();
		$front->_wp_enqueue_scripts();
		$this->assertTrue( wp_style_is( 'snow-monkey-dropdown-navigation', 'enqueued' ) );
		$style = wp_styles()->registered['snow-monkey-dropdown-navigation'];
		$this->assertSame( array( Helper::get_main_style_handle() ), $style->deps );
		$this->assertSame( SNOW_MONKEY_DROPDOWN_NAVIGATION_URL . '/dist/css/app.css', $style->src );
	}

	/**
	 * The hamburger control follows the theme's position setting.
	 */
	public function test_hamburger_control_position() {
		foreach ( array( 'left', 'right' ) as $position ) {
			set_theme_mod( 'hamburger-btn-position', $position );
			ob_start();
			do_action( 'snow_monkey_prepend_drawer_nav' );
			$html = ob_get_clean();
			$this->assertStringContainsString( 'c-dropdown__controls', $html );
			if ( 'left' === $position ) {
				$this->assertStringContainsString( 'c-dropdown__controls--left', $html );
			} else {
				$this->assertStringNotContainsString( 'c-dropdown__controls--left', $html );
			}
		}
		remove_theme_mod( 'hamburger-btn-position' );
	}
}
