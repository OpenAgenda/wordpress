<?php
/**
 * Helper functions
 *
 * @package OpenAgenda
 */

/**
 * Returns the path to a template file.
 * Looks first if the file exists in the `openagenda/` folder in the child theme,
 * then in the parent's theme `openagenda/` folder,
 * finally in the default plugin's template directory
 *
 * @param   string $slug     The template we're looking for.
 * @return  string  $located  The path to the template file if found.
 */
function openagenda_get_template( $slug ) {
	$located              = '';
	$stylesheet_path      = get_stylesheet_directory();
	$template_path        = get_template_directory();
	$template_name        = sanitize_file_name( "{$slug}.php" );
	$use_legacy_templates = openagenda_use_legacy_templates();

	if ( file_exists( $stylesheet_path . '/openagenda/' . $template_name ) ) {
		$located = $stylesheet_path . '/openagenda/' . $template_name;
	} elseif ( file_exists( $template_path . '/openagenda/' . $template_name ) ) {
		$located = $template_path . '/openagenda/' . $template_name;
	} else {
		if ( file_exists( OPENAGENDA_PATH . 'templates/' . $template_name ) ) {
			$located = OPENAGENDA_PATH . 'templates/' . $template_name;
		}
		if ( $use_legacy_templates && file_exists( OPENAGENDA_PATH . 'templates/legacy/' . $template_name ) ) {
			$located = OPENAGENDA_PATH . 'templates/legacy/' . $template_name;
		}
	}

	return str_replace( '..', '', $located );
}


/**
 * Returns whether legacy templates should be used.
 *
 * @return  bool  $use_legacy_templates  Option value.
 */
function openagenda_use_legacy_templates() {
	$settings = get_option( 'openagenda_general_settings' );
	return ! empty( $settings ) && (bool) $settings['openagenda_use_legacy_templates'];
}


/**
 * Returns whether basic styles should be loaded on the front end.
 *
 * @return  bool  $include_styles  Option value.
 */
function openagenda_should_enqueue_styles() {
	$settings = get_option( 'openagenda_general_settings' );
	return ! empty( $settings ) && (bool) $settings['openagenda_include_styles'];
}


/**
 * Gets the correct locale code to parse the event.
 *
 * @return  string  $locale  Locale code used by OpenAgenda
 */
function openagenda_get_locale() {
	global $openagenda;
	$current_locale = get_user_locale();
	$locale         = substr( $current_locale, 0, 2 );

	if ( ! empty( $_GET['oa-lang'] ) ) {
		$locale = sanitize_key( $_GET['oa-lang'] );
	}

	$context = $openagenda->get_context();
	if ( $openagenda && ! empty( $context ) && ! empty( $context['filters'] ) && ! empty( $context['filters']['oa-lang'] ) ) {
		$locale = sanitize_key( $context['filters']['oa-lang'] );
	}

	return apply_filters( 'openagenda_locale', $locale );
}


/**
 * Returns an array of expected image sizes, width dimensions.
 *
 * @return  array  $sizes  Image dimensions, keyed by size name.
 */
function openagenda_image_sizes() {
	$sizes = array(
		'thumbnail' => array(
			'width'  => 200,
			'height' => 200,
		),
		'full'      => array(
			'width'  => '',
			'height' => '',
		),
	);
	return apply_filters( 'openagenda_image_sizes', $sizes );
}


/**
 * Returns the dimensions for a given image size name.
 *
 * @param   string $size        OpenAgenda image size.
 * @return  array   $dimensions  Width and height of the image.
 */
function openagenda_get_image_dimensions( $size = '' ) {
	$sizes = openagenda_image_sizes();

	// Default to full size.
	$dimensions = array(
		'width'  => '',
		'height' => '',
	);

	// Regular size string is passed.
	if ( is_string( $size ) && array_key_exists( $size, $sizes ) ) {
		$dimensions = $sizes[ $size ];
	}

	// If Cloudimage arguments are passed.
	if ( is_array( $size ) ) {
		$dimensions = array(
			'width'  => ! empty( $size['width'] ) ? (int) $size['width'] : '',
			'height' => ! empty( $size['height'] ) ? (int) $size['height'] : '',
		);
	}

	return apply_filters( 'openagenda_image_dimensions', $dimensions, $size );
}


/**
 * Returns the dimensions for a given image size name.
 *
 * @param   string $url             Url to the original image.
 * @param   array  $args            Array of Cloudimage arguments.
 * @return  string  $cloudimage_url
 */
function openagenda_get_cloudimage_image_url( $url, $args ) {
	$settings = get_option( 'openagenda_integrations_settings' );

	$cloudimage_token = $settings['openagenda_cloudimage_api_key'];
	if ( empty( $cloudimage_token ) || ! is_array( $args ) ) {
		return $url;
	}

	$args['org_if_sml'] = 1;
	$cloudimage_url     = add_query_arg( $args, sprintf( 'https://%s.cloudimg.io/v7/%s', $cloudimage_token, $url ) );
	return apply_filters( 'openagenda_cloudimage_url', $cloudimage_url, $args );
}


/**
 * Returns an array of supported i18n fields, to allow for automatic language detection
 *
 * @return  array  Array of i18n fields
 */
function openagenda_i18n_fields() {
	$i18n = array( 'title', 'description', 'longDescription', 'html', 'access', 'range', 'dateRange', 'conditions', 'keywords' );
	return apply_filters( 'openagenda_i18n_fields', $i18n );
}


/**
 * Checks wether a given field is an i18n field.
 *
 * @param   string $field  Field to check.
 * @return  bool            Is the field an i18n field ?
 */
