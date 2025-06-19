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
class StyleSectionTitle {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [

			'section_title_alignment' => [
				'label'       => esc_html__( 'Alignment', 'the-post-grid' ),
				'type'        => 'text_align',
				'default'     => 'left',
				'options'     => et_builder_get_text_orientation_options(),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_section_title_style',
			],

			'section_title_color'            => [
				'label'       => esc_html__( 'Title Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_section_title_style',
			],

			'section_title_bg_color'            => [
				'label'       => esc_html__( 'Title Background Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_section_title_style',
				'show_if' => [
					'section_title_style' => [ 'style2', 'style3' ],
				],
			],

			'section_title_dot_color'            => [
				'label'       => esc_html__( 'Dot / Bar Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_section_title_style',
				'show_if' => [
					'section_title_style' => [ 'style1', 'style4' ],
				],
			],

			'section_title_line_color'            => [
				'label'       => esc_html__( 'Line / Border Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_section_title_style',
				'show_if_not' => [
					'section_title_style' => 'default',
				],
			],

			'prefix_text_color'            => [
				'label'       => esc_html__( 'Prefix Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_section_title_style',
				'show_if' => [
					'section_title_source' => 'page_title',
				],
			],
			'suffix_text_color'            => [
				'label'       => esc_html__( 'Suffix Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_section_title_style',
				'show_if' => [
					'section_title_source' => 'page_title',
				],
			],

			'external_icon_color'            => [
				'label'       => esc_html__( 'External Link Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_section_title_style',
			],


		];


		return $divi_fields;
	}

}
