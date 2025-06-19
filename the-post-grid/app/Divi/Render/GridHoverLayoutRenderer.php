<?php

namespace RT\ThePostGrid\Divi\Render;

use RT\ThePostGrid\Helpers\DiviFns;
use RT\ThePostGrid\Helpers\Fns;
use WP_Query;

class GridHoverLayoutRenderer {

	protected $settings;
	protected $prefix;
	protected $query;
	protected $query_args;
	protected $layout_id;
	protected $post_data;
	protected $layout;
	protected $template_path;
	protected $dynamic_class;
	protected $primary_color;
	protected $secondary_color;

	public function __construct( array $settings, string $prefix ) {
		$this->settings = $settings;
		$this->prefix   = $prefix;

		$this->normalize_settings();
		$this->setup_query();
		$this->prepare_render_data();
		DiviFns::get_script_depends( $settings, $prefix );
	}

	protected function normalize_settings() {
		$this->layout          = $this->settings[ $this->prefix . '_layout' ];
		$this->layout_id       = 'rt-tpg-container-' . wp_rand();
		$this->primary_color   = ! empty( $this->settings['layout_primary_color'] ) ? $this->settings['layout_primary_color'] : '';
		$this->secondary_color = ! empty( $this->settings['layout_secondary_color'] ) ? $this->settings['layout_secondary_color'] : '';
		if (
			! rtTPG()->hasPro() &&
			! in_array( $this->layout, [ 'grid_hover-layout1', 'grid_hover-layout2', 'grid_hover-layout3', ] )
		) {
			$this->layout = 'grid_hover-layout1';
		}
	}

	protected function setup_query() {
		$this->query_args = DiviFns::get_post_query( $this->settings, $this->prefix );
		$this->query      = new WP_Query( $this->query_args );
	}

	protected function prepare_render_data() {
		$posts_per_page  = $this->settings['display_per_page'] ?? $this->settings['post_limit'];
		$this->post_data = DiviFns::get_data_set(
			$this->settings,
			$this->query->max_num_pages,
			$posts_per_page,
			$this->prefix,
			'divi'
		);

		if ( isset( $this->settings['category_source'] ) ) {
			$this->post_data[ $this->settings['post_type'] . '_taxonomy' ] = $this->settings['category_source'];
		}
		if ( isset( $this->settings['tag_source'] ) ) {
			$this->post_data[ $this->settings['post_type'] . '_tags' ] = $this->settings['tag_source'];
		}

		$this->template_path = Fns::tpg_template_path( $this->post_data, 'divi' );
		$this->dynamic_class = Fns::get_dynamic_class_gutenberg( $this->settings, 'divi' );
	}

	public function block_css() {
		$css = '';
		if ( ! empty( $this->primary_color ) ) {
			$css .= "--tpg-primary-color: $this->primary_color;";
		}
		if ( ! empty( $this->secondary_color ) ) {
			$css .= "--tpg-secondary-color: $this->secondary_color;";
		}

		return $css;
	}

	protected function get_wrapper_class(): array {
		$class = [];

		if ( in_array( $this->layout, [
			'grid_hover-layout6',
			'grid_hover-layout7',
			'grid_hover-layout8',
			'grid_hover-layout9',
			'grid_hover-layout10',
			'grid_hover-layout11',
			'grid_hover-layout5-2',
			'grid_hover-layout6-2',
			'grid_hover-layout7-2',
			'grid_hover-layout9-2',
		] ) ) {
			$class[] = 'grid_hover-layout5';
		}

		$class[] = str_replace( '-2', '', $this->layout );
		$class[] = 'tpg-even grid-behaviour';
		$class[] = $this->prefix . '_layout_wrapper';

		return $class;
	}

	protected function render_posts() {
		if ( 'current_query' == $this->settings['post_type'] && ( is_archive() || is_home() ) ) {
			global $wp_query;
			$this->query = $wp_query;
		}

		if ( $this->query->have_posts() ) {
			$pCount = 1;
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				set_query_var( 'tpg_post_count', $pCount );
				set_query_var( 'tpg_total_posts', $this->query->post_count );
				Fns::tpg_template( $this->post_data, 'divi' );
				$pCount ++;
			}
			wp_reset_postdata();
		} else {
			printf(
				"<div class='no_posts_found_text'>%s</div>",
				esc_html( $this->settings['no_posts_found_text'] ?? __( 'No post found', 'the-post-grid' ) )
			);
		}
	}

	public function render(): string {
		ob_start();

		$wrapper_class = $this->get_wrapper_class();
		$is_carousel   = rtTPG()->hasPro() && 'carousel' === $this->settings['filter_btn_style'] && 'button' === $this->settings['filter_type']
			? 'carousel' : '';

		?>
        <div class="<?php echo esc_attr( $this->dynamic_class ); ?>" style='<?php echo esc_attr( $this->block_css() ) ?>'>
            <div class="rt-container-fluid rt-tpg-container tpg-el-main-wrapper tpg-divi clearfix <?php echo esc_attr( $this->layout . '-main' ); ?>"
                 id="<?php echo esc_attr( $this->layout_id ); ?>"
                 data-layout="<?php echo esc_attr( $this->layout ); ?>"
                 data-sc-id="elementor"
                 data-el-settings='<?php echo Fns::is_filter_enable( $this->settings ) ? esc_attr( htmlspecialchars( wp_json_encode( $this->post_data ) ) ) : ''; ?>'
                 data-el-query='<?php echo Fns::is_filter_enable( $this->settings ) ? esc_attr( htmlspecialchars( wp_json_encode( $this->query_args ) ) ) : ''; ?>'
                 data-el-path='<?php echo Fns::is_filter_enable( $this->settings ) ? esc_attr( $this->template_path ) : ''; ?>'>

				<?php Fns::render_loader_spinner(); ?>

                <div class="tpg-header-wrapper <?php echo esc_attr( $is_carousel ); ?>">
					<?php
					Fns::get_section_title( $this->settings, true );
					Fns::print_html( Fns::get_frontend_filter_markup( $this->settings, 'divi' ) );
					?>
                </div>

                <div class="rt-row rt-content-loader gutenberg-inner <?php echo esc_attr( implode( ' ', $wrapper_class ) ); ?>">
					<?php $this->render_posts(); ?>
                </div>

				<?php Fns::print_html( Fns::get_pagination_markup( $this->query, $this->settings ) ); ?>

            </div>
        </div>
		<?php

		do_action( 'tpg_divi_script' );

		return ob_get_clean();
	}

}