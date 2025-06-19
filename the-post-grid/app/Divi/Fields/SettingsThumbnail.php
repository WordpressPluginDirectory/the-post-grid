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
class SettingsThumbnail {

	public static function get_fields( $prefix = 'grid' ) {
		/*$thumb_exclude = '';
		if ( ! rtTPG()->hasPro() ) {
			$thumb_exclude = 'custom';
		}*/

		$image_sizes = Fns::get_image_sizes();
		$overlay_type_opt = [
			'always'              => esc_html__( 'Show Always', 'the-post-grid' ),
			'fadein-on-hover'     => esc_html__( 'FadeIn on hover', 'the-post-grid' ),
			'fadeout-on-hover'    => esc_html__( 'FadeOut on hover', 'the-post-grid' ),
			'slidein-on-hover'    => esc_html__( 'SlideIn on hover', 'the-post-grid' ),
			'slideout-on-hover'   => esc_html__( 'SlideOut on hover', 'the-post-grid' ),
			'zoomin-on-hover'     => esc_html__( 'ZoomIn on hover', 'the-post-grid' ),
			'zoomout-on-hover'    => esc_html__( 'ZoomOut on hover', 'the-post-grid' ),
			'zoominall-on-hover'  => esc_html__( 'ZoomIn Content on hover', 'the-post-grid' ),
			'zoomoutall-on-hover' => esc_html__( 'ZoomOut Content on hover', 'the-post-grid' ),
		];

		if ( $prefix == 'grid_hover' || $prefix == 'slider' ) {
			$overlay_type_opt2 = [
				'flipin-on-hover'  => esc_html__( 'FlipIn on hover', 'the-post-grid' ),
				'flipout-on-hover' => esc_html__( 'FlipOut on hover', 'the-post-grid' ),
			];
			$overlay_type_opt  = array_merge( $overlay_type_opt, $overlay_type_opt2 );
		}

		$overlay_height_condition = [
			'grid_hover_layout' => [ 'grid_hover-layout3' ],
		];
		if ( $prefix === 'slider' ) {
			$overlay_height_condition = [
				'slider_layout' => [ '' ],
			];
		}

		$divi_fields = [
			'media_source'   => [
				'label'       => esc_html__( 'Media Source', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'feature_image',
				'options'     => [
					'feature_image' => esc_html__( 'Feature Image', 'the-post-grid' ),
					'first_image'   => esc_html__( 'First Image from content', 'the-post-grid' ),
				],
				'show_if'     => [ 'show_thumb' => 'on' ],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_thumbnail',
			],
			'image_size'     => [
				'label'       => esc_html__( 'Image Size', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => $image_sizes,
				'default'     => 'medium_large',
				'show_if'     => [ 'show_thumb' => 'on' ],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_thumbnail',
			],

			'image_offset'   => [
				'label'       => esc_html__( 'Offset Image Size', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => $image_sizes,
				'default'     => 'medium_large',
				'show_if'     => DiviFns::thumb_condition( $prefix ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_thumbnail',
			],

			'hover_animation'       => [
				'label'       => esc_html__( 'Image Hover Animation', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => [
					'default'        => esc_html__( 'Default', 'the-post-grid' ),
					'img_zoom_in'    => esc_html__( 'Zoom In', 'the-post-grid' ),
					'img_zoom_out'   => esc_html__( 'Zoom Out', 'the-post-grid' ),
					'slide_to_right' => esc_html__( 'Slide to Right', 'the-post-grid' ),
					'slide_to_left'  => esc_html__( 'Slide to Left', 'the-post-grid' ),
					'img_no_effect'  => esc_html__( 'None', 'the-post-grid' ),
				],
				'show_if'     => [ 'show_thumb' => 'on' ],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_thumbnail',
			],

			'grid_hover_overlay_type'   => [
				'label'       => esc_html__( 'Overlay Interaction', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'always',
				'options'     => $overlay_type_opt,
				'description' => esc_html__( 'Please select an overlay color from Design tab before using this field.', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_thumbnail',
			],
			'grid_hover_overlay_height' => [
				'label'       => esc_html__( 'Overlay Height', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => [
					'default' => esc_html__( 'Default', 'the-post-grid' ),
					'full'    => esc_html__( '100%', 'the-post-grid' ),
					'auto'    => esc_html__( 'Auto', 'the-post-grid' ),
				],
				'show_if_not' => $overlay_height_condition,
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_thumbnail',
			],
			'on_hover_overlay'          => [
				'label'       => esc_html__( 'Overlay Height on hover', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => [
					'default' => esc_html__( 'Default', 'the-post-grid' ),
					'full'    => esc_html__( '100%', 'the-post-grid' ),
					'auto'    => esc_html__( 'Auto', 'the-post-grid' ),
				],
				'show_if_not' => $overlay_height_condition,
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_thumbnail',
			],
			'is_thumb_lightbox'     => [
				'label'       => esc_html__( 'Light Box', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => [
					'default' => esc_html__( 'Default', 'the-post-grid' ),
					'show'      => esc_html__( 'Show', 'the-post-grid' ),
					'hide'    => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'show_if'     => [ 'show_thumb' => 'on' ],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_thumbnail',
			],
		];

		if ( 'list' !== $prefix ) {
			unset( $divi_fields['list_image_side_width'] );
		}

		return $divi_fields;
	}

}
