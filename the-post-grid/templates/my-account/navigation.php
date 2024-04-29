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
extract( $data );
$user_id = $current_user->ID;
do_action( 'rtcl_before_account_navigation' );
global $wp;
?>

<nav class="rtcl-MyAccount-navigation">
	<div class="user-info">
		<div class="user-avatar">
			<?php echo get_avatar( $user_id, 150 ); ?>
		</div>
		<div class="user-bio">
			<h3 class="user-name"><?php echo esc_html( $current_user->display_name ); ?></h3>
			<span class="user-email"><?php echo esc_html( $current_user->user_email ); ?></span>
		</div>
	</div>
	<div class="myaccount-navbar">
		<ul>
			<?php
			foreach ( Fns::get_account_menu_items() as $endpoint => $label ) :
				$is_active = '';
				if ( isset( $wp->query_vars[ $endpoint ] ) ) {
					$is_active = 'is-active';
				}
				if ( 'dashboard' === $endpoint && ( isset( $wp->query_vars['page'] ) || empty( $wp->query_vars ) ) ) {
					$is_active = 'is-active';
				}
				?>
				<li class="<?php echo esc_attr( $endpoint . ' ' . $is_active ); ?>">
					<a href="<?php echo esc_url( Fns::get_account_endpoint_url( $endpoint ) ); ?>">
						<?php Fns::dashboard_icon( $endpoint ); ?>
						<?php echo esc_html( $label ); ?>
					</a>
				</li>
			<?php endforeach; ?>

			<li class="logout">
				<a href="<?php echo esc_url( Fns::logout_url() ); ?>">
					<?php Fns::dashboard_icon( 'logout' ); ?>
					<?php echo esc_html__( 'Logout', 'the-post-grid' ); ?>
				</a>
			</li>
			<?php if ( rtTPG()->hasPro() ) : ?>
			<li class="submit-post-button">
				<a href="<?php echo esc_url( Fns::get_account_endpoint_url( 'submit-post' ) ); ?>">
					<?php echo esc_html__( 'Submit Post', 'the-post-grid' ); ?>
					<svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M7.4637 0.554597C7.96073 0.057566 8.76658 0.057566 9.26361 0.554597L13.8091 5.10005C14.3061 5.59708 14.3061 6.40293 13.8091 6.89996L9.26361 11.4454C8.76658 11.9424 7.96073 11.9424 7.4637 11.4454C6.96667 10.9484 6.96667 10.1425 7.4637 9.64551L9.83648 7.27273H2.00002C1.29711 7.27273 0.727295 6.70291 0.727295 6.00001C0.727295 5.2971 1.29711 4.72728 2.00002 4.72728H9.83648L7.4637 2.35451C6.96667 1.85747 6.96667 1.05163 7.4637 0.554597Z" fill="white"/>
					</svg>
				</a>
			</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php do_action( 'rtcl_after_account_navigation_list' ); ?>
</nav>

<?php do_action( 'rtcl_after_account_navigation' ); ?>
