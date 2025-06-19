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
class SettingsMetaData {

	public static function get_fields( $prefix = 'grid' ) {
		$meta_position = [
			'default' => esc_html__( 'Default', 'the-post-grid' ),
		];
		if ( rtTPG()->hasPro() ) {
			$meta_position_pro = [
				'above_title'   => esc_html__( 'Above Title', 'the-post-grid' ),
				'below_title'   => esc_html__( 'Below Title', 'the-post-grid' ),
				'above_excerpt' => esc_html__( 'Above excerpt', 'the-post-grid' ),
				'below_excerpt' => esc_html__( 'Below excerpt', 'the-post-grid' ),
			];
			$meta_position     = array_merge( $meta_position, $meta_position_pro );
		}

		$meta_settings = [
			'meta_position'  => [
				'label'       => esc_html__( 'Meta Position', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => $meta_position,
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
			'show_meta_icon' => [
				'label'       => esc_html__( 'Show Meta Icon', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
			'meta_separator' => [
				'label'       => esc_html__( 'Meta Separator', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => [
					'default' => esc_html__( 'Default - None', 'the-post-grid' ),
					'.'       => esc_html__( 'Dot ( . )', 'the-post-grid' ),
					'/'       => esc_html__( 'Single Slash ( / )', 'the-post-grid' ),
					'//'      => esc_html__( 'Double Slash ( // )', 'the-post-grid' ),
					'-'       => esc_html__( 'Hyphen ( - )', 'the-post-grid' ),
					'|'       => esc_html__( 'Vertical Pipe ( | )', 'the-post-grid' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],

			'tpg_heading_text_author_settings' => [
				'label'       => esc_html__( 'Author Setting:', 'the-post-grid' ),
				'type'        => 'text',
				'show_if'     => [
					'show_author' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
			'author_prefix'                    => [
				'label'       => esc_html__( 'Author Prefix', 'the-post-grid' ),
				'type'        => 'text',
				'default'     => 'By',
				'placeholder' => esc_html__( 'By', 'the-post-grid' ),
				'show_if'     => [
					'show_author' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
			'author_icon_visibility'           => [
				'label'       => esc_html__( 'Author Icon Visibility', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'on',
				'options'     => [
					'default' => esc_html__( 'Default', 'the-post-grid' ),
					'hide'    => esc_html__( 'Hide', 'the-post-grid' ),
					'show'    => esc_html__( 'Show', 'the-post-grid' ),
				],
				'show_if'     => [
					'show_author' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
			'show_author_image'                => [
				'label'       => esc_html__( 'Author Image / Icon', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'icon',
				'options'     => [
					'image' => esc_html__( 'Image', 'the-post-grid' ),
					'icon'  => esc_html__( 'Icon', 'the-post-grid' ),
				],
				'show_if'     => [
					'show_author' => 'on',
				],
				'show_if_not' => [
					'author_icon_visibility' => 'hide',
					$prefix . '_layout'      => [ 'grid-layout7', 'slider-layout4' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],

			'tpg_heading_text_category_settings' => [
				'label'       => esc_html__( 'Category and Tags Setting:', 'the-post-grid' ),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],

			'category_position' => [
				'label'       => esc_html__( 'Category Position', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => [
					'default'      => esc_html__( 'Default', 'the-post-grid' ),
					'above_title'  => esc_html__( 'Above Title', 'the-post-grid' ),
					'with_meta'    => esc_html__( 'With Meta', 'the-post-grid' ),
					'top_left'     => esc_html__( 'Over image (Top Left)', 'the-post-grid' ),
					'top_right'    => esc_html__( 'Over image (Top Right)', 'the-post-grid' ),
					'bottom_left'  => esc_html__( 'Over image (Bottom Left)', 'the-post-grid' ),
					'bottom_right' => esc_html__( 'Over image (Bottom Right)', 'the-post-grid' ),
					'image_center' => esc_html__( 'Over image (Center)', 'the-post-grid' ),
				],
				'show_if'     => [
					'show_category' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
			'category_style'    => [
				'label'       => esc_html__( 'Category Style', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'style1',
				'options'     => [
					'style1' => esc_html__( 'Style 1 - Only Text', 'the-post-grid' ),
					'style2' => esc_html__( 'Style 2 - Background', 'the-post-grid' ),
					'style3' => esc_html__( 'Style 3 - Fold edge', 'the-post-grid' ),
					'style4' => esc_html__( 'Style 4 - Different Color', 'the-post-grid' ),
				],
				'description' => rtTPG()->hasPro() ? esc_html( 'Different background color will work if you use style 1 and 2' ) : '',
				'show_if_not' => [
					'category_position' => 'default',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],

			'tpg_directional_text_category_notice' => [
				'label'       => esc_html__( 'Please note: If you are using a different background color for the category, we recommend selecting Style 2 or Style 3 from the options above.', 'the-post-grid' ),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],

			'show_cat_icon' => [
				'label'       => esc_html__( 'Show Over Image Category Icon', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],

			'category_source' => [
				'label'       => esc_html__( 'Category Source', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => Fns::get_tax_object_ids(),
				'description' => esc_html__( 'Select which taxonomy should sit in the place of categories. Default: Category', 'the-post-grid' ),
				'default'     => 'category',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],

			'tag_source'      => [
				'label'       => esc_html__( 'Tag Source', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => Fns::get_tax_object_ids(),
				'description' => esc_html__( 'Select which taxonomy should sit in the place of tags. Default: Tags', 'the-post-grid' ),
				'default'     => 'post_tag',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
			'tpg_heading_text_comment_heading' => [
				'label'       => esc_html__( 'Comment Count ', 'the-post-grid' ),
				'type'        => 'text',
				'show_if'     => [
					'show_comment_count' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
			'show_comment_count_label'         => [
				'label'       => esc_html__( 'Show Comment Label', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'off',
				'show_if'     => [
					'show_comment_count' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
			'comment_count_label_singular'     => [
				'label'       => esc_html__( 'Comment Label Singular', 'the-post-grid' ),
				'type'        => 'text',
				'default'     => esc_html__( 'Comment', 'the-post-grid' ),
				'placeholder' => esc_html__( 'Type your title here', 'the-post-grid' ),
				'show_if'     => [
					'show_comment_count'       => 'on',
					'show_comment_count_label' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
			'comment_count_label_plural'       => [
				'label'       => esc_html__( 'Comment Label Plural', 'the-post-grid' ),
				'type'        => 'text',
				'default'     => esc_html__( 'Comments', 'the-post-grid' ),
				'placeholder' => esc_html__( 'Type your title here', 'the-post-grid' ),
				'show_if'     => [
					'show_comment_count'       => 'on',
					'show_comment_count_label' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
			'tpg_heading_text_meta_heading'    => [
				'label'       => esc_html__( 'Date Settings', 'the-post-grid' ),
				'type'        => 'text',
				'show_if'     => [
					'show_date' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
			'date_archive_link'                => [
				'label'       => esc_html__( 'Date Archive Link', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'on',
				'show_if'     => [
					'show_date' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_meta_data',
			],
		];


		if ( ! rtTPG()->hasPro() ) {
			unset( $meta_settings['tpg_directional_text_category_notice'] );
			unset( $meta_settings['show_cat_icon'] );
		}

		return $meta_settings;
	}

}
