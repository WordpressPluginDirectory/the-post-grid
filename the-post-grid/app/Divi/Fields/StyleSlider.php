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
class StyleSlider {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [
			'arrow_font_size' => [
				'label'       => esc_html__( 'Arrow Font Size', 'the-post-grid' ),
				'type'        => 'range',
				'default'     => '24px',
				'range_settings' => [
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_slider_style',
			],

			'arrow_border_radius' => [
				'label'       => esc_html__( 'Arrow Radius', 'the-post-grid' ),
				'type'        => 'range',
				'default'     => '5px',
				'range_settings' => [
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_slider_style',
			],

			'arrow_width' => [
				'label'       => esc_html__( 'Arrow Width', 'the-post-grid' ),
				'type'        => 'range',
				'default'     => '40px',
				'range_settings' => [
					'min'  => 0,
					'max'  => 200,
					'step' => 1,
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_slider_style',
			],

			'arrow_height' => [
				'label'       => esc_html__( 'Arrow Height', 'the-post-grid' ),
				'type'        => 'range',
				'default'     => '40px',
				'range_settings' => [
					'min'  => 0,
					'max'  => 200,
					'step' => 1,
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_slider_style',
			],

			'arrow_x_position' => [
				'label'       => esc_html__( 'Arrow X Position', 'the-post-grid' ),
				'type'        => 'range',
				'default'     => '0px',
				'range_settings' => [
					'min'  => -300,
					'max'  => 300,
					'step' => 1,
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_slider_style',
			],

			'arrow_y_position' => [
				'label'       => esc_html__( 'Arrow Y Position', 'the-post-grid' ),
				'type'        => 'range',
				'default'     => '0px',
				'range_settings' => [
					'min'  => -150,
					'max'  => 500,
					'step' => 1,
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_slider_style',
			],

			'arrow_color' => [
				'label'       => esc_html__( 'Arrow Icon Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_slider_style',
			],

			'arrow_arrow_bg_color' => [
				'label'       => esc_html__( 'Arrow Background', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_slider_style',
			],

			'arrow_hover_color' => [
				'label'       => esc_html__( 'Arrow Icon Color - Hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_slider_style',
			],

			'arrow_bg_hover_color' => [
				'label'       => esc_html__( 'Arrow Background - Hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_slider_style',
			],

		];

		return $divi_fields;
	}

}
