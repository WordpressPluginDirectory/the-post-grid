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
class ContentLayout {

	public static function get_fields( $prefix = 'grid' ) {
		$column_options = [
			'0'  => esc_html__( 'Default from layout', 'the-post-grid' ),
			'12' => esc_html__( '1 Columns', 'the-post-grid' ),
			'6'  => esc_html__( '2 Columns', 'the-post-grid' ),
			'4'  => esc_html__( '3 Columns', 'the-post-grid' ),
			'3'  => esc_html__( '4 Columns', 'the-post-grid' ),
		];

		$conditions_map = [
			'grid'       => [
				'grid_layout' => [ 'grid-layout5', 'grid-layout5-2', 'grid-layout6', 'grid-layout6-2' ],
			],
			'grid_hover' => [
				'grid_hover_layout' => [ 'grid_hover-layout8' ],
			],
		];

		$grid_column_condition = $conditions_map[ $prefix ] ?? [];

		if ( 'slider' === $prefix ) {
			$column_options        = [
				'0' => esc_html__( 'Default from layout', 'the-post-grid' ),
				'1' => esc_html__( '1 Columns', 'the-post-grid' ),
				'2' => esc_html__( '2 Columns', 'the-post-grid' ),
				'3' => esc_html__( '3 Columns', 'the-post-grid' ),
				'4' => esc_html__( '4 Columns', 'the-post-grid' ),
				'5' => esc_html__( '5 Columns', 'the-post-grid' ),
				'6' => esc_html__( '6 Columns', 'the-post-grid' ),
			];
			$grid_column_condition = [
				'slider_layout' => [ 'slider-layout10', 'slider-layout11', 'slider-layout13' ],
			];
		}

		if ( 'list' === $prefix ) {
			$column_options        = [
				'0'  => esc_html__( 'Default from layout', 'the-post-grid' ),
				'12' => esc_html__( '1 Columns', 'the-post-grid' ),
				'6'  => esc_html__( '2 Columns', 'the-post-grid' ),
				'4'  => esc_html__( '3 Columns', 'the-post-grid' ),
				'3'  => esc_html__( '4 Columns', 'the-post-grid' ),
			];
			$grid_column_condition = [
				'list_layout' => [ 'list-layout2', 'list-layout2-2', 'list-layout3', 'list-layout3-2', 'list-layout4' ],
			];
		}

		$divi_fields = [
			$prefix . '_layout' => [
				'label'       => esc_html__( 'Choose Layout', 'rtcl-divi-addons' ),
				'type'        => 'select',
				'options'     => self::layout_options( $prefix ),
				'default'     => $prefix . '-layout1',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_layout',
			],

			'offset_img_position' => [
				'label'       => esc_html__( 'Offset Image Position', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'image-left',
				'options'     => [
					'image-left'  => esc_html__( 'Left (Default)', 'the-post-grid' ),
					'image-right' => esc_html__( 'Right', 'the-post-grid' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_layout',
				'show_if'     => [
					'grid_layout' => [
						'grid-layout5',
						'grid-layout5-2',
						'list-layout2',
						'list-layout2-2',
						'list-layout3',
						'list-layout3-2',
					],
				],
			],

			'middle_border' => [
				'label'       => esc_html__( 'Middle Border?', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'yes',
				'options'     => [
					'yes' => esc_html__( 'Yes', 'the-post-grid' ),
					'no'  => esc_html__( 'No', 'the-post-grid' ),
				],
				'show_if'     => [
					'grid_layout' => [ 'grid-layout6', 'grid-layout6-2' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_layout',
			],

			'grid_column' => [
				'label'       => esc_html__( 'Column — desktop', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => $column_options,
				'default'     => '',
				'description' => esc_html__( 'Choose Column for Desktop.', 'the-post-grid' ),
				'show_if_not' => $grid_column_condition,
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_layout',
			],

			'grid_column_tab' => [
				'label'       => esc_html__( 'Column — tablet', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => $column_options,
				'default'     => '',
				'description' => esc_html__( 'Choose Column for tablet.', 'the-post-grid' ),
				'show_if_not' => $grid_column_condition,
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_layout',
			],

			'grid_column_mobile'          => [
				'label'       => esc_html__( 'Column — Mobile', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => $column_options,
				'default'     => '',
				'description' => esc_html__( 'Choose Column for mobile.', 'the-post-grid' ),
				'show_if_not' => $grid_column_condition,
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_layout',
			],
		];

		$layout_style_opt = [
			'tpg-even'        => esc_html__( 'Grid', 'the-post-grid' ),
			'tpg-full-height' => esc_html__( 'Grid Equal Height', 'the-post-grid' ),
		];
		if ( rtTPG()->hasPro() ) {
			$layout_style_new_opt = [
				'masonry' => esc_html__( 'Masonry', 'the-post-grid' ),
			];
			$layout_style_opt     = array_merge( $layout_style_opt, $layout_style_new_opt );
		}

		$divi_fields['grid_layout_style'] = [
			'label'       => esc_html__( 'Layout Style', 'the-post-grid' ),
			'type'        => 'select',
			'default'     => 'tpg-full-height',
			'options'     => $layout_style_opt,
			'description' => esc_html__( 'If you use card border then equal height will work. ', 'the-post-grid' ),
			'show_if'     => [
				$prefix . '_layout' => [
					'grid-layout1',
					'grid-layout3',
					'grid-layout4',
				],
			],
			'tab_slug'    => 'general',
			'toggle_slug' => 'tpg_layout',
		];

		$divi_fields['layout_primary_color'] = [
			'label'       => esc_html__( 'Primary Color', 'the-post-grid' ),
			'type'        => 'color-alpha',
			'tab_slug'    => 'general',
			'toggle_slug' => 'tpg_layout',
		];

		$divi_fields['layout_secondary_color'] = [
			'label'       => esc_html__( 'Secondary Color', 'the-post-grid' ),
			'type'        => 'color-alpha',
			'tab_slug'    => 'general',
			'toggle_slug' => 'tpg_layout',
		];

		return $divi_fields;
	}

	public static function layout_options( $prefix ) {
		$layout_map = [
			'grid'       => [
				$prefix . '-layout1'   => esc_html__( 'Layout 1', 'the-post-grid' ),
				$prefix . '-layout3'   => esc_html__( 'Layout 2', 'the-post-grid' ),
				$prefix . '-layout4'   => esc_html__( 'Layout 3', 'the-post-grid' ),
				$prefix . '-layout2'   => esc_html__( 'Layout 4', 'the-post-grid' ),
				$prefix . '-layout5'   => esc_html__( 'Layout 5', 'the-post-grid' ),
				$prefix . '-layout5-2' => esc_html__( 'Layout 6', 'the-post-grid' ),
				$prefix . '-layout6'   => esc_html__( 'Layout 7', 'the-post-grid' ),
				$prefix . '-layout6-2' => esc_html__( 'Layout 8', 'the-post-grid' ),
				$prefix . '-layout7'   => esc_html__( 'Gallery', 'the-post-grid' ),
			],
			'list'       => [
				$prefix . '-layout1'   => esc_html__( 'Layout 1', 'the-post-grid' ),
				$prefix . '-layout2'   => esc_html__( 'Layout 2', 'the-post-grid' ),
				$prefix . '-layout2-2' => esc_html__( 'Layout 3', 'the-post-grid' ),
				$prefix . '-layout3'   => esc_html__( 'Layout 4', 'the-post-grid' ),
				$prefix . '-layout3-2' => esc_html__( 'Layout 5', 'the-post-grid' ),
				$prefix . '-layout4'   => esc_html__( 'Layout 6', 'the-post-grid' ),
				$prefix . '-layout5'   => esc_html__( 'Layout 7', 'the-post-grid' ),
			],
			'grid_hover' => [
				$prefix . '-layout1'   => esc_html__( 'Layout 1', 'the-post-grid' ),
				$prefix . '-layout2'   => esc_html__( 'Layout 2', 'the-post-grid' ),
				$prefix . '-layout3'   => esc_html__( 'Layout 3', 'the-post-grid' ),
				$prefix . '-layout4'   => esc_html__( 'Layout 4', 'the-post-grid' ),
				$prefix . '-layout4-2' => esc_html__( 'Layout 5', 'the-post-grid' ),
				$prefix . '-layout5'   => esc_html__( 'Layout 6', 'the-post-grid' ),
				$prefix . '-layout5-2' => esc_html__( 'Layout 7', 'the-post-grid' ),
				$prefix . '-layout6'   => esc_html__( 'Layout 8', 'the-post-grid' ),
				$prefix . '-layout6-2' => esc_html__( 'Layout 9', 'the-post-grid' ),
				$prefix . '-layout7'   => esc_html__( 'Layout 10', 'the-post-grid' ),
				$prefix . '-layout7-2' => esc_html__( 'Layout 11', 'the-post-grid' ),
				$prefix . '-layout8'   => esc_html__( 'Layout 12', 'the-post-grid' ),
				$prefix . '-layout9'   => esc_html__( 'Layout 13', 'the-post-grid' ),
				$prefix . '-layout9-2' => esc_html__( 'Layout 14', 'the-post-grid' ),
				$prefix . '-layout10'  => esc_html__( 'Layout 15', 'the-post-grid' ),
				$prefix . '-layout11'  => esc_html__( 'Layout 16', 'the-post-grid' ),
			],
			'slider'     => [
				$prefix . '-layout1'  => esc_html__( 'Layout 1', 'the-post-grid' ),
				$prefix . '-layout2'  => esc_html__( 'Layout 2', 'the-post-grid' ),
				$prefix . '-layout3'  => esc_html__( 'Layout 3', 'the-post-grid' ),
				$prefix . '-layout4'  => esc_html__( 'Layout 4', 'the-post-grid' ),
				$prefix . '-layout5'  => esc_html__( 'Layout 5', 'the-post-grid' ),
				$prefix . '-layout6'  => esc_html__( 'Layout 6', 'the-post-grid' ),
				$prefix . '-layout7'  => esc_html__( 'Layout 7', 'the-post-grid' ),
				$prefix . '-layout8'  => esc_html__( 'Layout 8', 'the-post-grid' ),
				$prefix . '-layout9'  => esc_html__( 'Layout 9', 'the-post-grid' ),
				$prefix . '-layout10' => esc_html__( 'Layout 10', 'the-post-grid' ),
				$prefix . '-layout11' => esc_html__( 'Layout 11', 'the-post-grid' ),
				$prefix . '-layout12' => esc_html__( 'Layout 12', 'the-post-grid' ),
				$prefix . '-layout13' => esc_html__( 'Layout 13', 'the-post-grid' ),
			],
		];

		return $layout_map[ $prefix ] ?? [];
	}

}