function openagenda_is_i18n_field( $field ) {
	$is_i18n = in_array( $field, openagenda_i18n_fields(), true );
	return apply_filters( 'openagenda_is_i18n_field', $is_i18n, $field );
}


/**
 * Returns a label for a given accessibility code.
 *
 * @param   string $code  Accessibility code.
 * @return  string  $label  Corresponding label.
 */
function openagenda_accessibility_label( $code ) {
	$codes = openagenda_accessibility_codes();
	$label = '';
	if ( array_key_exists( $code, $codes ) ) {
		$label = $codes[ $code ];
	}
	return apply_filters( 'openagenda_accessibility_label', $label, $code );
}


/**
 * Returns a list of accessibility codes and labels.
 *
 * @return  array  $codes  array of $code => $label
 */
function openagenda_accessibility_codes() {
	$codes = array(
		'mi'  => __( 'Accessible to people suffering from motor disabilities.', 'openagenda' ),
		'pi'  => __( 'Accessible to people suffering from mental disabilities.', 'openagenda' ),
		'hi'  => __( 'Accessible to people suffering from hearing impairments.', 'openagenda' ),
		'vi'  => __( 'Accessible to people suffering from visual impairments.', 'openagenda' ),
		'mei' => __( 'Accessible to people suffering from mental disabilities.', 'openagenda' ),
		'ii'  => __( 'Accessible to people suffering from intellectual disabilities.', 'openagenda' ),
	);
	return apply_filters( 'openagenda_accessibility_codes', $codes );
}


/**
 * Returns an array of supported icons
 */
