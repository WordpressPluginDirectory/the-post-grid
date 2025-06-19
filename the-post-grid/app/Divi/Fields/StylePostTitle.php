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
class StylePostTitle {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [
			'title_min_height'        => [
				'label'          => esc_html__( 'Title Minimum Height (Optional)', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '300',
					'step' => '1',
				],
				
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_post_title_style',
			],
			'title_border_visibility' => [
				'label'       => esc_html__( 'Title Border Bottom', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => [
					'default' => esc_html__( 'Default', 'the-post-grid' ),
					'on'      => esc_html__( 'Show', 'the-post-grid' ),
					'hide'    => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'show_if'     => [
					$prefix . '_layout' => 'grid_hover-layout3',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_post_title_style',
			],
			'title_color'                  => [
				'label'       => esc_html__( 'Title Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_post_title_style',
			],
			'title_hover_color'                  => [
				'label'       => esc_html__( 'Title Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_post_title_style',
			],
			'title_bg_color'                  => [
				'label'       => esc_html__( 'Title Background', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_post_title_style',
			],
			'title_bg_color_hover'                  => [
				'label'       => esc_html__( 'Title Background:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_post_title_style',
			],
			'title_border_color'                  => [
				'label'       => esc_html__( 'Title Separator Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_post_title_style',
				'show_if' => [
					$prefix . '_layout'        => 'grid_hover-layout3',
				],
				'show_if_not' => [
					'title_border_visibility' => 'hide',
				]
			],

		];

		return $divi_fields;
	}

}
