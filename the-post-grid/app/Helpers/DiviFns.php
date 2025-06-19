<?php

namespace RT\ThePostGrid\Helpers;

class DiviFns {

	public static function get_listing_taxonomy( $parent = 'all', $taxonomy = '' ) {
		$args = [
			'taxonomy'   => 'category',
			'fields'     => 'id=>name',
			'hide_empty' => true,
		];

		if ( ! empty( $taxonomy ) ) {
			$args['taxonomy'] = sanitize_text_field( $taxonomy );
		}

		if ( 'parent' === $parent ) {
			$args['parent'] = 0;
		}

		$terms = get_terms( $args );
		if ( is_wp_error( $terms ) || ! is_array( $terms ) ) {
			return [];
		}
		$category_dropdown = [];

		foreach ( $terms as $id => $name ) {
			$category_dropdown[ $id ] = html_entity_decode( $name );
		}

		return $category_dropdown;
	}

	public static function get_page_number() {
		global $paged;

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} elseif ( isset( $_GET['listing-page'] ) ) {
			$paged = absint( empty( $_GET['listing-page'] ) ? 1 : $_GET['listing-page'] );
		} elseif ( isset( $_GET['store-page'] ) ) {
			$paged = absint( empty( $_GET['store-page'] ) ? 1 : $_GET['store-page'] );
		} else {
			$paged = 1;
		}

