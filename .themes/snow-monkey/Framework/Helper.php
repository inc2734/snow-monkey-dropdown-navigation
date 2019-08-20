<?php
/**
 * @package snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 * @version 7.2.0
 */

namespace Framework;

use Inc2734\Mimizuku_Core;

class Helper {

	use Mimizuku_Core\App\Contract\Helper\Helper;

	/**
	 * Return specific terms
	 *
	 * @param string $taxonomy
	 * @return array
	 */
	public static function get_terms( $taxonomy ) {
		$terms = wp_cache_get( 'snow-monkey-all-' . $taxonomy );
		if ( is_array( $terms ) ) {
			return $terms;
		}

		$terms = get_terms( [ $taxonomy ] );
		wp_cache_set( 'snow-monkey-all-' . $taxonomy, $terms );
		if ( is_array( $terms ) ) {
			return $terms;
		}

		return [];
	}
}
