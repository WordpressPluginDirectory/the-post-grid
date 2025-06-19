<?php

/**
 * DiviEditorCss class.
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Divi\Utils;

use RT\ThePostGrid\Helpers\Fns;

/**
 * Generate required CSS for Divi Editor
 */
class DiviEditorCss {

	public static function editor_css() {
		$custom_css = <<<CSS
.et-db #et-boc .et-l .et-fb-tabs__item {
	padding: 13px 20px;
	text-transform: capitalize;
}
.et-db #et-boc .et-l .et-fb-form__toggle h3 {
	color: #62666d;
}
.et-db #et-boc .et-l .et-fb-tabs__list .et-fb-tabs__item:nth-child(1) {
	order: 1;
}
.et-db #et-boc .et-l .et-fb-tabs__list .et-fb-tabs__item:nth-child(2) {
	order: 5;
}
.et-db #et-boc .et-l .et-fb-tabs__list .et-fb-tabs__item:nth-child(3) {
	order: 10;
}
.et-db #et-boc .et-l .et-fb-tabs__list .et-fb-tabs__item:nth-child(4) {
	order: 2;
}
.et-fb-multiple-checkboxes-wrap .et-fb-multiple-checkbox:has([id^="et-fb-multiple-checkbox-category_ids-"]),
.et-fb-multiple-checkboxes-wrap .et-fb-multiple-checkbox:has([id^="et-fb-multiple-checkbox-post_tag_ids-"]) {
	width: 46%;
	display: inline-flex;
	margin-right: 5px !important;
}
.et-db #et-boc .et-l .et-fb-form__group:has(.et-fb-option--yes-no_button) {
	display: flex;
	justify-content: space-between;
}
.et-db #et-boc .et-l .et-fb-form__group:has(.et-fb-option--yes-no_button) .et-fb-form__label {
	flex: 1;
}
.et-db #et-boc .et-l .et-fb-form__toggle[data-name="tpg_links"],
.et-db #et-boc .et-l .et-fb-form__toggle[data-name="tpg_card_style"],
.et-db #et-boc .et-l .et-fb-form__toggle[data-name="tpg_read_more"] {
	border-bottom: 4px solid #6c2fb9;
}

/*Pro Layout CSS Only you need to add other classes here*/
.et-db #et-boc .et-l :is(
	#et-fb-grid_layout,
	#et-fb-list_layout,
	#et-fb-grid_hover_layout,
	#et-fb-slider_layout
).et-fb-settings-custom-select-wrapper.et-fb-settings-option-select-active li {
	position: relative;
}

.no-rttpg-pro .et-db #et-boc .et-l :is(
	#et-fb-grid_layout,
	#et-fb-list_layout,
	#et-fb-grid_hover_layout,
	#et-fb-slider_layout
).et-fb-settings-custom-select-wrapper.et-fb-settings-option-select-active li:nth-child(n+4) {
	pointer-events: none;
	cursor: not-allowed;
}

.no-rttpg-pro .et-db #et-boc .et-l :is(
	#et-fb-grid_layout,
	#et-fb-list_layout,
	#et-fb-grid_hover_layout,
	#et-fb-slider_layout
).et-fb-settings-custom-select-wrapper.et-fb-settings-option-select-active li:nth-child(n+4)::after {
	content: "pro";
	color: #fff;
	padding: 2px 6px;
	background: red;
	line-height: 1;
	font-size: 10px;
	text-transform: uppercase;
	font-weight: bold;
	border-radius: 4px;
	margin-left: 3px;
}

.et-db #et-boc .et-l :is(
	#et-fb-grid_layout,
	#et-fb-list_layout,
	#et-fb-grid_hover_layout,
	#et-fb-slider_layout
).et-fb-settings-custom-select-wrapper.et-fb-settings-option-select-active li.select-option-item {
	width: 32.7%;
	display: inline-block;
	vertical-align: top;
	border: 1px solid #6c2fb9;
	border-radius: 0;
	margin-right: -1px;
	margin-bottom: -1px;
	padding: 0;
	box-sizing: content-box;
	height: 75px;
	background-size: contain;
	background-repeat: no-repeat;
}

.et-db #et-boc .et-l :is(
	#et-fb-grid_layout,
	#et-fb-list_layout,
	#et-fb-grid_hover_layout,
	#et-fb-slider_layout
).et-fb-settings-custom-select-wrapper.et-fb-settings-option-select-active li.et-fb-selected-item {
	background-color: #7d3bcf;
	color: #fff;
}

