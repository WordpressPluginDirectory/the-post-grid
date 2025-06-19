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
class StyleFilter {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [

			'filter_item_width' => [
				'label'          => esc_html__( 'Filter Item Width', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '600',
					'step' => '1',
				],
				
				'show_if'        => [
					'filter_type' => 'dropdown',
				],
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tpg_filter_style',
			],

			'filter_dropdown_align' => [
				'label'       => esc_html__( 'Dropdown Alignment', 'the-post-grid' ),
				'type'        => 'text_align',
				'default'     => 'left',
				'options'     => et_builder_get_text_orientation_options(),
				'show_if'     => [
					'filter_type' => 'dropdown',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],
			'filter_text_alignment' => [
				'label'       => esc_html__( 'Alignment', 'the-post-grid' ),
				'type'        => 'text_align',
				'default'     => 'left',
				'options'     => et_builder_get_text_orientation_options(),
				'show_if'     => [
					'filter_type'      => 'button',
					'filter_btn_style' => 'default',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],

			'filter_button_width' => [
				'label'          => esc_html__( 'Filter Width', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '1000',
					'step' => '1',
				],
				
				'show_if'        => [
					'filter_type'      => 'button',
					'filter_btn_style' => 'carousel',
				],
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tpg_filter_style',
			],

			'border_style' => [
				'label'       => esc_html__( 'Filter Border', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'disable',
				'options'     => [
					'disable' => esc_html__( 'Disable', 'the-post-grid' ),
					'enable'  => esc_html__( 'Enable', 'the-post-grid' ),
				],
				'show_if'     => [
					'filter_type'      => 'button',
					'filter_btn_style' => 'carousel',
				],
				'show_if_not' => [
					'section_title_style' => [ 'style2', 'style3' ],
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],

			'filter_btn_radius' => [
				'label'          => esc_html__( 'Border Radius', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '50',
					'step' => '1',
				],
				
				'show_if'        => [
					'filter_btn_style' => 'default',
				],
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tpg_filter_style',
			],

			'filter_color'       => [
				'label'       => esc_html__( 'Filter Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],
			'filter_color_hover' => [
				'label'       => esc_html__( 'Filter Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],

			'filter_bg_color'       => [
				'label'       => esc_html__( 'Filter Background Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],
			'filter_bg_color_hover' => [
				'label'       => esc_html__( 'Filter Background Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],

			'filter_border_color' => [
				'label'       => esc_html__( 'Filter Border Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],

			'filter_border_color_hover' => [
				'label'       => esc_html__( 'Filter Border Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],

			'filter_search_bg' => [
				'label'       => esc_html__( 'Search Background', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'show_search'      => 'on',
					'filter_btn_style' => 'default',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],

			'filter_search_bg_hover'  => [
				'label'       => esc_html__( 'Search Background:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'show_search'      => 'on',
					'filter_btn_style' => 'default',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],
			'sub_menu_bg_color'       => [
				'label'       => esc_html__( 'Submenu Background', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'filter_type' => 'dropdown',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],
			'sub_menu_bg_color_hover' => [
				'label'       => esc_html__( 'Submenu Background:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'filter_type' => 'dropdown',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],
			'sub_menu_color'          => [
				'label'       => esc_html__( 'Submenu Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'filter_type' => 'dropdown',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],
			'sub_menu_color_hover'    => [
				'label'       => esc_html__( 'Submenu Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'filter_type' => 'dropdown',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],

			'sub_menu_border_bottom'       => [
				'label'       => esc_html__( 'Submenu Border', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'filter_type' => 'dropdown',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],
			'sub_menu_border_bottom_hover' => [
				'label'       => esc_html__( 'Submenu Border:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'filter_type' => 'dropdown',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],

			'filter_nav_color'       => [
				'label'       => esc_html__( 'Filter Nav Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'filter_btn_style'     => 'carousel',
					'filter_next_prev_btn' => 'visible',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],
			'filter_nav_color_hover' => [
				'label'       => esc_html__( 'Filter Nav Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'filter_btn_style'     => 'carousel',
					'filter_next_prev_btn' => 'visible',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],
			'filter_nav_bg'          => [
				'label'       => esc_html__( 'Filter Nav Background', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'filter_btn_style'     => 'carousel',
					'filter_next_prev_btn' => 'visible',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],
			'filter_nav_bg_hover'    => [
				'label'       => esc_html__( 'Filter Nav Background:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'filter_btn_style'     => 'carousel',
					'filter_next_prev_btn' => 'visible',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],

			'filter_nav_border'       => [
				'label'       => esc_html__( 'Filter Nav Border', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'filter_btn_style'     => 'carousel',
					'filter_next_prev_btn' => 'visible',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],
			'filter_nav_border_hover' => [
				'label'       => esc_html__( 'Filter Nav Border:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'filter_btn_style'     => 'carousel',
					'filter_next_prev_btn' => 'visible',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_filter_style',
			],

		];

		return $divi_fields;
	}

}
