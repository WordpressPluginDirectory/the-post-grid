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
class SettingsACF {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [];

		$get_acf_field = Fns::get_groups_by_post_type( 'all' );
		ksort( $get_acf_field );

		$divi_fields['cf_group'] = [
			'label'       => esc_html__( 'Choose Advanced Custom Field (ACF)', 'the-post-grid' ),
			'type'        => 'multiple_checkboxes',
			'options'     => $get_acf_field,
			'show_if'     => [
				'show_acf' => 'on',
			],
			'tab_slug'    => 'general',
			'toggle_slug' => 'tpg_acf',
		];

		$divi_fields['cf_hide_empty_value'] = [
			'label'       => esc_html__( 'Hide field with empty value?', 'the-post-grid' ),
			'type'        => 'yes_no_button',
			'options'     => [
				'on'  => esc_html__( 'Yes', 'the-post-grid' ),
				'off' => esc_html__( 'No', 'the-post-grid' ),
			],
			'default'     => 'on',
			'tab_slug'    => 'general',
			'toggle_slug' => 'tpg_acf',
		];

		$divi_fields['cf_hide_group_title'] = [
			'label'       => esc_html__( 'Show group title?', 'the-post-grid' ),
			'type'        => 'yes_no_button',
			'options'     => [
				'on'  => esc_html__( 'Yes', 'the-post-grid' ),
				'off' => esc_html__( 'No', 'the-post-grid' ),
			],
			'default'     => 'on',
			'tab_slug'    => 'general',
			'toggle_slug' => 'tpg_acf',
		];

		$divi_fields['cf_show_only_value'] = [
			'label'       => esc_html__( 'Show label?', 'the-post-grid' ),
			'type'        => 'yes_no_button',
			'options'     => [
				'on'  => esc_html__( 'Yes', 'the-post-grid' ),
				'off' => esc_html__( 'No', 'the-post-grid' ),
			],
			'default'     => 'on',
			'tab_slug'    => 'general',
			'toggle_slug' => 'tpg_acf',
		];

		$divi_fields['acf_label_style'] = [
			'label'       => esc_html__( 'Label Style', 'the-post-grid' ),
			'type'        => 'select',
			'default'     => 'inline',
			'options'     => [
				'default' => esc_html__( 'Default', 'the-post-grid' ),
				'inline'  => esc_html__( 'Inline', 'the-post-grid' ),
				'block'   => esc_html__( 'Block', 'the-post-grid' ),
			],
			'show_if'     => [
				'cf_show_only_value' => 'on',
			],
			'tab_slug'    => 'general',
			'toggle_slug' => 'tpg_acf',
		];

		return $divi_fields;
	}

}
