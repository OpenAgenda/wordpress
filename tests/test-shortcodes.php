<?php
/**
 * Tests for OpenAgenda shortcodes.
 *
 * @package Openagenda
 */

/**
 * Test the registered shortcode callbacks.
 */
class OpenagendaShortcodesTest extends WP_UnitTestCase {

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
	 * Shortcode attributes are parsed into the attributes passed to its filter.
	 *
	 * @dataProvider shortcode_attributes_data_provider
	 *
	 * @param string               $shortcode   Shortcode name.
	 * @param string               $filter      Filter name used by the shortcode.
	 * @param string               $attributes  Shortcode attributes.
	 * @param array<string, mixed> $expected         Expected parsed attributes.
	 * @param string               $expected_markup Expected HTML fragment.
	 */
	public function test_shortcode_attributes( $shortcode, $filter, $attributes, $expected, $expected_markup ) {
		$parsed_atts = null;
		$callback    = function ( $html, $uid_or_atts = null, $atts = null ) use ( &$parsed_atts ) {
			$parsed_atts = null === $atts ? $uid_or_atts : $atts;
			return $html;
		};
		add_filter( $filter, $callback, 10, 3 );

		do_shortcode( sprintf( '[%s %s]', $shortcode, $attributes ) );

		remove_filter( $filter, $callback, 10 );
		$this->assertIsArray( $parsed_atts, sprintf( 'The %s shortcode did not pass attributes to %s.', $shortcode, $filter ) );
		foreach ( $expected as $key => $value ) {
			$this->assertArrayHasKey( $key, $parsed_atts );
			$this->assertSame( $value, $parsed_atts[ $key ], sprintf( 'Unexpected parsed value for %s.', $key ) );
		}
	}

