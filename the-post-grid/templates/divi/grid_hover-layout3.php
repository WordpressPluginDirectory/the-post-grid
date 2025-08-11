<?php
/**
 * Grid Layout Template - 1
 *
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

use RT\ThePostGrid\Helpers\DiviFns;
use RT\ThePostGrid\Helpers\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pID     = get_the_ID();
$excerpt = Fns::get_the_excerpt( $pID, $data );
$title   = Fns::get_the_title( $pID, $data );

/**
 * Get post link markup
 * $link_start, $link_end, $readmore_link_start, $readmore_link_end
 */

$post_link = Fns::get_post_link( $pID, $data );
extract( $post_link );

// Column Dynamic Class
$column_classes = [];

$column_classes[] .= $data['hover_animation'];
$column_classes[] .= 'rt-grid-hover-item rt-grid-item';
if ( 'masonry' == $data['layout_style'] ) {
	$column_classes[] .= 'masonry-grid-item';
}

?>

<div class="<?php echo esc_attr( DiviFns::layout_cols( $data ) . ' ' . implode( ' ', $column_classes ) ); ?>" data-id="<?php echo esc_attr( $pID ); ?>">
	<div class="rt-holder tpg-post-holder <?php echo esc_attr( is_sticky( $pID ) ? 'rt-sticky' : '' ) ?>">
		<div class="rt-detail rt-el-content-wrapper">
			<?php
			if ( 'on' == $data['show_thumb'] ) :
				$has_thumbnail = has_post_thumbnail() ? 'has-thumbnail' : 'has-no-thumbnail';
				?>
				<div class="rt-img-holder tpg-el-image-wrap <?php echo esc_attr( $has_thumbnail ); ?>">
					<?php Fns::get_post_thumbnail( $pID, $data, $link_start, $link_end ); ?>
				</div>
			<?php endif; ?>

			<div class="grid-hover-content">

				<?php
				if ( 'on' == $data['show_title'] ) {
					Fns::get_el_post_title( $data['title_tag'], $title, $link_start, $link_end, $data );
				}
				?>


				<?php if ( 'on' == $data['show_meta'] ) : ?>
					<div class="post-meta-tags rt-el-post-meta">
						<?php Fns::get_post_meta_html( $pID, $data ); ?>
					</div>
				<?php endif; ?>

				<?php if ( 'on' == $data['show_excerpt'] || 'on' == $data['show_acf'] ) : ?>
					<div class="tpg-excerpt tpg-el-excerpt">
						<?php if ( $excerpt && 'on' == $data['show_excerpt'] ) : ?>
							<div class="tpg-excerpt-inner">
								<?php echo wp_kses_post( $excerpt ); ?>
							</div>
						<?php endif; ?>
						<?php Fns::tpg_get_acf_data_elementor( $data, $pID ); ?>
					</div>
				<?php endif; ?>

				<?php
				if ( rtTPG()->hasPro() && 'on' === $data['show_social_share'] ) {
					Fns::print_html( \RT\ThePostGridPro\Helpers\Functions::rtShare( $pID ) );
				}
				if ( 'on' === $data['show_read_more'] && $data['read_more_label'] ) {
					Fns::get_read_more_button( $data, $readmore_link_start, $readmore_link_end, 'gutenberg' );
				}
				?>
			</div>
		</div>
	</div>
</div>
