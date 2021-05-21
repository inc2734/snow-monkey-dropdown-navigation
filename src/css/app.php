<?php
/**
 * @package snow-monkey-dropdown-navigation
 * @author inc2734
 * @license GPL-2.0+
 */

use Framework\Helper;
use Inc2734\WP_Customizer_Framework\Style;

if ( ! Helper::is_ie() ) {
	return;
}

$accent_color = get_theme_mod( 'accent-color' );
if ( ! $accent_color ) {
	return;
}

Style::register(
	'.c-dropdown',
	'background-color: ' . $accent_color
);

$sub_accent_color = get_theme_mod( 'sub-accent-color' );
if ( ! $sub_accent_color ) {
	return;
}

$drawer_nav_highlight_type = get_theme_mod( 'drawer-nav-highlight-type' );
if ( 'background-color' !== $drawer_nav_highlight_type ) {
	return;
}

Style::register(
	[
		'.c-dropdown--highlight-type-background-color .c-dropdown__item.sm-nav-menu-item-highlight',
		'.c-dropdown--highlight-type-background-color .c-dropdown__subitem.sm-nav-menu-item-highlight',
	],
	'background-color: ' . $sub_accent_color
);
