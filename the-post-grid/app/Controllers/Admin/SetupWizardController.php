<?php
/**
 * Setup Wizard Controller.
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Controllers\Admin;

use RT\ThePostGrid\Helpers\Fns;
use RT\ThePostGrid\Helpers\Options;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Setup Wizard Controller.
 */
class SetupWizardController {

	/**
	 * Option key for wizard completion status.
	 *
	 * @var string
	 */
	const WIZARD_COMPLETED_OPTION = 'rttpg_setup_wizard_completed';

	/**
	 * Option key for redirect flag.
	 *
	 * @var string
	 */
	const REDIRECT_OPTION = 'rttpg_setup_wizard_redirect';

	/**
	 * Admin page slug.
	 *
	 * @var string
	 */
	const PAGE_SLUG = 'rttpg-setup-wizard';

	/**
	 * REST API namespace.
	 *
	 * @var string
	 */
	const REST_NAMESPACE = 'rttpg/v1';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', [ $this, 'maybe_redirect_to_wizard' ], 1 );
		add_action( 'admin_menu', [ $this, 'register_admin_page' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'rest_api_init', [ $this, 'register_rest_routes' ] );

		// Add filter to allow other plugins/themes to modify wizard steps.
		add_filter( 'rttpg_setup_wizard_steps', [ $this, 'get_default_steps' ] );
		add_action( 'admin_init', function () {
			if ( isset( $_GET['tpg_wizard'] ) ) {
				remove_all_actions( 'admin_init' );
			}
		}, 1 );
	}

