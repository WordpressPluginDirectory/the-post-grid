<?php

namespace RT\ThePostGrid\Migrations;


// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

class Tpg_Migration {

	/**
	 * Option to mark cleanup as done
	 */
	const CLEANUP_DONE_OPTION = 'tpg_cache_cleanup_done';

	/**
	 * One-time scheduled event hook
	 */
	const CRON_HOOK = 'tpg_cache_cleanup_event';

	/**
	 * Batch size for deletion
	 */
	const BATCH_SIZE = 500;

	/**
	 * Initialize migration: schedule cleanup if not done
	 */
	public static function init() {
		if ( get_option( self::CLEANUP_DONE_OPTION, 'no' ) === 'no' ) {
			if ( ! wp_next_scheduled( self::CRON_HOOK ) ) {
				wp_schedule_single_event( time() + 10, self::CRON_HOOK ); // 10s after activation
			}
		}
		add_action( self::CRON_HOOK, [ __CLASS__, 'run_cleanup_batch' ] );
	}

	/**
	 * Run a single cleanup batch
	 */
	public static function run_cleanup_batch() {
		global $wpdb;

		try {
			// 1. Get a batch of tpg_cache transients
			$tpg_transients = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s LIMIT %d",
					'_transient_tpg_cache_%',
					self::BATCH_SIZE
				)
			);

			if ( ! empty( $tpg_transients ) ) {
				foreach ( $tpg_transients as $transient ) {
					// Remove the '_transient_' prefix to get the base name
					$key = str_replace( '_transient_', '', $transient );

					// Delete transient (automatically removes timeout too)
					delete_transient( $key );
				}
			}

			// Reschedule next batch if necessary
			if ( count( $tpg_transients ) === self::BATCH_SIZE ) {
				wp_schedule_single_event( time() + 5, self::CRON_HOOK ); // next batch in 5 seconds
			} else {
				// Cleanup complete: mark done
				update_option( self::CLEANUP_DONE_OPTION, 'yes' );
			}

		} catch ( \Exception $e ) {
			error_log( 'TPG Cache Migration Error: ' . $e->getMessage() );
		}
	}
}