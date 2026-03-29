<?php

namespace RT\ThePostGrid\Migrations;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SettingsMigration {
	/**
	 * Init hook
	 */
	public static function init() {
		if ( get_option( 'rttpg_post_view_migration' ) ) {
			return;
		}
		add_action( 'admin_init', [ __CLASS__, 'upgrade_to_7_8_10' ], 0 );
	}


	/**
	 * Upgrade routine for version 7.8.9
	 */
	public static function upgrade_to_7_8_10() {
		$option_key = rtTPG()->options['settings'];

		$settings = get_option( $option_key, [] );

		// Add new setting only if not exists
		if ( ! isset( $settings['tpg_enable_post_view_count'] ) ) {
			$settings['tpg_enable_post_view_count'] = 1;
		}

		update_option( $option_key, $settings );
		update_option( 'rttpg_post_view_migration', '1' );
	}
}