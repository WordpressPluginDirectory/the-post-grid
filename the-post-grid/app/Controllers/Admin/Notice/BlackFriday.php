<?php
/**
 * Notice Controller class.
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Controllers\Admin\Notice;

// Do not allow directly accessing this file.
use RT\ThePostGrid\Helpers\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Notice Controller class.
 */
class BlackFriday {

	/**
	 * Black friday notice.
	 *
	 * @return void
	 */
	public function __construct() {
		if ( ! Fns::is_black_friday_active() ) {
			return;
		}
		add_action( 'admin_notices', [ __CLASS__, 'render_notice' ], 1 );
		add_action( 'admin_footer', [ __CLASS__, 'admin_footer_scripts' ] );
		add_action( 'wp_ajax_rttpg_dismiss_black_friday_notice', [ __CLASS__, 'dismiss_black_friday_notice' ] );
	}

	/**
	 * Black friday notice.
	 *
	 * @return void
	 */
	public static function render_notice() {
		$plugin_name   = 'The Post Grid';
		$download_link = 'https://www.radiustheme.com/downloads/the-post-grid-pro-for-wordpress/';
		?>
        <div class="notice notice-info is-dismissible tpg-black-friday-notice" data-rttpg-dismissable="rttpg_dismiss_bf_notice" \
             style="padding: 0!important;"
        >
            <a href="<?php echo esc_url( $download_link ) ?>" style="display: block" target="_blank">
                <img alt="<?php echo esc_attr( $plugin_name ); ?>"
                     style="width: 100%;display: block;min-height: 30px;object-fit: cover"
                     src="<?php echo esc_url( rtTPG()->get_assets_uri( 'images/offer/black-friday.webp' ) ); ?>"/>
            </a>
        </div>
        <?php
	}

	public static function admin_footer_scripts() {
		?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(function () {
                    const dismissButtons = document.querySelectorAll('div[data-rttpg-dismissable] .notice-dismiss, div[data-rttpg-dismissable] .button-dismiss');

                    dismissButtons.forEach(function (button) {
                        button.addEventListener('click', function (e) {
                            e.preventDefault();

                            // Send AJAX request using fetch()
                            fetch(ajaxurl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                                },
                                body: new URLSearchParams({
                                    'action': 'rttpg_dismiss_black_friday_notice',
                                    'nonce': <?php echo wp_json_encode( wp_create_nonce( 'rttpg-dismissible-notice' ) ); ?>
                                }),
                            });

                            // Remove the closest notice element
                            const notice = e.target.closest('.is-dismissible');
                            if (notice) {
                                notice.remove();
                            }
                        });
                    });
                }, 1000);
            });
        </script>
		<?php
	}

	public static function dismiss_black_friday_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_success( new \WP_Error( 'rttpg_block_user_permission', __( 'User permission error', 'the-post-grid' ) ) );
		}
		check_ajax_referer( 'rttpg-dismissible-notice', 'nonce' );
		$currentYear = date( 'Y' );
		update_option( 'rttpg_dismiss_bf_notice_' . $currentYear, '1' );
		wp_die();
	}

}