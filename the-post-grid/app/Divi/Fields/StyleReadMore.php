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
class StyleReadMore {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [
			'readmore_btn_alignment' => [
				'label'       => esc_html__( 'Alignment', 'the-post-grid' ),
				'type'        => 'text_align',
				'options'     => et_builder_get_text_orientation_options(),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_read_more_style',
			],

			'readmore_text_color'       => [
				'label'       => esc_html__( 'Text Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_read_more_style',
			],
			'readmore_text_color_hover' => [
				'label'       => esc_html__( 'Text Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_read_more_style',
			],
			'readmore_icon_color'       => [
				'label'       => esc_html__( 'Icon Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'show_if'     => [
					'show_btn_icon' => 'on',
				],
				'toggle_slug' => 'tpg_read_more_style',
			],
			'readmore_icon_color_hover' => [
				'label'       => esc_html__( 'Icon Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'show_btn_icon' => 'on',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_read_more_style',
			],
			'readmore_bg'               => [
				'label'       => esc_html__( 'Background Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_read_more_style',
			],
			'readmore_bg_hover'         => [
				'label'       => esc_html__( 'Background Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_read_more_style',
			],
		];

		return $divi_fields;
	}

}
