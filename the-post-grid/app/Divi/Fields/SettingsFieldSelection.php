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
class SettingsFieldSelection {

	public static function get_fields( $prefix = 'grid' ) {
		$divi_fields = [
			'show_section_title' => [
				'label'       => esc_html__( 'Section Title', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
			'show_title'         => [
				'label'       => esc_html__( 'Post Title', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'default'     => 'on',
				'show_if_not' => [
					$prefix . '_layout' => [ 'grid-layout7', 'slider-layout4' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
			'show_thumb'         => [
				'label'       => esc_html__( 'Post Thumbnail', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
			'show_excerpt'       => [
				'label'       => esc_html__( 'Post Excerpt', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'show_if_not' => [
					$prefix . '_layout' => [ 'grid-layout7', 'slider-layout4' ],
				],
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
			'show_meta'          => [
				'label'       => esc_html__( 'Meta Data', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'show_if_not' => [
					$prefix . '_layout' => [ 'grid-layout7', 'slider-layout4' ],
				],
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
			'show_date'          => [
				'label'       => esc_html__( 'Post Date', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'show_if'     => [
					'show_meta' => 'on',
				],
				'show_if_not' => [
					$prefix . '_layout' => [ 'grid-layout7', 'slider-layout4' ],
				],
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
			'show_category'      => [
				'label'       => esc_html__( 'Post Categories', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'show_if'     => [
					'show_meta' => 'on',
				],
				'show_if_not' => [
					$prefix . '_layout' => [ 'grid-layout7', 'slider-layout4' ],
				],
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
			'show_author'        => [
				'label'       => esc_html__( 'Post Author', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'default'     => 'on',
				'show_if'     => [
					'show_meta' => 'on',
				],
				'show_if_not' => [
					$prefix . '_layout' => [ 'grid-layout7', 'slider-layout4' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
			'show_tags'          => [
				'label'       => esc_html__( 'Post Tags', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'default'     => 'off',
				'show_if'     => [
					'show_meta' => 'on',
				],
				'show_if_not' => [
					$prefix . '_layout' => [ 'grid-layout7', 'slider-layout4' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
			'show_comment_count' => [
				'label'       => esc_html__( 'Post Comment Count', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'default'     => 'off',
				'show_if'     => [
					'show_meta' => 'on',
				],
				'show_if_not' => [
					$prefix . '_layout' => [ 'grid-layout7', 'slider-layout4' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
			'show_post_count'    => [
				'label'       => esc_html__( 'Post View Count', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'default'     => 'off',
				'show_if'     => [
					'show_meta' => 'on',
				],
				'show_if_not' => [
					$prefix . '_layout' => [ 'grid-layout7', 'slider-layout4' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
			'show_read_more'     => [
				'label'       => esc_html__( 'Read More Button', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'default'     => 'on',
				'show_if_not' => [
					$prefix . '_layout' => [ 'grid-layout7', 'slider-layout4' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
			'show_social_share'  => [
				'label'       => esc_html__( 'Social Share', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'default'     => 'off',
				'show_if_not' => [
					$prefix . '_layout' => [ 'grid-layout7', 'slider-layout4' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			],
		];

		if ( Fns::is_acf() ) {
			$divi_fields['show_acf'] = [
				'label'       => esc_html__( 'Advanced Custom Field', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Show', 'the-post-grid' ),
					'off' => esc_html__( 'Hide', 'the-post-grid' ),
				],
				'default'     => 'off',
				'show_if_not' => [
					$prefix . '_layout' => [ 'grid-layout7', 'slider-layout4' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_selection',
			];
		}

		return $divi_fields;
	}

}
