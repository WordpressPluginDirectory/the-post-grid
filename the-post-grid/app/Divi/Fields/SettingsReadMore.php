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
class SettingsReadMore {

	public static function get_fields( $prefix = 'grid' ) {

		$divi_fields = [
			'readmore_btn_style' => [
				'label'        => esc_html__( 'Button Style', 'the-post-grid' ),
				'type'         => 'select',
				'default'      => 'default-style',
				'options'      => [
					'default-style' => esc_html__( 'Default from style', 'the-post-grid' ),
					'only-text'     => esc_html__( 'Only Text Button', 'the-post-grid' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_read_more',
			],
			'read_more_label' => [
				'label'       => esc_html__( 'Read More Label', 'the-post-grid' ),
				'type'        => 'text',
				'default'     => esc_html__( 'Read More', 'the-post-grid' ),
				'placeholder' => esc_html__( 'Type Read More Label here', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_read_more',
			],
			'show_btn_icon' => [
				'label'        => esc_html__( 'Show Button Icon', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_read_more',
			],
			'readmore_icon_position' => [
				'label'     => esc_html__( 'Icon Position', 'the-post-grid' ),
				'type'      => 'select',
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Left', 'the-post-grid' ),
					'right' => esc_html__( 'Right', 'the-post-grid' ),
				],
				'show_if' => [
					'show_btn_icon' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_read_more',
			],
		];

		return $divi_fields;
	}


}
