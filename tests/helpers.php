<?php
/**
 * Shared test helpers.
 *
 * @package Openagenda
 */

/**
 * Intercept the next HTTP request and return a fake successful response.
 *
 * @param string      $body        Response body.
 * @param string|null $request_url Captures the requested URL when provided.
 * @return callable HTTP pre-request callback.
 */
function openagenda_test_mock_remote_response( $body, &$request_url = null ) {
	$response = array(
		'headers'  => array(),
		'body'     => $body,
		'response' => array(
			'code'    => 200,
			'message' => 'OK',
		),
		'cookies'  => array(),
		'filename' => null,
	);

	$callback = function ( $preempt, $args, $url ) use ( $response, &$request_url ) {
		if ( false !== $preempt ) {
			return $preempt;
		}

		$request_url = $url;
		return $response;
	};

	add_filter( 'pre_http_request', $callback, 10, 3 );
	return $callback;
}
