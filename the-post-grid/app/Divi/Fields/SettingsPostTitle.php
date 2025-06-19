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
class SettingsPostTitle {

	public static function get_fields( $prefix = 'grid' ) {
		$title_position = [
			'default' => esc_html__( 'Default', 'the-post-grid' ),
		];
		if ( rtTPG()->hasPro() ) {
			$title_position_pro = [
				'above_image' => esc_html__( 'Above Image', 'the-post-grid' ),
				'below_image' => esc_html__( 'Below Image', 'the-post-grid' ),
			];
			$title_position     = array_merge( $title_position, $title_position_pro );
		}

		$divi_fields = [
			'title_tag'              => [
				'label'       => esc_html__( 'Title Tag', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'h3',
				'options'     => [
					'h1' => esc_html__( 'H1', 'the-post-grid' ),
					'h2' => esc_html__( 'H2', 'the-post-grid' ),
					'h3' => esc_html__( 'H3', 'the-post-grid' ),
					'h4' => esc_html__( 'H4', 'the-post-grid' ),
					'h5' => esc_html__( 'H5', 'the-post-grid' ),
					'h6' => esc_html__( 'H6', 'the-post-grid' ),
				],
				'show_if'     => [ 'show_title' => 'on' ],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_post_title',
			],
			'title_position'         => [
				'label'       => esc_html__( 'Title Position', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => $title_position,
				'description' => Fns::get_pro_message( 'more position (above/below image)', 'Change Title position' ),
				'show_if'     => [
					'show_title'        => 'on',
					$prefix . '_layout' => [
						'grid-layout1',
						'grid-layout2',
						'grid-layout3',
						'grid-layout4',
						'slider-layout1',
						'slider-layout2',
						'slider-layout3',
					],
				],

				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_post_title',
			],
			'title_hover_underline'  => [
				'label'       => esc_html__( 'Title Hover Underline', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => [
					'default' => esc_html__( 'Default', 'the-post-grid' ),
					'enable'  => esc_html__( 'Enable', 'the-post-grid' ),
					'disable' => esc_html__( 'Disable', 'the-post-grid' ),
				],
				'show_if'     => [ 'show_title' => 'on' ],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_post_title',
			],
			'title_visibility_style' => [
				'label'       => esc_html__( 'Title Visibility Style', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => [
					'default'    => esc_html__( 'Default', 'the-post-grid' ),
					'one-line'   => esc_html__( 'Show in 1 line', 'the-post-grid' ),
					'two-line'   => esc_html__( 'Show in 2 lines', 'the-post-grid' ),
					'three-line' => esc_html__( 'Show in 3 lines', 'the-post-grid' ),
				],
				'show_if'     => [ 'show_title' => 'on' ],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_post_title',
			],
			'title_limit'            => [
				'label'       => esc_html__( 'Title Length', 'the-post-grid' ),
				'description' => esc_html__( 'nter the title length (default trimming is by word count)', 'the-post-grid' ),
				'type'        => 'number',
				'step'        => 1,
				'show_if'     => [ 'show_title' => 'on' ],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_post_title',
			],
			'title_limit_type'       => [
				'label'       => esc_html__( 'Title trimming by', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'word',
				'options'     => [
					'word'      => esc_html__( 'Words', 'the-post-grid' ),
					'character' => esc_html__( 'Characters', 'the-post-grid' ),
				],
				'show_if'     => [ 'show_title' => 'on' ],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_post_title',
			],
		];

		return $divi_fields;
	}

}
