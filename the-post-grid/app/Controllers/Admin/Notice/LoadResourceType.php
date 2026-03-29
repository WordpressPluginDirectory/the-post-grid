<?php
/**
 * Notice Controller class.
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Controllers\Admin\Notice;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Notice Controller class.
 */
class LoadResourceType {

	/**
	 * Class Constructor
	 */
	public function __construct() {
		add_action( 'admin_notices', [ __CLASS__, 'rttpg_notice' ], 999 );
	}

	/**
	 * Notice
	 *
	 * @return void
	 */
	public static function rttpg_notice() {
		$settings = get_option( 'rt_the_post_grid_settings' );
		$screen   = get_current_screen();

		if ( isset( $settings['tpg_block_type'] ) ) {
			if (
				in_array( $screen->id, [ 'edit-rttpg', 'rttpg', ], true ) &&
				in_array( $settings['tpg_block_type'], [ 'elementor', 'divi' ] )
			) { ?>
                <div class="notice notice-for-warning">
                    <p>
						<?php
						$block_type      = $settings['tpg_block_type'] == 'elementor' ? esc_html__( "Elementor and Gutenberg", "the-post-grid" ) : $settings['tpg_block_type'];
						$selected_method = ucfirst( $block_type );

						echo sprintf(
							'%1$s<a href="%2$s">%3$s</a>',
							sprintf(
							/* translators: %s: Selected method (e.g., Elementor method) */
								esc_html__( 'You have selected "%s" as the resource load type. To use the Shortcode Generator, please enable either "Shortcode" or "Default" from here ', 'the-post-grid' ),
								$selected_method
							),
							esc_url( admin_url( 'edit.php?post_type=rttpg&page=rttpg_settings' ) ),
							esc_html__( 'Settings => Common Settings => Resource Load Type', 'the-post-grid' )
						);
						?>
                    </p>
                </div>
				<?php
			}

			if ( 'edit-tpg_builder' === $screen->id && 'shortcode' === $settings['tpg_block_type'] ) {
				?>
                <div class="notice notice-for-warning">
                    <p>
						<?php
						echo sprintf(
							'%1$s<a href="%2$s">%3$s</a>',
							esc_html__( 'You have selected only Shortcode Generator method. To use Elementor please enable Elementor or default from ', 'the-post-grid' ),
							esc_url( admin_url( 'edit.php?post_type=rttpg&page=rttpg_settings&section=common-settings' ) ),
							esc_html__( 'Settings => Common Settings => Resource Load Type', 'the-post-grid' )
						);
						?>
                    </p>
                </div>
				<?php
			}
		}
	}

}