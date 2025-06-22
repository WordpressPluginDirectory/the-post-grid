<?php

namespace RT\ThePostGrid\Abstracts;

use \ET_Builder_Module;

abstract class AbstractDivi extends ET_Builder_Module {

	public $vb_support = 'on';
	protected $video_id = 'PLeKWXbEok0';
	public $icon_path;

	public function init() {
		$this->name                   = $this->get_module_name();
		$this->icon_path              = $this->get_icon_path();
		$this->folder_name            = 'et_pb_the_post_grid_module';
		$this->settings_modal_toggles = $this->get_settings_modal_toggles();
		$this->help_videos            = $this->help_videos();
	}

	protected function get_module_name() {
		return esc_html__( 'The Post Grid Module Name', 'the-post-grid' );
	}

	protected function get_icon_path() {
		return trailingslashit( RT_THE_POST_GRID_PLUGIN_PATH ) . "/assets/images/gutenberg/grid-layout.svg";
	}

	protected function help_videos() {
		return [
			[
				'id'   => $this->video_id,
				'name' => $this->name,
			],
		];
	}

	public function get_settings_modal_toggles() {
		$general = [
			'tpg_layout'        => esc_html__( 'Layout', 'the-post-grid' ),
			'tpg_query'         => esc_html__( 'Query Builder', 'the-post-grid' ),
			'tpg_filter'        => esc_html__( 'Filter (Front-end)', 'the-post-grid' ),
			'tpg_pagination'    => esc_html__( 'Pagination', 'the-post-grid' ),
			'tpg_links'         => esc_html__( 'Post Link', 'the-post-grid' ),
			'tpg_selection'     => esc_html__( 'Field Selection', 'the-post-grid' ),
			'tpg_section_title' => esc_html__( 'Section Title', 'the-post-grid' ),
			'tpg_post_title'    => esc_html__( 'Post title', 'the-post-grid' ),
			'tpg_thumbnail'     => esc_html__( 'Thumbnail', 'the-post-grid' ),
			'tpg_excerpt'       => esc_html__( 'Excerpt / Content', 'the-post-grid' ),
			'tpg_meta_data'     => esc_html__( 'Meta Data', 'the-post-grid' ),
			'tpg_acf'           => esc_html__( 'ACF Settings', 'the-post-grid' ),
			'tpg_read_more'     => esc_html__( 'Read More', 'the-post-grid' ),
		];

		$advanced = [
			'tpg_section_title_style' => esc_html__( 'Section Title', 'the-post-grid' ),
			'tpg_post_title_style'    => esc_html__( 'Post Title', 'the-post-grid' ),
			'tpg_thumbnail_style'     => esc_html__( 'Thumbnail', 'the-post-grid' ),
			'tpg_excerpt_style'       => esc_html__( 'Excerpt / Content', 'the-post-grid' ),
			'tpg_meta_data_style'     => esc_html__( 'Meta Data', 'the-post-grid' ),
			'tpg_social_share_style'  => esc_html__( 'Social Share', 'the-post-grid' ),
			'tpg_read_more_style'     => esc_html__( 'Read More', 'the-post-grid' ),
			'tpg_filter_style'        => esc_html__( 'Front-End Filter', 'the-post-grid' ),
			'tpg_pagination_style'    => esc_html__( 'Pagination / Load More', 'the-post-grid' ),
			'tpg_acf_style'           => esc_html__( 'Advanced Custom Field (ACF)', 'the-post-grid' ),
			'tpg_card_style'          => esc_html__( 'Card (Post Item)', 'the-post-grid' ),
		];

		// Let child filter the array if needed
		$general  = $this->filter_general_toggles( $general );
		$advanced = $this->filter_advanced_toggles( $advanced );

		return [
			'general'  => [ 'toggles' => $general ],
			'advanced' => [ 'toggles' => $advanced ],
		];
	}

	protected function filter_general_toggles( $toggles ) {
		return $toggles;
	}

	protected function filter_advanced_toggles( $toggles ) {
		return $toggles;
	}

}