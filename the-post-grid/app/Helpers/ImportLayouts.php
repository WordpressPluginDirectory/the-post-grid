<?php
/**
 * Import Layouts Helper class.
 *
 * Fetches the starter layouts / premade sections payload from the remote
 * library once, then keeps it on the site itself so the import modal never
 * has to touch radiustheme.com again until the user asks it to.
 *
 * Storage is file-first:
 *
 *  1. uploads/the-post-grid/layouts-{key}.json — the browser reads this
 *     directly by URL, so opening the modal costs no PHP at all.
 *  2. A gzipped option — only used when the uploads directory is not
 *     writable (read-only containers, hardened hosts).
 *
 * A small companion option records the stamp/timestamp so freshness can be
 * checked without loading the ~1MB payload.
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Import Layouts Helper class.
 */
class ImportLayouts {

	/**
	 * Bump when the stored shape changes so old copies are re-synced.
	 */
	const SCHEMA_VERSION = 1;

	/**
	 * Directory created inside wp-content/uploads.
	 */
	const STORE_DIRNAME = 'the-post-grid';

	/**
	 * Minimum seconds between two forced syncs of the same payload.
	 *
	 * Without this a held-down Sync button, multiplied across every install,
	 * turns into a self-inflicted flood on the layout server.
	 */
	const SYNC_LOCK_TTL = 30;

	/**
	 * Remote request timeout in seconds.
	 */
	const REMOTE_TIMEOUT = 25;

	/**
	 * Name of the option holding the lightweight meta record.
	 *
	 * @param string $key Cache key suffix, eg. 'gutenberg' or 'elementor'.
	 *
	 * @return string
	 */
	public static function meta_option( $key ) {
		return 'rttpg_layout_meta_' . $key;
	}

	/**
	 * Name of the option used when the filesystem is unavailable.
	 *
	 * @param string $key Cache key suffix.
	 *
	 * @return string
	 */
	public static function blob_option( $key ) {
		return 'rttpg_layout_store_' . $key;
	}

