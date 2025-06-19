<?php
/**
 * Divi Helper Class
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Divi\Fields;


use RT\ThePostGrid\Helpers\Fns;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Divi Helper Class
 */
class ZComponent {

	public static function get_fields( $prefix = 'grid' ) {

		$divi_fields = [
			'test26' => [

				'tab_slug'    => 'general',
				'toggle_slug' => 'filter',
			],
			'test24' => [

				'tab_slug'    => 'general',
				'toggle_slug' => 'filter',
			],

		];

		$divi_fields_ex = [
			'test26' => [

				'tab_slug'    => 'general',
				'toggle_slug' => 'filter',
			],
			'test24' => [

				'tab_slug'    => 'general',
				'toggle_slug' => 'filter',
			],
		];

		return $divi_fields;
	}


}
