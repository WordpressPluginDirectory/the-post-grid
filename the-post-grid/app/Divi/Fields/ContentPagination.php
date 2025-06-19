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
class ContentPagination {

	public static function get_fields( $prefix = 'grid' ) {
		$pagination_type = [
			'pagination' => esc_html__( 'Default Pagination', 'the-post-grid' ),
		];

		if ( rtTPG()->hasPro() ) {
			$pagination_type_pro = [
				'pagination_ajax' => esc_html__( 'Ajax Pagination ( Only for Grid )', 'the-post-grid' ),
				'load_more'       => esc_html__( 'Load More - On Click', 'the-post-grid' ),
				'load_on_scroll'  => esc_html__( 'Load On Scroll', 'the-post-grid' ),
			];
			$pagination_type     = array_merge( $pagination_type, $pagination_type_pro );
		}

		$divi_fields = [
			'show_pagination' => [
				'label'       => esc_html__( 'Show Pagination', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_pagination',
			],
			'pagination_type' => [
				'label'       => esc_html__( 'Pagination Type', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'pagination',
				'options'     => $pagination_type,
				'description' => Fns::get_pro_message( 'loadmore and ajax pagination' ),
				'show_if'     => [
					'show_pagination' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_pagination',
			],

			'ajax_pagination_type'  => [
				'label'       => esc_html__( 'Enable Ajax Next Previous', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => [
					'yes' => esc_html__( 'Yes', 'the-post-grid' ),
					'no'  => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'no',
				'show_if'     => [
					'pagination_type' => 'pagination_ajax',
					'show_pagination' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_pagination',
			],
			'load_more_button_text' => [
				'label'       => esc_html__( 'Button Text', 'the-post-grid' ),
				'type'        => 'text',
				'default'     => esc_html__( 'Load More', 'the-post-grid' ),
				'show_if'     => [
					'pagination_type' => 'load_more',
					'show_pagination' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_pagination',
			],
		];

		return $divi_fields;
	}

}