function openagenda_icons() {

	$icons = array(
		'calendar'     => '<svg class="oa-icon oa-icon-calendar" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L64 64C28.7 64 0 92.7 0 128l0 16 0 48L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-256 0-48 0-16c0-35.3-28.7-64-64-64l-40 0 0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L152 64l0-40zM48 192l352 0 0 256c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16l0-256z"/></svg>',
		'clock'        => '<svg class="oa-icon oa-icon-clock" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>',
		'document'     => '<svg class="oa-icon oa-icon-document" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M0 64C0 28.7 28.7 0 64 0L224 0l0 128c0 17.7 14.3 32 32 32l128 0 0 288c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 64zm384 64l-128 0L256 0 384 128z"/></svg>',
		'download'     => '<svg class="oa-icon oa-icon-download" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>',
		'email'        => '<svg class="oa-icon oa-icon-email" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M64 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z"/></svg>',
		'facebook'     => '<svg class="oa-icon oa-icon-facebook" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/></svg>',
		'home'         => '<svg class="oa-icon oa-icon-home" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>',
		'info'  	   => '<svg class="oa-icon oa-icon-info" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>',
		'month'  	   => '<svg class="oa-icon oa-icon-month" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 48L0 160l0-48C0 85.5 21.5 64 48 64l48 0 0-32c0-17.7 14.3-32 32-32zM0 192l448 0 0 272c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 192zm80 64c-8.8 0-16 7.2-16 16l0 64c0 8.8 7.2 16 16 16l288 0c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16L80 256z"/></svg>',
		'link'         => '<svg class="oa-icon oa-icon-link" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z"/></svg>',
		'linkedin'     => '<svg class="oa-icon oa-icon-linkedin" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg>',
		'location'     => '<svg class="oa-icon oa-icon-location" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>',
		'next'         => '<svg class="oa-icon oa-icon-next" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>',
		'phone'        => '<svg class="oa-icon oa-icon-phone" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>',
		'pinned'       => '<svg class="oa-icon oa-icon-pinned" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M32 32C32 14.3 46.3 0 64 0L320 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-29.5 0 11.4 148.2c36.7 19.9 65.7 53.2 79.5 94.7l1 3c3.3 9.8 1.6 20.5-4.4 28.8s-15.7 13.3-26 13.3L32 352c-10.3 0-19.9-4.9-26-13.3s-7.7-19.1-4.4-28.8l1-3c13.8-41.5 42.8-74.8 79.5-94.7L93.5 64 64 64C46.3 64 32 49.7 32 32zM160 384l64 0 0 96c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-96z"/></svg>',
		'previous'     => '<svg class="oa-icon oa-icon-previous" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>',
		'refresh'      => '<svg class="oa-icon oa-icon-refresh" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M142.9 142.9c-17.5 17.5-30.1 38-37.8 59.8c-5.9 16.7-24.2 25.4-40.8 19.5s-25.4-24.2-19.5-40.8C55.6 150.7 73.2 122 97.6 97.6c87.2-87.2 228.3-87.5 315.8-1L455 55c6.9-6.9 17.2-8.9 26.2-5.2s14.8 12.5 14.8 22.2l0 128c0 13.3-10.7 24-24 24l-8.4 0c0 0 0 0 0 0L344 224c-9.7 0-18.5-5.8-22.2-14.8s-1.7-19.3 5.2-26.2l41.1-41.1c-62.6-61.5-163.1-61.2-225.3 1zM16 312c0-13.3 10.7-24 24-24l7.6 0 .7 0L168 288c9.7 0 18.5 5.8 22.2 14.8s1.7 19.3-5.2 26.2l-41.1 41.1c62.6 61.5 163.1 61.2 225.3-1c17.5-17.5 30.1-38 37.8-59.8c5.9-16.7 24.2-25.4 40.8-19.5s25.4 24.2 19.5 40.8c-10.8 30.6-28.4 59.3-52.9 83.8c-87.2 87.2-228.3 87.5-315.8 1L57 457c-6.9 6.9-17.2 8.9-26.2 5.2S16 449.7 16 440l0-119.6 0-.7 0-7.6z"/></svg>',
		'check'        => '<svg class="oa-icon oa-icon-check" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>',
		'square-check' => '<svg class="oa-icon oa-icon-square-check" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M64 80c-8.8 0-16 7.2-16 16l0 320c0 8.8 7.2 16 16 16l320 0c8.8 0 16-7.2 16-16l0-320c0-8.8-7.2-16-16-16L64 80zM0 96C0 60.7 28.7 32 64 32l320 0c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 96zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>',
		'star'         => '<svg class="oa-icon oa-icon-star" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>',
		'star-empty'   => '<svg class="oa-icon oa-icon-star-empty" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"/></svg>',
		'share'        => '<svg class="oa-icon oa-icon-share" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M307 34.8c-11.5 5.1-19 16.6-19 29.2l0 64-112 0C78.8 128 0 206.8 0 304C0 417.3 81.5 467.9 100.2 478.1c2.5 1.4 5.3 1.9 8.1 1.9c10.9 0 19.7-8.9 19.7-19.7c0-7.5-4.3-14.4-9.8-19.5C108.8 431.9 96 414.4 96 384c0-53 43-96 96-96l96 0 0 64c0 12.6 7.4 24.1 19 29.2s25 3 34.4-5.4l160-144c6.7-6.1 10.6-14.7 10.6-23.8s-3.8-17.7-10.6-23.8l-160-144c-9.4-8.5-22.9-10.6-34.4-5.4z"/></svg>',
		'share-nodes'  => '<svg class="oa-icon oa-icon-share-nodes" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M352 224c53 0 96-43 96-96s-43-96-96-96s-96 43-96 96c0 4 .2 8 .7 11.9l-94.1 47C145.4 170.2 121.9 160 96 160c-53 0-96 43-96 96s43 96 96 96c25.9 0 49.4-10.2 66.6-26.9l94.1 47c-.5 3.9-.7 7.8-.7 11.9c0 53 43 96 96 96s96-43 96-96s-43-96-96-96c-25.9 0-49.4 10.2-66.6 26.9l-94.1-47c.5-3.9 .7-7.8 .7-11.9s-.2-8-.7-11.9l94.1-47C302.6 213.8 326.1 224 352 224z"/></svg>',
		'ticket'       => '<svg class="oa-icon oa-icon-ticket" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M64 64C28.7 64 0 92.7 0 128l0 64c0 8.8 7.4 15.7 15.7 18.6C34.5 217.1 48 235 48 256s-13.5 38.9-32.3 45.4C7.4 304.3 0 311.2 0 320l0 64c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-64c0-8.8-7.4-15.7-15.7-18.6C541.5 294.9 528 277 528 256s13.5-38.9 32.3-45.4c8.3-2.9 15.7-9.8 15.7-18.6l0-64c0-35.3-28.7-64-64-64L64 64zm64 112l0 160c0 8.8 7.2 16 16 16l288 0c8.8 0 16-7.2 16-16l0-160c0-8.8-7.2-16-16-16l-288 0c-8.8 0-16 7.2-16 16zM96 160c0-17.7 14.3-32 32-32l320 0c17.7 0 32 14.3 32 32l0 192c0 17.7-14.3 32-32 32l-320 0c-17.7 0-32-14.3-32-32l0-192z"/></svg>',
		'time' 	       => '<svg class="oa-icon oa-icon-time" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>',
		'twitter'      => '<svg class="oa-icon oa-icon-twitter" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.4 151.7c.3 4.5 .3 9.1 .3 13.6 0 138.7-105.6 298.6-298.6 298.6-59.5 0-114.7-17.2-161.1-47.1 8.4 1 16.6 1.3 25.3 1.3 49.1 0 94.2-16.6 130.3-44.8-46.1-1-84.8-31.2-98.1-72.8 6.5 1 13 1.6 19.8 1.6 9.4 0 18.8-1.3 27.6-3.6-48.1-9.7-84.1-52-84.1-103v-1.3c14 7.8 30.2 12.7 47.4 13.3-28.3-18.8-46.8-51-46.8-87.4 0-19.5 5.2-37.4 14.3-53 51.7 63.7 129.3 105.3 216.4 109.8-1.6-7.8-2.6-15.9-2.6-24 0-57.8 46.8-104.9 104.9-104.9 30.2 0 57.5 12.7 76.7 33.1 23.7-4.5 46.5-13.3 66.6-25.3-7.8 24.4-24.4 44.8-46.1 57.8 21.1-2.3 41.6-8.1 60.4-16.2-14.3 20.8-32.2 39.3-52.6 54.3z"/></svg>',
		'website'      => '<svg class="oa-icon oa-icon-website" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352 256c0 22.2-1.2 43.6-3.3 64l-185.3 0c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64l185.3 0c2.2 20.4 3.3 41.8 3.3 64zm28.8-64l123.1 0c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64l-123.1 0c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32l-116.7 0c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0l-176.6 0c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 20.9 58.2 27 94.7zm-209 0L18.6 160C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192l123.1 0c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64L8.1 320C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6l176.6 0c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352l116.7 0zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6l116.7 0z"/></svg>',
		'x'            => '<svg class="oa-icon oa-icon-x" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>',
		'xpost'        => '<svg class="oa-icon oa-icon-xpost" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M80 104a24 24 0 1 0 0-48 24 24 0 1 0 0 48zm80-24c0 32.8-19.7 61-48 73.3l0 38.7c0 17.7 14.3 32 32 32l160 0c17.7 0 32-14.3 32-32l0-38.7C307.7 141 288 112.8 288 80c0-44.2 35.8-80 80-80s80 35.8 80 80c0 32.8-19.7 61-48 73.3l0 38.7c0 53-43 96-96 96l-48 0 0 70.7c28.3 12.3 48 40.5 48 73.3c0 44.2-35.8 80-80 80s-80-35.8-80-80c0-32.8 19.7-61 48-73.3l0-70.7-48 0c-53 0-96-43-96-96l0-38.7C19.7 141 0 112.8 0 80C0 35.8 35.8 0 80 0s80 35.8 80 80zm208 24a24 24 0 1 0 0-48 24 24 0 1 0 0 48zM248 432a24 24 0 1 0 -48 0 24 24 0 1 0 48 0z"/></svg>',
	);

	if ( openagenda_use_legacy_templates() ) {
		$icons = array(
			'document'   => '<svg class="oa-icon oa-icon-document" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M10 1H5c-1.1 0-2 .9-2 2v9c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V4l-3-3zm1.5 11c0 .3-.2.5-.5.5H5c-.3 0-.5-.2-.5-.5V3c0-.3.2-.5.5-.5h3V4c0 1.1.9 2 2 2h1.5v6z"/></g></svg>',
			'download'   => '<svg class="oa-icon oa-icon-download" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M11 7H9V3H7v4H5l3 3 3-3zm-8 4v2h10v-2H3z"/></g></svg>',
			'email'      => '<svg class="oa-icon oa-icon-email" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M12 3H4c-1.1 0-2 .9-2 2v5c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm1 3.2L8 9.1 3 6.2V5l5 2.9L13 5v1.2z"/></g></svg>',
			'facebook'   => '<svg class="oa-icon oa-icon-facebook" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="0" fill="none" width="24" height="24"/><g><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"/></g></svg>',
			'home'       => '<svg class="oa-icon oa-icon-home" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M7.4 3.5l-4 3.2c-.3.2-.4.5-.4.8V13h3.5v-2.5C6.5 9.7 7.2 9 8 9s1.5.7 1.5 1.5V13H13V7.5c0-.3-.1-.6-.4-.8l-4-3.2c-.3-.3-.9-.3-1.2 0z"/></g></svg>',
			'info'       => '<svg class="oa-icon oa-icon-info" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M8 2C4.7 2 2 4.7 2 8s2.7 6 6 6 6-2.7 6-6-2.7-6-6-6zm0 2c.6 0 1 .4 1 1s-.4 1-1 1-1-.4-1-1 .4-1 1-1zm2 8H6v-1h1.2V8h-1V7h2.5v4H10v1z"/></g></svg>',
			'library'    => '<svg class="oa-icon oa-icon-library" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 6l10-6 10 6v2H0V6zm0 12h20v2H0v-2zm2-2h16v2H2v-2zm0-8h4v8H2V8zm6 0h4v8H8V8zm6 0h4v8h-4V8z"/></svg>',
			'link'       => '<svg class="oa-icon oa-icon-link" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M13 4h-3c-1.1 0-2 .9-2 2v.8H7V6c0-1.1-.9-2-2-2H2C.9 4 0 4.9 0 6v3c0 1.1.9 2 2 2h3c1.1 0 2-.9 2-2v-.8h1V9c0 1.1.9 2 2 2h3c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM5.5 9c0 .3-.2.5-.5.5H2c-.3 0-.5-.2-.5-.5V6c0-.3.2-.5.5-.5h3c.3 0 .5.2.5.5v.8H5c-.4 0-.8.3-.8.8s.4.6.8.6h.5V9zm8 0c0 .3-.2.5-.5.5h-3c-.3 0-.5-.2-.5-.5v-.8h.5c.4 0 .8-.3.8-.8s-.4-.6-.8-.6h-.5V6c0-.3.2-.5.5-.5h3c.3 0 .5.2.5.5v3z"/></g></svg>',
			'linkedin'   => '<svg class="oa-icon oa-icon-linkedin" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="0" fill="none" width="24" height="24"/><g><path d="M19.7 3H4.3A1.3 1.3 0 003 4.3v15.4A1.3 1.3 0 004.3 21h15.4a1.3 1.3 0 001.3-1.3V4.3A1.3 1.3 0 0019.7 3zM8.339 18.338H5.667v-8.59h2.672v8.59zM7.004 8.574a1.548 1.548 0 11-.002-3.096 1.548 1.548 0 01.002 3.096zm11.335 9.764H15.67v-4.177c0-.996-.017-2.278-1.387-2.278-1.389 0-1.601 1.086-1.601 2.206v4.249h-2.667v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.779 3.203 4.092v4.711z"/></g></svg>',
			'location'   => '<svg class="oa-icon oa-icon-location" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M11.5 3.5c-2-2-5.1-2-7.1 0s-2 5.1 0 7.1L8 14.1l3.5-3.5c2-2 2-5.2 0-7.1zM9.4 8.4c-.8.8-2 .8-2.8 0-.8-.8-.8-2 0-2.8.8-.8 2-.8 2.8 0 .8.8.8 2 0 2.8z"/></g></svg>',
			'month'      => '<svg class="oa-icon oa-icon-month" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M12 3h-1V2H9v1H7V2H5v1H4c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 7c0 .4-.2.7-.4 1 .2.3.4.6.4 1v.5c0 .8-.7 1.5-1.5 1.5h-1C5.7 11 5 10.3 5 9.5V9h1v.5c0 .3.2.5.5.5h1c.3 0 .5-.2.5-.5V9c0-.3-.2-.5-.5-.5H7v-1h.5c.3 0 .5-.2.5-.5v-.5c0-.3-.2-.5-.5-.5h-1c-.3 0-.5.2-.5.5V7H5v-.5C5 5.7 5.7 5 6.5 5h1C8.3 5 9 5.7 9 6.5V7zm2 4h-1V5h1v6z"/></g></svg>',
			'next'       => '<svg class="oa-icon oa-icon-next" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M3 7h6.6L7.3 4.7l1.4-1.4L13.4 8l-4.7 4.7-1.4-1.4L9.6 9H3"/></g></svg>',
			'phone'      => '<svg class="oa-icon oa-icon-phone" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M10 1H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h4c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zM8.5 14h-1c-.3 0-.5-.2-.5-.5s.2-.5.5-.5h1c.3 0 .5.2.5.5s-.2.5-.5.5zm2.5-2H5V3h6v9z"/></g></svg>',
			'pinned'     => '<svg class="oa-icon oa-icon-pinned" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16" /><g><path d="M12 8c0-.5-.5-1-1-1h-.6l-.3-3c.5-.1.9-.5.9-1s-.5-1-1-1H6c-.5 0-1 .5-1 1s.4.9.9 1l-.3 3H5c-.5 0-1 .5-1 1v1h3v6l2-1V9h3V8z" /></g></svg>',
			'previous'   => '<svg class="oa-icon oa-icon-previous" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M13 7H6.4l2.3-2.3-1.4-1.4L2.6 8l4.7 4.7 1.4-1.4L6.4 9H13"/></g></svg>',
			'refresh'    => '<svg class="oa-icon oa-icon-refresh" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M3.8 3.8C2.7 4.9 2 6.3 2 8c0 3 2.2 5.4 5 5.9v-2.1c-1.7-.4-3-2-3-3.9 0-1.1.5-2.1 1.2-2.8L7 7V2H2l1.8 1.8zM14 8c0-3-2.2-5.4-5-5.9v2.1c1.7.4 3 2 3 3.9 0 1.1-.5 2.1-1.2 2.8L9.1 9.1 9 9v5h5l-1.8-1.8C13.3 11.1 14 9.7 14 8z"/></g></svg>',
			'star'       => '<svg class="oa-icon oa-icon-star" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M8 1.3l2 4.6 5 .5-3.7 3.4 1 4.9L8 12.2l-4.3 2.5 1-4.9L1 6.4l5-.5"/></g></svg>',
			'star-empty' => '<svg class="oa-icon oa-icon-star-empty" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M8 5l.7 1.5.3.8.9.1 1.6.2-1.2 1.1-.7.5.2.8.3 1.6-1.4-.8-.7-.4-.7.4-1.4.8.3-1.6.2-.8-.7-.5-1.2-1.1 1.6-.2.9-.1.4-.8L8 5m0-3.7L6 5.9l-5 .5 3.7 3.3-1 4.9L8 12.2l4.3 2.5-1-4.9L15 6.4l-5-.5-2-4.6z"/></g></svg>',
			'xpost'      => '<svg class="oa-icon oa-icon-xpost" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M13 4c0-1.1-.9-2-2-2s-2 .9-2 2c0 .7.4 1.4 1 1.7V7c0 1.1-.9 2-2 2-.7 0-1.4.2-2 .6V5.7c.6-.3 1-1 1-1.7 0-1.1-.9-2-2-2s-2 .9-2 2c0 .7.4 1.4 1 1.7V14h2v-1c0-1.1.9-2 2-2 2.2 0 4-1.8 4-4V5.7c.6-.3 1-1 1-1.7zm-8-.8c.4 0 .8.3.8.8s-.4.8-.8.8-.8-.4-.8-.8.4-.8.8-.8zm6 1.6c-.4 0-.8-.3-.8-.8s.3-.8.8-.8.8.3.8.8-.4.8-.8.8z"/></g></svg>',
			'time'       => '<svg class="oa-icon oa-icon-time" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M8 2C4.7 2 2 4.7 2 8s2.7 6 6 6 6-2.7 6-6-2.7-6-6-6zm2.5 9.5L7.2 8.3V4h1.5v3.7l2.8 2.8-1 1z"/></g></svg>',
			'twitter'    => '<svg class="oa-icon oa-icon-twitter" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="0" fill="none" width="24" height="24"/><g><path d="M22.23 5.924a8.212 8.212 0 01-2.357.646 4.115 4.115 0 001.804-2.27 8.221 8.221 0 01-2.606.996 4.103 4.103 0 00-6.991 3.742 11.647 11.647 0 01-8.457-4.287 4.087 4.087 0 00-.556 2.063 4.1 4.1 0 001.825 3.415 4.09 4.09 0 01-1.859-.513v.052a4.104 4.104 0 003.292 4.023 4.099 4.099 0 01-1.853.07 4.11 4.11 0 003.833 2.85 8.236 8.236 0 01-5.096 1.756 8.33 8.33 0 01-.979-.057 11.617 11.617 0 006.29 1.843c7.547 0 11.675-6.252 11.675-11.675 0-.178-.004-.355-.012-.531a8.298 8.298 0 002.047-2.123z"/></g></svg>',
			'website'    => '<svg class="oa-icon oa-icon-website" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M8 2C4.7 2 2 4.7 2 8s2.7 6 6 6 6-2.7 6-6-2.7-6-6-6zm3.9 3.8h-1.5c-.1-.7-.2-1.3-.4-1.8.7.3 1.4 1 1.9 1.8zm.6 2.2c0 .3 0 .5-.1.8h-1.9V8v-.8h1.9c.1.3.1.5.1.8zM8 12.5c-.2-.2-.6-.9-.8-2.2h1.6c-.2 1.2-.6 2-.8 2.2zM7 8.8V8v-.8h2v1.6H7zM3.5 8c0-.3 0-.5.1-.8h1.9v1.6H3.6c-.1-.3-.1-.5-.1-.8zM8 3.5c.2.1.6.9.8 2.2H7.2c.2-1.3.6-2.1.8-2.2zm-1.9.4c-.2.6-.3 1.2-.4 1.9H4.1c.5-.8 1.2-1.5 2-1.9zm-2 6.3h1.5c.1.7.2 1.3.4 1.8-.7-.3-1.4-1-1.9-1.8zm5.8 1.9c.2-.5.3-1.1.4-1.8h1.5c-.4.7-1.1 1.4-1.9 1.8z"/></g></svg>',
			'x'          => '<svg class="oa-icon oa-icon-x" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="0" fill="none" width="24" height="24"/><g><path d="M13.982 10.622L20.54 3h-1.554l-5.693 6.618L8.745 3H3.5l6.876 10.007L3.5 21h1.554l6.012-6.989L15.868 21h5.245l-7.131-10.378zm-2.128 2.474l-.697-.997-5.543-7.93H8l4.474 6.4.697.996 5.815 8.318h-2.387l-4.745-6.787z"/></g></svg>',
		);
	}
	return apply_filters( 'openagenda_icons', $icons );
}


