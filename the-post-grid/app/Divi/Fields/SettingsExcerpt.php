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
class SettingsExcerpt {

	public static function get_fields( $prefix = 'grid' ) {

		$excerpt_type = [
			'character' => esc_html__( 'Character', 'the-post-grid' ),
			'word'      => esc_html__( 'Word', 'the-post-grid' ),
		];

		if ( in_array( $prefix, [ 'grid', 'list' ] ) ) {
			$excerpt_type['full'] = esc_html__( 'Full Content', 'the-post-grid' );
		}

		$default_excerpt_limit = 100;
		if ( 'grid' == $prefix ) {
			$default_excerpt_limit = 200;
		}

		$divi_fields = [
			'excerpt_type' => [
				'label'   => esc_html__( 'Excerpt Type', 'the-post-grid' ),
				'type'    => 'select',
				'default' => 'character',
				'options' => $excerpt_type,
				'show_if'     => [ 'show_excerpt' => 'on' ],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_excerpt',
			],

			'excerpt_limit' => [
				'label'     => esc_html__( 'Excerpt Limit', 'the-post-grid' ),
				'type'      => 'number',
				'step'      => 1,
				'default'   => $default_excerpt_limit,
				'show_if' => [
					'show_excerpt' => 'on',
					'excerpt_type' => [ 'character', 'word' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_excerpt',
			],

			'excerpt_more_text' => [
				'label'     => esc_html__( 'Expansion Indicator', 'the-post-grid' ),
				'type'      => 'text',
				'default'   => '...',
				'show_if' => [
					'show_excerpt' => 'on',
					'excerpt_type' => [ 'character', 'word' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_excerpt',
			],

		];

		return $divi_fields;
	}


}