	/**
	 * Resolve the storage directory, creating it when needed.
	 *
	 * @return array|null [ 'dir' => path, 'url' => url ] or null when unusable.
	 */
	public static function store_dir() {
		$uploads = wp_upload_dir();

		if ( ! empty( $uploads['error'] ) || empty( $uploads['basedir'] ) ) {
			return null;
		}

		$dir = trailingslashit( $uploads['basedir'] ) . self::STORE_DIRNAME;

		if ( ! is_dir( $dir ) && ! wp_mkdir_p( $dir ) ) {
			return null;
		}

		if ( ! is_writable( $dir ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_is_writable -- WP_Filesystem has no writability probe, and loading it here would be heavier than the check.
			return null;
		}

		// Silence directory listing on servers that have it switched on.
		$guard = trailingslashit( $dir ) . 'index.php';

		if ( ! file_exists( $guard ) ) {
			@file_put_contents( $guard, "<?php\n// Silence is golden." ); // phpcs:ignore WordPress.WP.AlternativeFunctions, WordPress.PHP.NoSilencedErrors
		}

		return [
			'dir' => $dir,
			'url' => trailingslashit( $uploads['baseurl'] ) . self::STORE_DIRNAME,
		];
	}

	/**
	 * Absolute path of the stored payload.
	 *
	 * @param string $key Cache key suffix.
	 *
	 * @return string|null
	 */
	public static function file_path( $key ) {
		$store = self::store_dir();

		if ( ! $store ) {
			return null;
		}

		return trailingslashit( $store['dir'] ) . 'layouts-' . sanitize_key( $key ) . '.json';
	}

	/**
	 * Public URL of the stored payload, cache-busted by the content stamp.
	 *
	 * @param string $key   Cache key suffix.
	 * @param string $stamp Content stamp.
	 *
	 * @return string
	 */
	public static function file_url( $key, $stamp = '' ) {
		$uploads = wp_upload_dir();

		if ( ! empty( $uploads['error'] ) || empty( $uploads['baseurl'] ) ) {
			return '';
		}

		$url = trailingslashit( $uploads['baseurl'] ) . self::STORE_DIRNAME . '/layouts-' . sanitize_key( $key ) . '.json';

		return $stamp ? add_query_arg( 'v', $stamp, $url ) : $url;
	}

	/**
	 * Read the meta record for a stored payload.
	 *
	 * @param string $key Cache key suffix.
	 *
	 * @return array|null
	 */
	public static function get_meta( $key ) {
		$meta = get_option( self::meta_option( $key ) );

		if ( ! is_array( $meta ) || empty( $meta['stamp'] ) ) {
			return null;
		}

		// A record written by an older build is not trustworthy — re-sync.
		if ( (int) ( $meta['schema'] ?? 0 ) !== self::SCHEMA_VERSION ) {
			return null;
		}

		return $meta;
	}

	/**
	 * Load the stored payload.
	 *
	 * @param string $key Cache key suffix.
	 *
	 * @return array|null Decoded payload, or null when nothing usable is stored.
	 */
	public static function read( $key ) {
		$meta = self::get_meta( $key );

		if ( ! $meta ) {
			return null;
		}

		$payload = null;

		if ( 'file' === ( $meta['mode'] ?? '' ) ) {
			$path = self::file_path( $key );

			if ( $path && is_readable( $path ) ) {
				$raw = file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions

				if ( false !== $raw ) {
					$payload = json_decode( $raw, true );
				}
			}
		} else {
			$stored = get_option( self::blob_option( $key ) );

			if ( is_string( $stored ) && '' !== $stored ) {
				$payload = self::decode_blob( $stored, ! empty( $meta['gz'] ) );
			}
		}

		return self::is_valid( $payload ) ? $payload : null;
	}

	/**
	 * Persist a payload, preferring the filesystem.
	 *
	 * @param string $key     Cache key suffix.
	 * @param array  $payload Decoded payload.
	 *
	 * @return array|null Meta record on success, null when nothing could be stored.
	 */
	public static function write( $key, $payload ) {
		$json = wp_json_encode( $payload );

		if ( ! $json ) {
			return null;
		}

		$meta = [
			'schema' => self::SCHEMA_VERSION,
			'stamp'  => md5( $json ),
			'synced' => time(),
			'plugin' => RT_THE_POST_GRID_VERSION,
			'mode'   => '',
			'gz'     => false,
			'bytes'  => strlen( $json ),
		];

		if ( self::write_file( $key, $json ) ) {
			$meta['mode'] = 'file';

			// The filesystem copy is now authoritative; drop any DB leftover.
			delete_option( self::blob_option( $key ) );
		} else {
			$gzipped = false;
			$blob    = self::encode_blob( $json, $gzipped );

			if ( ! $blob ) {
				return null;
			}

			$meta['mode'] = 'db';
			$meta['gz']   = $gzipped;

			update_option( self::blob_option( $key ), $blob, false );
		}

		update_option( self::meta_option( $key ), $meta, false );

		return $meta;
	}

	/**
	 * Write the payload to disk atomically.
	 *
	 * The temp-file-then-rename dance means a concurrent reader can never see
	 * a half-written file.
	 *
	 * @param string $key  Cache key suffix.
	 * @param string $json Encoded payload.
	 *
	 * @return bool
	 */
	protected static function write_file( $key, $json ) {
		$path = self::file_path( $key );

		if ( ! $path ) {
			return false;
		}

		$tmp = $path . '.' . wp_generate_password( 8, false ) . '.tmp';

		// phpcs:disable WordPress.WP.AlternativeFunctions, WordPress.PHP.NoSilencedErrors
		if ( false === @file_put_contents( $tmp, $json, LOCK_EX ) ) {
			return false;
		}

		if ( ! @rename( $tmp, $path ) ) {
			@unlink( $tmp );

			return false;
		}
		// phpcs:enable

		return true;
	}

	/**
	 * Compress a payload for DB storage when zlib is available.
	 *
	 * @param string $json    Encoded payload.
	 * @param bool   $gzipped Set by reference to record which format was used.
	 *
	 * @return string|false
	 */
	protected static function encode_blob( $json, &$gzipped = false ) {
		$gzipped = false;

		if ( function_exists( 'gzcompress' ) ) {
			$packed = gzcompress( $json, 6 );

			if ( false !== $packed ) {
				$gzipped = true;

				return base64_encode( $packed ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions
			}
		}

		return $json;
	}

	/**
	 * Reverse encode_blob().
	 *
	 * @param string $stored  Stored string.
	 * @param bool   $gzipped Whether it was compressed.
	 *
	 * @return array|null
	 */
	protected static function decode_blob( $stored, $gzipped ) {
		if ( $gzipped ) {
			if ( ! function_exists( 'gzuncompress' ) ) {
				return null;
			}

			$packed = base64_decode( $stored, true ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions

			if ( false === $packed ) {
				return null;
			}

			$stored = @gzuncompress( $packed ); // phpcs:ignore WordPress.PHP.NoSilencedErrors

			if ( false === $stored ) {
				return null;
			}
		}

		return json_decode( $stored, true );
	}

	/**
	 * Whether the stored copy should be refreshed from the remote.
	 *
	 * True when nothing is stored yet, when the stored copy is unreadable, or
	 * when the plugin has been updated since it was written — the latter is
	 * how a release ships new layouts without anyone clicking Sync.
	 *
	 * @param string $key Cache key suffix.
	 *
	 * @return bool
	 */
	public static function needs_sync( $key ) {
		$meta = self::get_meta( $key );

		if ( ! $meta ) {
			return true;
		}

		if ( ( $meta['plugin'] ?? '' ) !== RT_THE_POST_GRID_VERSION ) {
			return true;
		}

		return null === self::read( $key );
	}

	/**
	 * Pull a fresh copy from the remote library and store it.
	 *
	 * @param string $url Remote endpoint.
	 * @param string $key Cache key suffix.
	 *
	 * @return array [ 'data' => array, 'meta' => array ] or [ 'error' => string ].
	 */
	public static function sync( $url, $key ) {
		$response = wp_remote_get(
			$url,
			[
				'timeout'    => self::REMOTE_TIMEOUT,
				'body'       => [ 'status' => 1 ],
				'headers'    => [ 'Accept' => 'application/json' ],
				'user-agent' => 'ThePostGrid/' . RT_THE_POST_GRID_VERSION . '; ' . home_url(),
			]
		);

		if ( is_wp_error( $response ) ) {
			return [ 'error' => $response->get_error_message() ];
		}

		$response_code = (int) wp_remote_retrieve_response_code( $response );

		if ( 200 !== $response_code ) {
			return [
				'error' => sprintf(
					/* translators: %d: HTTP status code returned by the layout server. */
					esc_html__( 'The layout server returned HTTP %d.', 'the-post-grid' ),
					$response_code
				),
			];
		}

		$payload = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( ! self::is_valid( $payload ) ) {
			return [ 'error' => esc_html__( 'The layout server sent a response we could not read.', 'the-post-grid' ) ];
		}

		$meta = self::write( $key, $payload );

		if ( ! $meta ) {
			// Nothing could be persisted, but the payload itself is good — serve
			// it for this request rather than showing an empty modal.
			return [
				'data' => $payload,
				'meta' => [
					'stamp'  => '',
					'synced' => time(),
					'mode'   => 'none',
				],
			];
		}

		return [
			'data' => $payload,
			'meta' => $meta,
		];
	}

	/**
	 * Fetch the layout payload, preferring the copy stored on this site.
	 *
	 * @param string $url   Remote endpoint.
	 * @param string $key   Cache key suffix, eg. 'gutenberg' or 'elementor'.
	 * @param bool   $force Skip the stored copy and re-query the remote.
	 *
	 * @return array Either [ 'data' => array, 'meta' => array, 'source' => string ]
	 *               or [ 'error' => string ].
	 */
	public static function get( $url, $key, $force = false ) {
		$meta   = self::get_meta( $key );
		$stored = $meta ? self::read( $key ) : null;

		// Inlined rather than calling needs_sync(), which would re-read — and
		// so re-decode — the whole payload a second time.
		$current = $stored && ( $meta['plugin'] ?? '' ) === RT_THE_POST_GRID_VERSION;

		if ( ! $force && $current ) {
			return [
				'data'   => $stored,
				'meta'   => $meta,
				'source' => 'local',
			];
		}

		$lock = 'rttpg_layout_sync_' . sanitize_key( $key );

		// Throttle repeat syncs, but never at the cost of an empty modal: the
		// lock only applies when we already have something to show.
		if ( $stored && get_transient( $lock ) ) {
			return [
				'data'      => $stored,
				'meta'      => self::get_meta( $key ),
				'source'    => 'local',
				'throttled' => true,
			];
		}

		set_transient( $lock, 1, self::SYNC_LOCK_TTL );

		$result = self::sync( $url, $key );

		if ( empty( $result['error'] ) ) {
			$result['source'] = 'remote';

			return $result;
		}

		// Remote is unreachable or broken — fall back to what we already have.
		if ( $stored ) {
			return [
				'data'    => $stored,
				'meta'    => self::get_meta( $key ),
				'source'  => 'local',
				'warning' => $result['error'],
			];
		}

		return [ 'error' => $result['error'] ];
	}

	/**
	 * The handful of values the import modal needs at editor load.
	 *
	 * Reads only the small meta option — never the payload itself.
	 *
	 * @param string $key Cache key suffix.
	 *
	 * @return array
	 */
	public static function client_meta( $key ) {
		$meta = self::get_meta( $key );

		if ( ! $meta ) {
			return [
				'stamp'  => '',
				'synced' => 0,
				'url'    => '',
				'mode'   => 'none',
				'stale'  => true,
			];
		}

		$stale = ( $meta['plugin'] ?? '' ) !== RT_THE_POST_GRID_VERSION;
		$url   = '';

		if ( 'file' === $meta['mode'] ) {
			$path = self::file_path( $key );

			// Confirm the file is really there before pointing a browser at
			// it. This is a stat(), not a read of the ~1MB payload, so it
			// stays cheap — and without it a copy removed by a migration,
			// backup restore or cleanup plugin would cost every editor a
			// wasted 404 on every modal open until the next sync.
			if ( $path && file_exists( $path ) ) {
				$url = self::file_url( $key, $meta['stamp'] );
			} else {
				$stale = true;
			}
		}

		return [
			'stamp'  => $meta['stamp'],
			'synced' => (int) $meta['synced'],
			'url'    => $url,
			'mode'   => $meta['mode'],
			'stale'  => $stale,
		];
	}

	/**
	 * Remove every trace of a stored payload.
	 *
	 * @param string $key Cache key suffix.
	 *
	 * @return void
	 */
	public static function forget( $key ) {
		$path = self::file_path( $key );

		if ( $path && file_exists( $path ) ) {
			@unlink( $path ); // phpcs:ignore WordPress.PHP.NoSilencedErrors, WordPress.WP.AlternativeFunctions
		}

		delete_option( self::meta_option( $key ) );
		delete_option( self::blob_option( $key ) );
		delete_transient( 'rttpg_layout_sync_' . sanitize_key( $key ) );
	}

	/**
	 * A payload is only usable if it actually carries layouts or sections.
	 *
	 * @param mixed $payload Decoded payload.
	 *
	 * @return bool
	 */
	public static function is_valid( $payload ) {
		if ( ! is_array( $payload ) ) {
			return false;
		}

		return ! empty( $payload['layouts']['posts'] ) || ! empty( $payload['sections']['posts'] );
	}

	/**
	 * Shared permission gate for the layout AJAX endpoints.
	 *
	 * Returns an error string when the request should be rejected, otherwise ''.
	 *
	 * @return string
	 */
	public static function permission_error() {
		if ( ! check_ajax_referer( 'rttpg_nonce', 'nonce', false ) ) {
			return esc_html__( 'Your session has expired. Please reload the editor and try again.', 'the-post-grid' );
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			return esc_html__( 'You don\'t have permission to perform this action.', 'the-post-grid' );
		}

		return '';
	}
}