/**
 * Echoes or returns an svg icon.
 *
 * @param   string $slug  Slug of the icon to retrieve.
 * @param   bool   $display  Whether to return or echo it.
 * @return  string  $icon  SVG icon.
 */
function openagenda_icon( $slug, $display = true ) {
	$icon  = '';
	$icons = openagenda_icons();
	if ( array_key_exists( $slug, $icons ) ) {
		$icon = $icons[ $slug ];
	}
	$icon = apply_filters( 'openagenda_icon', $icon, $slug );
	if ( $display ) {
		echo $icon;
	}
	return $icon;
}


/**
 * Wrapper for the is_single() method of openagenda global object
 *
 * @return  bool  Whether we're on a single event page or not.
 */
function openagenda_is_single() {
	global $openagenda;
	if ( ! $openagenda ) {
		return false;
	}

	return $openagenda->is_single();
}


/**
 * Wrapper for the is_archive() method of openagenda global object
 *
 * @return  bool  Whether we're on the event list page or not.
 */
function openagenda_is_archive() {
	global $openagenda;
	if ( ! $openagenda ) {
		return false;
	}

	return $openagenda->is_archive();
}


/**
 * Stringifies an associative array to use in a shortcode.
 *
 * @param   array  $attributes  Associative array you wish to turn to shortcode attributes.
 * @param   string $id  Optional ID attribute to add.
 * @return  string  $atts   Converted shortcode attributes.
 */
