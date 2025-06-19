<?php
/**
 * Divi Helper Class
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Divi\Fields;

class AdvancedFields {

	public static function get_fields( $prefix = '' ) {
		$advanced_fields = [];

		$advanced_fields['text']        = false; //hide text section
		$advanced_fields['text_shadow'] = []; //hide text shadow section

		//Advanced Fields
		$advanced_fields['form_field'] = [
			'tpg_section_title_style' => self::get_section_title(),
			'tpg_post_title_style'    => self::get_post_title(),
			'tpg_thumbnail_style'     => self::get_post_thumbail(),
			'tpg_excerpt_style'       => self::get_post_excerpt(),
			'tpg_meta_data_style'     => self::get_post_meta(),
			'tpg_social_share_style'  => self::get_social_share(),
			'tpg_read_more_style'     => self::get_read_more(),
			'tpg_filter_style'        => self::get_filter_style(),
			'tpg_pagination_style'    => self::get_pagination(),
			'tpg_card_style'          => self::get_post_card(),
		];

		if ( 'slider' == $prefix ) {
			$advanced_fields['form_field']['tpg_slider_style'] = self::get_slider();
		}

		return $advanced_fields;
	}

	/**
	 * Advanced fields for Section Title
	 *
	 * @return array
	 */
	public static function get_section_title() {
		return [
			'label'                  => __( 'Section Title', 'the-post-grid' ),
			'toggle_priority'        => 99,
			'focus_background_color' => false,
			'focus_text_color'       => false,
			'text_shadow'            => false,
			'box_shadow'             => false,
			'text_color'             => false,
			'background_color'       => false,

			'css' => [
				'main'      => '%%order_class%% .tpg-widget-heading-wrapper',
				'padding'   => '%%order_class%% .tpg-widget-heading-wrapper',
				'margin'    => '%%order_class%% .tpg-widget-heading-wrapper',
				'important' => [ 'all' ],
			],

			'margin_padding' => [
				'css' => [
					'main'      => '%%order_class%% .tpg-widget-heading-wrapper',
					'padding'   => '%%order_class%% .tpg-widget-heading-wrapper',
					'margin'    => '%%order_class%% .tpg-widget-heading-wrapper',
					'important' => 'all',
				],
			],
			'border_styles'  => [
				'tpg_section_title_style' => [
					'main'      => [
						'border_radii'  => '%%order_class%% .tpg-widget-heading-wrapper .tpg-widget-heading',
						'border_styles' => '%%order_class%% .tpg-widget-heading-wrapper .tpg-widget-heading',
					],
					'important' => 'all',
				],
			],

			'font_field' => [
				'css' => [
					'main'      => [ '.et-db .et-l %%order_class%% .tpg-widget-heading-wrapper .tpg-widget-heading' ],
					'important' => 'all',
				],
			],

		];
	}

	/**
	 * Advanced fields for Title
	 *
	 * @return array
	 */
	public static function get_post_title() {
		return [
			'label'                  => __( 'Post Title', 'the-post-grid' ),
			'focus_background_color' => false,
			'focus_text_color'       => false,
			'text_shadow'            => false,
			'box_shadow'             => false,
			'text_color'             => false,
			'background_color'       => false,

			'css' => [
				'main'      => '%%order_class%% .rt-tpg-container .rt-holder .entry-title-wrapper',
				'padding'   => '%%order_class%% .rt-tpg-container .rt-holder .entry-title-wrapper',
				'margin'    => '%%order_class%% .rt-tpg-container .rt-holder .entry-title-wrapper',
				'important' => [ 'all' ],
			],

			'margin_padding' => [
				'css' => [
					'main'      => '%%order_class%% .rt-tpg-container .rt-holder .entry-title-wrapper',
					'padding'   => '%%order_class%% .rt-tpg-container .rt-holder .entry-title-wrapper .entry-title',
					'margin'    => '%%order_class%% .rt-tpg-container .rt-holder .entry-title-wrapper',
					'important' => 'all',
				],
			],

			'font_field' => [
				'css' => [
					'main'      => [ '%%order_class%% .tpg-el-main-wrapper .entry-title-wrapper .entry-title' ],
					'important' => 'all',
				],
			],

			'border_styles' => [
				'tpg_post_title_style' => [
					'label_prefix' => __( 'Title', 'the-post-grid' ),
					'css'          => [
						'main' => [
							'border_styles' => '%%order_class%% .rt-tpg-container .rt-holder .entry-title-wrapper .entry-title',
							'border_radii'  => '%%order_class%% .rt-tpg-container .rt-holder .entry-title-wrapper .entry-title',
						],
					],
				],
			],

		];
	}

	/**
	 * Advanced fields for Post Thumbnail
	 *
	 * @return array
	 */
	public static function get_post_thumbail() {
		return [
			'label'                  => __( 'Post Thumbnail', 'the-post-grid' ),
			'focus_background_color' => false,
			'focus_text_color'       => false,
			'text_shadow'            => false,
			'box_shadow'             => false,
			'text_color'             => false,
			'background_color'       => false,
			'font_field'             => false,

			'css' => [
				'main'      => '%%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap',
				'padding'   => '%%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap',
				'margin'    => '%%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap',
				'important' => [ 'all' ],
			],

			'margin_padding' => [
				'css' => [
					'main'      => '%%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap',
					'padding'   => '%%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap',
					'margin'    => '%%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap',
					'important' => 'all',
				],
			],

			'border_styles' => [
				'tpg_thumbnail_style' => [
					'css'       => [
						'main' => [
							'border_radii'  => '%%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap, %%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap img, %%order_class%% .rt-grid-hover-item .grid-hover-content',
							'border_styles' => '%%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap, %%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap img, %%order_class%% .rt-grid-hover-item .grid-hover-content',
						],
					],
					'important' => 'all',
				],
			],

		];
	}

	/**
	 * Advanced fields for Post Excerpt / Content
	 *
	 * @return array
	 */
	public static function get_post_excerpt() {
		return [
			'label'                  => __( 'Post Excerpt / Content', 'the-post-grid' ),
			'focus_background_color' => false,
			'focus_text_color'       => false,
			'text_shadow'            => false,
			'box_shadow'             => false,
			'text_color'             => false,
			'background_color'       => false,
			'border_styles'          => false,

			'css' => [
				'main'      => '%%order_class%% .tpg-el-main-wrapper .tpg-el-excerpt',
				'padding'   => '%%order_class%% .tpg-el-main-wrapper .tpg-el-excerpt',
				'margin'    => '%%order_class%% .tpg-el-main-wrapper .tpg-el-excerpt',
				'important' => [ 'all' ],
			],

			'margin_padding' => [
				'css' => [
					'main'      => '%%order_class%% .tpg-el-main-wrapper .tpg-el-excerpt',
					'padding'   => '%%order_class%% .tpg-el-main-wrapper .tpg-el-excerpt',
					'margin'    => '%%order_class%% .tpg-el-main-wrapper .tpg-el-excerpt',
					'important' => 'all',
				],
			],

			'font_field' => [
				'css' => [
					'main'      => [ '%%order_class%% .tpg-el-main-wrapper .tpg-el-excerpt .tpg-excerpt-inner' ],
					'important' => 'all',
				],
			],

		];
	}

	/**
	 * Advanced fields for Post Meta
	 *
	 * @return array
	 */
	public static function get_post_meta() {
		return [
			'label'                  => __( 'Meta Data', 'the-post-grid' ),
			'focus_background_color' => false,
			'focus_text_color'       => false,
			'text_shadow'            => false,
			'box_shadow'             => false,
			'text_color'             => false,
			'background_color'       => false,
			'border_styles'          => false,

			'css' => [
				'main'      => '%%order_class%% .rt-tpg-container .rt-holder .entry-title-wrapper',
				'padding'   => '%%order_class%% .rt-tpg-container .rt-holder .entry-title-wrapper',
				'margin'    => '%%order_class%% .rt-tpg-container .rt-holder .entry-title-wrapper',
				'important' => [ 'all' ],
			],

			'margin_padding' => [
				'css' => [
					'main'      => '%%order_class%% .tpg-el-main-wrapper .rt-holder .rt-el-post-meta',
					'padding'   => '%%order_class%% .tpg-el-main-wrapper .rt-holder .rt-el-post-meta',
					'margin'    => '%%order_class%% .tpg-el-main-wrapper .rt-holder .rt-el-post-meta',
					'important' => 'all',
				],
			],

			'font_field' => [
				'css' => [
					'main'      => [ '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-el-post-meta, %%order_class%% .tpg-post-holder .tpg-separate-category .categories-links a, %%order_class%% .rt-tpg-container .tpg-post-holder .categories-links a' ],
					'important' => 'all',
				],
			],

		];
	}

	/**
	 * Advanced fields for Social Share
	 *
	 * @return array
	 */
	public static function get_social_share() {
		return [
			'label'                  => __( 'Social Share', 'the-post-grid' ),
			'focus_background_color' => false,
			'focus_text_color'       => false,
			'text_shadow'            => false,
			'text_align'             => false,
			'box_shadow'             => false,
			'text_color'             => false,
			'background_color'       => false,
			'font_field'             => false,

			'css' => [
				'main'      => '%%order_class%% .rt-tpg-social-share',
				'padding'   => '%%order_class%% .rt-tpg-social-share',
				'margin'    => '%%order_class%% .rt-tpg-social-share',
				'important' => [ 'all' ],
			],

			'margin_padding' => [
				'show_if' => [ 'show_social_share' => 'on' ],
				'css'     => [
					'main'      => '%%order_class%% .rt-tpg-social-share a i',
					'padding'   => '%%order_class%% .rt-tpg-social-share a i',
					'margin'    => '%%order_class%% .rt-tpg-social-share a',
					'important' => 'all',
				],
			],

			'border_styles' => [
				'show_if'                => [ 'show_social_share' => 'on' ],
				'tpg_social_share_style' => [
					'label_prefix' => __( 'Title', 'the-post-grid' ),
					'css'          => [
						'main' => [
							'border_radii'  => '%%order_class%% .rt-tpg-social-share a i',
							'border_styles' => '%%order_class%% .rt-tpg-social-share a i',
						],
					],
				],
			],

		];
	}

	/**
	 * Advanced fields for Read More
	 *
	 * @return array
	 */
	public static function get_read_more() {
		return [
			'label'                  => __( 'Read More', 'the-post-grid' ),
			'focus_background_color' => false,
			'focus_text_color'       => false,
			'text_shadow'            => false,
			'box_shadow'             => false,
			'text_color'             => false,
			'background_color'       => false,

			'css' => [
				'main'      => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more',
				'padding'   => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more',
				'margin'    => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more',
				'important' => [ 'all' ],
			],

			'margin_padding' => [
				'css' => [
					'main'      => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more',
					'padding'   => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more a',
					'margin'    => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more',
					'important' => 'all',
				],
			],

			'border_styles' => [
				'tpg_read_more_style' => [
					'label_prefix' => __( 'Title', 'the-post-grid' ),
					'css'          => [
						'main' => [
							'border_radii'  => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more a',
							'border_styles' => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more a',
						],
					],
				],
			],

			'font_field' => [
				'css' => [
					'main'      => [ '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more a' ],
					'important' => 'all',
				],
			],
		];
	}

	/**
	 * Advanced fields for Read More
	 *
	 * @return array
	 */
	public static function get_slider() {
		return [
			'label'                  => __( 'Slider', 'the-post-grid' ),
			'focus_background_color' => false,
			'focus_text_color'       => false,
			'text_shadow'            => false,
			'box_shadow'             => false,
			'text_color'             => false,
			'font_field'             => false,
			'background_color'       => false,

			'css' => [
				'main'      => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more',
				'padding'   => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more',
				'margin'    => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more',
				'important' => [ 'all' ],
			],

			'margin_padding' => [
				'css' => [
					'main'      => 'body %%order_class%% .tpg-el-main-wrapper .rt-slider-item',
					'padding'   => 'body %%order_class%% .tpg-el-main-wrapper .rt-slider-item',
					'margin'    => 'body %%order_class%% .tpg-el-main-wrapper .rt-swiper-holder',
					'important' => 'all',
				],
			],

			'border_styles' => [
				'tpg_read_more_style' => [
					'label_prefix' => __( 'Title', 'the-post-grid' ),
					'css'          => [
						'main' => [
							'border_radii'  => '%%order_class%% .tpg-el-main-wrapper .rt-slider-item',
							'border_styles' => '%%order_class%% .tpg-el-main-wrapper .rt-slider-item',
						],
					],
				],
			],

		];
	}

	/**
	 * Advanced fields for Read More
	 *
	 * @return array
	 */
	public static function get_filter_style() {
		return [
			'label'                  => __( 'Front-End Filter', 'the-post-grid' ),
			'focus_background_color' => false,
			'focus_text_color'       => false,
			'text_shadow'            => false,
			'box_shadow'             => false,
			'text_color'             => false,
			'background_color'       => false,

			'css' => [
				'main'      => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap',
				'padding'   => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap',
				'margin'    => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap',
				'important' => [ 'all' ],
			],

			'margin_padding' => [
				'css' => [
					'main'      => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap',
					'padding'   => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap',
					'margin'    => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap',
					'important' => 'all',
				],
			],

			'font_field' => [
				'css' => [
					'main'      => [ '%%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap, %%order_class%% .tpg-header-wrapper.carousel .rt-filter-item-wrap.swiper-wrapper .swiper-slide' ],
					'important' => 'all',
				],
			],

			'border_styles' => [
				'tpg_filter_style' => [
					'label_prefix' => __( 'Title', 'the-post-grid' ),
					'css'          => [
						'main' => [
							'border_radii'  => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap',
							'border_styles' => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap',
						],
					],
				],
			],
		];
	}

	/**
	 * Advanced fields for Pagination
	 *
	 * @return array
	 */
	public static function get_pagination() {
		return [
			'label'                  => __( 'Pagination', 'the-post-grid' ),
			'focus_background_color' => false,
			'focus_text_color'       => false,
			'text_shadow'            => false,
			'box_shadow'             => false,
			'text_color'             => false,
			'background_color'       => false,
			'border_styles'          => false,
			'margin_padding'                => false,

			'css' => [
				'main'      => '%%order_class%% .rt-tpg-container .rt-pagination-wrap',
				'margin'    => '%%order_class%% .rt-tpg-container .rt-pagination-wrap',
				'important' => [ 'all' ],
			],


			'font_field' => [
				'css' => [
					'main'      => [ '%%order_class%% .rt-pagination .pagination-list > li > a, %%order_class%% .rt-pagination .pagination-list > li > span' ],
					'important' => 'all',
				],
			],

		];
	}

	/**
	 * Advanced fields for Post Card
	 *
	 * @return array
	 */
	public static function get_post_card() {
		return [
			'label'                  => __( 'Card (Post Item)', 'the-post-grid' ),
			'focus_background_color' => false,
			'focus_text_color'       => false,
			'text_shadow'            => false,
			'text_color'             => false,
			'background_color'       => false,
			'font_field'             => false,

			'css' => [
				'main'      => 'body %%order_class%% .tpg-el-main-wrapper .rt-holder',
				'padding'   => 'body %%order_class%% .tpg-el-main-wrapper .rt-holder',
				'margin'    => 'body %%order_class%% .tpg-el-main-wrapper .rt-holder',
				'important' => [ 'all' ],
			],

			'margin_padding' => [
				'css' => [
					'main'      => 'body %%order_class%% .tpg-el-main-wrapper .rt-holder',
					'padding'   => 'body %%order_class%% .tpg-el-main-wrapper .rt-holder',
					'margin'    => 'body %%order_class%% .tpg-el-main-wrapper .rt-holder',
					'important' => 'all',
					'show_if'   => [
						'pagination_type!' => 'load_on_scroll',
					],
				],
			],

			'border_styles' => [
				'tpg_card_style' => [
					'label_prefix' => __( 'Title', 'the-post-grid' ),
					'css'          => [
						'main' => [
							'border_radii'  => 'body %%order_class%% .tpg-el-main-wrapper .rt-holder',
							'border_styles' => 'body %%order_class%% .rt-tpg-container .rt-holder',
						],
					],
				],
			],

			'box_shadow' => [
				'name' => 'card_box_shadow',
				'css'  => [
					'main' => 'body %%order_class%% .tpg-el-main-wrapper .rt-holder',
				],
			],
		];
	}

}