	/**
	 * Provide shortcode attribute sets and the parsed values to verify.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function shortcode_attributes_data_provider() {
		return array(
			'active filters'          => array(
				'openagenda_filter_active',
				'openagenda_filter_active',
				'id="custom-active" title="Active" dropdown="true" display_on_single="false"',
				array(
					'id'                => 'custom-active',
					'title'             => 'Active',
					'dropdown'          => 'true',
					'display_on_single' => 'false',
				),
				'',
			),
			'total filters'           => array(
				'openagenda_filter_total',
				'openagenda_filter_total',
				'id="custom-total" title="Count" dropdown="1" display_on_single="0"',
				array(
					'id'                => 'custom-total',
					'title'             => 'Count',
					'dropdown'          => '1',
					'display_on_single' => '0',
				),
				'',
			),
			'choice filter'           => array(
				'openagenda_filter_choice',
				'openagenda_filter_choice',
				'id="custom-choice" field="city" page_size="25" sort="name.asc" display_on_single="false"',
				array(
					'id'                => 'custom-choice',
					'field'             => 'city',
					'page_size'         => '25',
					'sort'              => 'name.asc',
					'display_on_single' => 'false',
				),
				'',
			),
			'additional field choice' => array(
				'openagenda_filter_choice',
				'openagenda_filter_choice',
				'id="custom-additional" field="additional_field" additional_field="audience"',
				array(
					'id'               => 'custom-additional',
					'field'            => 'additional_field',
					'additional_field' => 'audience',
				),
				'&quot;aggregation&quot;:{&quot;type&quot;:&quot;additionalFields&quot;,&quot;field&quot;:&quot;audience&quot;,&quot;size&quot;:2000}',
			),
			'favorites choice'        => array(
				'openagenda_filter_choice',
				'openagenda_filter_choice',
				'id="custom-favorites" field="favorites"',
				array(
					'id'    => 'custom-favorites',
					'field' => 'favorites',
				),
				'&quot;type&quot;:&quot;favorites&quot;',
			),
			'tags filter'             => array(
				'openagenda_filter_tags',
				'openagenda_filter_choice',
				'id="custom-tags" field="keyword" page_size="20" additional_field="topic"',
				array(
					'id'               => 'custom-tags',
					'field'            => 'keyword',
					'page_size'        => '20',
					'additional_field' => 'topic',
				),
				'data-oa-filter="custom-tags"',
			),
			'calendar filter'         => array(
				'openagenda_filter_calendar',
				'openagenda_filter_calendar',
				'id="custom-calendar" type="period" display_ranges="true" ranges="today,this-week"',
				array(
					'id'             => 'custom-calendar',
					'type'           => 'period',
					'display_ranges' => 'true',
					'ranges'         => 'today,this-week',
				),
				'data-oa-filter="custom-calendar" data-oa-filter-params="{&quot;type&quot;:&quot;period&quot;',
			),
			'defined ranges'          => array(
				'openagenda_filter_ranges',
				'openagenda_filter_ranges',
				'id="custom-ranges" static_ranges="today, this-week" title="Popular dates"',
				array(
					'id'            => 'custom-ranges',
					'static_ranges' => 'today, this-week',
					'title'         => 'Popular dates',
				),
				'&quot;staticRanges&quot;:[&quot;today&quot;,&quot;this-week&quot;]',
			),
			'map filter'              => array(
				'openagenda_filter_map',
				'openagenda_filter_map',
				'id="custom-map" map_tiles_link="https://tiles.example/{z}/{x}/{y}.png" map_attribution="Map data" map_zoom="8" map_auto="0" map_auto_message="Move map"',
				array(
					'id'               => 'custom-map',
					'map_tiles_link'   => 'https://tiles.example/{z}/{x}/{y}.png',
					'map_attribution'  => 'Map data',
					'map_zoom'         => '8',
					'map_auto'         => '0',
					'map_auto_message' => 'Move map',
				),
				'&quot;searchWithMap&quot;:false,&quot;searchMessage&quot;:&quot;Move map&quot;',
			),
			'preview alias'           => array(
				'openagenda_preview',
				'openagenda_filter_preview',
				'id="preview-id" uid="76126842" size="4" filters="q.city=Paris"',
				array(
					'id'      => 'preview-id',
					'uid'     => '76126842',
					'size'    => '4',
					'filters' => 'q.city=Paris',
				),
				'<div class="oa-preview">',
			),
			'preview filter'          => array(
				'openagenda_filter_preview',
				'openagenda_filter_preview',
				'id="filtered-preview" uid="76126842" view="grid" sort="title.asc" post_id="27"',
				array(
					'id'      => 'filtered-preview',
					'uid'     => '76126842',
					'view'    => 'grid',
					'sort'    => 'title.asc',
					'post_id' => '27',
				),
				'<div class="oa-preview">',
			),
			'relative filter'         => array(
				'openagenda_filter_relative',
				'openagenda_filter_relative',
				'id="custom-relative" title="Coming soon" dropdown="true"',
				array(
					'id'       => 'custom-relative',
					'title'    => 'Coming soon',
					'dropdown' => 'true',
				),
				'<details class="oa-widget-details"><summary class="oa-widget-summary">Coming soon</summary>',
			),
			'active filters dropdown' => array(
				'openagenda_filter_active',
				'openagenda_filter_active',
				'id="custom-dropdown" title="Agenda filters" dropdown="true"',
				array(
					'id'       => 'custom-dropdown',
					'title'    => 'Agenda filters',
					'dropdown' => 'true',
				),
				'<details class="oa-widget-details"><summary class="oa-widget-summary">Agenda filters</summary><div class="oa-widget oa-active-filters-widget" data-oa-widget="custom-dropdown"',
			),
			'search filter'           => array(
				'openagenda_filter_search',
				'openagenda_filter_search',
				'id="custom-search" placeholder="Find events"',
				array(
					'id'          => 'custom-search',
					'placeholder' => 'Find events',
				),
				'data-oa-filter="custom-search" data-oa-filter-params="{&quot;type&quot;:&quot;search&quot;,&quot;name&quot;:&quot;search&quot;,&quot;placeholder&quot;:&quot;Find events&quot;,&quot;manualSearch&quot;:false}',
			),
			'sort filter'             => array(
				'openagenda_filter_sort',
				'openagenda_filter_sort',
				'id="custom-sort" options="score, name.asc, date.desc"',
				array(
					'id'      => 'custom-sort',
					'options' => 'score, name.asc, date.desc',
				),
				'&quot;options&quot;:[&quot;score&quot;,&quot;name.asc&quot;,&quot;date.desc&quot;]',
			),
			'submit filter'           => array(
				'openagenda_filter_submit',
				'openagenda_filter_submit',
				'id="custom-submit" button_label="Update agenda" display_on_single="false"',
				array(
					'id'                => 'custom-submit',
					'button_label'      => 'Update agenda',
					'display_on_single' => 'false',
				),
				'',
			),
		);
	}

	/**
	 * Shortcodes render the expected HTML for each attribute test case.
	 *
	 * @dataProvider shortcode_attributes_data_provider
	 *
	 * @param string               $shortcode       Shortcode name.
	 * @param string               $filter          Filter name used by the shortcode.
	 * @param string               $attributes      Shortcode attributes.
	 * @param array<string, mixed> $expected        Expected parsed attributes.
	 * @param string               $expected_markup Expected HTML fragment.
	 */
	public function test_shortcode_html( $shortcode, $filter, $attributes, $expected, $expected_markup ) {
		$html = do_shortcode( sprintf( '[%s %s]', $shortcode, $attributes ) );

		if ( '' === $expected_markup ) {
			$this->assertSame( '', $html );
		} else {
			$this->assertStringContainsString( $expected_markup, $html );
		}
	}

