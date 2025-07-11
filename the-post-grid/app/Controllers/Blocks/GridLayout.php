<?php

namespace RT\ThePostGrid\Controllers\Blocks;

use RT\ThePostGrid\Controllers\Blocks\BlockController\SettingsTabController;
use RT\ThePostGrid\Controllers\Blocks\BlockController\StyleTabController;
use RT\ThePostGrid\Controllers\Blocks\BlockController\ContentTabController;
use RT\ThePostGrid\Helpers\Fns;

/**
 * GridLayout Class
 */
class GridLayout extends BlockBase {

	private $prefix;
	private $attribute_args;
	private $block_type;

	public function __construct() {
		add_action( 'init', [ $this, 'register_blocks' ] );
		$this->prefix         = 'grid';
		$this->block_type     = 'rttpg/tpg-' . $this->prefix . '-layout';
		$this->attribute_args = [
			'prefix'         => $this->prefix,
			'default_layout' => 'grid-layout1',
		];
	}

	/**
	 * Register Block
	 *
	 * @return void
	 */
	public function register_blocks() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}
		register_block_type(
			$this->block_type,
			[
				'attributes'      => $this->get_attributes(),
				'render_callback' => [ $this, 'render_block' ],
			]
		);
	}

	/**
	 * Get attributes
	 *
	 * @param bool $default
	 *
	 * @return array
	 */
	public function get_attributes() {
		/**
		 * All Attribute
		 * Content Tab | Settings Tab | Style Tab
		 */
		$content_attribute  = ContentTabController::get_controller( $this->attribute_args );
		$settings_attribute = SettingsTabController::get_controller();
		$style_attribute    = StyleTabController::get_controller();

		return array_merge( $content_attribute, $settings_attribute, $style_attribute );
	}

	/**
	 * @param array $data
	 *
	 * @return false|string
	 */
	public function render_block( $data ) {
		$this->get_script_depends( $data );

		$_prefix = $data['prefix'];

		if ( ! rtTPG()->hasPro() && ! in_array( $data[ $_prefix . '_layout' ], [ 'grid-layout1', 'grid-layout4', 'grid-layout3' ] ) ) {
			$data[ $_prefix . '_layout' ] = 'grid-layout1';
		}

		// Query
		$posts_per_page = ! empty( $data['display_per_page'] ) ? $data['display_per_page'] : $data['post_limit'];
		$query_args     = $this->post_query_guten( $data, $_prefix );
		if ( 'current_query' == $data['post_type'] && is_archive() ) {
            global $wp_query;
			$query = $wp_query;
        } else {
			$query          = new \WP_Query( $query_args );
        }

		$rand     = wp_rand();
		$layoutID = 'rt-tpg-container-' . $rand;
		/**
		 * Get Post Data for render post
		 */

		$post_data = Fns::get_render_data_set( $data, $query->max_num_pages, $posts_per_page, $_prefix, 'yes' );

		/**
		 * Post type render
		 */

		// Category Source if exists
		if ( isset( $data['category_source'] ) ) {
			$post_data[ $data['post_type'] . '_taxonomy' ] = $data['category_source'];
		}
		// Tag source
		if ( isset( $data['tag_source'] ) ) {
			$post_data[ $data['post_type'] . '_tags' ] = $data['tag_source'];
		}

		$template_path = Fns::tpg_template_path( $post_data, 'gutenberg' );
		$_layout       = $data[ $_prefix . '_layout' ];
		$_layout_style = $data['grid_layout_style'];
		$dynamicClass  = Fns::get_dynamic_class_gutenberg( $data );

		ob_start();
		?>
        <div class="<?php echo esc_attr( $dynamicClass ); ?>">
            <div class="rt-container-fluid rt-tpg-container tpg-el-main-wrapper tpg-gutenberg clearfix <?php echo esc_attr( $_layout . '-main' ); ?>"
                 id="<?php echo esc_attr( $layoutID ); ?>"
                 data-layout="<?php echo esc_attr( $data[ $_prefix . '_layout' ] ); ?>"
                 data-grid-style="<?php echo esc_attr( $data['grid_layout_style'] ); ?>" data-sc-id="elementor"
                 data-el-settings='<?php echo Fns::is_filter_enable( $data ) ? esc_attr( htmlspecialchars( wp_json_encode( $post_data ) ) ) : ''; ?>'
                 data-el-query='<?php echo Fns::is_filter_enable( $data ) ? esc_attr( htmlspecialchars( wp_json_encode( $query_args ) ) ) : ''; ?>'
                 data-el-path='<?php echo Fns::is_filter_enable( $data ) ? esc_attr( $template_path ) : ''; ?>'>
				<?php

				$settings = get_option( rtTPG()->options['settings'] );
				if ( isset( $settings['tpg_load_script'] ) || isset( $settings['tpg_enable_preloader'] ) ) {
					?>
                    <div id="bottom-script-loader" class="bottom-script-loader">
                        <div class="rt-ball-clip-rotate">
                            <div></div>
                        </div>
                    </div>
					<?php
				}

				$wrapper_class   = [];
				$wrapper_class[] = str_replace( '-2', '', $_layout );
				$wrapper_class[] = 'grid-behaviour';
				$wrapper_class[] = ( in_array( $_layout, [ 'grid-layout2' ] ) ) ? 'tpg-even' : $_layout_style;
				$wrapper_class[] = $_prefix . '_layout_wrapper';
				if ( 'masonry' === $_layout_style && in_array(
						$_layout,
						[
							'grid-layout1',
							'grid-layout3',
							'grid-layout4',
						]
					) ) {
					$wrapper_class[] = 'tpg-masonry';
				}

				if ( in_array( $_layout, [ 'grid-layout6', 'grid-layout6-2' ] ) && $data['middle_border'] === 'no' ) {
					$wrapper_class[] = 'disable-middle-border';
				}

				// Section title settings.
				$is_carousel = '';
				if ( rtTPG()->hasPro() && 'carousel' == $data['filter_btn_style'] && 'button' == $data['filter_type'] ) {
					$is_carousel = 'carousel';
				}

				?>
                <div class='tpg-header-wrapper <?php echo esc_attr( $is_carousel ); ?>'>
					<?php
					Fns::get_section_title( $data, true );
					Fns::print_html( Fns::get_frontend_filter_markup( $data, 'guten' ) );
					?>
                </div>

                <div class="rt-row rt-content-loader gutenberg-inner <?php echo esc_attr( implode( ' ', $wrapper_class ) ); ?>">
					<?php
					if ( $query->have_posts() ) {
						$pCount = 1;
						while ( $query->have_posts() ) {
							$query->the_post();
							set_query_var( 'tpg_post_count', $pCount );
							set_query_var( 'tpg_total_posts', $query->post_count );
							Fns::tpg_template( $post_data, 'gutenberg' );
							$pCount ++;
						}
					} else {
						if ( $data['no_posts_found_text'] ) {
							printf( "<div class='no_posts_found_text'>%s</div>", esc_html( $data['no_posts_found_text'] ) );
						} else {
							printf( "<div class='no_posts_found_text'>%s</div>", esc_html__( 'No post found', 'the-post-grid' ) );
						}
					}
					wp_reset_postdata();
					?>
                </div>

				<?php Fns::print_html( Fns::get_pagination_markup( $query, $data ) ); ?>

            </div>
        </div>
		<?php

		do_action( 'tpg_elementor_script' );

		return ob_get_clean();
	}

}