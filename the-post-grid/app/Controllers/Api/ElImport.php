<?php

namespace RT\ThePostGrid\Controllers\Api;

use RT\ThePostGrid\Helpers\Fns;

class ElImport {
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_elementor_import_route' ] );
	}

	public function register_elementor_import_route() {
		register_rest_route(
			'rttpg/v1',
			'elimport',
			[
				'methods'             => 'POST',
				'callback'            => [ $this, 'el_import' ],
				'permission_callback' => function ( $request ) {
					$post_id = absint( $request->get_param( 'post_id' ) );

					return $post_id && current_user_can( 'edit_post', $post_id );
				},
			]
		);
	}

	public function el_import( $data ) {
		$post_id = absint( $data['post_id'] ?? 0 );

		if ( ! $post_id || ! isset( $data['content'] ) ) {
			return new \WP_Error( 'rttpg_invalid_request', esc_html__( 'Invalid request', 'the-post-grid' ), [ 'status' => 400 ] );
		}

		if ( ! Fns::verifyNonce() ) {
			return new \WP_Error( 'rttpg_invalid_nonce', esc_html__( 'Invalid nonce', 'the-post-grid' ), [ 'status' => 403 ] );
		}

		$content = json_decode( wp_unslash( $data['content'] ) );

		update_post_meta( $post_id, '_elementor_data', $content );

		return rest_ensure_response(
			[
				'success' => true,
			]
		);
	}
}
