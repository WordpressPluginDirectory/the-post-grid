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
class StylePagination {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [

			'pagination_text_align'    => [
				'label'       => esc_html__( 'Alignment', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'center',
				'options'     => [
					'flex-start' => esc_html__( 'Left', 'the-post-grid' ),
					'center'     => esc_html__( 'Center', 'the-post-grid' ),
					'flex-end'   => esc_html__( 'Right', 'the-post-grid' ),
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_pagination_style',
			],

			'pagination_border_radius' => [
				'label'          => esc_html__( 'Border Radius', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				],
				
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tpg_pagination_style',
			],

			'pagination_margin_top' => [
				'label'          => esc_html__( 'Margin Top', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '300',
					'step' => '1',
				],
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tpg_pagination_style',
			],

			'pagination_color'        => [
				'label'       => esc_html__( 'Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_pagination_style',
			],
			'pagination_color_hover'  => [
				'label'       => esc_html__( 'Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_pagination_style',
			],
			'pagination_color_active' => [
				'label'       => esc_html__( ' Color:active', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_pagination_style',
			],
			'pagination_bg'           => [
				'label'       => esc_html__( 'Background Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_pagination_style',
			],
			'pagination_bg_hover'     => [
				'label'       => esc_html__( 'Background Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_pagination_style',
			],

			'pagination_bg_active' => [
				'label'       => esc_html__( 'Background Color:active', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_pagination_style',
			],

			'pagination_border_color'       => [
				'label'       => esc_html__( 'Border Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_pagination_style',
			],
			'pagination_border_color_hover' => [
				'label'       => esc_html__( 'Border Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_pagination_style',
			],
		];

		return $divi_fields;
	}

}
