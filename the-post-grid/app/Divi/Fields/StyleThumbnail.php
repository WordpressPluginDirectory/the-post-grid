<?php
/**
 * Divi Helper Class
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Divi\Fields;

use RT\ThePostGrid\Helpers\DiviFns;
use RT\ThePostGrid\Helpers\Fns;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Divi Helper Class
 */
class StyleThumbnail {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [
			'image_width'  => [
				'label'       => esc_html__( 'Image Width (Optional)', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => [
					'inherit' => esc_html__( 'Default', 'the-post-grid' ),
					'100%'    => esc_html__( '100%', 'the-post-grid' ),
					'auto'    => esc_html__( 'Auto', 'the-post-grid' ),
				],
				'default'     => 'inherit',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_thumbnail_style',
			],
			'image_height' => [
				'label'          => esc_html__( 'Image Height', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '1000',
					'step' => '1',
				],
				'show_if'        => [ 'show_thumb' => 'on' ],

				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_thumbnail_style',
			],

			'list_image_side_width' => [
				'label'          => esc_html__( 'List Image Width', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '1000',
					'step' => '1',
				],

				'show_if'     => [ 'show_thumb' => 'on' ],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_thumbnail_style',
			],

			'offset_image_height'            => [
				'label'          => esc_html__( 'Offset Image Height', 'the-post-grid' ),
				'description'    => esc_html__( 'Note: This option is available only for select layouts.', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '1000',
					'step' => '1',
				],
				'show_if'        => DiviFns::thumb_condition( $prefix ),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tpg_thumbnail_style',
			],
			'grid_hover_overlay_color'       => [
				'label'       => esc_html__( 'Overlay BG', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_thumbnail_style',
			],
			'grid_hover_overlay_color_hover' => [
				'label'       => esc_html__( 'Overlay BG:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_thumbnail_style',
			],
			'thumb_lightbox_bg'              => [
				'label'       => esc_html__( 'Light Box Background', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'is_thumb_lightbox' => 'show',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_thumbnail_style',
			],
			'thumb_lightbox_bg_hover'        => [
				'label'       => esc_html__( 'Light Box Background:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'is_thumb_lightbox' => 'show',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_thumbnail_style',
			],
			'thumb_lightbox_color'           => [
				'label'       => esc_html__( 'Light Box Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'is_thumb_lightbox' => 'show',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_thumbnail_style',
			],
			'thumb_lightbox_color_hover'     => [
				'label'       => esc_html__( 'Light Box Color:hover', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'show_if'     => [
					'is_thumb_lightbox' => 'show',
				],
				'toggle_slug' => 'tpg_thumbnail_style',
			],
			'thumbnail_position'             => [
				'label'       => esc_html__( 'Thumb Position', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => [
					''              => esc_html__( 'Center Center', 'the-post-grid' ),
					'top center'    => esc_html__( 'Top Center', 'the-post-grid' ),
					'bottom center' => esc_html__( 'Bottom Center', 'the-post-grid' ),
					'center left'   => esc_html__( 'Left Center', 'the-post-grid' ),
					'center right'  => esc_html__( 'Right Center', 'the-post-grid' ),
				],
				'default'     => 'inherit',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_thumbnail_style',
			],
			'thumbnail_position_hover'       => [
				'label'       => esc_html__( 'Thumb Position:hover', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => [
					''              => esc_html__( 'Center Center', 'the-post-grid' ),
					'top center'    => esc_html__( 'Top Center', 'the-post-grid' ),
					'bottom center' => esc_html__( 'Bottom Center', 'the-post-grid' ),
					'center left'   => esc_html__( 'Left Center', 'the-post-grid' ),
					'center right'  => esc_html__( 'Right Center', 'the-post-grid' ),
				],
				'default'     => 'inherit',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_thumbnail_style',
			],
			'thumbnail_opacity'              => [
				'label'          => esc_html__( 'Thumbnail Opacity', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '1',
					'step' => '0.1',
				],
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tpg_thumbnail_style',
			],

			'thumbnail_opacity_hover' => [
				'label'          => esc_html__( 'Thumbnail Opacity:hover', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '1',
					'step' => '0.1',
				],
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tpg_thumbnail_style',
			],

		];

		if ( $prefix !== 'list' ) {
			unset( $divi_fields['list_image_side_width'] );
		}

		return $divi_fields;
	}

}