		return apply_filters( 'rttpg_pagination_page_number', absint( $paged ) );
	}

	public static function divi_selected_terms( $term_name, $divi_checkbox_value ) {
		$checkbox_values_arr = explode( '|', $divi_checkbox_value );

		// Get the options again to map index to term ID
		$options     = Fns::tpg_get_categories_by_id( $term_name, 'term_id' ); // [44 => 'Cat A', 33 => 'Cat B', ...]
		$option_keys = array_keys( $options );

		$selected_term_ids = [];
		foreach ( $checkbox_values_arr as $index => $value ) {
			if ( $value === 'on' && isset( $option_keys[ $index ] ) ) {
				$selected_term_ids[] = $option_keys[ $index ]; // Actual term ID
			}
		}

		return $selected_term_ids;
	}

	/**
	 * Get computed depends data key group
	 *
	 * @return string[]
	 */
	public static function computed_depends_on( $prefix ) {
		$taxonomies    = get_taxonomies( [], 'objects' );
		$computed_data = [
			'grid_column',
			'grid_column_tab',
			'grid_column_mobile',
			'layout_primary_color',
			'layout_secondary_color',
			'post_type',
			'post_types',
			'multiple_post_type',
			'post_id',
			'show_pagination',
			'ignore_sticky_posts',
			'orderby',
			'order',
			'instant_query',
			'author',
			'post_keyword',
			'exclude',
			'offset',
			'relation',
			'post_limit',
			'date_range',
			'show_taxonomy_filter',
			'show_author_filter',
			'filter_btn_style',
			'post_filter_taxonomy',
			'filter_type',
			'display_per_page',
			'pagination_type',
			'show_title',
			'excerpt_type',
			'excerpt_limit',
			'excerpt_more_text',
			'title_limit',
			'title_limit_type',
			'title_visibility_style',
			'post_link_type',
			'link_target',
			'show_thumb',
			'hover_animation',
			'is_thumb_linked',
			'is_thumb_lightbox',
			'grid_hover_overlay_type',
			'grid_hover_overlay_height',
			'on_hover_overlay',
			'show_meta',
			'meta_position',
			'show_author',
			'show_author_image',
			'author_icon_visibility',
			'show_meta_icon',
			'show_category',
			'category_style',
			'show_cat_icon',
			'show_date',
			'show_tags',
			'show_comment_count',
			'show_post_count',
			'show_excerpt',
			'show_social_share',
			'media_source',
			'image_size',
			'title_tag',
			'title_position',
			'title_hover_underline',
			'meta_separator',
			'show_read_more',
			'readmore_btn_style',
			'readmore_icon_position',
			'read_more_label',
			'readmore_btn_icon',
			'show_btn_icon',
			'category_position',
			'author_prefix',
			'grid_layout_style',
			'show_order_by',
			'show_sort_order',
			'show_search',
			'show_section_title',
			'section_title_style',
			'section_title_source',
			'section_title_text',
			'enable_external_link',
			'section_external_text',
			'section_title_tag',
			'section_title_alignment',
			'no_posts_found_text',
			'category_source',
			'tag_source',
			'show_comment_count_label',
			'comment_count_label_singular',
			'comment_count_label_plural',
			'date_archive_link',
			'show_acf',
			'cf_group',
			'cf_hide_empty_value',
			'cf_show_only_value',
			'cf_hide_group_title',
			'acf_label_style',
		];

		$computed_data[] = $prefix . '_layout';

		$post_types = Fns::get_post_types();

		foreach ( $taxonomies as $taxonomy => $object ) {
			if ( ! isset( $object->object_type[0] )
			     || ! in_array( $object->object_type[0], array_keys( $post_types ) )
			     || in_array( $taxonomy, Fns::get_excluded_taxonomy() )
			) {
				continue;
			}

			$computed_data[] = $taxonomy . '_ids';
			$computed_data[] = $taxonomy . '_ids2';
		}

		if ( 'slider' === $prefix ) {
			$computed_data[] = 'lazyLoad';
			$computed_data[] = 'speed';
			$computed_data[] = 'autoplaySpeed';
			$computed_data[] = 'autoplay';
			$computed_data[] = 'stopOnHover';
			$computed_data[] = 'arrows';
			$computed_data[] = 'dots';
			$computed_data[] = 'infinite';
			$computed_data[] = 'autoHeight';
			$computed_data[] = 'dynamic_dots';
			$computed_data[] = 'grabCursor';
			$computed_data[] = 'slider_per_group';
			$computed_data[] = 'slider_direction';
			$computed_data[] = 'arrow_position';
		}

		return $computed_data;
	}

	public static function get_data_set( $data, $total_pages, $posts_per_page, $_prefix, $is_gutenberg ) {
		$data_set = Fns::get_render_data_set( $data, $total_pages, $posts_per_page, $_prefix, $is_gutenberg );
		unset( $data_set['grid_column'] );

		$data_set['grid_column']        = $data['grid_column'] ?? '';
		$data_set['grid_column_tab']    = $data['grid_column_tab'] ?? '';
		$data_set['grid_column_mobile'] = $data['grid_column_mobile'] ?? '';

		return $data_set;
	}

	public static function layout_cols( $data, $lg = 4, $md = 6, $sm = 12 ) {
		$grid_column_desktop = ! empty( $data['grid_column'] ) ? $data['grid_column'] : $lg;
		$grid_column_tab     = ! empty( $data['grid_column_tab'] ) ? $data['grid_column_tab'] : $md;
		$grid_column_mobile  = ! empty( $data['grid_column_mobile'] ) ? $data['grid_column_mobile'] : $sm;

		return sprintf(
			'rt-col-md-%s rt-col-sm-%s rt-col-xs-%s',
			$grid_column_desktop,
			$grid_column_tab,
			$grid_column_mobile
		);
	}

	public static function thumb_condition( $prefix ) {
		$thumb_condition = [
			'media_source' => 'feature_image',
			'grid_layout'  => [ 'grid-layout5', 'grid-layout5-2', 'grid-layout6', 'grid-layout6-2' ],
		];

		if ( $prefix === 'list' ) {
			$thumb_condition = [
				'media_source' => 'feature_image',
				'list_layout'  => [ 'list-layout2', 'list-layout3', 'list-layout2-2', 'list-layout3-2' ],
			];
		}

		if ( $prefix === 'grid_hover' ) {
			$thumb_condition = [
				'media_source'      => 'feature_image',
				'grid_hover_layout' => [
					'grid_hover-layout4',
					'grid_hover-layout4-2',
					'grid_hover-layout5',
					'grid_hover-layout5-2',
					'grid_hover-layout6',
					'grid_hover-layout6-2',
					'grid_hover-layout7',
					'grid_hover-layout7-2',
					'grid_hover-layout9',
					'grid_hover-layout9-2',
				],
			];
		}

		if ( $prefix === 'slider' ) {
			$thumb_condition = [
				'media_source'  => 'feature_image',
				'slider_layout' => [ 'slider-layout10' ],
			];
		}

		return $thumb_condition;
	}

	/**
	 * Post Query for normal grid widget
	 *
	 * @param          $data
	 * @param string $prefix
	 *
	 * @return array
	 */
	public static function get_post_query( $data, $prefix = '' ): array {
		$_post_type = ! empty( $data['post_type'] ) ? esc_html( $data['post_type'] ) : 'post';

		if ( rtTPG()->hasPro() && 'on' == $data['multiple_post_type'] && ! empty( $data['post_types'] ) ) {
			$post_types          = Fns::get_post_types();
			$checkbox_values_arr = explode( '|', $data['post_types'] );

			$option_keys = array_keys( $post_types );

			$_post_types = [];
			foreach ( $checkbox_values_arr as $index => $value ) {
				if ( $value === 'on' && isset( $option_keys[ $index ] ) ) {
					$_post_types[] = $option_keys[ $index ]; // Actual term ID
				}
			}

			$post_type = Fns::available_post_types( $_post_types );
		} else {
			$post_type = Fns::available_post_type( $_post_type );
		}
		/**
		 * Post status has been removed. The commented code will be deleted later.
		 */
		$args = [
			'post_type'   => $post_type,
			'post_status' => 'publish',
		];

		if ( $prefix !== 'slider' && 'on' === $data['show_pagination'] ) {
			$_paged        = is_front_page() ? 'page' : 'paged';
			$args['paged'] = get_query_var( $_paged ) ? absint( get_query_var( $_paged ) ) : 1;
		}

		if ( rtTPG()->hasPro() && 'on' == $data['ignore_sticky_posts'] ) {
			$args['ignore_sticky_posts'] = 1;
		}

		if ( 'current_query' == $data['post_type'] && is_archive() ) {
			return $args;
		}

		if ( $data['post_id'] ) {
			$post_ids = explode( ',', esc_html( $data['post_id'] ) );
			$post_ids = array_map( 'trim', $post_ids );

			$args['post__in'] = $post_ids;
		}

		if ( $orderby = $data['orderby'] ) {
			$order_by        = ( $orderby == 'meta_value_datetime' ) ? 'meta_value_num' : $orderby;
			$args['orderby'] = esc_html( $order_by );

			if ( in_array( $orderby, [ 'meta_value', 'meta_value_num', 'meta_value_datetime' ] ) && $data['meta_key'] ) {
				$args['meta_key'] = esc_html( $data['meta_key'] ); //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			} elseif ( 'include_only' == $orderby ) {
				$args['orderby'] = 'post__in';
			}
		}

		if ( $data['order'] ) {
			$args['order'] = esc_html( $data['order'] );
		}

		if ( $data['instant_query'] ) {
			$args = Fns::get_instant_query( $data['instant_query'], $args );
		}

		if ( $data['author'] ) {
			$args['author__in'] = array_map( 'intval', $data['author'] );
		}

		if ( isset( $data['date_range'] ) ) :
			if ( rtTPG()->hasPro() && $data['date_range'] ) {
				if ( strpos( $data['date_range'], 'to' ) ) {
					$date_range         = explode( 'to', esc_html( $data['date_range'] ) );
					$args['date_query'] = [
						[
							'after'     => trim( $date_range[0] ),
							'before'    => trim( $date_range[1] ),
							'inclusive' => true,
						],
					];
				}
			}
		endif;

		if ( rtTPG()->hasPro() && 'on' === $data['multiple_post_type'] ) {
			$_taxonomies = [];
			foreach ( $post_type as $ptype ) {
				$_obj = get_object_taxonomies( $ptype, 'objects' );
				foreach ( $_obj as $key => $obj ) {
					$_taxonomies[ $key ] = $obj;
				}
			}
			$tax_id = '_ids2';
		} else {
			$_taxonomies = get_object_taxonomies( $post_type, 'objects' );
			$tax_id      = '_ids';
		}

		$_post_type = is_array( $post_type ) ? 'post' : $post_type;
		foreach ( $_taxonomies as $index => $object ) {
			if ( in_array( $object->name, Fns::get_excluded_taxonomy() ) ) {
				continue;
			}

			$setting_key = $object->name . $tax_id;

			$selected_term_ids = DiviFns::divi_selected_terms( $object->name, $data[ $setting_key ] );

			if ( $prefix !== 'slider' && rtTPG()->hasPro() && 'on' === $data['show_taxonomy_filter'] ) {
				if ( ( $data[ $_post_type . '_filter_taxonomy' ] == $object->name ) && isset( $data[ $object->name . '_default_terms' ] ) && $data[ $object->name . '_default_terms' ] !== '0' ) {
					//phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					$args['tax_query'][] = [
						'taxonomy' => $data[ $_post_type . '_filter_taxonomy' ],
						'field'    => 'term_id',
						'terms'    => $data[ $object->name . '_default_terms' ],
					];
				} else {
					if ( ! empty( $selected_term_ids ) ) {
						//phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
						$args['tax_query'][] = [
							'taxonomy' => $object->name,
							'field'    => 'term_id',
							'terms'    => $selected_term_ids,
						];
					}
				}
			} else {
				if ( ! empty( $selected_term_ids ) ) {
					//phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					$args['tax_query'][] = [
						'taxonomy' => $object->name,
						'field'    => 'term_id',
						'terms'    => $selected_term_ids,
					];
				}
			}
		}

		if ( ! empty( $args['tax_query'] ) && $data['relation'] ) {
			$args['tax_query']['relation'] = esc_html( $data['relation'] ); //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		}

		if ( $data['post_keyword'] ) {
			$args['s'] = esc_html( $data['post_keyword'] );
		}

		$offset_posts = $excluded_ids = [];
		if ( $data['exclude'] || $data['offset'] ) {
			if ( $data['exclude'] ) {
				$excluded_ids = explode( ',', esc_html( $data['exclude'] ) );
				$excluded_ids = array_map( 'trim', $excluded_ids );
			}

			if ( $data['offset'] ) {
				$_temp_args = $args;
				unset( $_temp_args['paged'] );
				$_temp_args['posts_per_page'] = $data['offset'];
				$_temp_args['fields']         = 'ids';

				$offset_posts = get_posts( $_temp_args );
			}

			$excluded_post_ids    = array_merge( $offset_posts, $excluded_ids );
			$args['post__not_in'] = array_unique( $excluded_post_ids );  //phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in
		}

		if ( $prefix !== 'slider' ) {
			if ( $data['post_limit'] ) {
				$tempArgs                   = $args;
				$tempArgs['posts_per_page'] = intval( $data['post_limit'] );
				$tempArgs['paged']          = 1;
				$tempArgs['fields']         = 'ids';
				if ( ! empty( $offset_posts ) ) {
					$tempArgs['post__not_in'] = $offset_posts; //phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in
				}

				$tempQ = new \WP_Query( apply_filters( 'tpg_sc_temp_query_args', $tempArgs ) );
				if ( ! empty( $tempQ->posts ) ) {
					$_post_per_page = ( 'on' == $data['show_pagination'] && $data['display_per_page'] ) ? $data['display_per_page'] : $data['post_limit'];
					if ( $data['post_limit'] > 0 ) {
						$args['post__in'] = $tempQ->posts;
					}
					$args['posts_per_page'] = intval( $_post_per_page );
				}
			} else {
				$_posts_per_page = 9;
				if ( 'grid' === $prefix ) {
					if ( $data['grid_layout'] == 'grid-layout5' ) {
						$_posts_per_page = 5;
					} elseif ( in_array( $data['grid_layout'], [ 'grid-layout6', 'grid-layout6-2' ] ) ) {
						$_posts_per_page = 3;
					} elseif ( in_array( $data['grid_layout'], [ 'grid-layout5', 'grid-layout5-2' ] ) ) {
						$_posts_per_page = 5;
					}
				} elseif ( 'list' === $prefix ) {
					if ( in_array( $data['list_layout'], [ 'list-layout2', 'list-layout2-2' ] ) ) {
						$_posts_per_page = 7;
					} elseif ( in_array( $data['list_layout'], [ 'list-layout3', 'list-layout3-2' ] ) ) {
						$_posts_per_page = 5;
					}
				} elseif ( 'grid_hover' === $prefix ) {
					if ( in_array( $data['grid_hover_layout'], [ 'grid_hover-layout4', 'grid_hover-layout4-2' ] ) ) {
						$_posts_per_page = 7;
					} elseif ( in_array(
						$data['grid_hover_layout'],
						[
							'grid_hover-layout5',
							'grid_hover-layout5-2',
						]
					) ) {
						$_posts_per_page = 3;
					} elseif ( in_array(
						$data['grid_hover_layout'],
						[
							'grid_hover-layout6',
							'grid_hover-layout6-2',
							'grid_hover-layout9',
							'grid_hover-layout9-2',
							'grid_hover-layout10',
							'grid_hover-layout11',
						]
					)
					) {
						$_posts_per_page = 4;
					} elseif ( in_array(
						$data['grid_hover_layout'],
						[
							'grid_hover-layout7',
							'grid_hover-layout7-2',
							'grid_hover-layout8',
						]
					) ) {
						$_posts_per_page = 5;
					} elseif ( in_array(
						$data['grid_hover_layout'],
						[
							'grid_hover-layout6',
							'grid_hover-layout6-2',
						]
					) ) {
						$_posts_per_page = 4;
					}
				}

				$args['posts_per_page'] = $data['display_per_page'] ?: $_posts_per_page;
			}
		} else {
			$slider_per_page = $data['post_limit'];
			if ( $data['slider_layout'] == 'slider-layout10' ) {
				$slider_reminder = ( intval( $data['post_limit'], 10 ) % 5 );
				if ( $slider_reminder ) {
					$slider_per_page = ( $data['post_limit'] - $slider_reminder + 5 );
				}
			}
			$args['posts_per_page'] = intval( $slider_per_page );
		}

		return apply_filters( 'tpg_sc_query_args', $args );
	}

	public static function is_divi_builder_preview(): bool {
		return (
			( isset( $_GET['et_fb'] ) && $_GET['et_fb'] == '1' ) ||
			( is_admin() && isset( $_GET['page'] ) && $_GET['page'] === 'et_theme_builder' )
		);
	}

	/**
	 * Script controller
	 *
	 * @param $dat
	 *
	 * @return void
	 */
	public static function get_script_depends( $data, $prefix ) {
		$settings = get_option( rtTPG()->options['settings'] );

		if (
			rtTPG()->hasPro() &&
			(
				$data['is_thumb_lightbox'] === 'show' || 'popup' == $data['post_link_type'] || 'multi_popup' == $data['post_link_type'] ||
				in_array( $data[ $prefix . '_layout' ], [ 'grid-layout7', 'slider-layout4' ] )
			)
		) {
			wp_enqueue_style( 'rt-magnific-popup' );
			wp_enqueue_script( 'rt-magnific-popup' );
		}

		if ( rtTPG()->hasPro() && ( 'popup' == $data['post_link_type'] || 'multi_popup' == $data['post_link_type'] ) ) {
			wp_enqueue_script( 'rt-scrollbar' );
			add_action( 'wp_footer', [ Fns::class, 'get_modal_markup' ] );
		}

		if ( rtTPG()->hasPro() && 'button' == $data['filter_type'] && 'carousel' == $data['filter_btn_style'] ) {
			wp_enqueue_script( 'swiper' );
		}

		if ( isset( $data['grid_layout_style'] ) && 'masonry' === $data['grid_layout_style'] ) {
			wp_enqueue_script( 'rt-isotope-js' );
		}

		if ( 'on' == $data['show_pagination'] && 'pagination_ajax' == $data['pagination_type'] ) {
			wp_enqueue_script( 'rt-pagination' );
		}

		if ( isset( $settings['tpg_load_script'] ) ) {
			wp_enqueue_style( 'rt-fontawsome' );
			wp_enqueue_style( 'rt-flaticon' );
			wp_enqueue_style( 'rt-tpg-block' );
			if ( $prefix === 'slider' ) {
				wp_enqueue_style( 'swiper' );
			}
		}

		wp_enqueue_script( 'imagesloaded' );
		if ( $prefix === 'slider' ) {
			wp_enqueue_script( 'swiper' );
			wp_enqueue_style( 'swiper' );
		}
		wp_enqueue_script( 'rt-tpg' );
		wp_enqueue_script( 'rttpg-block-pro' );
	}

}