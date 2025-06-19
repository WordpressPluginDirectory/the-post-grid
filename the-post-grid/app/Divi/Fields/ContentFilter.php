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
class ContentFilter {

	public static function get_fields( $prefix = 'grid' ) {
		if ( ! rtTPG()->hasPro() ) {
			return [];
		}

		$divi_fields = [

			'tpg_directional_text_filter_notice' => [
				'label'       => esc_html__( "Please note: Not all front-end filter features are supported in the editor view.", 'the-post-grid' ),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],

			'show_taxonomy_filter' => [
				'label'       => esc_html__( 'Taxonomy Filter', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],
			'show_author_filter'   => [
				'label'       => esc_html__( 'Author Filter', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],
			'show_order_by'        => [
				'label'       => esc_html__( 'Order By Filter', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],
			'show_sort_order'      => [
				'label'       => esc_html__( 'Sort Order Filter', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],
			'show_search'          => [
				'label'       => esc_html__( 'Search Filter', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],

			'search_by' => [
				'label'       => esc_html__( 'Search By', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'all_content',
				'options'     => [
					'all_content' => esc_html__( 'All Content', 'the-post-grid' ),
					'title'       => esc_html__( 'Title only', 'the-post-grid' ),
				],
				'show_if'     => [ 'show_search' => 'on' ],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],

			'filter_type'       => [
				'label'       => esc_html__( 'Filter Type', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'dropdown',
				'options'     => [
					'dropdown' => esc_html__( 'Dropdown', 'the-post-grid' ),
					'button'   => esc_html__( 'Button', 'the-post-grid' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],
			/*'multiple_taxonomy' => [
				'label'        => esc_html__( 'Multiple Taxonomy', 'the-post-grid' ),
				'type'         => 'yes_no_button',
				'options'      => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'      => 'off',
				'description'  => esc_html__( 'You must choose taxonomy terms from the query build for each taxonomy for the multiple taxonomy. Otherwise it won\'t work. ', 'the-post-grid' ),
				'return_value' => 'yes',
				'show_if'      => [
					'show_taxonomy_filter' => 'on',
				],
				'tab_slug'     => 'general',
				'toggle_slug'  => 'tpg_filter',
			],*/
		];

		$post_types      = Fns::get_post_types();

		foreach ( $post_types as $post_type => $label ) {
			$_taxonomies = get_object_taxonomies( $post_type, 'object' );
			if ( empty( $_taxonomies ) ) {
				continue;
			}
			$taxonomies_list = [];
			foreach ( $_taxonomies as $tax ) {
				if ( in_array(
					$tax->name,
					[
						'post_format',
						'elementor_library_type',
						'product_visibility',
						'product_shipping_class',
					]
				) ) {
					continue;
				}

				$taxonomies_list[ $tax->name ] = $tax->label;
			}

			if ( 'post' === $post_type ) {
				$default_cat = 'category';
			} elseif ( 'product' === $post_type ) {
				$default_cat = 'product_cat';
			} elseif ( 'download' === $post_type ) {
				$default_cat = 'download_category';
			} elseif ( 'docs' === $post_type ) {
				$default_cat = 'doc_category';
			} elseif ( 'lp_course' === $post_type ) {
				$default_cat = 'course_category';
			} else {
				$taxonomie_keys = array_keys( $_taxonomies );
				$filter_cat     = array_filter(
					$taxonomie_keys,
					function( $item ) {
						return strpos( $item, 'cat' ) !== false;
					}
				);

				if ( is_array( $filter_cat ) && ! empty( $filter_cat ) ) {
					$default_cat = array_shift( $filter_cat );
				}
			}

			$divi_fields[ $post_type . '_filter_taxonomy' ] = [
				'label'       => esc_html__( 'Choose Taxonomy', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => $default_cat,
				'options'     => $taxonomies_list,
				'show_if'     => [
					'post_type'            => $post_type,
					'show_taxonomy_filter' => 'on',
				],
				'show_if_not' => [
					'multiple_taxonomy' => 'on',
				],
				'description' => esc_html__( 'Select a taxonomy for showing in filter', 'the-post-grid' ),
				'tab_slug'     => 'general',
				'toggle_slug'  => 'tpg_filter',
			];

			$divi_fields[ $post_type . '_filter_taxonomies' ] = [
				'label'       => esc_html__( 'Choose Taxonomies', 'the-post-grid' ),
				'type'        => 'select',
				'multiple'    => true,
				'default'     => $default_cat,
				'options'     => $taxonomies_list,
				'show_if'     => [
					'post_type'            => $post_type,
					'show_taxonomy_filter' => 'on',
					'multiple_taxonomy'    => 'on',
				],
				'description' => esc_html__( 'Select a taxonomies for showing in filter', 'the-post-grid' ),
				'tab_slug'     => 'general',
				'toggle_slug'  => 'tpg_filter',
			];

			foreach ( $_taxonomies as $tax ) {
				if ( in_array(
					$tax->name,
					[
						'post_format',
						'elementor_library_type',
						'product_visibility',
						'product_shipping_class',
					]
				) ) {
					continue;
				}

				$term_first = [ '0' => esc_html__( '--Select--', 'the-post-grid' ) ];
				$term_lists = get_terms(
					[
						'taxonomy'   => $tax->name, // Custom taxonomy name.
						'hide_empty' => true,
						'fields'     => 'id=>name',
					]
				);

				$term_lists = $term_first + $term_lists;

				$terms_prefix = '';
				if ( 'post' != $post_type ) {
					$terms_prefix = $post_type . '_';
				}
				$terms_prefix .= $tax->name;

				$divi_fields[ $terms_prefix . '_default_terms' ] = [
					'label'       => esc_html__( 'Selected ', 'the-post-grid' ) . $tax->label,
					'type'        => 'select',
					'default'     => '0',
					'options'     => $term_lists,
					'show_if'     => [
						$post_type . '_filter_taxonomy' => $tax->name,
						'post_type'                     => $post_type,
						'show_taxonomy_filter'          => 'on',
					],
					'show_if_not' => [
						'multiple_taxonomy' => 'on',
					],
					'tab_slug'     => 'general',
					'toggle_slug'  => 'tpg_filter',
				];
			}
		}

		$divi_fields2 = [

			'filter_btn_style' => [
				'label'       => esc_html__( 'Filter Style', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'default',
				'options'     => [
					'default'  => esc_html__( 'Default', 'the-post-grid' ),
					'carousel' => esc_html__( 'Collapsable', 'the-post-grid' ),
				],
				'show_if'     => [ 'filter_type' => 'button', ],
				'show_if_not' => [ 'multiple_taxonomy' => 'on' ],
				'description' => esc_html__( 'If you use collapsable then only taxonomy section will show on the filter', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],

			'filter_btn_item_per_page' => [
				'label'       => esc_html__( 'Button Item Per Slider', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => [
					'auto' => esc_html__( 'Auto', 'the-post-grid' ),
					'2'    => esc_html__( '2', 'the-post-grid' ),
					'3'    => esc_html__( '3', 'the-post-grid' ),
					'4'    => esc_html__( '4', 'the-post-grid' ),
					'5'    => esc_html__( '5', 'the-post-grid' ),
					'6'    => esc_html__( '6', 'the-post-grid' ),
					'7'    => esc_html__( '7', 'the-post-grid' ),
					'8'    => esc_html__( '8', 'the-post-grid' ),
					'9'    => esc_html__( '9', 'the-post-grid' ),
					'10'   => esc_html__( '10', 'the-post-grid' ),
					'11'   => esc_html__( '11', 'the-post-grid' ),
					'12'   => esc_html__( '12', 'the-post-grid' ),
				],
				'default'     => 'auto',
				'show_if'     => [
					'filter_type'      => 'button',
					'filter_btn_style' => 'carousel',
				],
				'description' => esc_html__( 'If you use carousel then only category section show on the filter', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],

			'filter_post_count' => [
				'label'       => esc_html__( 'Filter Post Count', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'no',
				'options'     => [
					'yes' => esc_html__( 'Yes', 'the-post-grid' ),
					'no'  => esc_html__( 'No', 'the-post-grid' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],

			'tgp_filter_taxonomy_hierarchical' => [
				'label'       => esc_html__( 'Tax Hierarchical', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'yes',
				'options'     => [
					'yes' => esc_html__( 'Yes', 'the-post-grid' ),
					'no'  => esc_html__( 'No', 'the-post-grid' ),
				],
				'show_if'     => [
					'filter_type'      => 'button',
					'filter_btn_style' => 'default',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],

			'tpg_hide_all_button' => [
				'label'       => esc_html__( 'Hide "Show all" button', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'yes',
				'options'     => [
					'yes' => esc_html__( 'Yes', 'the-post-grid' ),
					'no'  => esc_html__( 'No', 'the-post-grid' ),
				],
				'show_if'     => [
					'filter_type' => 'button',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],

			'custom_taxonomy_order' => [
				'label'       => esc_html__( 'Taxonomy Order', 'the-post-grid' ),
				'default'     => 'no',
				'type'        => 'select',
				'options'     => [
					'yes' => esc_html__( 'Yes', 'the-post-grid' ),
					'no'  => esc_html__( 'No', 'the-post-grid' ),
				],
				'show_if'     => [
					'show_taxonomy_filter' => 'on',
				],
				'description' => esc_html__( 'You must sort taxonomy from the dashboard first.', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],

			'tax_filter_all_text'    => [
				'label'       => esc_html__( 'All Taxonomy Text', 'the-post-grid' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'Enter All Category Text Here..', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],
			'tax_filter_all_text2'   => [
				'label'       => esc_html__( 'All Taxonomy Text 2', 'the-post-grid' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'Enter All Tax 2 Here..', 'the-post-grid' ),
				'description' => esc_html__( 'This is optional. If you need you can change for 2nd taxonomy.', 'the-post-grid' ),
				'show_if'     => [
					'multiple_taxonomy' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],
			'tax_filter_all_text3'   => [
				'label'       => esc_html__( 'All Taxonomy Text 3', 'the-post-grid' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'Enter All Tax 3 Here..', 'the-post-grid' ),
				'description' => esc_html__( 'This is optional. If you need you can change for 3rd taxonomy.', 'the-post-grid' ),
				'show_if'     => [
					'multiple_taxonomy' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],
			'author_filter_all_text' => [
				'label'       => esc_html__( 'All Users Text', 'the-post-grid' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'Enter All Users Text Here..', 'the-post-grid' ),
				'show_if'     => [
					'show_author_filter' => 'on',
					'filter_btn_style'   => 'default',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],
			'filter_preloader'       => [
				'label'       => esc_html__( 'Filter Preloader?', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'on',
				'options'     => [
					'on'  => esc_html__( 'On', 'the-post-grid' ),
					'off' => esc_html__( 'Off', 'the-post-grid' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_filter',
			],
		];

		return array_merge( $divi_fields, $divi_fields2 );
	}

}
