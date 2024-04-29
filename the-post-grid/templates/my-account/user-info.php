<?php
/**
 *
 * @author        RadiusTheme
 * @package    the-post-grid/templates
 * @version     1.0.0
 */

use RT\ThePostGrid\Helpers\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$current_user = $data['current_user'];
?>
<div class="dashboard-content">
	<div class="myaccount-title-wrapper">
		<h2 class="title"><?php echo esc_html__( 'Dashboard', 'the-post-grid' ); ?></h2>
		<?php Fns::current_time(); ?>
	</div>
	<div class="user-info-action">
		<div class="action">
			<div class="icon-wrap all">
				<?php Fns::dashboard_icon( 'total-post' ); ?>
			</div>
		   <div class="info">
			   <span class="label"><?php echo esc_html__( 'Total Post', 'the-post-grid' ); ?></span>
			   <span class="count"><?php echo esc_html( Fns::count_post( $current_user, 'all' ) ); ?></span>
		   </div>
		</div>

		<div class="action">
			<div class="icon-wrap publish">
				<?php Fns::dashboard_icon( 'publish-post' ); ?>
			</div>
			<div class="info">
				<span class="label"><?php echo esc_html__( 'Publish Post', 'the-post-grid' ); ?></span>
				<span class="count"><?php echo esc_html( Fns::count_post( $current_user ) ); ?></span>
			</div>
		</div>

		<div class="action">
			<div class="icon-wrap draft">
				<?php Fns::dashboard_icon( 'draft-post' ); ?>
			</div>
			<div class="info">
				<span class="label"><?php echo esc_html__( 'Draft Post', 'the-post-grid' ); ?></span>
				<span class="count"><?php echo esc_html( Fns::count_post( $current_user, 'draft' ) ); ?></span>
			</div>
		</div>

		<div class="action">
			<div class="icon-wrap pending">
				<?php Fns::dashboard_icon( 'pending-post' ); ?>
			</div>
			<div class="info">
				<span class="label"><?php echo esc_html__( 'Pending Post', 'the-post-grid' ); ?></span>
				<span class="count"><?php echo esc_html( Fns::count_post( $current_user, 'pending' ) ); ?></span>
			</div>
		</div>
	</div>

	<br>
	<h3><?php esc_html_e( 'Latest Post', 'the-post-grid' ); ?></h3>
	<div class="latest-post-wrapper">
		<?php
		$args = [
			'posts_per_page' => 3,
			'post_type'      => 'post',
			'post_status'    => [ 'publish' ],
			'oderby'         => 'date',
			'order'          => 'DESC',
			'author'         => $current_user->ID,
		];

		$_latest_post = new \WP_Query( $args );

		$count = 0;
		if ( $_latest_post->have_posts() ) {
			while ( $_latest_post->have_posts() ) {
				$_latest_post->the_post();
				$data       = [
					'excerpt_limit' => 30,
					'excerpt_type'  => 'word',
				];
				$pid        = get_the_ID();
				$excerpt    = Fns::get_the_excerpt( $pid, $data );
				$categories = Fns::rt_get_the_term_list( $pid, 'category', null, '<span class="rt-separator">,</span>' );
				$tags       = Fns::rt_get_the_term_list( $pid, 'post_tag', null, '<span class="rt-separator">,</span>' );

				?>
				<div class="post-item tpg-post-container">
					<div class="post-image">
						<?php the_post_thumbnail( 'medium' ); ?>
						<span class="status <?php echo esc_attr( get_post_status() ); ?>"><?php echo esc_html( get_post_status() ); ?></span>
					</div>
					<div class="post-content">
						<h3 class="post-title"><?php the_title( sprintf( '<a href="%s">', get_the_permalink() ), '</a>' ); ?></h3>
						<div class="post-excerpt">
							<?php echo wp_kses_post( $excerpt ); ?>
						</div>

						<div class="post-meta">
							<span class='date'>
								<?php Fns::dashboard_icon( 'calender' ); ?>
								<?php echo get_the_date( '', $pid ); ?>
							</span>

							<?php if ( $categories ) : ?>
								<span class="categories">
								<?php Fns::dashboard_icon( 'folder' ); ?>
								<?php echo wp_kses( $categories, Fns::allowedHtml() ); ?>
							</span>
							<?php endif; ?>

							<?php if ( $tags ) : ?>
								<span class="tags">
								<?php Fns::dashboard_icon( 'tags' ); ?>
								<?php echo wp_kses( $tags, Fns::allowedHtml() ); ?>
							</span>
							<?php endif; ?>

							<span class='comment'>
								<?php Fns::dashboard_icon( 'comment' ); ?>
								<?php echo get_comments_number( $pid ); ?>
							</span>
						</div>

						<?php if ( rtTPG()->hasPro() ) : ?>
							<div class="post-btn-action">
								<a class="btn edit-btn"
								   href="<?php echo esc_url( Fns::get_account_endpoint_url( 'edit-post' ) ); ?>?pid=<?php echo esc_attr( $pid ); ?>">
									<?php Fns::dashboard_icon( 'edit' ); ?>
									<?php echo esc_html__( 'Edit', 'the-post-grid' ); ?>
								</a>
								<a class="btn delete-btn tpg-delete-post" href="" data-id="<?php echo esc_attr( $pid ); ?>">
									<?php Fns::dashboard_icon( 'delete' ); ?>
									<?php echo esc_html__( 'Delete', 'the-post-grid' ); ?>
								</a>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php
			}
		}
		wp_reset_postdata();
		?>
	</div>
</div>
