<?php

/**
 * DiviFrontEndCss class.
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Divi\Utils;

class DiviFrontEndCss {

	/**
	 * Render CSS for front-end
	 *
	 * @param $render_slug
	 *
	 * @return void
	 */
	public static function render_css( $render_slug, $settings ) {
		$all_css = self::css_collection();

		foreach ( $all_css as $settingsKey => $css ) {
			$css_val = $settings[ $settingsKey ] ?? '';

			if ( ! $css_val ) {
				continue;
			}

			$unit = ! empty( $css['unit'] ) ? $css['unit'] : '';
			if ( $unit && preg_match( '/(px|%)$/', $css_val ) ) {
				$unit = '';
			}
			unset( $css['unit'] );
			foreach ( $css as $property => $selector ) {
				\ET_Builder_Element::set_style( $render_slug, [ 'selector' => $selector, 'declaration' => "$property:$css_val$unit;" ] );
			}
		}
	}

	/**
	 * CSS Collection
	 *
	 * @return array[]
	 */
	public static function css_collection() {
		return [
			//Section Title

			'section_title_color'      => [ 'color' => '%%order_class%% .tpg-widget-heading-wrapper .tpg-widget-heading' ],
			'section_title_bg_color'   => [
				'background-color' => '%%order_class%% .tpg-widget-heading-wrapper.heading-style2 .tpg-widget-heading, %%order_class%% .tpg-widget-heading-wrapper.heading-style3 .tpg-widget-heading',
				'border-color'     => '%%order_class%% .tpg-widget-heading-wrapper.heading-style2 .tpg-widget-heading::after, %%order_class%% .tpg-widget-heading-wrapper.heading-style2 .tpg-widget-heading::before',
			],
			'section_title_dot_color'  => [ 'background-color' => '%%order_class%% .tpg-widget-heading-wrapper.heading-style1 .tpg-widget-heading::before, %%order_class%% .tpg-widget-heading-wrapper.heading-style4::before' ],
			'section_title_line_color' => [
				'border-color'        => '%%order_class%% .tpg-widget-heading-wrapper.heading-style1 .tpg-widget-heading-line',
				'color'               => '%%order_class%% .section-title-style-style2 .tpg-header-wrapper.carousel .rt-filter-item-wrap.swiper-wrapper .swiper-slide.selected, %%order_class%% .section-title-style-style3 .tpg-header-wrapper.carousel .rt-filter-item-wrap.swiper-wrapper .swiper-slide.selected, %%order_class%% .section-title-style-style2 .tpg-header-wrapper.carousel .rt-filter-item-wrap.swiper-wrapper .swiper-slide:hover, %%order_class%% .section-title-style-style2 .tpg-header-wrapper.carousel .rt-filter-item-wrap.swiper-wrapper .swiper-slide:hover',
				'border-bottom-color' => '%%order_class%% .section-title-style-style2 .tpg-header-wrapper:not(.carousel) .tpg-widget-heading-wrapper, %%order_class%% .section-title-style-style3 .tpg-header-wrapper:not(.carousel) .tpg-widget-heading-wrapper, %%order_class%% .section-title-style-style2 .tpg-header-wrapper.carousel, %%order_class%% .section-title-style-style3 .tpg-header-wrapper.carousel, %%order_class%% .section-title-style-style2 .tpg-header-wrapper.carousel .rt-filter-item-wrap.swiper-wrapper .swiper-slide::before, %%order_class%% .section-title-style-style3 .tpg-header-wrapper.carousel .rt-filter-item-wrap.swiper-wrapper .swiper-slide::before',
				'background-color'    => '%%order_class%% .tpg-widget-heading-wrapper.heading-style4::after',
			],
			'prefix_text_color'        => [ 'color' => '%%order_class%% .tpg-widget-heading-wrapper .tpg-widget-heading .prefix-text' ],
			'suffix_text_color'        => [ 'color' => '%%order_class%% .tpg-widget-heading-wrapper .tpg-widget-heading .suffix-text' ],
			'external_icon_color'      => [ 'color' => '%%order_class%% .tpg-widget-heading-wrapper .external-link' ],
			//Post Title
			'title_min_height'         => [
				'unit'       => 'px',
				'min-height' => '%%order_class%% .rt-tpg-container .entry-title-wrapper',
			],
			'title_color'              => [ 'color' => 'body %%order_class%% .rt-tpg-container.tpg-el-main-wrapper .entry-title' ],
			'title_hover_color'        => [ 'color' => 'body %%order_class%% .rt-tpg-container.tpg-el-main-wrapper .tpg-post-holder .entry-title:hover' ],
			'title_bg_color'           => [ 'background-color' => '%%order_class%% .tpg-el-main-wrapper .entry-title' ],
			'title_bg_color_hover'     => [ 'background-color' => 'body %%order_class%% .tpg-el-main-wrapper .entry-title:hover' ],
			'title_border_color'       => [ 'background-color' => '%%order_class%% .rt-tpg-container .rt-holder .entry-title-wrapper .entry-title::before' ],

			//Post Thumbnail
			'image_width'              => [
				'width' => '%%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap img',
			],
			'image_height'             => [
				'unit'   => 'px',
				'height' => '%%order_class%% .tpg-el-main-wrapper .rt-content-loader > :not(.offset-right) :is(.tpg-el-image-wrap, .tpg-el-image-wrap img), %%order_class%% .tpg-el-main-wrapper:is(.slider-layout11-main, .slider-layout12-main) .rt-grid-hover-item .rt-holder .rt-el-content-wrapper',
			],
			'list_image_side_width'    => [
				'unit'       => 'px',
				'flex-basis' => '%%order_class%% .rt-tpg-container .list-layout-wrapper [class*="rt-col"]:not(.offset-left) .rt-holder .tpg-el-image-wrap',
				'max-width'  => '%%order_class%% .rt-tpg-container .list-layout-wrapper [class*="rt-col"]:not(.offset-left) .rt-holder .tpg-el-image-wrap',
			],
			'offset_image_height'      => [
				'unit'   => 'px',
				'height' => '%%order_class%% .tpg-el-main-wrapper .rt-content-loader .offset-right :is(.tpg-el-image-wrap, .tpg-el-image-wrap img)',
			],

			'grid_hover_overlay_color'       => [ 'background-color' => '%%order_class%% .rt-tpg-container .rt-grid-hover-item .rt-holder .grid-hover-content:before, %%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap .overlay' ],
			'grid_hover_overlay_color_hover' => [ 'background-color' => '%%order_class%% .rt-tpg-container .rt-grid-hover-item .rt-holder .grid-hover-content:after, %%order_class%% .tpg-el-main-wrapper .rt-holder:hover .tpg-el-image-wrap .overlay' ],
			'thumb_lightbox_bg'              => [ 'background-color' => '%%order_class%% .rt-tpg-container .rt-holder .rt-img-holder .tpg-zoom i' ],
			'thumb_lightbox_bg_hover'        => [ 'background-color' => '%%order_class%% .rt-tpg-container .rt-holder .rt-img-holder .tpg-zoom:hover i' ],
			'thumb_lightbox_color'           => [ 'color' => '%%order_class%% .rt-tpg-container .rt-holder .rt-img-holder .tpg-zoom i' ],
			'thumb_lightbox_color_hover'     => [ 'color' => '%%order_class%% .rt-tpg-container .rt-holder .rt-img-holder .tpg-zoom:hover i' ],
			'thumbnail_position'             => [ 'object-position' => '%%order_class%% .tpg-el-main-wrapper .rt-holder .tpg-el-image-wrap img' ],
			'thumbnail_position_hover'       => [ 'object-position' => '%%order_class%% .tpg-el-main-wrapper .rt-holder:hover .tpg-el-image-wrap img' ],
			'thumbnail_opacity'              => [ 'opacity' => '%%order_class%% .tpg-el-main-wrapper .tpg-el-image-wrap img' ],
			'thumbnail_opacity_hover'        => [ 'opacity' => '%%order_class%% .tpg-el-main-wrapper .rt-holder:hover .tpg-el-image-wrap img' ],

			//Post Excerpt
			'content_alignment'              => [ 'text-align' => '%%order_class%% .tpg-el-main-wrapper .tpg-el-excerpt .tpg-excerpt-inner' ],
			'excerpt_color'                  => [ 'color' => '%%order_class%% .tpg-el-main-wrapper .tpg-el-excerpt .tpg-excerpt-inner' ],
			'excerpt_hover_color'            => [ 'color' => '%%order_class%% .tpg-el-main-wrapper .tpg-post-holder:hover .tpg-el-excerpt .tpg-excerpt-inner' ],
			'excerpt_border'                 => [ 'background' => '%%order_class%%.meta_position_default .tpg-el-main-wrapper .grid-layout3 .rt-holder .rt-el-post-meta::before' ],
			'excerpt_border_hover'           => [ 'background' => '%%order_class%%.meta_position_default .tpg-el-main-wrapper .grid-layout3 .rt-holder:hover .rt-el-post-meta::before' ],

			//Post Meta Data
			'post_meta_alignment'            => [
				'text-align'      => '%%order_class%% .rt-tpg-container .rt-el-post-meta',
				'justify-content' => '%%order_class%% .rt-tpg-container .rt-el-post-meta',
			],
			'meta_info_color'                => [ 'color' => '%%order_class%% .tpg-el-main-wrapper .post-meta-tags span' ],
			'meta_link_color'                => [ 'color' => '%%order_class%% .tpg-el-main-wrapper .post-meta-tags a' ],
			'meta_link_colo_hover'           => [ 'color' => '%%order_class%% .tpg-el-main-wrapper .tpg-post-holder .post-meta-tags a:hover' ],
			'meta_link_colo_box_hover'       => [ 'color' => '%%order_class%% .tpg-el-main-wrapper .tpg-post-holder:hover .post-meta-tags *' ],
			'meta_icon_color'                => [ 'color' => '%%order_class%% .tpg-el-main-wrapper .post-meta-tags i' ],
			'meta_separator_color'           => [ 'color' => '%%order_class%% .tpg-el-main-wrapper .post-meta-tags .separator' ],
			'separate_category_color'        => [ 'color' => '%%order_class%% .tpg-el-main-wrapper .tpg-separate-category .categories-links, %%order_class%% .tpg-el-main-wrapper .tpg-separate-category .categories-links a, %%order_class%% .tpg-el-main-wrapper .post-meta-tags .categories-links a' ],
			'separate_category_color_hover'  => [ 'color' => '%%order_class%% .tpg-el-main-wrapper .tpg-separate-category .categories-links a:hover, %%order_class%% .tpg-el-main-wrapper .post-meta-tags .categories-links a:hover' ],
			'separate_category_bg'           => [
				'background-color' => '%%order_class%% .tpg-el-main-wrapper .tpg-separate-category.style1 .categories-links a, %%order_class%% .tpg-el-main-wrapper .tpg-separate-category:not(.style1) .categories-links a, %%order_class%% .tpg-el-main-wrapper .post-meta-tags .categories-links a',
				'border-top-color' => '%%order_class%% .tpg-el-main-wrapper .tpg-separate-category:not(.style1) .categories-links a:after',
			],
			'separate_category_bg_hover'     => [
				'background-color' => '%%order_class%% .tpg-el-main-wrapper .tpg-separate-category.style1 .categories-links:hover, %%order_class%% .tpg-el-main-wrapper .tpg-separate-category .categories-links:not(.style1) a:hover, %%order_class%% .tpg-el-main-wrapper .post-meta-tags .categories-links a:hover',
				'border-top-color' => '%%order_class%% .tpg-el-main-wrapper .tpg-separate-category .categories-links:not(.style1) a:hover::after',
			],
			'separate_category_icon_color'   => [ 'color' => '%%order_class%% .tpg-el-main-wrapper .tpg-separate-category .categories-links i, %%order_class%% .tpg-el-main-wrapper .post-meta-tags .categories-links i' ],
			'category_radius'                => [ 'border-radius' => '%%order_class%% .tpg-el-main-wrapper .post-meta-tags .categories-links a, %%order_class%% .tpg-el-main-wrapper .tpg-separate-category .categories-links a' ],

			//Social Share
			'social_icon_alignment'          => [ 'text-align' => '%%order_class%% .tpg-el-main-wrapper .rt-tpg-social-share' ],
			'icon_font_size'                 => [
				'unit'      => 'px',
				'font-size' => '%%order_class%% .rt-tpg-social-share a i',
			],
			'icon_width_height'              => [
				'unit'        => 'px',
				'width'       => '%%order_class%% .rt-tpg-social-share a i',
				'height'      => '%%order_class%% .rt-tpg-social-share a i',
				'line-height' => '%%order_class%% .rt-tpg-social-share a i',
			],
			'social_icon_color'              => [ 'color' => '%%order_class%% .rt-tpg-social-share a i' ],
			'social_icon_color_hover'        => [ 'color' => '%%order_class%% .rt-tpg-social-share a:hover i' ],
			'social_icon_bg_color'           => [ 'background-color' => '%%order_class%% .rt-tpg-social-share a i' ],
			'social_icon_bg_color_hover'     => [ 'background-color' => '%%order_class%% .rt-tpg-social-share a:hover i' ],

			//Read More
			'readmore_btn_alignment'         => [ 'text-align' => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more' ],
			'readmore_text_color'            => [ 'color' => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more a' ],
			'readmore_text_color_hover'      => [ 'color' => 'body %%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more a:hover' ],
			'readmore_icon_color'            => [ 'color' => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more a i' ],
			'readmore_icon_color_hover'      => [ 'color' => 'body %%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more a:hover i' ],
			'readmore_bg'                    => [ 'background-color' => '%%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more a' ],
			'readmore_bg_hover'              => [ 'background-color' => 'body %%order_class%% .rt-tpg-container .tpg-post-holder .rt-detail .read-more a:hover' ],

			//Pagination
			'pagination_text_align'          => [ 'justify-content' => '%%order_class%% .rt-pagination-wrap' ],
			'pagination_border_radius'       => [
				'unit'          => 'px',
				'border-radius' => '%%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-loadmore-btn, %%order_class%% .rt-pagination .pagination-list > li > a, %%order_class%% .rt-pagination .pagination-list > li > span, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-page-numbers .paginationjs .paginationjs-pages ul li > a',
			],
			'pagination_margin_top'          => [
				'unit'       => 'px',
				'margin-top' => '%%order_class%% .rt-tpg-container .rt-pagination-wrap',
			],
			'pagination_color'               => [ 'color' => '%%order_class%% .rt-pagination .pagination-list > li:not(:hover) > a, %%order_class%% .rt-pagination .pagination-list > li:not(:hover) > span, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-page-numbers .paginationjs .paginationjs-pages ul li:not(:hover) > a, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-page-numbers .paginationjs .paginationjs-pages ul li:not(:hover), %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-loadmore-btn' ],
			'pagination_color_hover'         => [ 'color' => '%%order_class%% .rt-pagination .pagination-list > li:hover > a, %%order_class%% .rt-pagination .pagination-list > li:hover > span, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-page-numbers .paginationjs .paginationjs-pages ul li:hover > a, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-loadmore-btn:hover' ],
			'pagination_color_active'        => [ 'color' => '%%order_class%% .rt-pagination .pagination-list > .active > :is(a, span, a:hover, span:hover, a:focus, span:focus), %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-page-numbers .paginationjs .paginationjs-pages ul li.active > a' ],
			'pagination_bg'                  => [ 'background-color' => '%%order_class%% .rt-pagination .pagination-list > li > a:not(:hover), %%order_class%% .rt-pagination .pagination-list > li:not(:hover) > span, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-page-numbers .paginationjs .paginationjs-pages ul li:not(:hover) > a, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-loadmore-btn' ],
			'pagination_bg_hover'            => [ 'background-color' => '%%order_class%% .rt-pagination .pagination-list > li:hover > a, %%order_class%% .rt-pagination .pagination-list > li:hover > span, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-page-numbers .paginationjs .paginationjs-pages ul li:hover > a, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-loadmore-btn:hover' ],
			'pagination_bg_active'           => [
				'background-color' => '%%order_class%% .rt-pagination .pagination-list > .active > :is(a, span, a:hover, span:hover, a:focus, span:focus), %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-page-numbers .paginationjs .paginationjs-pages ul li.active > a',
				'border-color'     => '%%order_class%% .rt-pagination .pagination-list > .active > :is(a, span, a:hover, span:hover, a:focus, span:focus), %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-page-numbers .paginationjs .paginationjs-pages ul li.active > a',
			],
			'pagination_border_color'        => [ 'border-color' => '%%order_class%% .rt-pagination .pagination-list > li > a:not(:hover), %%order_class%% .rt-pagination .pagination-list > li:not(:hover) > span, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-page-numbers .paginationjs .paginationjs-pages ul li:not(:hover) > a, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-loadmore-btn' ],
			'pagination_border_color_hover'  => [ 'border-color' => '%%order_class%% .rt-pagination .pagination-list > li:hover > a, %%order_class%% .rt-pagination .pagination-list > li:hover > span, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-page-numbers .paginationjs .paginationjs-pages ul li:hover > a, %%order_class%% .rt-tpg-container .rt-pagination-wrap .rt-loadmore-btn:hover' ],

			//Slier CSS
			'slider_gap'                     => [ 'background-color' => 'body %%order_class%% .tpg-el-main-wrapper .rt-slider-item' ],

			//Post Card
			'sticky_item_background'         => [ 'background-color' => '.rt-tpg-container .rt-holder.rt-sticky' ],
			'box_background'                 => [ 'background-color' => 'body %%order_class%% .tpg-el-main-wrapper .tpg-post-holder' ],
			'box_background_hover'           => [ 'background-color' => 'body %%order_class%% .tpg-el-main-wrapper .tpg-post-holder:hover' ],
			'list_layout_alignment'          => [ 'align-items' => '%%order_class%% .tpg-el-main-wrapper .list-behaviour .rt-holder .rt-el-content-wrapper' ],
			'list_flex_direction'            => [ 'flex-direction' => '%%order_class%% .tpg-el-main-wrapper .list-behaviour .rt-holder .rt-el-content-wrapper' ],

			//Front-end Filter
			'filter_item_width'              => [ 'width' => '%%order_class%% .rt-filter-wrap .rt-filter-dropdown' ],
			'filter_dropdown_align'          => [ 'text-align' => '%%order_class%% .rt-filter-wrap .rt-filter-dropdown .rt-filter-dropdown-item' ],
			'filter_text_alignment'          => [
				'text-align'      => '%%order_class%% .tpg-el-main-wrapper .rt-layout-filter-container .rt-filter-wrap',
				'justify-content' => '%%order_class%% .tpg-el-main-wrapper .rt-layout-filter-container .rt-filter-wrap',
			],
			'filter_button_width'            => [
				'max-width'  => '%%order_class%% .tpg-header-wrapper.carousel .rt-layout-filter-container',
				'flex-basis' => '%%order_class%% .tpg-header-wrapper.carousel .rt-layout-filter-container',
			],
			'filter_btn_radius'              => [ 'border-radius' => '%%order_class%% .rt-filter-item-wrap.rt-filter-button-wrap span.rt-filter-button-item, %%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap, %%order_class%% .rt-filter-item-wrap.rt-search-filter-wrap input.rt-search-input' ],
			'filter_color'                   => [
				'color'            => '%%order_class%% .rt-filter-item-wrap.rt-filter-button-wrap span.rt-filter-button-item, %%order_class%% .rt-filter-item-wrap.rt-filter-button-wrap span.rt-filter-button-item, %%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-filter-dropdown-wrap, %%order_class%% .rt-filter-item-wrap.rt-search-filter-wrap input.rt-search-input',
				'background-color' => '%%order_class%% .rt-filter-item-wrap.rt-sort-order-action .rt-sort-order-action-arrow > span:before, %%order_class%% .rt-filter-item-wrap.rt-sort-order-action .rt-sort-order-action-arrow > span:after',
			],
			'filter_color_hover'             => [
				'color'            => '%%order_class%% .rt-filter-item-wrap.rt-filter-button-wrap span.rt-filter-button-item.selected, %%order_class%% .rt-filter-item-wrap.rt-filter-button-wrap span.rt-filter-button-item:hover, %%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-filter-dropdown-wrap:hover',
				'background-color' => '%%order_class%% .rt-filter-item-wrap.rt-sort-order-action:hover .rt-sort-order-action-arrow > span:before, %%order_class%% .rt-filter-item-wrap.rt-sort-order-action:hover .rt-sort-order-action-arrow > span:after',
			],
			'filter_bg_color'                => [ 'background-color' => '%%order_class%% .rt-filter-item-wrap.rt-filter-button-wrap span.rt-filter-button-item,%%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-filter-dropdown-wrap, %%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-sort-order-action' ],
			'filter_bg_color_hover'          => [ 'background-color' => '%%order_class%% .rt-filter-item-wrap.rt-filter-button-wrap span.rt-filter-button-item.selected, %%order_class%% .rt-filter-item-wrap.rt-filter-button-wrap span.rt-filter-button-item:hover, %%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-filter-dropdown-wrap:hover, %%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-sort-order-action:hover' ],
			'filter_border_color'            => [ 'border-color' => '%%order_class%% .rt-filter-item-wrap.rt-filter-button-wrap span.rt-filter-button-item, %%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-filter-dropdown-wrap, %%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-sort-order-action, %%order_class%% .rt-filter-item-wrap.rt-search-filter-wrap input.rt-search-input, %%order_class%%.filter-button-border-enable .tpg-header-wrapper.carousel .rt-layout-filter-container' ],
			'filter_border_color_hover'      => [ 'border-color' => '%%order_class%% .rt-filter-item-wrap.rt-filter-button-wrap span.rt-filter-button-item.selected, %%order_class%% .rt-filter-item-wrap.rt-filter-button-wrap span.rt-filter-button-item:hover, %%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-filter-dropdown-wrap:hover, %%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-sort-order-action:hover, %%order_class%% .rt-filter-item-wrap.rt-search-filter-wrap input.rt-search-input:hover, %%order_class%%.filter-button-border-enable .tpg-header-wrapper.carousel .rt-layout-filter-container:hover' ],
			'filter_search_bg'               => [ 'background-color' => '%%order_class%% .rt-filter-item-wrap.rt-search-filter-wrap input.rt-search-input' ],
			'filter_search_bg_hover'         => [ 'background-color' => '%%order_class%% .rt-filter-item-wrap.rt-search-filter-wrap input.rt-search-input:hover' ],
			'sub_menu_bg_color'              => [ 'background-color' => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-filter-dropdown-wrap .rt-filter-dropdown' ],
			'sub_menu_bg_color_hover'        => [ 'background-color' => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-filter-dropdown-wrap .rt-filter-dropdown .rt-filter-dropdown-item:hover' ],
			'sub_menu_color'                 => [ 'color' => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-filter-dropdown-wrap .rt-filter-dropdown .rt-filter-dropdown-item' ],
			'sub_menu_color_hover'           => [ 'color' => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-filter-dropdown-wrap .rt-filter-dropdown .rt-filter-dropdown-item:hover' ],
			'sub_menu_border_bottom'         => [ 'border-bottom-color' => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-filter-dropdown-wrap .rt-filter-dropdown .rt-filter-dropdown-item' ],
			'sub_menu_border_bottom_hover'   => [ 'border-bottom-color' => '%%order_class%% .rt-layout-filter-container .rt-filter-wrap .rt-filter-item-wrap.rt-filter-dropdown-wrap .rt-filter-dropdown .rt-filter-dropdown-item:hover' ],
			'filter_nav_color'               => [ 'color' => '%%order_class%% .rt-tpg-container .swiper-navigation .slider-btn' ],
			'filter_nav_color_hover'         => [ 'color' => '%%order_class%% .rt-tpg-container .swiper-navigation .slider-btn:hover' ],
			'filter_nav_bg'                  => [ 'background-color' => '%%order_class%% .rt-tpg-container .swiper-navigation .slider-btn:hover' ],
			'filter_nav_bg_hover'            => [ 'background-color' => '%%order_class%% .rt-tpg-container .swiper-navigation .slider-btn:hover' ],
			'filter_nav_border'              => [ 'border-color' => '%%order_class%% .rt-tpg-container .swiper-navigation .slider-btn' ],
			'filter_nav_border_hover'        => [ 'border-color' => '%%order_class%% .rt-tpg-container .swiper-navigation .slider-btn:hover' ],

			//ACF CSS
			'acf_label_width'                => [ 'unit' => 'px', 'min-width' => '%%order_class%% .tgp-cf-field-label' ],
			'acf_group_title_color'          => [ 'color' => '%%order_class%% .acf-custom-field-wrap .tpg-cf-group-title' ],
			'acf_label_color'                => [ 'color' => '%%order_class%% .acf-custom-field-wrap .tgp-cf-field-label' ],
			'acf_value_color'                => [ 'color' => '%%order_class%% .acf-custom-field-wrap .tgp-cf-field-value' ],
		];
	}

}