function openagenda_get_shortcode_attributes( $attributes, $id = '' ) {
	$atts = array();
	if ( ! empty( $id ) ) {
		$atts[] = sprintf( 'id="%s"', esc_attr( $id ) );
	}
	$atts = array_merge(
		$atts,
		array_map(
			function ( $key, $value ) {
				if ( is_array( $value ) ) {
					$value = join( ',', $value );
				}
				return sprintf( '%s="%s"', $key, 'filters' !== $key ? sanitize_text_field( $value ) : $value );
			},
			array_keys( $attributes ),
			array_values( $attributes )
		)
	);
	return join( ' ', $atts );
}


/**
 * Returns the HTML content of the content area.
 *
 * @param   string $view  Accepts 'list' or 'grid'.
 * @param   bool   $with_controls  Whether to display pagination on archive.
 * @return  string  $html  Template HTML.
 */
function openagenda_get_events_html( $view = 'list', $with_controls = true ) {
	global $openagenda;
	if ( ! $openagenda ) {
		return '';
	}

	ob_start();
	$openagenda->reset_index(); // Make sure we're at the start of the loop.
	$template = $openagenda->is_single() ? 'single-event' : 'event';
	$class    = $openagenda->is_single() ? 'oa-event' : sprintf( 'oa-event-%s', sanitize_title( $view ) );
	if ( $openagenda->is_single() ) {
		$with_controls = true;
	}
	include openagenda_get_template( 'event-loop' );
	return ob_get_clean();
}

