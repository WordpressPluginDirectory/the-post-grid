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
 * Review class.
 */
class Review {

	/**
	 * Review notice.
	 *
	 * @return void
	 */
	public function __construct() {
		if ( Fns::is_black_friday_active() ) {
			return;
		}
		add_action( 'admin_notices', [ $this, 'render_review_notice' ] );
		add_action( 'admin_init', [ __CLASS__, 'update_notice_status' ] );
		add_action( 'admin_head', [ __CLASS__, 'admin_scripts' ] );
	}

	/**
	 * Check if review notice should be shown or not
	 *
	 * @return void
	 */

	public function render_review_notice() {
		$spare_me     = get_option( 'rttpg_spare_me', '0' );
		$install_date = (int) get_option( 'rttpg_plugin_activation_time' );
		$remind_time  = (int) get_option( 'rttpg_remind_me' );
		$now          = time();

		// Early exit if user opted out permanently or already rated.
		if ( in_array( $spare_me, [ '1', '3' ], true ) ) {
			return;
		}

		// Calculate date thresholds.
		$ten_days_after_install    = $install_date + ( 10 * DAY_IN_SECONDS );
		$remind_due                = $remind_time + ( 15 * DAY_IN_SECONDS );
		$should_show_reminder      = $remind_time && ( $now >= $remind_due ); //15 days later from reminding
		$should_show_after_install = $install_date && ( $now >= $ten_days_after_install ) && $spare_me !== '2';

		if ( $should_show_reminder || $should_show_after_install ) {
			$this->rttpg_display_admin_notice();
		}
	}

	/**
	 * Display Admin Notice, asking for a review
	 *
	 * @return void
	 */
	public function rttpg_display_admin_notice() {
		global $pagenow;

		$exclude_pages = [
			'themes.php',
			'users.php',
			'tools.php',
			'options-general.php',
			'options-writing.php',
			'options-reading.php',
			'options-discussion.php',
			'options-media.php',
			'options-permalink.php',
			'options-privacy.php',
			'edit-comments.php',
			'upload.php',
			'media-new.php',
			'admin.php',
			'import.php',
			'export.php',
			'site-health.php',
			'export-personal-data.php',
			'erase-personal-data.php',
		];

		if ( in_array( $pagenow, $exclude_pages, true ) ) {
			return;
		}

		$nonce         = wp_create_nonce( 'rttpg_notice_nonce' );
		$current_url   = self::rttpg_current_admin_url();
		$dont_disturb  = add_query_arg( [ '_wpnonce' => $nonce, 'rttpg_spare_me' => '1' ], $current_url );
		$remind_me     = add_query_arg( [ '_wpnonce' => $nonce, 'rttpg_remind_me' => '1' ], $current_url );
		$rated         = add_query_arg( [ '_wpnonce' => $nonce, 'rttpg_rated' => '1' ], $current_url );
		$review_url    = 'https://wordpress.org/support/plugin/the-post-grid/reviews/?filter=5#new-post';
		$plugin_name   = 'The Post Grid';
		$download_link = 'https://www.radiustheme.com/downloads/the-post-grid-pro-for-wordpress/';
		$image_url     = rtTPG()->get_assets_uri( 'images/post-grid-gif.gif' );
		?>
        <div class="notice rttpg-review-notice rttpg-review-notice--extended">
            <div class="rttpg-review-notice_content" style="display: flex; gap: 15px;">
                <a href="<?php echo esc_url( $download_link ); ?>" target="_blank">
                    <img alt="<?php echo esc_attr( $plugin_name ); ?>"
                         src="<?php echo esc_url( $image_url ); ?>"
                         width="50" height="50"
                         style="transform: translateY(2px)"/>
                </a>
                <div>
                    <p>
                        <strong><?php echo esc_html( "Thank you for choosing $plugin_name." ); ?></strong>
						<?php echo esc_html( "If you have found our plugin useful and makes you smile, please consider giving us a 5-star rating on WordPress.org. It will help us to grow." ); ?>
                    </p>
                    <div class="rttpg-review-notice_actions">
                        <a href="<?php echo esc_url( $review_url ); ?>" class="rttpg-review-button rttpg-review-button--cta" target="_blank">
                            <span>⭐</span><span>Yes, You Deserve It!</span>
                        </a>
                        <a href="<?php echo esc_url( $rated ); ?>" class="rttpg-review-button rttpg-review-button--cta rttpg-review-button--outline">
                            <span>😀</span><span>Already Rated!</span>
                        </a>
                        <a href="<?php echo esc_url( $remind_me ); ?>" class="rttpg-review-button rttpg-review-button--cta rttpg-review-button--outline">
                            <span>🔔</span><span>Remind Me Later</span>
                        </a>
                        <a href="<?php echo esc_url( $dont_disturb ); ?>" class="rttpg-review-button rttpg-review-button--cta rttpg-review-button--error rttpg-review-button--outline">
                            <span>😐</span><span>No Thanks</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

		<?php
	}

