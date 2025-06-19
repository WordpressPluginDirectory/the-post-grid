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
class StyleSocialShare {

	public static function get_fields( $prefix = 'grid' ) {
		if ( ! rtTpg()->hasPro() ) {
			return [];
		}
		$divi_fields = [
			'social_icon_alignment' => [
				'label'       => esc_html__( 'Alignment', 'the-post-grid' ),
				'type'        => 'text_align',
				'default'     => 'left',
				'options'     => et_builder_get_text_orientation_options(),
				'show_if'     => [ 'show_social_share' => 'on' ],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_social_share_style',
			],

			'icon_font_size' => [
				'label'          => esc_html__( 'Icon Font Size', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '12',
					'max'  => '50',
					'step' => '1',
				],
				'show_if'        => [ 'show_social_share' => 'on' ],
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tpg_social_share_style',
			],

			'icon_width_height' => [
				'label'          => esc_html__( 'Icon Width/Height', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '12',
					'max'  => '100',
					'step' => '1',
				],
				'show_if'        => [ 'show_social_share' => 'on' ],
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tpg_social_share_style',
			],

			'social_icon_color'       => [
				'label'       => esc_html__( 'Icon color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [ 'show_social_share' => 'on' ],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_social_share_style',
			],
			'social_icon_color_hover' => [
				'label'       => esc_html__( 'Icon color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [ 'show_social_share' => 'on' ],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_social_share_style',
			],

			'social_icon_bg_color' => [
				'label'       => esc_html__( 'Social Icon Background', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [ 'show_social_share' => 'on' ],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_social_share_style',
			],

			'social_icon_bg_color_hover' => [
				'label'       => esc_html__( 'Icon Background', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [ 'show_social_share' => 'on' ],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_social_share_style',
			],

		];

		return $divi_fields;
	}

}
