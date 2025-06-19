<?php
/**
 * Divi Helper Class
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Divi\Fields;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Divi Helper Class
 */
class StyleACF {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [

			'acf_label_width' => [
				'label'          => esc_html__( 'Label Min Width', 'the-post-grid' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => '0',
					'max'  => '500',
					'step' => '1',
				],
				'show_if'        => [
					'acf_label_style' => 'default',
				],
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tpg_acf_style',
			],

			'acf_group_title_color' => [
				'label'       => esc_html__( 'Group Title Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'cf_hide_group_title' => 'on',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_acf_style',
			],

			'acf_label_color' => [
				'label'       => esc_html__( 'Label Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'cf_show_only_value' => 'on',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_acf_style',
			],

			'acf_value_color' => [
				'label'       => esc_html__( 'Value Color', 'the-post-grid' ),
				'type'        => 'color-alpha',
				'show_if'     => [
					'cf_show_only_value' => 'on',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tpg_acf_style',
			],

		];

		return $divi_fields;
	}

}
