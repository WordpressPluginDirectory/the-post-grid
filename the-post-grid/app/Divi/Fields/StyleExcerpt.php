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
class StyleExcerpt {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [
			'content_alignment'    => [
				'label'       => esc_html__( 'Text Alignment', 'the-post-grid' ),
				'type'        => 'text_align',
				'default'     => 'left',
				'options'     => et_builder_get_text_orientation_options(),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_excerpt_style',
			],
			'excerpt_color'        => [
				'label'       => esc_html__( 'Excerpt color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_excerpt_style',
			],
			'excerpt_hover_color'  => [
				'label'       => esc_html__( 'Excerpt color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_excerpt_style',
			],
			'excerpt_border'       => [
				'label'       => esc_html__( 'Border color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'meta_position'     => 'default',
					$prefix . '_layout' => [ 'grid-layout3' ],
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_excerpt_style',
			],
			'excerpt_border_hover' => [
				'label'       => esc_html__( 'Border color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'meta_position'     => 'default',
					$prefix . '_layout' => [ 'grid-layout3' ],
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_excerpt_style',
			],

		];

		return $divi_fields;
	}

}
