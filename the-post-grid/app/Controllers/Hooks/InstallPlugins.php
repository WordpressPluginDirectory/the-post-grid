<?php
/**
 * Action Hooks class.
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Controllers\Hooks;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

use Plugin_Upgrader;
use WP_Ajax_Upgrader_Skin;
use WpOrg\Requests\Exception;

/**
 * Action Hooks class.
 */
class InstallPlugins {

	/**
	 * Class init.
	 *
	 * @return void
	 */
	public static function init() {
		// Step 4: PHP — AJAX Handlers to Install and Activate Plugin

		// Handle plugin installation via AJAX
		add_action( 'wp_ajax_rttpg_install_plugin', function() {
			// Check permissions and nonce
			if ( ! current_user_can( 'install_plugins' ) || ! check_ajax_referer( rtTPG()->nonceText(), rtTPG()->nonceId(), false ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Permission denied', 'the-post-grid' ) ] );
			}


			if ( empty( $_POST['slug'] ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Missing plugin slug', 'the-post-grid' ) ] );
			}

			$slug = sanitize_key( wp_unslash( $_POST['slug'] ) );

			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/misc.php';
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader-skins.php';

			// Get plugin information from WordPress.org API
			$api = plugins_api( 'plugin_information', [
				'slug'   => $slug,
				'fields' => [ 'sections' => false ],
			] );

			if ( is_wp_error( $api ) ) {
				wp_send_json_error( [ 'message' => $api->get_error_message() ] );
			}

			// Ensure filesystem credentials are set up
			$creds = request_filesystem_credentials( '', '', false, false, [] );
			if ( ! WP_Filesystem( $creds ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Filesystem credentials error.', 'the-post-grid' ) ] );
			}

			// Install the plugin
			$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );
			$result   = $upgrader->install( $api->download_link );

			if ( is_wp_error( $result ) ) {
				wp_send_json_error( [ 'message' => $result->get_error_message() ] );
			}

			if ( ! $upgrader->plugin_info() ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Plugin installation failed.', 'the-post-grid' ) ] );
			}

			$plugin_file = $upgrader->plugin_info(); // e.g., classified-listing/classified-listing.php
			wp_send_json_success( [ 'plugin' => $plugin_file ] );
		} );

		// Handle plugin activation via AJAX
		add_action( 'wp_ajax_rttpg_activate_plugin', function() {
			if ( ! current_user_can( 'install_plugins' ) || ! check_ajax_referer( rtTPG()->nonceText(), rtTPG()->nonceId(), false ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Permission denied', 'the-post-grid' ) ] );
			}

			if ( empty( $_POST['plugin'] ) ) {
				wp_send_json_error( [ 'message' => esc_html__( 'Missing plugin path', 'the-post-grid' ) ] );
			}

			$plugin = plugin_basename( sanitize_text_field( wp_unslash( $_POST['plugin'] ) ) );

			include_once ABSPATH . 'wp-admin/includes/plugin.php';

			$result = activate_plugin( $plugin );

			if ( is_wp_error( $result ) ) {
				wp_send_json_error( [ 'message' => $result->get_error_message() ] );
			}

			wp_send_json_success();
		} );

		add_action( 'admin_head', function() {
			// Get current screen object
			$screen = get_current_screen();

			// Check if we are on our desired page
			//phpcs:ignore WordPress.Security.NonceVerification.Recommended -- screen detection only, nothing is written.
			$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';

			if (
				$screen &&
				'rttpg' === $screen->post_type &&
				'rttpg_our_plugins' === $page
			) {
				// Remove default WordPress admin notices
				remove_all_actions( 'admin_notices' );
				remove_all_actions( 'all_admin_notices' );

				// Optionally also hide them with CSS as fallback
				echo '<style>.notice, .updated, .error, .is-dismissible { display: none !important; }</style>';
			}
		} );
	}

}

