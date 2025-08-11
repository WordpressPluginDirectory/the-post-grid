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
class StyleCard {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [
			'box_background'         => [
				'label'       => esc_html__( 'Background', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_card_style',
			],
			'box_background_hover'   => [
				'label'       => esc_html__( 'Background:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_card_style',
			],

		];

		if ( 'grid_hover' !== $prefix ) {
			$divi_fields['sticky_item_background'] = [
				'label'       => esc_html__( 'Sticky Background', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_card_style',
			];
		}

		if ( 'list' === $prefix ) {
			$divi_fields['list_layout_alignment'] = [
				'label'       => esc_html__( 'Vertical Alignment', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => '',
				'options'     => [
					''              => esc_html__( 'Default', 'the-post-grid' ),
					'flex-start'    => esc_html__( 'Start', 'the-post-grid' ),
					'center'        => esc_html__( 'Center', 'the-post-grid' ),
					'flex-end'      => esc_html__( 'End', 'the-post-grid' ),
					'space-around'  => esc_html__( 'Space Around', 'the-post-grid' ),
					'space-between' => esc_html__( 'Space Between', 'the-post-grid' ),
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_card_style',
				'show_if_not' => [
					'list_layout' => [ 'list-layout2', 'list-layout2-2' ],
				],
			];

			$divi_fields['list_flex_direction'] = [
				'label'       => esc_html__( 'Flex Direction', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => '',
				'options'     => [
					''               => esc_html__( 'Default', 'the-post-grid' ),
					'row-reverse'    => esc_html__( 'Row Reverse', 'the-post-grid' ),
					'column'         => esc_html__( 'Column', 'the-post-grid' ),
					'column-reverse' => esc_html__( 'Column Reverse', 'the-post-grid' ),
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_card_style',
				'show_if'     => [
					'list_layout' => [ 'list-layout1', 'list-layout5' ],
				],
			];


		}


		return $divi_fields;
	}

}
