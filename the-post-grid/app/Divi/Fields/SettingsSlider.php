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
class SettingsSlider {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [
			'arrows' => [
				'label'       => esc_html__( 'Arrow Visibility', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'show_if_not' => [
					'slider_layout' => [ 'slider-layout11', 'slider-layout12' ],
				],
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
			],

			'arrow_position' => [
				'label'           => esc_html__( 'Arrow Position', 'the-post-grid' ),
				'type'            => 'select',
				'default'         => 'default',
				'options'         => [
					'default'    => esc_html__( 'Default', 'the-post-grid' ),
					'top-right'  => esc_html__( 'Top Right', 'the-post-grid' ),
					'top-left'   => esc_html__( 'Top Left', 'the-post-grid' ),
					'show-hover' => esc_html__( 'Center (Show on hover)', 'the-post-grid' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
				'show_if'         => ['arrows' => 'on'],

			],

			'dots' => [
				'label'           => esc_html__( 'Dots Visibility', 'the-post-grid' ),
				'type'            => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'         => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
			],

			'dynamic_dots' => [
				'label'           => esc_html__( 'Enable Dynamic Dots', 'the-post-grid' ),
				'type'            => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'         => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
				'show_if'         => ['dots' => 'on'],
			],

			'dots_style' => [
				'label'           => esc_html__( 'Dots Style', 'the-post-grid' ),
				'type'            => 'select',
				'default'         => 'default',
				'options'         => [
					'default'    => esc_html__( 'Default', 'the-post-grid' ),
					'background' => esc_html__( 'With Background', 'the-post-grid' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
				'show_if'         => ['dots' => 'on'],
			],

			'infinite' => [
				'label'           => esc_html__( 'Infinite', 'the-post-grid' ),
				'type'            => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'         => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
			],

			'autoplay' => [
				'label'           => esc_html__( 'Autoplay', 'the-post-grid' ),
				'type'            => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'         => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
			],

			'autoplaySpeed' => [
				'label'           => esc_html__( 'Autoplay Speed (ms)', 'the-post-grid' ),
				'type'            => 'range',
				'default'         => 3000,
				'range_settings'  => [
					'min'  => 1000,
					'max'  => 10000,
					'step' => 500,
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
				'show_if'         => ['autoplay' => 'on'],
			],

			'stopOnHover' => [
				'label'           => esc_html__( 'Stop On Hover', 'the-post-grid' ),
				'type'            => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'         => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
				'show_if'         => ['autoplay' => 'on'],
			],

			'grabCursor' => [
				'label'           => esc_html__( 'Allow Touch Move', 'the-post-grid' ),
				'type'            => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'         => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
			],

			'autoHeight' => [
				'label'           => esc_html__( 'Auto Height', 'the-post-grid' ),
				'type'            => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'         => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
			],

			'lazyLoad' => [
				'label'           => esc_html__( 'Lazy Load', 'the-post-grid' ),
				'type'            => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'         => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
			],

			'speed' => [
				'label'           => esc_html__( 'Speed (ms)', 'the-post-grid' ),
				'type'            => 'range',
				'default'         => 500,
				'range_settings'  => [
					'min'  => 100,
					'max'  => 3000,
					'step' => 100,
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
			],

			'carousel_overflow' => [
				'label'           => esc_html__( 'Slider Overflow', 'the-post-grid' ),
				'type'            => 'select',
				'default'         => 'hidden',
				'options'         => [
					'hidden' => esc_html__( 'Hidden', 'the-post-grid' ),
					'none'   => esc_html__( 'None', 'the-post-grid' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
				'show_if_not'     => ['lazyLoad' => 'on'],
			],

			'slider_direction' => [
				'label'           => esc_html__( 'Direction', 'the-post-grid' ),
				'type'            => 'select',
				'default'         => '',
				'options'         => [
					'' => esc_html__( '-Select-', 'the-post-grid' ),
					'ltr' => esc_html__( 'LTR', 'the-post-grid' ),
					'rtl' => esc_html__( 'RTL', 'the-post-grid' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_slider',
			],

		];

		return $divi_fields;
	}

}
