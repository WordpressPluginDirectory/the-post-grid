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
class ContentLink {

	public static function get_fields( $prefix = 'grid' ) {
		$link_type = [
			'default' => esc_html__( 'Link to details page', 'the-post-grid' ),
		];
		if ( rtTPG()->hasPro() ) {
			$link_type['popup']       = esc_html__( 'Single Popup', 'the-post-grid' );
			$link_type['multi_popup'] = esc_html__( 'Multi Popup', 'the-post-grid' );
		}
		$link_type['none'] = esc_html__( 'No Link', 'the-post-grid' );

		$divi_fields = [
			'post_link_type'  => [
				'label'       => esc_html__( 'Post link type', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => $link_type,
				'description' => Fns::get_pro_message( 'popup options' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_links',
			],
			'link_target'     => [
				'label'       => esc_html__( 'Link Target', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => '_self',
				'options'     => [
					'_self'  => esc_html__( 'Same Window', 'the-post-grid' ),
					'_blank' => esc_html__( 'New Window', 'the-post-grid' ),
				],
				'show_if'     => [
					'post_link_type' => 'default',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_links',
			],
			'is_thumb_linked' => [
				'label'       => esc_html__( 'Thumbnail Link', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'yes',
				'options'     => [
					'yes' => esc_html__( 'Same Window', 'the-post-grid' ),
					'no'  => esc_html__( 'New Window', 'the-post-grid' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_links',
			],
		];

		return $divi_fields;
	}

}
