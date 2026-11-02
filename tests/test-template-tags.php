<?php
/**
 * Tests for OpenAgenda template tags.
 *
 * @package Openagenda
 */

/**
 * Tests template tags against mocked API event data.
 */
class OpenagendaTemplateTagsTest extends WP_UnitTestCase {

	/**
	 * Current mock HTTP callback.
	 *
	 * @var callable|null
	 */
	private $http_callback = null;

	/**
	 * Previous global agenda instance.
	 *
	 * @var mixed
	 */
	private $previous_openagenda;

	/**
	 * Previous `oa-lang` query value.
	 *
	 * @var mixed
	 */
	private $previous_locale;

	/**
	 * Whether `oa-lang` was set before the test.
	 *
	 * @var bool
	 */
	private $had_previous_locale = false;

	/**
	 * Load the event fixture and save globals before each test.
	 */
	public function setUp(): void {
		parent::setUp();

		global $openagenda;
		$this->previous_openagenda = $openagenda;
		$this->had_previous_locale = isset( $_GET['oa-lang'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$this->previous_locale     = $this->had_previous_locale ? $_GET['oa-lang'] : null; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		$events_response = json_decode( file_get_contents( OPENAGENDA_PATH . 'tests/sample-data/events.json' ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Read a local test fixture.

		update_option(
			'openagenda_general_settings',
			array(
				'openagenda_api_key' => 'test-api-key',
			)
		);
		update_option( 'date_format', 'Y-m-d' );
		update_option( 'time_format', 'H:i' );
		update_option( 'timezone_string', 'UTC' );
		update_option( 'gmt_offset', 0 );

		$this->http_callback = openagenda_test_mock_remote_response( wp_json_encode( $events_response ) );

		$openagenda = new \OpenAgenda\OpenAgenda(
			'76126842',
			array(),
			array(
				'context'   => false,
				'use_cache' => false,
			)
		);
	}

	/**
	 * Restore globals and remove the HTTP mock.
	 */
	public function tearDown(): void {
		global $openagenda;
		$openagenda = $this->previous_openagenda;

		if ( $this->had_previous_locale ) {
			$_GET['oa-lang'] = $this->previous_locale; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		} else {
			unset( $_GET['oa-lang'] );
		}

		if ( $this->http_callback ) {
			remove_filter( 'pre_http_request', $this->http_callback );
		}

		parent::tearDown();
	}

	/**
	 * Resolves event fields including localization and nested values.
	 *
	 * @dataProvider event_fields_data_provider
	 *
	 * @param string $field     Field to retrieve.
	 * @param int    $event_uid Event UID to retrieve.
	 * @param string $locale    Requested locale.
	 * @param mixed  $expected  Expected field value or timing fields.
	 */
	public function test_get_field_resolves_event_data( $field, $event_uid, $locale, $expected ) {
		$_GET['oa-lang'] = $locale; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		$value = openagenda_get_field( $field, $event_uid );
		if ( is_array( $expected ) && ! empty( $expected ) ) {
			foreach ( $expected as $key => $expected_value ) {
				$this->assertSame( $expected_value, $value[ $key ] );
			}
		} else {
			$this->assertSame( $expected, $value );
		}
	}

	/**
	 * Provide localized, nested, and derived event field examples.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function event_fields_data_provider() {
		return array(
			'requested translation'      => array(
				'title',
				42639064,
				'fr',
				'Les expositions',
			),
			'fallback translation'       => array(
				'title',
				42639064,
				'de',
				'Les expositions',
			),
			'nested event value'         => array(
				'location.city',
				42639064,
				'en',
				'Paris',
			),
			'normalized keyword list'    => array(
				'keywords-list',
				42639064,
				'fr',
				'Sciences de la vie, Habitat - territoire - transport, Environnement - developpement durable - energies, Mathematiques - physique - chimie, Innovation - recherche - industrie - ingenierie, Médecine, Santé, Sciences cognitives',
			),
			'next timing is formatted'   => array(
				'next-timing',
				42639064,
				'en',
				array(
					'begin'            => '2026-10-29T10:00:00+01:00',
					'end'              => '2026-10-29T18:00:00+01:00',
					'start_date_label' => '2026-10-29',
					'start_time_label' => '09:00',
					'end_date_label'   => '2026-10-29',
					'end_time_label'   => '17:00',
				),
			),
			'last timing is formatted'   => array(
				'last-timing',
				42639064,
				'en',
				array(
					'begin'            => '2027-10-24T10:00:00.000+02:00',
					'end'              => '2027-10-24T19:00:00.000+02:00',
					'start_date_label' => '2027-10-24',
					'start_time_label' => '08:00',
					'end_date_label'   => '2027-10-24',
					'end_time_label'   => '17:00',
				),
			),
			'event timing list is empty' => array(
				'timings',
				42639064,
				'en',
				array(),
			),
			'next timing list is empty'  => array(
				'next-timings',
				42639064,
				'en',
				array(),
			),
		);
	}

	/**
	 * Retrieves the requested image variant and its dimensions.
	 *
	 * @dataProvider event_image_data_provider
	 *
	 * @param string               $size      Image variant.
	 * @param int                  $event_uid Event UID.
	 * @param array<string, mixed> $expected Expected URL and dimensions.
	 */
	public function test_get_event_image_data_selects_variant( $size, $event_uid, $expected ) {
		$this->assertSame( $expected, openagenda_get_event_image_data( $size, $event_uid ) );
	}

	/**
	 * Provide image sizes available in the sample event.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function event_image_data_provider() {
		return array(
			'default image'   => array(
				'',
				42639064,
				array(
					'url'        => 'https://img.openagenda.com/main/4ae92709f4a34050b889398cac5e36f7.base.image.jpg',
					'dimensions' => array(
						'width'  => 700,
						'height' => 467,
					),
				),
			),
			'thumbnail image' => array(
				'thumbnail',
				42639064,
				array(
					'url'        => 'https://img.openagenda.com/main/4ae92709f4a34050b889398cac5e36f7.thumb.image.jpg',
					'dimensions' => array(
						'width'  => 200,
						'height' => 200,
					),
				),
			),
			'full image'      => array(
				'full',
				42639064,
				array(
					'url'        => 'https://img.openagenda.com/main/4ae92709f4a34050b889398cac5e36f7.full.image.jpg',
					'dimensions' => array(
						'width'  => 1080,
						'height' => 721,
					),
				),
			),
		);
	}
}
