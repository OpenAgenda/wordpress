<?php
/**
 * Class OpenagendaTest
 *
 * @package Openagenda
 */

/**
 * Test case for the OpenAgenda class.
 */
class OpenagendaTest extends WP_UnitTestCase {

	/**
	 * Events API response fixture.
	 *
	 * @var array<string, mixed>
	 */
	private $events_response = array();

	/**
	 * Single-event API response fixture.
	 *
	 * @var array<string, mixed>
	 */
	private $single_event_response = array();

	/**
	 * URL captured by the mocked API request.
	 *
	 * @var string
	 */
	private $request_url = '';

	/**
	 * Agenda post_id.
	 *
	 * @var int
	 */
	private $post_id = 0;

	/**
	 * Load the API response fixtures.
	 */
	public function setUp(): void {
		parent::setUp();

		$fixture                     = json_decode( file_get_contents( OPENAGENDA_PATH . 'tests/sample-data/events.json' ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Read a local test fixture.
		$this->events_response       = $fixture;
		$this->single_event_response = array(
			'event' => $fixture['events'][0],
		);

		$post_args     = require OPENAGENDA_PATH . 'tests/sample-data/agenda-post.php';
		$this->post_id = wp_insert_post( $post_args );

		update_option(
			'openagenda_general_settings',
			array(
				'openagenda_api_key' => 'settings-api-key',
			)
		);
	}

	/**
	 * The constructor parses the query and populates an agenda response.
	 */
	public function test_constructor_initializes_paginated_agenda() {
		$this->mock_remote_response( wp_json_encode( $this->events_response ) );

		$agenda = new \OpenAgenda\OpenAgenda(
			'76126842',
			array(
				'page'      => 2,
				'size'      => 10,
				'page_size' => 10,
			),
			array(
				'post_id'   => $this->post_id,
				'context'   => false,
				'use_cache' => false,
			)
		);

		$this->assertSame( '76126842', $agenda->get_uid() );
		$this->assertSame( 'settings-api-key', $agenda->get_api_key() );
		$this->assertSame( $this->post_id, $agenda->get_post_id() );
		$this->assertFalse( $agenda->is_single() );
		$this->assertSame( 2, $agenda->get_current_page() );
		$this->assertSame( 10, $agenda->get_size() );
		$this->assertSame( 10, $agenda->get_args()['from'] );
		$this->assertSame( 3142, $agenda->get_total() );
		$this->assertSame( 315, $agenda->get_total_pages() );
		$this->assertSame( $this->events_response['events'][0], $agenda->get_current_event() );
		$this->assertStringContainsString( 'agendas/76126842/events', $this->request_url );
	}

	/**
	 * A slug argument initializes the constructor's single-event state.
	 */
	public function test_constructor_initializes_single_event() {
		$this->mock_remote_response( wp_json_encode( $this->single_event_response ) );

		$agenda = new \OpenAgenda\OpenAgenda(
			'76126842',
			array(
				'slug' => 'sample-event',
				'size' => 20,
			),
			array(
				'api_key'   => 'option-api-key',
				'context'   => false,
				'use_cache' => false,
			)
		);

		$this->assertSame( 'option-api-key', $agenda->get_api_key() );
		$this->assertTrue( $agenda->is_single() );
		$this->assertSame( 1, $agenda->get_args()['size'] );
		$this->assertSame( 1, $agenda->get_total() );
		$this->assertSame( $this->single_event_response['event'], $agenda->get_current_event() );
		$this->assertStringContainsString( 'agendas/76126842/events/slug/sample-event', $this->request_url );
	}

	/**
	 * Verify query argument parsing across common archive and single-event inputs.
	 *
	 * @dataProvider parse_args_data_provider
	 *
	 * @param array<string, mixed> $input    Arguments passed to parse_args().
	 * @param array<string, mixed> $expected Expected parsed state.
	 */
	public function test_parse_args( $input, $expected ) {
		$this->mock_remote_response( wp_json_encode( $this->events_response ) );
		$agenda = new \OpenAgenda\OpenAgenda(
			'76126842',
			array(),
			array(
				'context'   => false,
				'use_cache' => false,
			)
		);
		$args   = $agenda->parse_args( $input );

		$this->assertSame( $expected['size'], $agenda->get_size() );
		$this->assertSame( $expected['page'], $agenda->get_current_page() );
		$this->assertSame( $expected['is_single'], $agenda->is_single() );
		$this->assertSame( $expected['is_archive'], $agenda->is_archive() );

		foreach ( $expected['args'] as $key => $value ) {
			$this->assertSame( $value, $args[ $key ] );
		}
		foreach ( $expected['removed_args'] as $key ) {
			$this->assertArrayNotHasKey( $key, $args );
		}
		$expected_params = $expected['params'];
		if ( isset( $expected_params['host'] ) ) {
			$expected_params['host'] = get_home_url();
		}
		if ( isset( $expected_params['uses_site_editor'] ) ) {
			$expected_params['uses_site_editor'] = function_exists( 'wp_is_block_theme' ) && wp_is_block_theme();
		}
		$this->assertSame( $expected_params, $agenda->get_params() );
		$this->assertSame( $expected['filters'], $agenda->get_filters() );
	}

	/**
	 * Provide query argument cases.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function parse_args_data_provider() {
		return array(
			'default archive'              => array(
				array(),
				array(
					'size'         => 20,
					'page'         => 1,
					'is_single'    => false,
					'is_archive'   => true,
					'args'         => array( 'size' => 20 ),
					'removed_args' => array( 'page', 'page_size', 'id' ),
					'params'       => array(
						'size'                  => 20,
						'longDescriptionFormat' => 'HTMLWithEmbeds',
						'includeLabels'         => true,
						'cms'                   => 'wp',
						'host'                  => 'http://example.org',
						'uses_site_editor'      => false,
					),
					'filters'      => array(),
				),
			),
			'pagination and custom filter' => array(
				array(
					'page'      => 3,
					'size'      => 10,
					'page_size' => 10,
					'id'        => 42,
					'category'  => 'music',
				),
				array(
					'size'         => 10,
					'page'         => 3,
					'is_single'    => false,
					'is_archive'   => true,
					'args'         => array(
						'size'     => 10,
						'from'     => 20,
						'category' => 'music',
					),
					'removed_args' => array( 'page', 'page_size', 'id' ),
					'params'       => array(
						'size'                  => 10,
						'longDescriptionFormat' => 'HTMLWithEmbeds',
						'includeLabels'         => true,
						'cms'                   => 'wp',
						'host'                  => 'http://example.org',
						'uses_site_editor'      => false,
						'from'                  => 20,
					),
					'filters'      => array( 'category' => 'music' ),
				),
			),
			'minimum page size'            => array(
				array( 'size' => 0 ),
				array(
					'size'         => 1,
					'page'         => 1,
					'is_single'    => false,
					'is_archive'   => true,
					'args'         => array( 'size' => 0 ),
					'removed_args' => array( 'page', 'page_size', 'id' ),
					'params'       => array(
						'size'                  => 0,
						'longDescriptionFormat' => 'HTMLWithEmbeds',
						'includeLabels'         => true,
						'cms'                   => 'wp',
						'host'                  => 'http://example.org',
						'uses_site_editor'      => false,
					),
					'filters'      => array(),
				),
			),
			'maximum page size'            => array(
				array( 'size' => 400 ),
				array(
					'size'         => 300,
					'page'         => 1,
					'is_single'    => false,
					'is_archive'   => true,
					'args'         => array( 'size' => 400 ),
					'removed_args' => array( 'page', 'page_size', 'id' ),
					'params'       => array(
						'size'                  => 400,
						'longDescriptionFormat' => 'HTMLWithEmbeds',
						'includeLabels'         => true,
						'cms'                   => 'wp',
						'host'                  => 'http://example.org',
						'uses_site_editor'      => false,
					),
					'filters'      => array(),
				),
			),
			'single event and search'      => array(
				array(
					'slug'   => 'sample-event',
					'size'   => 20,
					'page'   => 2,
					'search' => 'It\\\'s a test',
				),
				array(
					'size'         => 1,
					'page'         => 2,
					'is_single'    => true,
					'is_archive'   => false,
					'args'         => array(
						'size'   => 1,
						'from'   => 1,
						'slug'   => 'sample-event',
						'search' => "It's a test",
					),
					'removed_args' => array( 'page', 'page_size', 'id' ),
					'params'       => array(
						'size'                  => 1,
						'longDescriptionFormat' => 'HTMLWithEmbeds',
						'includeLabels'         => true,
						'cms'                   => 'wp',
						'host'                  => 'http://example.org',
						'uses_site_editor'      => false,
						'from'                  => 1,
					),
					'filters'      => array(
						'slug'   => 'sample-event',
						'search' => "It's a test",
					),
				),
			),
		);
	}

	/**
	 * Verify option defaults, explicit overrides, and legacy cache arguments.
	 *
	 * @dataProvider parse_options_data_provider
	 *
	 * @param array<string, mixed>|bool $options          Options to parse.
	 * @param array<string, mixed>      $general_settings General plugin settings.
	 * @param array<string, mixed>      $expected         Expected parsed options.
	 */
	public function test_parse_options( $options, $general_settings, $expected ) {
		update_option( 'openagenda_general_settings', $general_settings );
		$agenda = new \OpenAgenda\OpenAgenda(
			'76126842',
			array(),
			array(
				'context'   => false,
				'use_cache' => false,
			)
		);

		$this->assertSame( $expected, $agenda->parse_options( $options ) );
	}

	/**
	 * Provide option parsing cases.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function parse_options_data_provider() {
		$defaults = array(
			'is_preview'      => false,
			'cache'           => true,
			'context'         => true,
			'infinite_scroll' => false,
			'include_usage'   => true,
			'include_embeds'  => true,
			'api_key'         => '',
			'post_id'         => 0,
		);

		return array(
			'default options'                   => array(
				array(),
				array(),
				$defaults,
			),
			'explicit overrides'                => array(
				array(
					'is_preview'      => true,
					'cache'           => false,
					'infinite_scroll' => true,
					'api_key'         => 'custom-key',
					'post_id'         => 25,
				),
				array(),
				array_merge(
					$defaults,
					array(
						'is_preview'      => true,
						'cache'           => false,
						'infinite_scroll' => true,
						'api_key'         => 'custom-key',
						'post_id'         => 25,
					)
				),
			),
			'general settings control defaults' => array(
				array(),
				array(
					'openagenda_allow_usage_stats_collection' => false,
					'openagenda_include_embeds' => false,
				),
				array_merge(
					$defaults,
					array(
						'include_usage'  => false,
						'include_embeds' => false,
					)
				),
			),
			'legacy cache option'               => array(
				false,
				array(),
				array_merge(
					$defaults,
					array(
						'cache' => false,
					)
				),
			),
		);
	}

	/**
	 * Intercept the request and return a fake successful HTTP response.
	 *
	 * @param string $body Response body.
	 */
	private function mock_remote_response( $body ) {
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

		add_filter(
			'pre_http_request',
			function ( $preempt, $args, $url ) use ( $response ) {
				$this->request_url = $url;
				return $response;
			},
			10,
			3
		);
	}
}
