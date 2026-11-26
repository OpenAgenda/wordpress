<?php
/**
 * Tests for OpenAgenda widgets.
 *
 * @package Openagenda
 */

/**
 * Test the OpenAgenda widget classes.
 */
class OpenagendaWidgetsTest extends WP_UnitTestCase {

	/**
	 * Mock HTTP callback.
	 *
	 * @var callable|null
	 */
	private $http_callback;

	/**
	 * Agenda object that was present before the test.
	 *
	 * @var mixed
	 */
	private $previous_openagenda;

	/**
	 * URL requested by the preview widget test.
	 *
	 * @var string|null
	 */
	private $requested_url;

	/**
	 * Build a single-event agenda using a mocked API response.
	 */
	public function setUp(): void {
		parent::setUp();

		global $openagenda;
		$this->previous_openagenda = $openagenda;

		$post_args = require OPENAGENDA_PATH . 'tests/sample-data/agenda-post.php';
		$post_id   = wp_insert_post( $post_args );
		$this->go_to( get_permalink( $post_id ) );

		$fixture           = json_decode( file_get_contents( OPENAGENDA_PATH . 'tests/sample-data/events.json' ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Read a local test fixture.
		$response          = $fixture;
		$response['event'] = $fixture['events'][0];

		$this->http_callback = openagenda_test_mock_remote_response( wp_json_encode( $response ) );

		update_option( 'date_format', 'Y-m-d' );
		update_option(
			'openagenda_general_settings',
			array(
				'openagenda_manual_submit' => true,
			)
		);

		$openagenda = new \OpenAgenda\OpenAgenda(
			'76126842',
			array( 'slug' => 'explora_507' ),
			array(
				'context'   => false,
				'use_cache' => false,
			)
		);
		$this->assertTrue( $openagenda->is_single() );
	}

	/**
	 * Restore the agenda and remove the HTTP mock.
	 */
	public function tearDown(): void {
		global $openagenda;
		$openagenda = $this->previous_openagenda;

		if ( $this->http_callback ) {
			remove_filter( 'pre_http_request', $this->http_callback, 10 );
		}

		parent::tearDown();
	}

	/**
	 * Preview widget settings are sanitized and displayed in its form.
	 *
	 * @dataProvider preview_widget_settings_data_provider
	 *
	 * @param array<string, mixed> $new_instance New widget settings.
	 * @param array<string, mixed> $expected     Expected saved settings.
	 */
	public function test_preview_widget_updates_and_displays_settings( $new_instance, $expected ) {
		$widget   = new \OpenAgenda\Preview_Widget();
		$instance = $widget->update( $new_instance, array() );

		$this->assertSame( $expected, $instance );

		ob_start();
		$widget->form( $instance );
		$form = ob_get_clean();

		$this->assertStringContainsString( sprintf( 'value="%s"', $expected['title'] ), $form );
		$this->assertStringContainsString( sprintf( 'value="%s"', $expected['uid'] ), $form );
		$this->assertStringContainsString( sprintf( 'value="%d"', $expected['size'] ), $form );
		$this->assertMatchesRegularExpression( sprintf( '/value="%s" checked=/', preg_quote( $expected['view'], '/' ) ), $form );
		$this->assertMatchesRegularExpression( sprintf( '/<option value="%s" selected/', preg_quote( $expected['sort'], '/' ) ), $form );
		if ( '' !== $expected['filters'] ) {
			$this->assertStringContainsString( sprintf( 'value="%s"', esc_attr( $expected['filters'] ) ), $form );
		}
		if ( $expected['links'] ) {
			$this->assertMatchesRegularExpression( '/<input type="checkbox"[^>]+checked=/', $form );
		}
	}

	/**
	 * Preview widget passes different instance settings through to its shortcode.
	 *
	 * @dataProvider preview_widget_output_data_provider
	 *
	 * @param array<string, mixed> $instance      Widget instance settings.
	 * @param array<string, mixed> $expected_atts Expected shortcode attributes.
	 */
	public function test_preview_widget_passes_settings_to_shortcode( $instance, $expected_atts ) {
		$widget      = new \OpenAgenda\Preview_Widget();
		$parsed_atts = null;
		$callback    = function ( $html, $atts ) use ( &$parsed_atts ) {
			$parsed_atts = $atts;
			return '<span class="preview-widget-test"></span>';
		};
		add_filter( 'openagenda_filter_preview', $callback, 10, 2 );

		ob_start();
		$widget->widget(
			array(
				'before_widget' => '<aside>',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			),
			$instance
		);
		$html = ob_get_clean();
		remove_filter( 'openagenda_filter_preview', $callback, 10 );

		$this->assertStringContainsString( sprintf( '<aside><h2>%s</h2>', $instance['title'] ), $html );
		$this->assertStringContainsString( 'preview-widget-test', $html );
		$this->assertStringContainsString( '</aside>', $html );
		foreach ( $expected_atts as $key => $value ) {
			$this->assertSame( $value, $parsed_atts[ $key ], sprintf( 'Unexpected shortcode value for %s.', $key ) );
		}
	}

	/**
	 * Preview widgets render the events returned for their agenda and settings.
	 *
	 * @dataProvider preview_widget_events_data_provider
	 *
	 * @param int[]    $event_indexes      Fixture event indexes returned by the API.
	 * @param string[] $expected_titles    Event titles expected in the rendered widget.
	 * @param string[] $unexpected_titles  Event titles that must not be rendered.
	 * @param int      $size               Number of events requested by the widget.
	 * @param string   $filters            Widget filters.
	 * @throws RuntimeException If the preview widget does not request the configured agenda.
	 */
	public function test_preview_widget_renders_returned_events( $event_indexes, $expected_titles, $unexpected_titles, $size, $filters ) {
		$fixture = json_decode( file_get_contents( OPENAGENDA_PATH . 'tests/sample-data/events.json' ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Read a local test fixture.
		$events  = array();
		foreach ( $event_indexes as $index ) {
			$events[] = $fixture['events'][ $index ];
		}

		remove_filter( 'pre_http_request', $this->http_callback, 10 );
		$this->requested_url = null;
		$response            = array(
			'headers'  => array(),
			'body'     => wp_json_encode(
				array(
					'events' => $events,
					'total'  => count( $events ),
				)
			),
			'response' => array(
				'code'    => 200,
				'message' => 'OK',
			),
			'cookies'  => array(),
			'filename' => null,
		);
		$this->http_callback = function ( $preempt, $args, $url ) use ( $response ) {
			if ( false !== $preempt ) {
				return $preempt;
			}

			$this->requested_url = $url;
			return $response;
		};
		add_filter( 'pre_http_request', $this->http_callback, 10, 3 );

		$locale_callback = function () {
			return 'fr';
		};
		add_filter( 'openagenda_locale', $locale_callback );

		$widget = new \OpenAgenda\Preview_Widget();
		ob_start();
		$widget->widget(
			array(
				'before_widget' => '<aside>',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			),
			array(
				'title'   => 'Agenda preview',
				'uid'     => '76126842',
				'size'    => $size,
				'view'    => 'list',
				'sort'    => 'timingsWithFeatured.asc',
				'filters' => $filters,
				'links'   => false,
			)
		);
		$html = ob_get_clean();
		remove_filter( 'openagenda_locale', $locale_callback );

		foreach ( $expected_titles as $title ) {
			$this->assertStringContainsString( $title, $html );
		}
		foreach ( $unexpected_titles as $title ) {
			$this->assertStringNotContainsString( $title, $html );
		}

		if ( ! is_string( $this->requested_url ) ) {
			throw new RuntimeException( 'The preview widget did not make an API request.' );
		}

		$request_parts = wp_parse_url( $this->requested_url );
		if ( ! is_array( $request_parts ) ) {
			throw new RuntimeException( 'The preview widget made an invalid API request.' );
		}

		parse_str( $request_parts['query'], $request_params );
		$this->assertSame( '/v2/agendas/76126842/events', $request_parts['path'] );
		$this->assertSame( (string) $size, $request_params['size'] );
		if ( '' !== $filters ) {
			$this->assertSame( array( 'upcoming' ), $request_params['relative'] );
		}
	}

	/**
	 * Filter widget settings are sanitized and displayed in its form.
	 *
	 * @dataProvider filter_widget_settings_data_provider
	 *
	 * @param array<string, array<string, mixed>> $available_filters Available filter definitions.
	 * @param array<string, mixed>                $new_instance      New widget settings.
	 * @param array<string, mixed>                $expected          Expected saved settings.
	 * @param string[]                            $form_values       Values expected in the settings form.
	 */
	public function test_filter_widget_updates_and_displays_settings( $available_filters, $new_instance, $expected, $form_values ) {
		$widget   = new \OpenAgenda\Filter_Widget( array( 'available_filters' => $available_filters ) );
		$instance = $widget->update( $new_instance, array() );

		$this->assertSame( $expected, $instance );

		ob_start();
		$widget->form( $instance );
		$form = ob_get_clean();

		$this->assertStringContainsString( sprintf( 'value="%s"', $expected['title'] ), $form );
		$this->assertMatchesRegularExpression( sprintf( '/<option value="%s"[^>]*selected/', preg_quote( $expected['filter'], '/' ) ), $form );
		$this->assertStringContainsString( sprintf( 'data-filter="%s"', esc_attr( $expected['filter'] ) ), $form );
		foreach ( $form_values as $value ) {
			$this->assertStringContainsString( sprintf( 'value="%s"', esc_attr( $value ) ), $form );
		}
		$this->assertStringContainsString( 'checked=', $form );
	}

	/**
	 * Filter widget passes its settings through to the selected shortcode.
	 *
	 * @dataProvider filter_widget_output_data_provider
	 *
	 * @param array<string, array<string, mixed>> $available_filters Available filter definitions.
	 * @param array<string, mixed>                $instance          Widget instance settings.
	 * @param array<string, mixed>                $expected_atts     Expected shortcode attributes.
	 */
	public function test_filter_widget_passes_settings_to_shortcode( $available_filters, $instance, $expected_atts ) {
		$widget      = new \OpenAgenda\Filter_Widget( array( 'available_filters' => $available_filters ) );
		$parsed_atts = null;
		$callback    = function ( $html, $uid, $atts ) use ( &$parsed_atts ) {
			$parsed_atts = $atts;
			return '<span class="filter-widget-test"></span>';
		};
		add_filter( $instance['filter'], $callback, 10, 3 );

		ob_start();
		$widget->widget(
			array(
				'before_widget' => '<aside>',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
				'widget_id'     => 'openagenda-filter-widget-2',
			),
			$instance
		);
		$html = ob_get_clean();
		remove_filter( $instance['filter'], $callback, 10 );

		$this->assertStringContainsString( sprintf( '<aside><h2>%s</h2>', $instance['title'] ), $html );
		$this->assertStringContainsString( 'filter-widget-test', $html );
		$this->assertStringContainsString( '</aside>', $html );
		foreach ( $expected_atts as $key => $value ) {
			$this->assertSame( $value, $parsed_atts[ $key ], sprintf( 'Unexpected shortcode value for %s.', $key ) );
		}
	}

	/**
	 * Preview widget update cases with different saved settings.
	 *
	 * @return array<string, array<int, mixed>>
	 */
	public static function preview_widget_settings_data_provider() {
		return array(
			'list defaults' => array(
				array(
					'title' => 'Recent events',
					'uid'   => '76126842',
				),
				array(
					'title'   => 'Recent events',
					'uid'     => '76126842',
					'size'    => 3,
					'view'    => 'list',
					'sort'    => 'timingsWithFeatured.asc',
					'filters' => '',
					'links'   => false,
				),
			),
			'filtered grid' => array(
				array(
					'title'   => 'Featured events',
					'uid'     => '76126842',
					'size'    => '5',
					'view'    => 'grid',
					'sort'    => 'timings.asc',
					'filters' => '?relative[]=upcoming',
					'links'   => '1',
				),
				array(
					'title'   => 'Featured events',
					'uid'     => '76126842',
					'size'    => 5,
					'view'    => 'grid',
					'sort'    => 'timings.asc',
					'filters' => '?relative[]=upcoming',
					'links'   => true,
				),
			),
		);
	}

	/**
	 * Preview widget front-end cases with different instance configurations.
	 *
	 * @return array<string, array<int, mixed>>
	 */
	public static function preview_widget_output_data_provider() {
		return array(
			'filtered grid with external links'      => array(
				array(
					'title'   => 'Featured events',
					'uid'     => '76126842',
					'size'    => 5,
					'view'    => 'grid',
					'sort'    => 'timings.asc',
					'filters' => '?relative[]=upcoming',
					'links'   => true,
				),
				array(
					'uid'     => '76126842',
					'size'    => '5',
					'view'    => 'grid',
					'sort'    => 'timings.asc',
					'filters' => rawurlencode( '?relative[]=upcoming' ),
					'links'   => 'oa',
				),
			),
			'list without filters or external links' => array(
				array(
					'title'   => 'Recent events',
					'uid'     => '76126842',
					'size'    => 2,
					'view'    => 'list',
					'sort'    => 'lastTiming.asc',
					'filters' => '',
					'links'   => false,
				),
				array(
					'uid'     => '76126842',
					'size'    => '2',
					'view'    => 'list',
					'sort'    => 'lastTiming.asc',
					'filters' => '',
					'links'   => '',
				),
			),
		);
	}

	/**
	 * Filter widget update cases with distinct available filters and settings.
	 *
	 * @return array<string, array<int, mixed>>
	 */
	public static function filter_widget_settings_data_provider() {
		$search_filter = array(
			'openagenda_filter_search' => array(
				'label'     => 'Search',
				'shortcode' => 'openagenda_filter_search',
				'settings'  => array(
					'placeholder' => array(
						'name'    => 'placeholder',
						'type'    => 'text',
						'label'   => 'Placeholder',
						'default' => '',
					),
				),
			),
		);
		$choice_filter = array(
			'openagenda_filter_choice' => array(
				'label'     => 'Choice',
				'shortcode' => 'openagenda_filter_choice',
				'settings'  => array(
					'field'            => array(
						'name'    => 'field',
						'type'    => 'select',
						'label'   => 'Field',
						'default' => '',
						'options' => array( 'city' => 'City' ),
					),
					'additional_field' => array(
						'name'    => 'additional_field',
						'type'    => 'text',
						'label'   => 'Additional field',
						'default' => '',
					),
					'page_size'        => array(
						'name'    => 'page_size',
						'type'    => 'number',
						'label'   => 'Number of options',
						'default' => 10,
					),
					'sort'             => array(
						'name'    => 'sort',
						'type'    => 'select',
						'label'   => 'Sort options',
						'default' => '',
						'options' => array( 'alphabetical' => 'Alphabetical' ),
					),
				),
			),
		);

		return array(
			'search settings' => array(
				$search_filter,
				array(
					'title'             => 'Find events',
					'filter'            => 'openagenda_filter_search',
					'dropdown'          => '1',
					'display_on_single' => '1',
					'placeholder'       => 'Search by keyword',
				),
				array(
					'title'             => 'Find events',
					'filter'            => 'openagenda_filter_search',
					'dropdown'          => true,
					'display_on_single' => true,
					'placeholder'       => 'Search by keyword',
				),
				array( 'Search by keyword' ),
			),
			'choice settings' => array(
				$choice_filter,
				array(
					'title'             => 'Choose a city',
					'filter'            => 'openagenda_filter_choice',
					'dropdown'          => '',
					'display_on_single' => '1',
					'field'             => 'city',
					'additional_field'  => 'audience',
					'page_size'         => '25',
					'sort'              => 'alphabetical',
				),
				array(
					'title'             => 'Choose a city',
					'filter'            => 'openagenda_filter_choice',
					'dropdown'          => false,
					'display_on_single' => true,
					'field'             => 'city',
					'additional_field'  => 'audience',
					'page_size'         => 25,
					'sort'              => 'alphabetical',
				),
				array( 'city', 'audience', '25', 'alphabetical' ),
			),
		);
	}

	/**
	 * Filter widget front-end cases with distinct shortcodes and instance settings.
	 *
	 * @return array<string, array<int, mixed>>
	 */
	public static function filter_widget_output_data_provider() {
		return array(
			'search filter' => array(
				array(
					'openagenda_filter_search' => array(
						'label'     => 'Search',
						'shortcode' => 'openagenda_filter_search',
						'settings'  => array(),
					),
				),
				array(
					'title'             => 'Find events',
					'filter'            => 'openagenda_filter_search',
					'dropdown'          => true,
					'display_on_single' => true,
					'placeholder'       => 'Search by keyword',
				),
				array(
					'id'                => 'openagenda-filter-widget-2',
					'placeholder'       => 'Search by keyword',
					'dropdown'          => '1',
					'display_on_single' => '1',
				),
			),
			'choice filter' => array(
				array(
					'openagenda_filter_choice' => array(
						'label'     => 'Choice',
						'shortcode' => 'openagenda_filter_choice',
						'settings'  => array(),
					),
				),
				array(
					'title'             => 'Choose a city',
					'filter'            => 'openagenda_filter_choice',
					'dropdown'          => false,
					'display_on_single' => true,
					'field'             => 'city',
					'additional_field'  => 'district',
					'page_size'         => 25,
					'sort'              => 'alphabetical',
				),
				array(
					'id'                => 'openagenda-filter-widget-2',
					'field'             => 'city',
					'additional_field'  => 'district',
					'page_size'         => '25',
					'sort'              => 'alphabetical',
					'dropdown'          => '',
					'display_on_single' => '1',
				),
			),
		);
	}

	/**
	 * Preview widget API responses contain different event sets and page sizes.
	 *
	 * @return array<string, array<int, mixed>>
	 */
	public static function preview_widget_events_data_provider() {
		return array(
			'second event only'                     => array(
				array( 1 ),
				array( 'Chiens et chats' ),
				array( 'Les expositions' ),
				1,
				'',
			),
			'two later events with upcoming filter' => array(
				array( 2, 3 ),
				array( "Cité des sciences et de l'industrie", 'Mission Spatiale' ),
				array( 'Les expositions', 'Chiens et chats' ),
				2,
				'?relative[]=upcoming',
			),
		);
	}
}
