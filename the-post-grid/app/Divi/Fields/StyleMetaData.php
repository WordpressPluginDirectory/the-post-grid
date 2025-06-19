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
class StyleMetaData {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [
			'post_meta_alignment'  => [
				'label'       => esc_html__( 'Alignment', 'the-post-grid' ),
				'type'        => 'text_align',
				'default'     => 'left',
				'options'     => et_builder_get_text_orientation_options(),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_meta_data_style',
			],
			'meta_info_color'      => [
				'label'       => esc_html__( 'Meta Text Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_meta_data_style',
			],
			'meta_link_color'      => [
				'label'       => esc_html__( 'Meta Link color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_meta_data_style',
			],
			'meta_link_colo_hover' => [
				'label'       => esc_html__( 'Meta Link color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_meta_data_style',
			],
			'meta_icon_color'      => [
				'label'       => esc_html__( 'Meta Icon color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_meta_data_style',
			],
			'meta_separator_color' => [
				'label'       => esc_html__( 'Meta Separator color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'meta_separator!' => 'default',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_meta_data_style',
			],

			'separate_category_color'       => [
				'label'       => esc_html__( 'Separate Category Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_meta_data_style',
			],
			'separate_category_color_hover' => [
				'label'       => esc_html__( 'Separate Category Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_meta_data_style',
			],
			'separate_category_bg'          => [
				'label'       => esc_html__( 'Separate Category Background', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'description' => rtTPG()->hasPro() ? esc_html__( 'If you use different background color then avoid this color', 'the-post-grid' ) : esc_html__( 'Choose separate category background', 'the-post-grid' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_meta_data_style',
			],
			'separate_category_bg_hover'    => [
				'label'       => esc_html__( 'Separate Category Background:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'description' => rtTPG()->hasPro() ? esc_html__( 'If you use different background color then avoid this color', 'the-post-grid' ) : esc_html__( 'Choose separate category background', 'the-post-grid' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_meta_data_style',
			],
			'separate_category_icon_color'  => [
				'label'       => esc_html__( 'Separate Category Icon Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_meta_data_style',
			],
			'category_radius' => [
				'label'          => esc_html__( 'Category Border Radius', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				],
				
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tpg_meta_data_style',
			],

		];

		return $divi_fields;
	}

}