.et-db #et-boc .et-l :is(
	#et-fb-grid_layout,
	#et-fb-list_layout,
	#et-fb-grid_hover_layout,
	#et-fb-slider_layout
).et-fb-settings-custom-select-wrapper.et-fb-settings-option-select-active li.et-fb-selected-item svg {
	width: 100%;
	fill: #008e12 !important;
	background: white !important;
	border-radius: 50%;
	transform: translate(-10px, 4px);
}

.et-db #et-boc .et-l :is(
	#et-fb-grid_layout,
	#et-fb-list_layout,
	#et-fb-grid_hover_layout,
	#et-fb-slider_layout
).et-fb-settings-custom-select-wrapper.et-fb-settings-option-select-active li .select-option-item__name {
	position: absolute;
	bottom: 5px;
	left: 0;
	top: auto;
	line-height: 1;
	width: 100%;
	text-align: center;
	font-size: 12px;
	padding-top: 3px;
}

.et-db #et-boc .et-l .et-fb-form__group:has([id*='et-fb-tpg_directional_text']) .et-fb-form__label-text,
.et-db #et-boc .et-l .et-fb-form__group:has([id*='et-fb-tpg_heading_text']) .et-fb-form__label-text {
    background: #6c2fb917;
    padding: 12px 15px 15px;
    border-radius: 5px;
    border: 1px solid #6c2fb936;
    max-width: 100%;
    width: 100%;
}

.et-db #et-boc .et-l .et-fb-form__group:has([id*='et-fb-tpg_heading_text']) .et-fb-form__label-text {
	padding: 5px 15px 7px;
	background: #6c2fb9;
	color: #fff;
}
.et-db #et-boc .et-l .et-fb-form__group:has([id*='et-fb-tpg_directional_text']) .et-fb-settings-options,
.et-db #et-boc .et-l .et-fb-form__group:has([id*='et-fb-tpg_heading_text']) .et-fb-settings-options {
display: none !important;
}
.et-db #et-boc .et-l .et-fb-modules-list li[class*='tpg_'] svg {
    width: 70% !important;
}