/**
 * Returns the HTML content of the events loop only.
 *
 * @return  string  $html  Events HTML.
 */
function openagenda_get_events_loop_html() {
	global $openagenda;
	if ( ! $openagenda ) {
		return '';
	}

	ob_start();
	$openagenda->reset_index(); // Make sure we're at the start of the loop.
	$template = $openagenda->is_single() ? 'single-event' : 'event';
	while ( $openagenda->have_events() ) :
		$openagenda->the_event();
		include openagenda_get_template( $template );
	endwhile;
	return ob_get_clean();
}


/**
 * Returns the list header HTML, consisting of a filter widget and total number of events.
 *
 * @param  string $view  'list' or 'grid'.
 * @return  string  $html  HTML.
 */
function openagenda_get_list_header_html( $view = 'list' ) {
	global $openagenda;
	if ( ! $openagenda ) {
		return '';
	}

	ob_start();
	$class = sprintf( 'oa-events-header oa-event-%s-header', sanitize_title( $view ) );
	include openagenda_get_template( 'list-header' );
	return ob_get_clean();
}


/**
 * Returns the AJAX overlay template html
 */
function openagenda_get_update_overlay_html() {
	$html = sprintf(
		'<div class="oa-update-overlay">%s<p>%s</p></div>',
		openagenda_icon( 'refresh', false ),
		__( 'Fetching events... Please wait a moment.', 'openagenda' )
	);
	return apply_filters( 'openagenda_update_overlay_html', $html );
}


/**
 * Returns the AJAX overlay template html
 */
function openagenda_get_update_notice_html() {
	$html = sprintf(
		'<div class="oa-notice oa-notice-error" role="alert"><p>%s</p></div>',
		__( 'There was an error updating the events. Pleaser refresh the page and try again.', 'openagenda' )
	);
	return apply_filters( 'openagenda_update_notice_html', $html );
}


