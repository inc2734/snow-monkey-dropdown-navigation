<?php
/**
 * @package snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 * @version 7.0.0
 */

use Inc2734\Mimizuku_Core\Core;
use Framework\Helper;

/**
* Uses composer autoloader
*/
require_once( get_template_directory() . '/vendor/autoload.php' );

/**
 * Adjusted due to different directory structure in development and release
 */
spl_autoload_register(
	function( $class ) {
		if ( 0 !== strpos( $class, 'Framework\\' ) ) {
			return;
		}

		$class = str_replace( '\\', '/', $class );
		$file  = get_template_directory() . '/' . $class . '.php';
		if ( file_exists( $file ) ) {
			require_once( $file );
		}
	}
);