	/**
	 * The display_on_single attribute controls filters in a single-event view.
	 *
	 * @dataProvider display_on_single_data_provider
	 *
	 * @param string $shortcode       Shortcode name.
	 * @param string $additional_atts Additional attributes required by the shortcode.
	 * @param string $display         Value of display_on_single.
	 * @param bool   $is_visible      Whether the widget should be rendered.
	 */
	public function test_display_on_single( $shortcode, $additional_atts, $display, $is_visible ) {
		$html = do_shortcode( sprintf( '[%s %s display_on_single="%s"]', $shortcode, $additional_atts, $display ) );

		if ( $is_visible ) {
			$this->assertNotSame( '', $html );
		} else {
			$this->assertSame( '', $html );
		}
	}

	/**
	 * Provide both visible and hidden single-event cases for each filter shortcode.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function display_on_single_data_provider() {
		$shortcodes = array(
			'active filters'  => array( 'openagenda_filter_active', '' ),
			'total filters'   => array( 'openagenda_filter_total', '' ),
			'choice filter'   => array( 'openagenda_filter_choice', 'field="city"' ),
			'tags filter'     => array( 'openagenda_filter_tags', '' ),
			'calendar filter' => array( 'openagenda_filter_calendar', '' ),
			'ranges filter'   => array( 'openagenda_filter_ranges', '' ),
			'map filter'      => array( 'openagenda_filter_map', '' ),
			'relative filter' => array( 'openagenda_filter_relative', '' ),
			'search filter'   => array( 'openagenda_filter_search', '' ),
			'sort filter'     => array( 'openagenda_filter_sort', '' ),
			'submit filter'   => array( 'openagenda_filter_submit', '' ),
		);
		$cases      = array();

		foreach ( $shortcodes as $name => $shortcode ) {
			$cases[ sprintf( '%s hidden', $name ) ]            = array( $shortcode[0], $shortcode[1], 'false', false );
			$cases[ sprintf( '%s hidden with zero', $name ) ]  = array( $shortcode[0], $shortcode[1], '0', false );
			$cases[ sprintf( '%s hidden when empty', $name ) ] = array( $shortcode[0], $shortcode[1], '', false );
			$cases[ sprintf( '%s visible', $name ) ]           = array( $shortcode[0], $shortcode[1], 'true', true );
		}

		return $cases;
	}
}
