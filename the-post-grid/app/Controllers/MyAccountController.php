<?php
/**
 * MyAccountController Controller class.
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Controllers;

// Do not allow directly accessing this file.
use RT\ThePostGrid\Helpers\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * MyAccountController class
 */
class MyAccountController {

	public static $endpoint = 'my-account';

	private static $current_user = '';

	/**
	 * PageTemplateController constructor
	 */
	public function __construct() {
		add_shortcode( 'tpg_my_account', [ $this, 'shortcode' ] );
		add_action( 'init', [ __CLASS__, 'add_endpoint' ] );
		add_action( 'tpg_account_navigation', [ __CLASS__, 'navigation' ] );
		add_action( 'tpg_account_content', [ __CLASS__, 'account_content' ] );
		add_action( 'admin_post_tpg_post_save', [ $this, 'tpg_save_if_submitted' ] );
		add_action( 'admin_post_tpg_post_update', [ $this, 'tpg_save_if_submitted' ] );
		add_action( 'wp_ajax_tpg_tag_search', [ $this, 'tpg_tag_search' ] );
		add_action( 'wp_ajax_nopriv_tpg_tag_search', [ $this, 'tpg_tag_search' ] );
		add_action( 'wp_ajax_tpg_delete_post', [ $this, 'delete_post' ] );
		add_action( 'wp_ajax_nopriv_tpg_delete_post', [ $this, 'delete_post' ] );
	}

	public function shortcode( $atts ) {
		if ( is_admin() ) {
			return '';
		}

		$settings        = get_option( rtTPG()->options['settings'] );
		$max_upload_size = ! empty( $settings['max_upload_file'] ) ? $settings['max_upload_file'] : '1048576';
		wp_enqueue_style( 'rt-select2' );
		wp_enqueue_script( 'rt-tpg-myaccount' );

		wp_localize_script(
			'rt-tpg-myaccount',
			'rtTpg',
			[
				'ajaxurl'           => admin_url( 'admin-ajax.php' ),
				'confirm_text'      => __( 'Are you sure?', 'the-post-grid' ),
				'uid'               => get_current_user_id(),
				'nonceID'           => esc_attr( rtTPG()->nonceId() ),
				'nonce'             => esc_attr( wp_create_nonce( rtTPG()->nonceText() ) ),
				'max_upload_size'   => $max_upload_size,
				'file_exceeds_text' => sprintf( esc_html__( 'File size exceeds %s bytes limit. Please choose a smaller file.', 'the-post-grid' ), $max_upload_size ),
			]
		);
		wp_enqueue_media();
		self::$current_user = get_user_by( 'id', get_current_user_id() );

		$output = "<div class='tpgMyAccount'>";
		if ( ! is_user_logged_in() ) {
			$output .= wp_login_form( [ 'echo' => false ] );
		} else {
			$data = [
				'layout'  => 'dashboard',
				'post_id' => get_the_ID(),
				'user_id' => get_current_user_id(),
			];

			ob_start();
			Fns::tpg_template( $data, 'my-account' );
			$output .= ob_get_clean();
		}
		$output .= '</div>';

		return $output;
	}

	/**
	 * End point
	 *
	 * @return void
	 */
	public static function add_endpoint() {
		$end_points = Fns::get_endpoint();
		foreach ( $end_points as $end_point ) {
			add_rewrite_endpoint( $end_point, EP_PAGES );
		}
		flush_rewrite_rules();
	}

	public static function navigation() {
		$data = [
			'layout'       => 'navigation',
			'current_user' => get_user_by( 'id', get_current_user_id() ),
		];
		Fns::tpg_template( $data, 'my-account' );
	}

	public static function account_content() {

		global $wp_query;
		$allVars = $wp_query->query_vars;

		$data = [
			'layout'       => 'user-info',
			'current_user' => get_user_by( 'id', get_current_user_id() ),
		];

		foreach ( Fns::get_endpoint() as $endpoint ) {

			if ( isset( $allVars[ $endpoint ] ) ) {
				$data = [
					'layout'       => $endpoint,
					'current_user' => get_user_by( 'id', get_current_user_id() ),
				];
			}
		}

		// No endpoint found? Default to dashboard.
		Fns::tpg_template( $data, 'my-account' );
	}