/**
 * Formats a given timing for display
 *
 * @param   array        $timing        Timing from the JSON event data.
 * @param   DateTimeZone $datetimezone  Timezone to use.
 * @return  array         $timing        Timing with additionnal formatted data.
 */
function openagenda_format_timing( $timing, $datetimezone = null ) {
	$start_timestamp = strtotime( $timing['begin'] );
	$end_timestamp   = strtotime( $timing['end'] );

	$timing['start_date_label']  = wp_date( get_option( 'date_format' ), $start_timestamp, $datetimezone );
	$timing['start_time_label']  = wp_date( get_option( 'time_format' ), $start_timestamp, $datetimezone );
	$timing['start_year']        = wp_date( 'Y', $start_timestamp, $datetimezone );
	$timing['start_month']       = wp_date( 'm', $start_timestamp, $datetimezone );
	$timing['start_month_label'] = wp_date( 'F Y', $start_timestamp, $datetimezone );
	$timing['start_week']        = wp_date( 'W', $start_timestamp, $datetimezone );
	$timing['start_week_label']  = wp_date( 'W', $start_timestamp, $datetimezone );
	$timing['start_day']         = wp_date( 'd', $start_timestamp, $datetimezone );
	$timing['start_day_label']   = wp_date( 'l d', $start_timestamp, $datetimezone );
	$timing['end_date_label']    = wp_date( get_option( 'date_format' ), $end_timestamp, $datetimezone );
	$timing['end_time_label']    = wp_date( get_option( 'time_format' ), $end_timestamp, $datetimezone );

	$now                      = time();
	$time_diff                = human_time_diff( $now, strtotime( $timing['begin'] ) );
	$timing['relative_label'] = strtotime( $timing['begin'] ) >= $now
		/* translators: %s : next event relative timing */
		? sprintf( _x( 'In %s', 'next event timing', 'openagenda' ), esc_html( $time_diff ) )
		/* translators: %s : last event relative timing */
		: sprintf( _x( '%s ago', 'last event timing', 'openagenda' ), esc_html( $time_diff ) );

	return $timing;
}


/**
 * Checks whether a given month is nearer in the future than a given reference month
 *
 * @param   string $month  Month to test (format Y-m).
 * @param   string $ref    Reference month.
 * @param   string $today  This month.
 * @return  bool
 */
function openagenda_is_month_nearer( $month, $ref, $today ) {
	if ( ! $ref ) {
		return true;
	}
	if ( $ref < $today ) {
		return $month > $ref;
	}
	if ( $ref > $today ) {
		return ( $month >= $today ) && ( $month < $ref );
	}
	return false;
}


/**
 * Format and group event timings by month and week
 *
 * @param   array $timings  Timings to group.
 * @return  array  $months
 */
function openagenda_group_timings( $timings ) {
	$today         = new DateTime();
	$today_month   = $today->format( 'Y-m' );
	$months        = array();
	$month_cursor  = false;
	$week_cursor   = false;
	$nearest_month = false;

	foreach ( $timings as $timing ) {
		$timing_month_year = $timing['start_year'] . '-' . $timing['start_month'];

		if ( $month_cursor !== $timing_month_year ) {
			$month_cursor            = $timing_month_year;
			$months[ $month_cursor ] = array(
				'label'   => $timing['start_month_label'],
				'nearest' => false,
			);
			if ( openagenda_is_month_nearer( $month_cursor, $nearest_month, $today_month ) ) {
				$nearest_month = $month_cursor;
			}
		}

		if ( $week_cursor !== $timing['start_week'] ) {
			$week_cursor                                      = $timing['start_week'];
			$months[ $month_cursor ]['weeks'][ $week_cursor ] = array(
				'label'   => $timing['start_week_label'],
				'current' => $timing['start_week'] === $today->format( 'W' ),
			);
		}

		$months[ $month_cursor ]['weeks'][ $week_cursor ]['timings'][] = $timing;
	}

	if ( $nearest_month ) {
		$months[ $nearest_month ]['nearest'] = true;
	}
	return $months;
}


/**
 * Reads context from URL or passed string, and returns it.
 *
 * @param   string $context_string  Context data stringified array. Should be base64-encoded.
 * @return  array   $context         Decoded array of context data.
 */
function openagenda_decode_context( $context_string = null ) {
	if ( ! $context_string ) {
		$context_string = isset( $_GET['context'] ) ? $_GET['context'] : false;
	}
	$decoded_context = ! empty( $context_string ) ? base64_decode( $_GET['context'] ) : false;
	$context         = $decoded_context ? json_decode( $decoded_context, true ) : false;
	return $context;
}


/**
 * Encodes the context data into a string.
 *
 * @param   array $context_array    Context data.
 * @return  string  $encoded_context  Bas64 encode.
 */
function openagenda_encode_context( $context_array ) {
	return base64_encode( wp_json_encode( $context_array ) );
}


/**
 * Backups the main openagenda request,
 * in case of alternate request on the main events page
 */
function openagenda_save() {
	global $openagenda, $openagenda_backup;
	if ( $openagenda && ! $openagenda_backup ) {
		$openagenda_backup = $openagenda;
	}
}


/**
 * Restore the original global $openagenda,
 * after alternate request has been treated
 */
function openagenda_reset() {
	global $openagenda, $openagenda_backup;
	if ( $openagenda_backup ) {
		$openagenda        = $openagenda_backup;
		$openagenda_backup = null;
	}
}

/**
 * Clears transient when settings are saved.
 */
function openagenda_clear_transient() {
	global $wpdb;
	$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_oa%'" );
	$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_timeout_oa%'" );
}


