<?php

namespace RT\ThePostGrid\Controllers\Api;

class AIIntegration {
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_post_route' ] );
	}

	public function register_post_route() {
		register_rest_route(
			'rttpg/v1',
			'ai',
			[
				'methods'             => 'POST',
				'callback'            => [ $this, 'chatgpt_callback' ],
				'permission_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			]
		);
	}

	/**
	 * Handles AI response based on the selected AI type (chatgpt or gemini).
	 *
	 * @param array $data Request data containing AI type and content parameters.
	 *
	 * @return \WP_REST_Response|\WP_Error
	 */
	public function chatgpt_callback( $data ) {
		$aiType = ! empty( $data['aiType'] ) ? sanitize_text_field( $data['aiType'] ) : '';

		if ( empty( $aiType ) ) {
			return new \WP_Error( 'rttpg_error', esc_html__( 'AI Type is empty', 'the-post-grid' ), [ 'status' => 400 ] );
		}

		if ( 'chatgpt' === $aiType ) {
			return $this->ai_response( $data, 'chatgpt' );
		}

		if ( 'gemini' === $aiType ) {
			return $this->ai_response( $data, 'gemini' );
		}
	}

	/**
	 * Prepares and sends AI request (ChatGPT or Gemini) based on type.
	 *
	 * @param array  $data    User input and content data.
	 * @param string $aiType  'chatgpt' or 'gemini'.
	 *
	 * @return \WP_REST_Response
	 */
	public function ai_response( $data, $aiType ) {
		$settings = get_option( rtTPG()->options['settings'] );

		$isChatGPT = ( 'chatgpt' === $aiType );

		$api_key       = $settings[ $aiType . '_secret_key' ] ?? '';
		$model         = $settings[ $aiType . '_model' ] ?? ( $isChatGPT ? 'gpt-3.5-turbo' : 'gemini-pro' );
		$response_time = intval( $settings[ $aiType . '_response_time' ] ?? 50 );
		$content_limit = intval( $settings[ $aiType . '_max_tokens' ] ?? 1200 );

		$writingStyle  = sanitize_text_field( $data['writingStyle'] ?? '' );
		$language      = sanitize_text_field( $data['language'] ?? '' );
		$headingNumber = sanitize_text_field( $data['headingNumber'] ?? '' );
		$headingTag    = sanitize_text_field( $data['headingTag'] ?? '' );
		$request_txt   = sanitize_text_field( $data['request_txt'] ?? '' );

		$send_data = [
			'status'  => 'ok',
			'content' => '',
		];

		if ( ! $api_key ) {
			$send_data['status']  = 'error';
			$send_data['content'] = sprintf(
				'<h3>%s</h3>',
				sprintf(
					/* translators: 1: AI service name, 2: settings screen name. */
					esc_html__( 'Please enter the %1$s API key in [ The Post Grid > Settings > %2$s ]', 'the-post-grid' ),
					esc_html( $aiType ),
					esc_html( ucfirst( $aiType ) )
				)
			);
			return rest_ensure_response( $send_data );
		}

		$instruction_text = $this->build_instruction_text( $request_txt, $writingStyle, $headingNumber, $headingTag, $language );

		if ( $isChatGPT ) {
			$url  = 'https://api.openai.com/v1/chat/completions';
			$body = wp_json_encode( [
				'model'       => $model,
				'messages'    => [ [ 'role' => 'user', 'content' => $instruction_text ] ],
				'temperature' => 0.7,
				'max_tokens'  => $content_limit,
			] );
			$headers = [ 'Content-Type' => 'application/json', 'Authorization' => "Bearer $api_key" ];
		} else {
			$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$api_key}";
			$body = wp_json_encode( [
				'contents' => [ [ 'parts' => [ [ 'text' => $instruction_text ] ] ] ],
			] );
			$headers = [ 'Content-Type' => 'application/json' ];
		}

		$response = wp_safe_remote_post( $url, [
			'headers' => $headers,
			'body'    => $body,
			'timeout' => $response_time,
		] );

		if ( is_wp_error( $response ) ) {
			$send_data['status']  = 'error';
			$send_data['content'] = '<h3>' . esc_html__( 'Something is wrong...', 'the-post-grid' ) . '</h3>';
			return rest_ensure_response( $send_data );
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		if ( isset( $data['error'] ) ) {
			$send_data['status']  = 'error';
			$send_data['content'] = esc_html( $data['error']['message'] );
		} else {
			$content = $isChatGPT
				? $data['choices'][0]['message']['content'] ?? ''
				: $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

			$content = preg_replace( '/^```html\s*|```$/m', '', $content );
			$send_data['content'] = ( 'html' !== $writingStyle ) ? nl2br( $content ) : $content;
		}

		return rest_ensure_response( $send_data );
	}

	/**
	 * Builds the full instruction text by adding style, language, and heading directions.
	 *
	 * @param string $text          Base user request.
	 * @param string $writingStyle  Writing style (e.g. html).
	 * @param string $headingNumber Number of headings.
	 * @param string $headingTag    Heading tag (e.g. h2, h3).
	 * @param string $language      Language of the output.
	 *
	 * @return string
	 */
	private function build_instruction_text( $text, $writingStyle, $headingNumber, $headingTag, $language ) {
		$direction = [];

		if ( 'html' === $writingStyle ) {
			/* translators: %s: topic the content should be written about. */
			$text        = sprintf( esc_html__( 'Write a post content on this topic- %s', 'the-post-grid' ), $text );
			$direction[] = esc_html__( 'write everything in html tag, do not add any style attribute', 'the-post-grid' );

			if ( $headingNumber ) {
				/* translators: 1: number of headings, 2: heading tag such as h2. */
				$direction[] = sprintf( esc_html__( 'and use %1$s %2$s html headings for the content', 'the-post-grid' ), $headingNumber, $headingTag );
			}
		}

		if ( $language ) {
			/* translators: %s: output language. */
			$direction[] = sprintf( esc_html__( 'write everything in %s language', 'the-post-grid' ), $language );
		}

		if ( ! empty( $direction ) ) {
			$text .= ' ( ' . implode( ' ', $direction ) . ' )';
		}

		return $text;
	}


}