	/***
	 * Check form submitted or not
	 * Validate form data
	 ***/
	public function tpg_save_if_submitted() {
		$settings = get_option( rtTPG()->options['settings'] );
		$url      = $_SERVER['HTTP_REFERER'];

		// Verify nonce
		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'tpg-frontend-post' ) ) {
			wp_safe_redirect(
				esc_url_raw(
					add_query_arg( 'status', 'error', $url )
				)
			);
			exit;
		}

		// Stop running function if form wasn't submitted.

		if ( ! isset( $_POST['submit'] ) ) {
			return;
		}

		$category = [];

		if ( isset( $_POST['post_category'] ) ) {
			$category = array_filter( array_map( 'absint', $_POST['post_category'] ) );
		}

		$user_id = get_current_user_id();

		if ( $user_id != $_POST['uid'] ) {
			wp_safe_redirect(
				esc_url_raw(
					add_query_arg( 'status', 'error', $url )
				)
			);
			exit;
		}

		$post_args = [
			'post_title'    => ! empty( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '',
			'post_content'  => ! empty( $_POST['content'] ) ? wp_kses_post( wp_unslash( $_POST['content'] ) ) : '',
			'post_excerpt'  => ! empty( $_POST['excerpt'] ) ? sanitize_text_field( wp_unslash( $_POST['excerpt'] ) ) : '',
			'post_author'   => $user_id,
			'post_category' => $category,
			'post_type'     => 'post',
		];

		if ( ! empty( $_POST['rtpg_post_tag'] ) ) {
			$post_args['tags_input'] = sanitize_text_field( wp_unslash( $_POST['rtpg_post_tag'] ) );
		}

		if ( isset( $_POST['action'] ) && 'tpg_post_update' === $_POST['action'] ) {
			$post_args['ID']          = ! empty( $_REQUEST['post_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['post_id'] ) ) : '';
			$post_args['post_status'] = ! empty( $_POST['post_status'] ) ? sanitize_text_field( wp_unslash( $_POST['post_status'] ) ) : 'pending';
			$insert_id                = wp_update_post( $post_args );
		} else {
			$post_args['post_status'] = ! empty( $settings['post_status'] ) ? $settings['post_status'] : 'pending';
			$insert_id                = wp_insert_post( $post_args );
		}

		if ( $insert_id ) {
			if ( current_user_can( 'upload_files' ) ) {
				if ( ! empty( $_POST['tpg_feature_image'] ) ) {
					set_post_thumbnail( $insert_id, intval( $_POST['tpg_feature_image'] ) );
				}
			} else {
				if ( ! empty( $_FILES['tpg-feature-image2']['name'] ) ) {

					/*Insert Featured Image*/
					$theFile             = $_FILES['tpg-feature-image2'];
					$file_path           = sanitize_file_name( $theFile['name'] );
					$file_type           = sanitize_mime_type( $theFile['type'] );
					$sanitized_file_data = array(
						'name'      => $file_path,
						'full_path' => $file_path,
						'type'      => $file_type,
						'tmp_name'  => sanitize_text_field( $theFile['tmp_name'] ),
						'error'     => sanitize_text_field( $theFile['error'] ),
						'size'      => absint( $theFile['size'] ),
					);

					$fileName = $sanitized_file_data['name'];
					$tempFile = $sanitized_file_data['tmp_name'];

					require_once ABSPATH . 'wp-admin/includes/image.php';
					require_once ABSPATH . 'wp-admin/includes/file.php';
					require_once ABSPATH . 'wp-admin/includes/media.php';

					$upload = wp_handle_upload( $sanitized_file_data, [ 'test_form' => false ] );

					$wp_filetype = wp_check_filetype( basename( $upload['file'] ), null );
					$attachment  = [
						'post_mime_type' => $wp_filetype['type'],
						'post_title'     => sanitize_file_name( $fileName ),
						'post_content'   => '',
						'post_status'    => 'inherit',
					];
					$attach_id   = wp_insert_attachment( $attachment, $upload['file'], $insert_id );
					$attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
					wp_update_attachment_metadata( $attach_id, $attach_data );
					set_post_thumbnail( $insert_id, $attach_id );
				}
			}
			wp_safe_redirect(
				esc_url_raw(
					add_query_arg( 'status', 'success', Fns::get_account_endpoint_url( 'my-post' ) )
				)
			);

		} else {
			wp_safe_redirect(
				esc_url_raw(
					add_query_arg( 'status', 'fail', $url )
				)
			);
		}
		exit;
	}


	public static function tpg_tag_search() {
		$taxonomy        = 'post_tag';
		$taxonomy_object = get_taxonomy( $taxonomy );

		if ( ! $taxonomy_object ) {
			wp_die( 0 );
		}

		if ( ! current_user_can( $taxonomy_object->cap->assign_terms ) ) {
			wp_die( 0 );
		}

		if ( isset( $_GET['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'tpg-frontend-post' ) ) {
			wp_die( - 1 );
		}

		$search = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';

		$comma = _x( ',', 'tag delimiter' );
		if ( ',' !== $comma ) {
			$search = str_replace( $comma, ',', $search );
		}

		if ( str_contains( $search, ',' ) ) {
			$search = explode( ',', $search );
			$search = $search[ count( $search ) - 1 ];
		}

		$search = trim( $search );

		$term_search_min_chars = (int) apply_filters( 'tpg_term_search_min_chars', 2, $taxonomy_object, $search );

		if ( ( 0 == $term_search_min_chars ) || ( strlen( $search ) < $term_search_min_chars ) ) {
			wp_die();
		}

		$results = get_terms(
			[
				'taxonomy'   => $taxonomy,
				'name__like' => $search,
				'fields'     => 'names',
				'hide_empty' => false,
				'number'     => isset( $_GET['number'] ) ? (int) $_GET['number'] : 0,
			]
		);

		$results = apply_filters( 'tpg_ajax_term_search_results', $results, $taxonomy_object, $search );

		$success = false;

		$existingVal  = isset( $_GET['existingVal'] ) ? sanitize_text_field( wp_unslash( $_GET['existingVal'] ) ) : '';
		$existingArr  = explode( ',', $existingVal );
		$existingTrim = array_map( 'trim', $existingArr );
		$html         = '';
		if ( ! empty( $results ) ) {
			$success = true;
			$html   .= '<ul>';
			foreach ( $results as $name ) {
				if ( in_array( $name, $existingTrim ) ) {
					$html .= "<li class='disabled'>$name</li>";
				} else {
					$html .= "<li>$name</li>";
				}
			}
			$html .= '</ul>';
		}

		$response = [
			'success' => $success,
			'list'    => $html,
		];

		wp_send_json( $response );
	}

	public static function delete_post() {
		$settings = get_option( rtTPG()->options['settings'] );

		$delete_status = $settings['delete_post_status'] ?? 'trash';
		$success       = false;
		$message       = $msg_class = $redirect_url = $post_id = null;

		if ( Fns::verifyNonce() ) {
			$post_id   = absint( $_REQUEST['post_id'] );
			$post_info = get_post( $post_id );

			if ( $post_info && get_current_user_id() == $post_info->post_author && current_user_can( 'edit_post', $post_id ) ) {
				$children = get_children(
					apply_filters(
						'tpg_before_delete_post_attachment_query_args',
						[
							'post_parent'    => $post_id,
							'post_type'      => 'attachment',
							'posts_per_page' => - 1,
							'post_status'    => 'inherit',
						],
						$post_id
					)
				);
				if ( 'delete' == $delete_status ) {
					if ( ! empty( $children ) ) {
						foreach ( $children as $child ) {
							wp_delete_attachment( $child->ID, true );
						}
					}
				}

				do_action( 'tpe_before_delete_post', $post_id );
				if ( 'delete' == $delete_status ) {
					wp_delete_post( $post_id, true );
				} else {
					wp_trash_post( $post_id );
				}
				$success      = true;
				$message     .= esc_html__( 'Successfully deleted.', 'the-post-grid' );
				$redirect_url = Fns::get_account_endpoint_url( 'my-post' );
			} else {
				$message .= esc_html__( 'Permission Error.', 'the-post-grid' );
			}
		} else {
			$message .= esc_html__( 'Session expired.', 'the-post-grid' );
		}

		wp_send_json(
			apply_filters(
				'tpg_delete_post_ajax_response',
				[
					'success'      => $success,
					'post_id'      => $post_id,
					'message'      => $message,
					'redirect_url' => $redirect_url,
				]
			)
		);
	}
}
