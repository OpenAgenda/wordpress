<?php
/**
 * Tests for OpenAgenda helper functions.
 *
 * @package Openagenda
 */

/**
 * Tests helper functions with significant formatting and parsing logic.
 */
class OpenagendaHelperFunctionsTest extends WP_UnitTestCase {

	/**
	 * Set predictable date and time formats for timing tests.
	 */
	public function setUp(): void {
		parent::setUp();

		update_option( 'date_format', 'Y-m-d' );
		update_option( 'time_format', 'H:i' );
	}

	/**
	 * Formats start and end times in the requested timezone.
	 *
	 * @dataProvider format_timing_data_provider
	 *
	 * @param array<string, string> $timing   Timing data.
	 * @param string                $timezone Timezone used to format the timing.
	 * @param array<string, string> $expected Expected formatted date and time fields.
	 */
	public function test_format_timing_uses_timezone( $timing, $timezone, $expected ) {
		$formatted = openagenda_format_timing( $timing, new DateTimeZone( $timezone ) );

		foreach ( $expected as $key => $value ) {
			$this->assertSame( $value, $formatted[ $key ] );
		}
		$this->assertArrayHasKey( 'relative_label', $formatted );
	}

	/**
	 * Provide timings with timezone conversions.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function format_timing_data_provider() {
		return array(
			'UTC rendered in Los Angeles' => array(
				array(
					'begin' => '2025-01-01T00:30:00+00:00',
					'end'   => '2025-01-01T01:15:00+00:00',
				),
				'America/Los_Angeles',
				array(
					'start_date_label' => '2024-12-31',
					'start_time_label' => '16:30',
					'end_date_label'   => '2024-12-31',
					'end_time_label'   => '17:15',
					'start_year'       => '2024',
					'start_month'      => '12',
					'start_day'        => '31',
				),
			),
			'UTC rendered in Paris'       => array(
				array(
					'begin' => '2025-01-01T00:30:00+00:00',
					'end'   => '2025-01-01T01:15:00+00:00',
				),
				'Europe/Paris',
				array(
					'start_date_label' => '2025-01-01',
					'start_time_label' => '01:30',
					'end_date_label'   => '2025-01-01',
					'end_time_label'   => '02:15',
					'start_year'       => '2025',
					'start_month'      => '01',
					'start_day'        => '01',
				),
			),
		);
	}

	/**
	 * Selects the month nearer to today relative to the reference month.
	 *
	 * @dataProvider is_month_nearer_data_provider
	 *
	 * @param string       $month   Month being tested.
	 * @param string|false $ref     Reference month.
	 * @param string       $today   Current month.
	 * @param bool         $expected Whether the month is nearer.
	 */
	public function test_is_month_nearer( $month, $ref, $today, $expected ) {
		$this->assertSame( $expected, openagenda_is_month_nearer( $month, $ref, $today ) );
	}

	/**
	 * Provide past and future month comparisons.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function is_month_nearer_data_provider() {
		return array(
			'no reference month'                    => array( '2026-11', false, '2026-11', true ),
			'past reference prefers later month'    => array( '2026-10', '2026-08', '2026-11', true ),
			'month before past reference'           => array( '2026-07', '2026-08', '2026-11', false ),
			'future reference includes today'       => array( '2026-11', '2026-12', '2026-11', true ),
			'future reference excludes later month' => array( '2027-01', '2026-12', '2026-11', false ),
			'today as reference is not nearer'      => array( '2026-11', '2026-11', '2026-11', false ),
		);
	}

	/**
	 * Encodes and decodes context data, including an empty context string.
	 *
	 * @dataProvider context_data_provider
	 *
	 * @param array<string, mixed>|string $context  Context to encode, or empty string.
	 * @param array<string, mixed>|false  $expected Expected decoded context.
	 */
	public function test_context_encoding_and_decoding( $context, $expected ) {
		if ( '' === $context ) {
			$this->assertSame( $expected, openagenda_decode_context( $context ) );
			return;
		}

		$this->assertSame( $expected, openagenda_decode_context( openagenda_encode_context( $context ) ) );
	}

	/**
	 * Provide context values for round-trip tests.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function context_data_provider() {
		return array(
			'nested context'       => array(
				array(
					'params'  => array( 'size' => 10 ),
					'filters' => array( 'city' => 'Paris' ),
					'page'    => 2,
				),
				array(
					'params'  => array( 'size' => 10 ),
					'filters' => array( 'city' => 'Paris' ),
					'page'    => 2,
				),
			),
			'empty context string' => array( '', array() ),
		);
	}

	/**
	 * Parses saved agenda filters and applies exclusion and sort defaults.
	 *
	 * @dataProvider pre_filters_data_provider
	 *
	 * @param string               $filters_url Saved filter URL.
	 * @param string               $exclude     Whether past events are excluded.
	 * @param string               $sort        Saved default sort.
	 * @param array<string, mixed> $filters     Filters already present in the request.
	 * @param array<string, mixed> $expected    Expected initial filters.
	 */
	public function test_get_pre_filters( $filters_url, $exclude, $sort, $filters, $expected ) {
		$post_id = self::factory()->post->create(
			array(
				'post_type' => 'oa-calendar',
			)
		);
		update_post_meta( $post_id, 'oa-calendar-filters', $filters_url );
		update_post_meta( $post_id, 'oa-calendar-exclude', $exclude );
		update_post_meta( $post_id, 'oa-calendar-sort', $sort );

		$this->assertSame( $expected, openagenda_get_pre_filters( $post_id, $filters ) );
	}

	/**
	 * Provide saved and request-level filter combinations.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function pre_filters_data_provider() {
		return array(
			'saved URL and defaults'                    => array(
				'https://openagenda.com/events?q.city=Paris&q.category=music',
				'yes',
				'date',
				array(),
				array(
					'city'     => 'Paris',
					'category' => 'music',
					'relative' => array( 'current', 'upcoming' ),
					'sort'     => 'date',
				),
			),
			'request timing and sort override defaults' => array(
				'',
				'yes',
				'date',
				array(
					'timings' => array( '2026-11-02' ),
					'sort'    => 'title',
				),
				array(),
			),
			'saved relative filter is retained'         => array(
				'https://openagenda.com/events?q.relative=all',
				'yes',
				'',
				array( 'timings' => array( '2026-11-02' ) ),
				array( 'relative' => 'all' ),
			),
		);
	}
}
