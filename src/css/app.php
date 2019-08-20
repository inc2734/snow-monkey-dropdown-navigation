<?php
/**
 * @package snow-monkey-dropdown-navigation
 * @author inc2734
 * @license GPL-2.0+
 */

use Inc2734\WP_Customizer_Framework\Style;

$accent_color = get_theme_mod( 'accent-color' );

Style::register(
	'.c-dropdown',
	'background-color: ' . $accent_color
);
