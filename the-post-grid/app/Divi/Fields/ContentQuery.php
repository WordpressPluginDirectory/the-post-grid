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
class ContentQuery {

	public static function get_fields( $prefix = 'grid' ) {
		$post_types = Fns::get_post_types();

		$taxonomies     = get_taxonomies( [], 'objects' );
		$singlePostType = $post_types;
		if ( rtTPG()->hasPro() ) {
			$singlePostType = $post_types + [ 'current_query' => __( 'Current Query', 'the-post-grid' ) ];
		}

		$query_fields = [
			'multiple_post_type' => [
				'label'       => esc_html__( 'Multiple Post Types?', 'the-post-grid' ),
				'description' => esc_html__( 'If you enable Multiple Post Types the Front-end Filter will not work.', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'off',
				'show_if_not' => [
					'post_type' => 'current_query',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],

			'post_type'                       => [
				'label'       => esc_html__( 'Post Source', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => $singlePostType,
				'default'     => 'post',
				'description' => Fns::get_pro_message( 'all post type.' ),
				'show_if_not' => [
					'multiple_post_type' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'post_types'                      => [
				'label'       => esc_html__( 'Post Sources', 'the-post-grid' ),
				'type'        => 'multiple_checkboxes',
				'options'     => $post_types,
				'default'     => [ 'post' ],
				'description' => Fns::get_pro_message( 'all post type.' ),
				'show_if'     => [
					'multiple_post_type' => 'on',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'post_id'                         => [
				'label'       => esc_html__( 'Include only', 'the-post-grid' ),
				'type'        => 'text',
				'description' => esc_html__( 'Enter the post IDs separated by comma for include', 'the-post-grid' ),
				'placeholder' => 'Eg. 10, 15, 17',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'exclude'                         => [
				'label'       => esc_html__( 'Exclude', 'the-post-grid' ),
				'type'        => 'text',
				'description' => esc_html__( 'Enter the post IDs separated by comma for exclude', 'the-post-grid' ),
				'placeholder' => 'Eg. 12, 13',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'post_limit'                      => [
				'label'       => esc_html__( 'Limit', 'the-post-grid' ),
				'type'        => 'number',
				'description' => esc_html__( 'The number of posts to show. Enter -1 to show all found posts.', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'display_per_page'                => [
				'label'       => esc_html__( 'Display Per Page', 'the-post-grid' ),
				'type'        => 'number',
				'description' => esc_html__( 'Enter how may posts will display per page. It works only for the the pagination and ajax-filer.', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'offset'                          => [
				'label'       => esc_html__( 'Offset', 'the-post-grid' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'Enter Post offset', 'the-post-grid' ),
				'description' => esc_html__( 'Number of posts to skip. The offset parameter is ignored when post limit => -1 is used.', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'instant_query'                   => [
				'label'       => esc_html__( 'Quick Query', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => [
					'default'                     => esc_html__( '--Quick Query--', 'the-post-grid' ),
					'popular_post_1_day_view'     => esc_html__( 'Popular Post (1 Day View)', 'the-post-grid' ),
					'popular_post_7_days_view'    => esc_html__( 'Popular Post (7 Days View)', 'the-post-grid' ),
					'popular_post_30_days_view'   => esc_html__( 'Popular Post (30 Days View)', 'the-post-grid' ),
					'popular_post_all_times_view' => esc_html__( 'Popular Post (All time View)', 'the-post-grid' ),
					'most_comment_1_day'          => esc_html__( 'Most Comment (1 Day)', 'the-post-grid' ),
					'most_comment_7_days'         => esc_html__( 'Most Comment (7 Days)', 'the-post-grid' ),
					'most_comment_30_days'        => esc_html__( 'Most Comment (30 Days)', 'the-post-grid' ),
					'random_post_7_days'          => esc_html__( 'Random Posts (7 Days)', 'the-post-grid' ),
					'random_post_30_days'         => esc_html__( 'Random Post (30 Days)', 'the-post-grid' ),
					'related_category'            => esc_html__( 'Related Posts (Category)', 'the-post-grid' ),
					'related_tag'                 => esc_html__( 'Related Posts (Tag)', 'the-post-grid' ),
					'related_cat_tag'             => esc_html__( 'Related Posts (Tag and Category)', 'the-post-grid' ),
				],
				'default'     => 'default',
				'description' => esc_html__( 'If you choose any value from here the orderby worn\'t work.', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'tpg_heading_text_advanced_query' => [
				'label'       => esc_html__( 'Advanced Query', 'the-post-grid' ),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
		];

		$_url = site_url( 'wp-admin/edit.php?post_type=rttpg&page=tgp_taxonomy_order' );

		foreach ( $taxonomies as $taxonomy => $object ) {
			if ( ! isset( $object->object_type[0] )
			     || ! in_array( $object->object_type[0], array_keys( $post_types ) )
			     || in_array( $taxonomy, Fns::get_excluded_taxonomy() )
			) {
				continue;
			}

			$taxonomy_lists = Fns::tpg_get_categories_by_id( $taxonomy, 'term_id' );

			$query_fields[ $taxonomy . '_ids' ] = [
				'label'       => esc_html__( 'By ', 'the-post-grid' ) . $object->label,
				'type'        => 'multiple_checkboxes',
				'options'     => $taxonomy_lists,
				'show_if'     => [ 'post_type' => $object->object_type, ],
				'show_if_not' => [ 'multiple_post_type' => 'on' ],
				'description' => "For custom order: <a target='_blank' href='" . $_url . "'>The Post Grid > Taxonomy Order</a>. NB: The terms are currently displayed in the order of their term_id",
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
				'columns'     => 2,
			];

			if(! empty($taxonomy_lists)) {
				$query_fields[ $taxonomy . '_ids2' ] = [
					'label'       => esc_html__( 'By ', 'the-post-grid' ) . $object->label,
					'type'        => 'multiple_checkboxes',
					'options'     => $taxonomy_lists,
					'show_if'     => [
						'multiple_post_type' => 'on',
					],
					'description' => "For custom order: <a target='_blank' href='" . $_url . "'>The Post Grid > Taxonomy Order</a>",
					'tab_slug'    => 'general',
					'toggle_slug' => 'tpg_query',
					'columns'     => 2,
				];
			}
		}

		$orderby_opt = [
			'date'          => esc_html__( 'Date', 'the-post-grid' ),
			'ID'            => esc_html__( 'Order by post ID', 'the-post-grid' ),
			'author'        => esc_html__( 'Author', 'the-post-grid' ),
			'title'         => esc_html__( 'Title', 'the-post-grid' ),
			'modified'      => esc_html__( 'Last modified date', 'the-post-grid' ),
			'parent'        => esc_html__( 'Post parent ID', 'the-post-grid' ),
			'comment_count' => esc_html__( 'Number of comments', 'the-post-grid' ),
			'menu_order'    => esc_html__( 'Menu order', 'the-post-grid' ),
		];

		if ( rtTPG()->hasPro() ) {
			$prderby_pro_opt = [
				'include_only'        => esc_html__( 'Include Only', 'the-post-grid' ),
				'rand'                => esc_html__( 'Random order', 'the-post-grid' ),
				'meta_value'          => esc_html__( 'Meta value', 'the-post-grid' ), //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'meta_value_num'      => esc_html__( 'Meta value number', 'the-post-grid' ),
				'meta_value_datetime' => esc_html__( 'Meta value datetime', 'the-post-grid' ),
			];
			$orderby_opt     = array_merge( $orderby_opt, $prderby_pro_opt );
		}

		$query_fields_2 = [
			'relation'            => [
				'label'       => esc_html__( 'Taxonomies Relation', 'the-post-grid' ),
				'type'        => 'select',
				'default'     => 'OR',
				'options'     => [
					'OR'  => __( 'OR', 'the-post-grid' ),
					'AND' => __( 'AND', 'the-post-grid' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'author'              => [
				'label'       => esc_html__( 'By Author', 'the-post-grid' ),
				'options'     => Fns::rt_get_users(),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'post_keyword'        => [
				'label'       => esc_html__( 'By Keyword', 'the-post-grid' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'Search by keyword', 'the-post-grid' ),
				'description' => esc_html__( 'Search by post title or content keyword', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'date_range'          => [
				'label'       => esc_html__( 'Date Range (Start - End)', 'the-post-grid' ),
				'type'        => 'text',
				'placeholder' => esc_html__( '2025-02-22 to 2025-05-30', 'the-post-grid' ),
				'description' => esc_html__( 'Enter a date range in the format: 2025-02-22 to 2025-05-30. Use "to" to separate the start and end dates.', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'orderby'             => [
				'label'       => esc_html__( 'Order by', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => $orderby_opt,
				'default'     => 'date',
				'description' => Fns::get_pro_message( 'Random Order.' ),
				'show_if'     => [
					'instant_query' => 'default',
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'meta_key'            => [
				'label'       => esc_html__( 'Meta Key', 'the-post-grid' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'Enter Meta Key.', 'the-post-grid' ),
				'show_if'     => [
					'orderby' => [ 'meta_value', 'meta_value_num', 'meta_value_datetime' ],
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'order'               => [
				'label'       => esc_html__( 'Sort order', 'the-post-grid' ),
				'type'        => 'select',
				'options'     => [
					'ASC'  => esc_html__( 'ASC', 'the-post-grid' ),
					'DESC' => esc_html__( 'DESC', 'the-post-grid' ),
				],
				'default'     => 'DESC',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'ignore_sticky_posts' => [
				'label'       => esc_html__( 'Ignore sticky posts at the top', 'the-post-grid' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'Yes', 'the-post-grid' ),
					'off' => esc_html__( 'No', 'the-post-grid' ),
				],
				'default'     => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
			'no_posts_found_text' => [
				'label'       => esc_html__( 'No post found Text', 'the-post-grid' ),
				'type'        => 'text',
				'default'     => esc_html__( 'No posts found.', 'the-post-grid' ),
				'placeholder' => esc_html__( 'Enter No post found', 'the-post-grid' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'tpg_query',
			],
		];

		return array_merge( $query_fields, $query_fields_2 );
	}

}