/**
 * Parses and returns pre-filters
 *
 * @param   string $post_id  Agenda ID to pre-filter.
 * @param  array  $filters  Filters to apply to initial request.
 * @return  array   $filters  Filters to apply to initial request.
 */
function openagenda_get_pre_filters( $post_id = false, $filters = array() ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$filters_url         = get_post_meta( $post_id, 'oa-calendar-filters', true );
	$exclude_past_events = get_post_meta( $post_id, 'oa-calendar-exclude', true );
	$sort                = get_post_meta( $post_id, 'oa-calendar-sort', true );

	$prefilters = array();

	if ( filter_var( $filters_url, FILTER_VALIDATE_URL ) !== false ) {
		$query = wp_parse_url( urldecode( $filters_url ), PHP_URL_QUERY );
		$query = ! empty( $query ) ? str_replace( 'q.', '', $query ) : '';
		if ( ! empty( $query ) ) {
			parse_str( $query, $prefilters );
		}
	}

	if ( 'yes' === $exclude_past_events ) {
		if ( ! isset( $filters['timings'] ) && ! isset( $filters['relative'] ) ) {
			$prefilters['relative'] = array( 'current', 'upcoming' );
		}
	}

	if ( ! empty( $sort ) && ! isset( $filters['sort'] ) ) {
		$prefilters['sort'] = $sort;
	}

	return apply_filters( 'openagenda_pre_filters', $prefilters, $post_id );
}


/**
 * Retrieves the Event Rich Snippet object
 *
 * @param   string $uid     UID of the event.
 * @return  string  $schema  JSON encoded schema object
 */
function openagenda_get_event_schema( $uid = false ) {
	global $openagenda;
	if ( ! $openagenda ) {
		return array();
	}

	$api_key = $openagenda->get_api_key();
	$client  = new \OpenAgendaSdk\OpenAgendaSdk( $api_key );

	$event     = openagenda_get_event( $uid );
	$permalink = openagenda_event_permalink( $uid, false, false );
	$locale    = openagenda_get_locale();
	$schema    = ! empty( $event ) ? $client->getEventRichSnippet( $event, $permalink, $locale ) : array();
	return apply_filters( 'openagenda_event_schema', $schema, $event );
}


/**
 * Retrieves default calendar post ID
 *
 * @return  $post_id  Default agenda id.
 */
function openagenda_get_default_calendar_id() {
	$args = array(
		'post_type'      => 'oa-calendar',
		'posts_per_page' => 1,
		'fields'         => 'ids',
		'meta_query'     => array(
			array(
				'key'   => '_oa_main_calendar',
				'value' => 1,
			),
		),
	);
	if ( function_exists( 'pll_current_language' ) ) {
		$args['lang'] = sanitize_title( pll_current_language() );
	}
	$post_ids = get_posts( $args );
	$post_id  = ! empty( $post_ids ) ? $post_ids[0] : false;
	return apply_filters( 'openagenda_default_calendar_id', $post_id );
}


/**
 * Retrieves default calendar UID
 *
 * @return  $uid  Default calendar uid.
 */
function openagenda_get_default_calendar_uid() {
	$post_id = openagenda_get_default_calendar_id();
	$uid     = get_post_meta( $post_id, 'oa-calendar-uid', true );
	return apply_filters( 'openagenda_default_calendar_uid', $uid );
}


/**
 * Gets a calendar settings and schema
 *
 * @param   int $post_id  Calendar post id.
 * @return  array  $settings  Calendar settings an schema.
 */
function openagenda_get_calendar_settings( $post_id = null ) {
	global $openagenda;

	if ( ! $openagenda ) {
		return false;
	}

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$settings = array();
	if ( 'oa-calendar' === get_post_type( $post_id ) ) {
		$settings = get_post_meta( $post_id, 'oa-calendar-settings', true );
	}

	if ( empty( $settings ) || $openagenda->is_preview() ) {
		$settings = $openagenda->get_settings();
	}

	return $settings;
}


/**
 * Gets a calendar fields schema
 *
 * @param   string $type   Type of fields you need schema for. Default 'all'.
 * @param   int    $post_id   Calendar post id.
 * @return  array  $schema  Fields schema.
 */
function openagenda_get_calendar_fields_schema( $type = 'all', $post_id = null ) {
	$agenda_settings = openagenda_get_calendar_settings( $post_id );
	$schema          = $agenda_settings['schema']['fields'] ?? array();
	switch ( $type ) {
		case 'standard':
		case 'additional':
			$schema = array_filter(
				$schema,
				function ( $f ) use ( $type ) {
					return 'standard' === $type
					? ! empty( $f['schemaType'] ) && 'event' === $f['schemaType']
					: ! empty( $f['schemaType'] ) && 'event' !== $f['schemaType'];
				}
			);
			$schema = array_values(
				array_filter(
					$schema,
					function ( $f ) {
						return ( empty( $f['type'] ) || 'section' !== $f['type'] ) && ( empty( $f['fieldtype'] ) || 'abstract' !== $f['fieldtype'] );
					}
				)
			);
			break;
	}
	return $schema;
}


/**
 * Gets a single field schema
 *
 * @param   string $field   Field name.
 * @param   int    $post_id   Calendar post id.
 * @return  array  $settings  Calendar settings an schema.
 */
function openagenda_get_field_schema( $field, $post_id = null ) {
	$schema       = openagenda_get_calendar_fields_schema( 'all', $post_id );
	$field_schema = array_values(
		array_filter(
			$schema,
			function ( $f ) use ( $field ) {
				return ! empty( $f['field'] ) && $f['field'] === $field;
			}
		)
	);
	$field_schema = ! empty( $field_schema ) && is_array( $field_schema ) ? $field_schema[0] : array();
	return $field_schema;
}
