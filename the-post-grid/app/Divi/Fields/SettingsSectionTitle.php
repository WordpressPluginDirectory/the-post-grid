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
class SettingsSectionTitle {

	public static function get_fields( $prefix = 'grid' ) {

		$divi_fields = [

			'section_title_style' => [
				'label'        => esc_html__( 'Section Title Style', 'the-post-grid' ),
				'type'         => 'select',
				'default'      => 'style1',
				'options'      => [
					'default' => esc_html__( 'Default - Text', 'the-post-grid' ),
					'style1'  => esc_html__( 'Style 1 - Dot & Border', 'the-post-grid' ),
					'style2'  => esc_html__( 'Style 2 - BG & Border', 'the-post-grid' ),
					'style3'  => esc_html__( 'Style 3 - BG & Border - 2', 'the-post-grid' ),
					'style4'  => esc_html__( 'Style 4 - Border Bottom', 'the-post-grid' ),
				],
				'show_if'    => [
					'show_section_title' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_section_title',
			],
			'section_title_source' => [
				'label'     => esc_html__( 'Title Source', 'the-post-grid' ),
				'type'      => 'select',
				'default'   => 'custom_title',
				'options'   => [
					'page_title'   => esc_html__( 'Page Title', 'the-post-grid' ),
					'custom_title' => esc_html__( 'Custom Title', 'the-post-grid' ),
				],
				'show_if' => [
					'show_section_title' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_section_title',
			],
			'section_title_text' => [
				'label'       => esc_html__( 'Title', 'the-post-grid' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'Type your title here', 'the-post-grid' ),
				'default'     => esc_html__( 'Section Title', 'the-post-grid' ),
				'label_block' => true,
				'show_if'   => [
					'section_title_source' => 'custom_title',
					'show_section_title'   => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_section_title',
			],

			'title_prefix' => [
				'label'       => esc_html__( 'Title Prefix Text', 'the-post-grid' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'Title prefix text', 'the-post-grid' ),
				'show_if'   => [
					'section_title_source' => 'page_title',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_section_title',
			],
			'title_suffix' => [
				'label'       => esc_html__( 'Title Suffix Text', 'the-post-grid' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'Title suffix text', 'the-post-grid' ),
				'show_if'   => [
					'section_title_source' => 'page_title',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_section_title',
			],
			'section_title_tag' => [
				'label'     => esc_html__( 'Title Tag', 'the-post-grid' ),
				'type'      => 'select',
				'default'   => 'h2',
				'options'   => [
					'h1' => esc_html__( 'H1', 'the-post-grid' ),
					'h2' => esc_html__( 'H2', 'the-post-grid' ),
					'h3' => esc_html__( 'H3', 'the-post-grid' ),
					'h4' => esc_html__( 'H4', 'the-post-grid' ),
					'h5' => esc_html__( 'H5', 'the-post-grid' ),
					'h6' => esc_html__( 'H6', 'the-post-grid' ),
				],
				'show_if' => [
					'show_section_title' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_section_title',
			],
			'enable_external_link' => [
				'label'       => esc_html__( 'Enable External Link', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'off',
				'show_if' => [
					'show_section_title' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_section_title',
			],

			'section_external_url' => [
				'label'       => esc_html__( 'External Link', 'the-post-grid' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'https://your-link.com', 'the-post-grid' ),
				'show_if'   => [
					'enable_external_link' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_section_title',
			],
			'section_external_url_target' => [
				'label'       => esc_html__( 'Link Target', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'_blank'  => esc_html__( '_blank', 'the-post-grid' ),
					'_self' => esc_html__( '_blank', 'the-post-grid' ),
				],
				'default'     => '_blank',
				'show_if' => [
					'enable_external_link' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_section_title',
			],
			'section_external_text' => [
				'label'     => esc_html__( 'Link Text', 'the-post-grid' ),
				'type'      => 'text',
				'default'   => esc_html__( 'See More', 'the-post-grid' ),
				'show_if' => [
					'enable_external_link' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_section_title',
			],
		];


		return $divi_fields;
	}


}