	/**
	 * Set redirect flag on activation.
	 *
	 * @return void
	 */
	public static function set_activation_redirect() {
		// Only set redirect for single site or network admin.
		if ( ! is_network_admin() && ! isset( $_GET['activate-multi'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			update_option( self::REDIRECT_OPTION, 'yes' );
		}
	}

	/**
	 * Check if wizard should redirect.
	 *
	 * @return void
	 */
	public function maybe_redirect_to_wizard() {
		// Don't redirect if wizard is already completed.
		if ( get_option( self::WIZARD_COMPLETED_OPTION ) ) {
			return;
		}

		// Check for redirect flag.
		if ( get_option( self::REDIRECT_OPTION ) !== 'yes' ) {
			return;
		}

		// Delete redirect flag.
		delete_option( self::REDIRECT_OPTION );

		// Don't redirect on AJAX, bulk activate, or if user doesn't have permissions.
		if (
			wp_doing_ajax() ||
			is_network_admin() ||
			! current_user_can( 'manage_options' ) ||
			isset( $_GET['activate-multi'] ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		) {
			return;
		}

		// Redirect to setup wizard.
		wp_safe_redirect( admin_url( 'admin.php?page=' . self::PAGE_SLUG ) );
		exit;
	}

	/**
	 * Register hidden admin page.
	 *
	 * @return void
	 */
	public function register_admin_page() {
		add_submenu_page(
			'', // No parent - hidden page.
			esc_html__( 'The Post Grid Setup Wizard', 'the-post-grid' ),
			esc_html__( 'Setup Wizard', 'the-post-grid' ),
			'manage_options',
			self::PAGE_SLUG,
			[ $this, 'render_wizard_page' ]
		);
	}

	/**
	 * Render wizard page.
	 *
	 * @return void
	 */
	public function render_wizard_page() {
		// Capability check.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to access this page.', 'the-post-grid' ) );
		}

		/**
		 * Action hook before wizard page renders.
		 */
		do_action( 'rttpg_before_setup_wizard_page' );

		echo '<div id="rttpg-setup-wizard-root" class="rttpg-setup-wizard-wrap"></div>';

		/**
		 * Action hook after wizard page renders.
		 */
		do_action( 'rttpg_after_setup_wizard_page' );
	}

	/**
	 * Enqueue scripts only on wizard page.
	 *
	 * @param string $hook_suffix Current admin page hook.
	 *
	 * @return void
	 */
	public function enqueue_scripts( $hook_suffix ) {
		// Only load on setup wizard page.
		if ( 'admin_page_' . self::PAGE_SLUG !== $hook_suffix ) {
			return;
		}

		$asset_file = RT_THE_POST_GRID_PLUGIN_PATH . '/assets/setup-wizard/main.asset.php';
		$asset      = file_exists( $asset_file ) ? require $asset_file : [
			'dependencies' => [ 'wp-element', 'wp-components', 'wp-i18n', 'wp-api-fetch' ],
			'version'      => RT_THE_POST_GRID_VERSION,
		];

		// Enqueue React app.
		wp_enqueue_script(
			'rttpg-setup-wizard',
			RT_THE_POST_GRID_PLUGIN_URL . '/assets/setup-wizard/main.js',
			$asset['dependencies'],
			$asset['version'],
			true
		);

		// Enqueue styles.
		wp_enqueue_style(
			'rttpg-setup-wizard',
			RT_THE_POST_GRID_PLUGIN_URL . '/assets/setup-wizard/main.css',
			[ 'wp-components' ],
			$asset['version']
		);

		// Localize script data.
		wp_localize_script(
			'rttpg-setup-wizard',
			'rttpgSetupWizard',
			$this->get_localized_data()
		);

		// Set script translations.
		wp_set_script_translations( 'rttpg-setup-wizard', 'the-post-grid' );
	}

	/**
	 * Get localized data for JavaScript.
	 *
	 * @return array
	 */
	private function get_localized_data() {
		$settings = get_option( rtTPG()->options['settings'], rtTPG()->defaultSettings );

		/**
		 * Filter the wizard localized data.
		 *
		 * @param array $data Localized data.
		 */
		return apply_filters(
			'rttpg_setup_wizard_localized_data',
			[
				'restUrl'            => esc_url_raw( rest_url( self::REST_NAMESPACE ) ),
				'nonce'              => wp_create_nonce( 'wp_rest' ),
				'adminUrl'           => admin_url(),
				'dashboardUrl'       => admin_url( 'index.php' ),
				'tpgSettingsUrl'     => admin_url( 'edit.php?post_type=rttpg&page=rttpg_settings' ),
				'proUrl'             => rtTPG()->proLink(),
				'hasPro'             => rtTPG()->hasPro(),
				'settings'           => $this->get_current_settings( $settings ),
				'steps'              => apply_filters( 'rttpg_setup_wizard_steps', [] ),
				'pluginName'         => esc_html__( 'The Post Grid', 'the-post-grid' ),
				'logoUrl'            => RT_THE_POST_GRID_PLUGIN_URL . '/assets/images/post-grid-gif.gif',
				'recommendedPlugins' => $this->get_recommended_plugins(),
				'tutorials'          => $this->get_tutorials(),
			]
		);
	}

	/**
	 * Get current settings values.
	 *
	 * @param array $settings Saved settings.
	 *
	 * @return array
	 */
	private function get_current_settings( $settings ) {
		return [
			// General settings.
			'tpg_block_type'             => $settings['tpg_block_type'] ?? 'default',
			'tpg_load_script'            => ! empty( $settings['tpg_load_script'] ),
			'tpg_enable_preloader'       => ! empty( $settings['tpg_enable_preloader'] ),
			'tpg_enable_post_view_count' => ! empty( $settings['tpg_enable_post_view_count'] ),
			'tpg_icon_font'              => $settings['tpg_icon_font'] ?? 'flaticon',
			'tpg_pagination_range'       => $settings['tpg_pagination_range'] ?? '4',
			'tpg_primary_color_main'     => $settings['tpg_primary_color_main'] ?? '#0d6efd',
			'tpg_secondary_color_main'   => $settings['tpg_secondary_color_main'] ?? '#0654c4',
			// AI settings.
			'ai_type'                    => $settings['ai_type'] ?? '',
			'chatgpt_status'             => ! empty( $settings['chatgpt_status'] ),
			'chatgpt_secret_key'         => $settings['chatgpt_secret_key'] ?? '',
			'chatgpt_model'              => $settings['chatgpt_model'] ?? 'gpt-3.5-turbo',
			'chatgpt_response_time'      => $settings['chatgpt_response_time'] ?? 60,
			'chatgpt_max_tokens'         => $settings['chatgpt_max_tokens'] ?? 1200,
			'gemini_status'              => ! empty( $settings['gemini_status'] ),
			'gemini_secret_key'          => $settings['gemini_secret_key'] ?? '',
			'gemini_model'               => $settings['gemini_model'] ?? 'gemini-2.0-flash',
			'gemini_response_time'       => $settings['gemini_response_time'] ?? 60,
			'gemini_max_tokens'          => $settings['gemini_max_tokens'] ?? 1200,
		];
	}

	/**
	 * Get recommended plugins list.
	 *
	 * @return array
	 */
	private function get_recommended_plugins() {
		$plugins = [
			[
				'slug'        => 'radius-booking',
				'name'        => esc_html__( 'Radius Booking', 'the-post-grid' ),
				'description' => esc_html__( 'WordPress booking plugin for appointments, staff management...', 'the-post-grid' ),
				'icon'        => 'dashicons-calendar-alt',
			],
			[
				'slug'        => 'review-schema',
				'name'        => esc_html__( 'Review Schema', 'the-post-grid' ),
				'description' => esc_html__( 'Add rich snippet reviews for better SEO and Google visibility.', 'the-post-grid' ),
				'icon'        => 'dashicons-star-filled',
			],
			[
				'slug'        => 'classified-listing',
				'name'        => esc_html__( 'Classified Listing', 'the-post-grid' ),
				'description' => esc_html__( 'AI-powered WordPress plugin for classified listings and directories.', 'the-post-grid' ),
				'icon'        => 'dashicons-star-filled',
			],
			[
				'slug'        => 'shopbuilder',
				'name'        => esc_html__( 'ShopBuilder', 'the-post-grid' ),
				'description' => esc_html__( 'Build stunning WooCommerce stores with drag-and-drop builder.', 'the-post-grid' ),
				'icon'        => 'dashicons-cart',
			],
			[
				'slug'        => 'tlp-food-menu',
				'name'        => esc_html__( 'Food Menu', 'the-post-grid' ),
				'description' => esc_html__( 'Create beautiful restaurant menus, categories, and layouts.', 'the-post-grid' ),
				'icon'        => 'dashicons-carrot',
			],
			[
				'slug'        => 'tlp-team',
				'name'        => esc_html__( 'Team Members', 'the-post-grid' ),
				'description' => esc_html__( 'Showcase your team with beautiful profiles and social links.', 'the-post-grid' ),
				'icon'        => 'dashicons-groups',
			],
			[
				'slug'        => 'testimonial-slider-and-showcase',
				'name'        => esc_html__( 'Testimonial Slider', 'the-post-grid' ),
				'description' => esc_html__( 'Display customer testimonials with responsive slider and grid layouts.', 'the-post-grid' ),
				'icon'        => 'dashicons-groups',
			],
			[
				'slug'        => 'woo-product-variation-gallery',
				'name'        => esc_html__( 'Variation Gallery', 'the-post-grid' ),
				'description' => esc_html__( 'WooCommerce plugin for unlimited additional variation image galleries.', 'the-post-grid' ),
				'icon'        => 'dashicons-groups',
			],
			[
				'slug'        => 'woo-product-variation-swatches',
				'name'        => esc_html__( 'Variation Swatches', 'the-post-grid' ),
				'description' => esc_html__( 'WooCommerce variations into images, colors, labels, and radios.', 'the-post-grid' ),
				'icon'        => 'dashicons-groups',
			],
		];

		// Check installed/active status.
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$installed_plugins = get_plugins();
		$active_plugins    = get_option( 'active_plugins', [] );

		foreach ( $plugins as $key => $plugin ) {
			$plugin_file = $this->get_plugin_file( $plugin['slug'], $installed_plugins );

			$plugins[ $key ]['installed'] = ! empty( $plugin_file );
			$plugins[ $key ]['active']    = ! empty( $plugin_file ) && in_array( $plugin_file, $active_plugins, true );
		}

		return $plugins;
	}

	/**
	 * Get plugin file from slug.
	 *
	 * @param string $slug Plugin slug.
	 * @param array $installed_plugins Installed plugins.
	 *
	 * @return string|false
	 */
	private function get_plugin_file( $slug, $installed_plugins ) {
		foreach ( $installed_plugins as $file => $plugin ) {
			if ( strpos( $file, $slug . '/' ) === 0 || $file === $slug . '.php' ) {
				return $file;
			}
		}

		return false;
	}

	/**
	 * Get tutorial videos.
	 *
	 * @return array
	 */
	private function get_tutorials() {
		return [
			[
				'title'       => esc_html__( 'The post grid all in one', 'the-post-grid' ),
				'description' => esc_html__( 'How to Use The Post Grid Plugin with Shortcode, Elementor and Gutenberg', 'the-post-grid' ),
				'videoId'     => 'PLeKWXbEok0',
			],
			[
				'title'       => esc_html__( 'Gutenberg Blocks', 'the-post-grid' ),
				'description' => esc_html__( 'How to use The Post Grid Gutenberg Blocks [Free]', 'the-post-grid' ),
				'videoId'     => 'wHWAnfL0VhU',
			],
			[
				'title'       => esc_html__( 'Elementor Integration', 'the-post-grid' ),
				'description' => esc_html__( 'How to Use The Post Grid Plugin with Elementor | Step-by-Step Tutorial', 'the-post-grid' ),
				'videoId'     => '6rb70U9KciI',
			],
		];
	}

	/**
	 * Get default wizard steps configuration.
	 *
	 * @param array $steps Existing steps.
	 *
	 * @return array
	 */
	public function get_default_steps( $steps ) {
		return [
			[
				'id'          => 'general',
				'title'       => esc_html__( 'General Settings', 'the-post-grid' ),
				'description' => esc_html__( 'Configure performance, display options, and colors for your post grids.', 'the-post-grid' ),
			],
			[
				'id'          => 'ai',
				'title'       => esc_html__( 'AI Integration', 'the-post-grid' ),
				'description' => esc_html__( 'Configure AI-powered features using ChatGPT or Google Gemini.', 'the-post-grid' ),
			],
			[
				'id'          => 'plugins',
				'title'       => esc_html__( 'Website Powerups', 'the-post-grid' ),
				'description' => esc_html__( 'Enhance your website with powerful features to create a complete WordPress experience.', 'the-post-grid' ),
			],
			[
				'id'          => 'tutorials',
				'title'       => esc_html__( 'Master Post Grid', 'the-post-grid' ),
				'description' => esc_html__( "Watch these quick video tutorials to get the most out of your new post grid builder. We have simplified the complex for you.", 'the-post-grid' ),
			],
		];
	}

	/**
	 * Register REST API routes.
	 *
	 * @return void
	 */
	public function register_rest_routes() {
		register_rest_route(
			self::REST_NAMESPACE,
			'/setup-wizard/save',
			[
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => [ $this, 'save_settings' ],
				'permission_callback' => [ $this, 'check_permission' ],
				'args'                => $this->get_save_args(),
			]
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/setup-wizard/skip',
			[
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => [ $this, 'skip_wizard' ],
				'permission_callback' => [ $this, 'check_permission' ],
			]
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/setup-wizard/complete',
			[
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => [ $this, 'complete_wizard' ],
				'permission_callback' => [ $this, 'check_permission' ],
			]
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/setup-wizard/install-plugin',
			[
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => [ $this, 'install_plugin' ],
				'permission_callback' => [ $this, 'check_install_permission' ],
				'args'                => [
					'slug' => [
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					],
				],
			]
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/setup-wizard/activate-plugin',
			[
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => [ $this, 'activate_plugin' ],
				'permission_callback' => [ $this, 'check_install_permission' ],
				'args'                => [
					'slug' => [
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					],
				],
			]
		);
	}

	/**
	 * Check REST API permission.
	 *
	 * @return bool|\WP_Error
	 */
	public function check_permission() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return new \WP_Error(
				'rest_forbidden',
				esc_html__( 'You do not have permission to perform this action.', 'the-post-grid' ),
				[ 'status' => rest_authorization_required_code() ]
			);
		}

		return true;
	}