	/**
	 * Current admin URL.
	 *
	 * @return string
	 */
	protected static function rttpg_current_admin_url() {
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		$uri = preg_replace( '|^.*/wp-admin/|i', '', $uri ?? '' );

		if ( ! $uri ) {
			return '';
		}

		return remove_query_arg(
			[
				'_wpnonce',
				'_wc_notice_nonce',
				'wc_db_update',
				'wc_db_update_nonce',
				'wc-hide-notice',
			],
			admin_url( $uri )
		);
	}

	/**
	 * Remove the notice for the user if review already done
	 *
	 * @return void
	 */
	public static function update_notice_status() {
		// Verify nonce
		if ( empty( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'rttpg_notice_nonce' ) ) {
			return;
		}

		// Map GET parameters to update callbacks
		$actions = [
			'rttpg_spare_me'  => function () {
				update_option( 'rttpg_spare_me', '1' );
			},
			'rttpg_remind_me' => function () {
				$now = time();
				update_option( 'rttpg_remind_me', $now );
				update_option( 'rttpg_spare_me', '2' );
			},
			'rttpg_rated'     => function () {
				update_option( 'rttpg_rated', 'yes' );
				update_option( 'rttpg_spare_me', '3' );
			},
		];

		// Loop through actions and execute if GET parameter exists and equals 1
		foreach ( $actions as $key => $callback ) {
			if ( isset( $_GET[ $key ] ) && absint( $_GET[ $key ] ) === 1 ) {
				$callback();
			}
		}
	}


	/**
	 * Admin Scripts
	 * @return void
	 */
	public static function admin_scripts() {
		?>
        <style>
            .rttpg-review-button--cta {
                --e-button-context-color: #4C6FFF;
                --e-button-context-color-dark: #4C6FFF;
                --e-button-context-tint: rgb(75 47 157/4%);
                --e-focus-color: rgb(75 47 157/40%);
            }

            .rttpg-review-notice {
                position: relative;
                margin: 5px 20px 5px 2px;
                border: 1px solid #ccd0d4;
                background: #fff;
                box-shadow: none;
                font-family: Roboto, Arial, Helvetica, Verdana, sans-serif;
                border-inline-start-width: 4px;
            }

            .rttpg-review-notice.notice {
                padding: 0;
            }

            .rttpg-review-notice:before {
                position: absolute;
                top: -1px;
                bottom: -1px;
                left: -4px;
                display: block;
                width: 4px;
                background: -webkit-linear-gradient(bottom, #4C6FFF 0%, #6939c6 100%);
                background: linear-gradient(0deg, #4C6FFF 0%, #6939c6 100%);
                content: "";
            }

            .rttpg-review-notice_content img {
                width: 50px;
                height: 50px;
            }

            .rttpg-review-notice_content {
                padding: 10px;
            }

            .rttpg-review-notice_actions > * + * {
                margin-inline-start: 8px;
                -webkit-margin-start: 8px;
                -moz-margin-start: 8px;
            }

            .rttpg-review-notice p {
                margin: 0;
                padding: 0;
                line-height: 1.5;
            }

            p + .rttpg-review-notice_actions {
                margin-top: 5px;
            }

            .rttpg-review-notice h3 {
                margin: 0;
                font-size: 1.0625rem;
                line-height: 1.2;
            }

            .rttpg-review-notice h3 + p {
                margin-top: 2px;
            }

            .rttpg-review-button span {
                display: flex;
            }

            .rttpg-review-button {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 10px;
                border: 0;
                border-radius: 3px;;
                background: var(--e-button-context-color);
                color: #fff;
                vertical-align: middle;
                text-align: center;
                text-decoration: none;
                white-space: nowrap;
                font-size: 13px
                font-weight: normal;
            }

            .rttpg-review-button:active {
                background: var(--e-button-context-color-dark);
                color: #fff;
                text-decoration: none;
            }

            .rttpg-review-button:focus {
                outline: 0;
                background: var(--e-button-context-color-dark);
                box-shadow: 0 0 0 2px var(--e-focus-color);
                color: #fff;
                text-decoration: none;
            }

            .rttpg-review-button:hover {
                background: var(--e-button-context-color-dark);
                color: #fff;
                text-decoration: none;
            }

            .rttpg-review-button.focus {
                outline: 0;
                box-shadow: 0 0 0 2px var(--e-focus-color);
            }

            .rttpg-review-button--error {
                --e-button-context-color: #d72b3f;
                --e-button-context-color-dark: #ae2131;
                --e-button-context-tint: rgba(215, 43, 63, 0.04);
                --e-focus-color: rgba(215, 43, 63, 0.4);
            }

            .rttpg-review-button.rttpg-review-button--outline {
                border: 1px solid;
                background: 0 0;
                color: #212121;
            }

            .rttpg-review-button.rttpg-review-button--outline:focus {
                background: var(--e-button-context-tint);
                color: var(--e-button-context-color-dark);
            }

            .rttpg-review-button.rttpg-review-button--outline:hover {
                background: var(--e-button-context-tint);
                color: var(--e-button-context-color-dark);
            }
        </style>
		<?php
	}

}