.et-db #et-boc .et-l .et-fb-modules-list ul>li.et_fb_the_post_grid_module {
	padding-top: 1px;
}
.et-db #et-boc .et-l .et-fb-modules-list ul>li.et_fb_the_post_grid_module:before {
    content: "TPG";
    font-family: 'Open Sans', sans-serif;
    font-weight: bold;
    background: #2b87da;
    color: #fff;
    display: inline-block;
    margin-bottom: 0;
    line-height: 1;
    position: relative;
    padding: 2px 3px;
    font-size: 10px;
    border-radius: 3px;
}
CSS;

		$layouts = [
			'grid'       => [
				'grid-layout1'   => 'grid1.png',
				'grid-layout3'   => 'grid12.png',
				'grid-layout4'   => 'grid_layout8.png',
				'grid-layout2'   => 'grid2.png',
				'grid-layout5'   => 'grid_layout9.png',
				'grid-layout5-2' => 'grid_layout9-2.png',
				'grid-layout6'   => 'grid_layout10.png',
				'grid-layout6-2' => 'grid_layout10-2.png',
				'grid-layout7'   => 'gallery.png',
			],
			'grid_hover' => [
				'grid_hover-layout1'   => 'grid3.png',
				'grid_hover-layout2'   => 'grid4.png',
				'grid_hover-layout3'   => 'grid5.png',
				'grid_hover-layout4'   => 'grid16.png',
				'grid_hover-layout4-2' => 'grid16-2.png',
				'grid_hover-layout5'   => 'grid_hover10.png',
				'grid_hover-layout5-2' => 'grid_hover10-2.png',
				'grid_hover-layout6'   => 'grid_hover11.png',
				'grid_hover-layout6-2' => 'grid_hover11-2.png',
				'grid_hover-layout7'   => 'grid_hover12.png',
				'grid_hover-layout7-2' => 'grid_hover12-2.png',
				'grid_hover-layout8'   => 'grid_hover13.png',
				'grid_hover-layout9'   => 'grid_hover9.png',
				'grid_hover-layout9-2' => 'grid_hover9-2.png',
				'grid_hover-layout10'  => 'grid_hover15.png',
				'grid_hover-layout11'  => 'grid_hover16.png',
			],
			'list'       => [
				'list-layout1'   => 'list1.png',
				'list-layout2'   => 'list3.png',
				'list-layout2-2' => 'list3-2.png',
				'list-layout3'   => 'list4.png',
				'list-layout3-2' => 'list4-2.png',
				'list-layout4'   => 'list_layout1.png',
				'list-layout5'   => 'list_layout2.png',
			],
			'slider'     => [
				'slider-layout1'  => 'carousel1.png',
				'slider-layout2'  => 'carousel1.1.png',
				'slider-layout3'  => 'carousel1.3.png',
				'slider-layout4'  => 'carousel2.2.png',
				'slider-layout5'  => 'carousel2.png',
				'slider-layout6'  => 'carousel6.6.png',
				'slider-layout7'  => 'carousel7.7.png',
				'slider-layout8'  => 'carousel8.8.png',
				'slider-layout9'  => 'carousel9.9.png',
				'slider-layout10' => 'carousel10.2.png',
				'slider-layout11' => 'slider_layout11.png',
				'slider-layout12' => 'slider_layout12.png',
				'slider-layout13' => 'slider_layout13.png',
			],
		];

		foreach ( $layouts as $prefix => $layout ) {
			$count = 1;
			foreach ( $layout as $class => $image ) {
				if ( ! rtTPG()->hasPro() && $count > 3 ) {
					$custom_css .= ".et-db #et-boc .et-l .et-fb-settings-custom-select-wrapper#et-fb-{$prefix}_layout.et-fb-settings-option-select-active li.select-option-item.select-option-item-{$class} {pointer-events:none; opacity: .8;}";
					$custom_css .= ".et-db #et-boc .et-l .et-fb-settings-custom-select-wrapper#et-fb-{$prefix}_layout.et-fb-settings-option-select-active li.select-option-item.select-option-item-{$class} * {pointer-events:none;}";

					$custom_css .= ".et-db #et-boc .et-l .et-fb-settings-custom-select-wrapper#et-fb-{$prefix}_layout.et-fb-settings-option-select-active li.select-option-item.select-option-item-{$class}::after{
						content:'pro';background: #f00;padding: 0 3px;line-height: 1;display: inline-block;height: 17px;border-radius: 3px;color: #FFF;position: absolute;top: 5px;right: 5px;text-transform: uppercase;font-weight: bold;font-size: 10px;display: flex;align-items: center;justify-content: center;
					}";
				}
				$layout_img = rtTPG()->get_assets_uri( "images/layouts/$image" );
				$custom_css .= ".et-db #et-boc .et-l .et-fb-settings-custom-select-wrapper#et-fb-{$prefix}_layout.et-fb-settings-option-select-active li.select-option-item.select-option-item-{$class}{background-image: url($layout_img);}";
				$count ++;
			}
		}

		if ( ! rtTPG()->hasPro() ) {
			$custom_css .= self::pro_label( 'multiple_post_type' );
			$custom_css .= self::pro_label( 'instant_query' );
			$custom_css .= self::pro_label( 'date_range' );
			$custom_css .= self::pro_label( 'ignore_sticky_posts' );
			$custom_css .= self::pro_label( 'show_post_count' );
			$custom_css .= self::pro_label( 'show_social_share' );
			$custom_css .= self::pro_label( 'show_acf' );
			$custom_css .= self::pro_label( 'is_thumb_lightbox' );
			$custom_css .= self::pro_label( 'title_position' );
			$custom_css .= self::pro_label( 'meta_position' );
			$custom_css .= self::pro_label( 'category_position' );
			$custom_css .= self::pro_label( 'category_style' );
			$custom_css .= self::pro_label( 'image_height' );
			$custom_css .= self::pro_label( 'offset_image_height' );
		}

		return Fns::minify_css( $custom_css );
	}

	public static function pro_label( $key ) {
		return <<<CSS
				.et-db #et-boc .et-l .et-fb-form__group:has(#et-fb-{$key}) .et-fb-form__label-text {
					max-width: 100%;
				}	
				.et-db #et-boc .et-l .et-fb-form__group:has(#et-fb-{$key}) .et-fb-form__label-text::after {
				    content: "pro";
					color: #fff;
					padding: 2px 6px;
					background: red;
					line-height: 1;
					font-size: 10px;
					text-transform: uppercase;
					font-weight: bold;
					border-radius: 4px;
					margin-left: 3px;
				}
				.et-db #et-boc .et-l .et-fb-form__group:has(#et-fb-{$key}) {
					cursor: not-allowed;
				}
				.et-db #et-boc .et-l .et-fb-form__group:has(#et-fb-{$key}) > * {
					pointer-events: none !important;
				}
			CSS;
	}

}