	/**
	 * Check plugin installation permission.
	 *
	 * @return bool|\WP_Error
	 */
	public function check_install_permission() {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return new \WP_Error(
				'rest_forbidden',
				esc_html__( 'You do not have permission to install plugins.', 'the-post-grid' ),
				[ 'status' => rest_authorization_required_code() ]
			);
		}

		return true;
	}

	/**
	 * Get REST API save arguments schema.
	 *
	 * @return array
	 */
	private function get_save_args() {
		return [
			'settings' => [
				'required'          => true,
				'type'              => 'object',
				'sanitize_callback' => [ $this, 'sanitize_settings' ],
				'validate_callback' => [ $this, 'validate_settings' ],
			],
		];
	}

	/**
	 * Sanitize settings input.
	 *
	 * @param array $settings Input settings.
	 *
	 * @return array
	 */
	public function sanitize_settings( $settings ) {
		$sanitized = [];

		// General settings.
		if ( isset( $settings['tpg_block_type'] ) ) {
			$allowed_types               = [ 'default', 'elementor', 'divi', 'shortcode' ];
			$sanitized['tpg_block_type'] = in_array( $settings['tpg_block_type'], $allowed_types, true )
				? sanitize_text_field( $settings['tpg_block_type'] )
				: 'default';
		}

		if ( isset( $settings['tpg_load_script'] ) ) {
			$sanitized['tpg_load_script'] = rest_sanitize_boolean( $settings['tpg_load_script'] );
		}

		if ( isset( $settings['tpg_enable_preloader'] ) ) {
			$sanitized['tpg_enable_preloader'] = rest_sanitize_boolean( $settings['tpg_enable_preloader'] );
		}

		if ( isset( $settings['tpg_enable_post_view_count'] ) ) {
			$sanitized['tpg_enable_post_view_count'] = rest_sanitize_boolean( $settings['tpg_enable_post_view_count'] );
		}

		if ( isset( $settings['tpg_icon_font'] ) ) {
			$allowed_fonts              = [ 'fontawesome', 'flaticon' ];
			$sanitized['tpg_icon_font'] = in_array( $settings['tpg_icon_font'], $allowed_fonts, true )
				? sanitize_text_field( $settings['tpg_icon_font'] )
				: 'flaticon';
		}

		if ( isset( $settings['tpg_pagination_range'] ) ) {
			$range                             = absint( $settings['tpg_pagination_range'] );
			$sanitized['tpg_pagination_range'] = max( 1, min( 10, $range ) );
		}

		if ( isset( $settings['tpg_primary_color_main'] ) ) {
			$sanitized['tpg_primary_color_main'] = sanitize_hex_color( $settings['tpg_primary_color_main'] ) ?: '#0d6efd';
		}

		if ( isset( $settings['tpg_secondary_color_main'] ) ) {
			$sanitized['tpg_secondary_color_main'] = sanitize_hex_color( $settings['tpg_secondary_color_main'] ) ?: '#0654c4';
		}

		// AI settings.
		if ( isset( $settings['ai_type'] ) ) {
			$allowed_ai_types     = [ '', 'chatgpt', 'gemini' ];
			$sanitized['ai_type'] = in_array( $settings['ai_type'], $allowed_ai_types, true )
				? sanitize_text_field( $settings['ai_type'] )
				: '';
		}

		if ( isset( $settings['chatgpt_status'] ) ) {
			$sanitized['chatgpt_status'] = rest_sanitize_boolean( $settings['chatgpt_status'] );
		}

		if ( isset( $settings['chatgpt_secret_key'] ) ) {
			$sanitized['chatgpt_secret_key'] = sanitize_text_field( $settings['chatgpt_secret_key'] );
		}

		if ( isset( $settings['chatgpt_model'] ) ) {
			$allowed_models             = [ 'gpt-3.5-turbo', 'text-davinci-002', 'text-davinci-003', 'gpt-4', 'gpt-4o-mini' ];
			$sanitized['chatgpt_model'] = in_array( $settings['chatgpt_model'], $allowed_models, true )
				? sanitize_text_field( $settings['chatgpt_model'] )
				: 'gpt-3.5-turbo';
		}

		if ( isset( $settings['chatgpt_response_time'] ) ) {
			$sanitized['chatgpt_response_time'] = absint( $settings['chatgpt_response_time'] );
		}

		if ( isset( $settings['chatgpt_max_tokens'] ) ) {
			$sanitized['chatgpt_max_tokens'] = absint( $settings['chatgpt_max_tokens'] );
		}

		if ( isset( $settings['gemini_status'] ) ) {
			$sanitized['gemini_status'] = rest_sanitize_boolean( $settings['gemini_status'] );
		}

		if ( isset( $settings['gemini_secret_key'] ) ) {
			$sanitized['gemini_secret_key'] = sanitize_text_field( $settings['gemini_secret_key'] );
		}

		if ( isset( $settings['gemini_model'] ) ) {
			$allowed_gemini_models     = [ 'gemini-2.0-flash', 'gemini-2.0-flash-lite' ];
			$sanitized['gemini_model'] = in_array( $settings['gemini_model'], $allowed_gemini_models, true )
				? sanitize_text_field( $settings['gemini_model'] )
				: 'gemini-2.0-flash';
		}

		if ( isset( $settings['gemini_response_time'] ) ) {
			$sanitized['gemini_response_time'] = absint( $settings['gemini_response_time'] );
		}

		if ( isset( $settings['gemini_max_tokens'] ) ) {
			$sanitized['gemini_max_tokens'] = absint( $settings['gemini_max_tokens'] );
		}

		/**
		 * Filter to allow sanitization of additional settings.
		 *
		 * @param array $sanitized Sanitized settings.
		 * @param array $settings Original settings input.
		 */
		return apply_filters( 'rttpg_setup_wizard_sanitize_settings', $sanitized, $settings );
	}

	/**
	 * Validate settings input.
	 *
	 * @param array $settings Input settings.
	 *
	 * @return bool
	 */
	public function validate_settings( $settings ) {
		if ( ! is_array( $settings ) ) {
			return false;
		}

		/**
		 * Filter to allow additional validation.
		 *
		 * @param bool $valid Whether settings are valid.
		 * @param array $settings Settings to validate.
		 */
		return apply_filters( 'rttpg_setup_wizard_validate_settings', true, $settings );
	}

	/**
	 * Save wizard settings via REST API.
	 *
	 * @param \WP_REST_Request $request Request object.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function save_settings( \WP_REST_Request $request ) {
		$settings = $request->get_param( 'settings' );

		// Get existing settings.
		$existing_settings = get_option( rtTPG()->options['settings'], rtTPG()->defaultSettings );

		// Merge with new settings.
		$updated_settings = array_merge( $existing_settings, $settings );


		// Save settings.
		$saved = update_option( rtTPG()->options['settings'], $updated_settings );

		/**
		 * Action hook after wizard settings are saved.
		 *
		 * @param array $updated_settings The updated settings.
		 * @param array $settings The new settings from the wizard.
		 */
		do_action( 'rttpg_setup_wizard_settings_saved', $updated_settings, $settings );

		if ( $saved ) {
			return new \WP_REST_Response(
				[
					'success' => true,
					'message' => esc_html__( 'Settings saved successfully.', 'the-post-grid' ),
				],
				200
			);
		}

		return new \WP_REST_Response(
			[
				'success' => true,
				'message' => esc_html__( 'No changes were made to settings.', 'the-post-grid' ),
			],
			200
		);
	}

	/**
	 * Skip wizard via REST API.
	 *
	 * @return \WP_REST_Response
	 */
	public function skip_wizard() {
		update_option( self::WIZARD_COMPLETED_OPTION, 'skipped' );

		/**
		 * Action hook when wizard is skipped.
		 */
		do_action( 'rttpg_setup_wizard_skipped' );

		return new \WP_REST_Response(
			[
				'success'     => true,
				'message'     => esc_html__( 'Setup wizard skipped.', 'the-post-grid' ),
				'redirectUrl' => admin_url( 'edit.php?post_type=rttpg&page=rttpg_settings' ),
			],
			200
		);
	}

	/**
	 * Complete wizard via REST API.
	 *
	 * @return \WP_REST_Response
	 */
	public function complete_wizard() {
		update_option( self::WIZARD_COMPLETED_OPTION, 'completed' );

		/**
		 * Action hook when wizard is completed.
		 */
		do_action( 'rttpg_setup_wizard_completed' );

		return new \WP_REST_Response(
			[
				'success'     => true,
				'message'     => esc_html__( 'Setup wizard completed successfully!', 'the-post-grid' ),
				'redirectUrl' => admin_url( 'edit.php?post_type=rttpg' ),
			],
			200
		);
	}

	/**
	 * Install plugin via REST API.
	 *
	 * @param \WP_REST_Request $request Request object.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function install_plugin( \WP_REST_Request $request ) {
		$slug = $request->get_param( 'slug' );

		// Include all required files for plugin installation.
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/misc.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		// Initialize WP_Filesystem.
		WP_Filesystem();

		// Get plugin info from WordPress.org.
		$api = plugins_api(
			'plugin_information',
			[
				'slug'   => $slug,
				'fields' => [
					'short_description' => false,
					'sections'          => false,
					'requires'          => false,
					'rating'            => false,
					'ratings'           => false,
					'downloaded'        => false,
					'last_updated'      => false,
					'added'             => false,
					'tags'              => false,
					'compatibility'     => false,
					'homepage'          => false,
					'donate_link'       => false,
				],
			]
		);

		if ( is_wp_error( $api ) ) {
			return new \WP_Error(
				'plugin_not_found',
				esc_html__( 'Plugin not found on WordPress.org.', 'the-post-grid' ),
				[ 'status' => 404 ]
			);
		}

		// Use silent upgrader skin to suppress output.
		$upgrader = new \Plugin_Upgrader( new \WP_Ajax_Upgrader_Skin() );
		$result   = $upgrader->install( $api->download_link );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		if ( ! $result ) {
			return new \WP_Error(
				'plugin_install_failed',
				esc_html__( 'Plugin installation failed.', 'the-post-grid' ),
				[ 'status' => 500 ]
			);
		}

		return new \WP_REST_Response(
			[
				'success' => true,
				'message' => esc_html__( 'Plugin installed successfully.', 'the-post-grid' ),
			],
			200
		);
	}

	/**
	 * Activate plugin via REST API.
	 *
	 * @param \WP_REST_Request $request Request object.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function activate_plugin( \WP_REST_Request $request ) {
		$slug = $request->get_param( 'slug' );

		// Include required files.
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		$installed_plugins = get_plugins();
		$plugin_file       = $this->get_plugin_file( $slug, $installed_plugins );

		if ( ! $plugin_file ) {
			return new \WP_Error(
				'plugin_not_installed',
				esc_html__( 'Plugin is not installed.', 'the-post-grid' ),
				[ 'status' => 404 ]
			);
		}

		$result = activate_plugin( $plugin_file );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		return new \WP_REST_Response(
			[
				'success' => true,
				'message' => esc_html__( 'Plugin activated successfully.', 'the-post-grid' ),
			],
			200
		);
	}

	/**
	 * Check if wizard is completed.
	 *
	 * @return bool
	 */
	public static function is_completed() {
		return (bool) get_option( self::WIZARD_COMPLETED_OPTION );
	}

	/**
	 * Reset wizard completion status (useful for testing).
	 *
	 * @return void
	 */
	public static function reset() {
		delete_option( self::WIZARD_COMPLETED_OPTION );
		delete_option( self::REDIRECT_OPTION );
	}
}
