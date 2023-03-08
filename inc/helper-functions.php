<?php
/**
 * Helper functions
 *
 * @package Openagenda
 */


/**
 * Returns the path to a template file.
 * Looks first if the file exists in the `open-agenda/` folder in the child theme,
 * then in the parent's theme `open-agenda/` folder,
 * finally in the default plugin's template directory
 *
 * @param   string  $slug     The template we're looking for
 * @return  string  $located  The path to the template file if found.
 */
function openagenda_get_template( $slug ) {
    $located = '';
    
    $template_name = sanitize_file_name( "{$slug}.php" );
    if ( file_exists( STYLESHEETPATH . '/openagenda/' . $template_name ) ) {
        $located = STYLESHEETPATH . '/openagenda/' . $template_name;
    } elseif ( file_exists( TEMPLATEPATH . '/openagenda/' . $template_name ) ) {
        $located = TEMPLATEPATH . '/openagenda/' . $template_name;
    } elseif ( file_exists( OPENAGENDA_PATH . 'templates/' . $template_name ) ) {
        $located = OPENAGENDA_PATH . 'templates/' . $template_name;
    }

    return str_replace( '..', '', $located ) ;
}


/**
 * Returns whether basic styles should be loaded on the front end.
 */
function openagenda_should_enqueue_styles() {
    $settings = get_option( 'openagenda_general_settings' );
    return ! empty( $settings ) && $settings['openagenda_include_styles'];
}


/**
 * Gets the correct locale code to parse the event.
 * 
 * @return  string  $locale  Locale code used by Open Agenda
 */ 
function openagenda_get_locale(){
    global $openagenda;
    $current_locale = get_locale();
    $locale         = substr( $current_locale, 0, 2 );

    if( ! empty( $_GET['oa-lang'] ) ){
        $locale = sanitize_key( $_GET['oa-lang'] );
    }

    if( ! empty( $_POST['query'] ) ){
        $query = json_decode( stripslashes( html_entity_decode( $_POST['query'] ) ), true );
        if( null !== $query && ! empty( $query['oa-lang'] ) ){
            $locale = sanitize_key( $query['oa-lang'] );
        }
    }

    if( ! empty( $context = $openagenda->get_context() ) && ! empty( $context['filters'] ) && ! empty( $context['filters']['oa-lang'] ) ){
        $locale = sanitize_key( $context['filters']['oa-lang'] );
    }
        
    return apply_filters( 'openagenda_locale', $locale );
}


/**
 * Returns an array of expected image sizes, width dimensions.
 * 
 * @return  array  $sizes  Image dimensions, keyed by size name.
 */
function openagenda_image_sizes(){
    $sizes = array(
        'thumbnail' => array(
            'width'  => 200,
            'height' => 200,
        ),
        'full' => array(
            'width'  => '',
            'height' => '',
        ),
    );
    return apply_filters( 'openagenda_image_sizes', $sizes );
}


/**
 * Returns the dimensions for a given image size name.
 * 
 * @param   string  $size        Open Agenda image size.
 * @return  array   $dimensions  Width and height of the image.
 */
function openagenda_get_image_dimensions( $size = '' ){
    $sizes = openagenda_image_sizes();
    
    // Default to full size.
    $dimensions = array(
        'width'  => '',
        'height' => '',
    );

    // Regular size string is passed
    if( is_string( $size ) && array_key_exists( $size, $sizes ) ){
        $dimensions = $sizes[$size];
    }

    // If Cloudimage arguments are passed.
    if( is_array( $size ) ){
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
 * @param   string  $url             Url to the original image.
 * @param   array   $args            Array of Cloudimage arguments.
 * @return  string  $cloudimage_url
 */
function openagenda_get_cloudimage_image_url( $url, $args ){
    $settings = get_option( 'openagenda_integrations_settings' );

    $cloudimage_token = $settings['openagenda_cloudimage_api_key'];
    if( empty( $cloudimage_token ) || ! is_array( $args ) ) return $url;

    $args['org_if_sml'] = 1;
    $cloudimage_url     = add_query_arg( $args, sprintf( 'https://%s.cloudimg.io/v7/%s', $cloudimage_token, $url ) );
    return apply_filters( 'openagenda_cloudimage_url', $cloudimage_url, $args );
}


/**
 * Returns an array of supported i18n fields, to allow for automatic language detection
 * 
 * @return  array  Array of i18n fields
 */
function openagenda_i18n_fields(){
    $i18n = array( 'title', 'description', 'longDescription', 'html', 'access', 'range','dateRange', 'conditions', 'keywords' );
    return apply_filters( 'openagenda_i18n_fields', $i18n );
}


/**
 * Checks wether a given field is an i18n field.
 * 
 * @param   string  $field  Field to check. 
 * @return  bool            Is the field an i18n field ?
 */
function openagenda_is_i18n_field( $field ){
    $is_i18n = in_array( $field, openagenda_i18n_fields() ); 
    return apply_filters( 'openagenda_is_i18n_field', $is_i18n, $field );
}


/**
 * Returns a label for a given accessibility code.
 * 
 * @param   string  $code  Accessibility code
 * @return  string  $label  Corresponding label. 
 */
function openagenda_accessibility_label( $code ){
    $codes = openagenda_accessibility_codes();
    $label = '';
    if( array_key_exists( $code, $codes ) ){
        $label = $codes[$code];
    }
    return apply_filters( 'openagenda_accessibility_label', $label, $code );
}


/**
 * Returns a list of accessibility codes and labels.
 * 
 * @return  array  $codes  array of $code => $label
 */
function openagenda_accessibility_codes(){
    $codes = array( 
        'mi'  => __( 'Accessible to people suffering from motor disabilities.', 'openagenda' ),
        'pi'  => __( 'Accessible to people suffering from mental disabilities.', 'openagenda' ),
        'hi'  => __( 'Accessible to people suffering from hearing impairments.', 'openagenda' ),
        'vi'  => __( 'Accessible to people suffering from visual impairments.', 'openagenda' ),
        'mei' => __( 'Accessible to people suffering from mental disabilities.', 'openagenda' ),
    );
    return apply_filters( 'openagenda_accessibility_codes', $codes );
}


/**
 * Returns an array of supported icons
 */
function openagenda_icons(){
    $icons = array(
        'download' => '<svg class="oa-icon oa-icon-download" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M11 7H9V3H7v4H5l3 3 3-3zm-8 4v2h10v-2H3z"/></g></svg>',
        'email'    => '<svg class="oa-icon oa-icon-email" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M12 3H4c-1.1 0-2 .9-2 2v5c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm1 3.2L8 9.1 3 6.2V5l5 2.9L13 5v1.2z"/></g></svg>',
        'facebook' => '<svg class="oa-icon oa-icon-facebook" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="0" fill="none" width="24" height="24"/><g><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"/></g></svg>',
        'home'     => '<svg class="oa-icon oa-icon-home" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M7.4 3.5l-4 3.2c-.3.2-.4.5-.4.8V13h3.5v-2.5C6.5 9.7 7.2 9 8 9s1.5.7 1.5 1.5V13H13V7.5c0-.3-.1-.6-.4-.8l-4-3.2c-.3-.3-.9-.3-1.2 0z"/></g></svg>',
        'library'  => '<svg class="oa-icon oa-icon-library" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 6l10-6 10 6v2H0V6zm0 12h20v2H0v-2zm2-2h16v2H2v-2zm0-8h4v8H2V8zm6 0h4v8H8V8zm6 0h4v8h-4V8z"/></svg>',
        'link'     => '<svg class="oa-icon oa-icon-link" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M13 4h-3c-1.1 0-2 .9-2 2v.8H7V6c0-1.1-.9-2-2-2H2C.9 4 0 4.9 0 6v3c0 1.1.9 2 2 2h3c1.1 0 2-.9 2-2v-.8h1V9c0 1.1.9 2 2 2h3c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM5.5 9c0 .3-.2.5-.5.5H2c-.3 0-.5-.2-.5-.5V6c0-.3.2-.5.5-.5h3c.3 0 .5.2.5.5v.8H5c-.4 0-.8.3-.8.8s.4.6.8.6h.5V9zm8 0c0 .3-.2.5-.5.5h-3c-.3 0-.5-.2-.5-.5v-.8h.5c.4 0 .8-.3.8-.8s-.4-.6-.8-.6h-.5V6c0-.3.2-.5.5-.5h3c.3 0 .5.2.5.5v3z"/></g></svg>',
        'linkedin' => '<svg class="oa-icon oa-icon-linkedin" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="0" fill="none" width="24" height="24"/><g><path d="M19.7 3H4.3A1.3 1.3 0 003 4.3v15.4A1.3 1.3 0 004.3 21h15.4a1.3 1.3 0 001.3-1.3V4.3A1.3 1.3 0 0019.7 3zM8.339 18.338H5.667v-8.59h2.672v8.59zM7.004 8.574a1.548 1.548 0 11-.002-3.096 1.548 1.548 0 01.002 3.096zm11.335 9.764H15.67v-4.177c0-.996-.017-2.278-1.387-2.278-1.389 0-1.601 1.086-1.601 2.206v4.249h-2.667v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.779 3.203 4.092v4.711z"/></g></svg>',
        'location' => '<svg class="oa-icon oa-icon-location" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M11.5 3.5c-2-2-5.1-2-7.1 0s-2 5.1 0 7.1L8 14.1l3.5-3.5c2-2 2-5.2 0-7.1zM9.4 8.4c-.8.8-2 .8-2.8 0-.8-.8-.8-2 0-2.8.8-.8 2-.8 2.8 0 .8.8.8 2 0 2.8z"/></g></svg>',
        'month'    => '<svg class="oa-icon oa-icon-month" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M12 3h-1V2H9v1H7V2H5v1H4c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 7c0 .4-.2.7-.4 1 .2.3.4.6.4 1v.5c0 .8-.7 1.5-1.5 1.5h-1C5.7 11 5 10.3 5 9.5V9h1v.5c0 .3.2.5.5.5h1c.3 0 .5-.2.5-.5V9c0-.3-.2-.5-.5-.5H7v-1h.5c.3 0 .5-.2.5-.5v-.5c0-.3-.2-.5-.5-.5h-1c-.3 0-.5.2-.5.5V7H5v-.5C5 5.7 5.7 5 6.5 5h1C8.3 5 9 5.7 9 6.5V7zm2 4h-1V5h1v6z"/></g></svg>',
        'next'     => '<svg class="oa-icon oa-icon-next" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M3 7h6.6L7.3 4.7l1.4-1.4L13.4 8l-4.7 4.7-1.4-1.4L9.6 9H3"/></g></svg>',
        'phone'    => '<svg class="oa-icon oa-icon-phone" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M10 1H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h4c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zM8.5 14h-1c-.3 0-.5-.2-.5-.5s.2-.5.5-.5h1c.3 0 .5.2.5.5s-.2.5-.5.5zm2.5-2H5V3h6v9z"/></g></svg>',
        'previous' => '<svg class="oa-icon oa-icon-previous" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M13 7H6.4l2.3-2.3-1.4-1.4L2.6 8l4.7 4.7 1.4-1.4L6.4 9H13"/></g></svg>',
        'refresh'  => '<svg class="oa-icon oa-icon-refresh" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M3.8 3.8C2.7 4.9 2 6.3 2 8c0 3 2.2 5.4 5 5.9v-2.1c-1.7-.4-3-2-3-3.9 0-1.1.5-2.1 1.2-2.8L7 7V2H2l1.8 1.8zM14 8c0-3-2.2-5.4-5-5.9v2.1c1.7.4 3 2 3 3.9 0 1.1-.5 2.1-1.2 2.8L9.1 9.1 9 9v5h5l-1.8-1.8C13.3 11.1 14 9.7 14 8z"/></g></svg>',
        'star'     => '<svg class="oa-icon oa-icon-star" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M8 1.3l2 4.6 5 .5-3.7 3.4 1 4.9L8 12.2l-4.3 2.5 1-4.9L1 6.4l5-.5"/></g></svg>',
        'star-empty' => '<svg class="oa-icon oa-icon-star-empty" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M8 5l.7 1.5.3.8.9.1 1.6.2-1.2 1.1-.7.5.2.8.3 1.6-1.4-.8-.7-.4-.7.4-1.4.8.3-1.6.2-.8-.7-.5-1.2-1.1 1.6-.2.9-.1.4-.8L8 5m0-3.7L6 5.9l-5 .5 3.7 3.3-1 4.9L8 12.2l4.3 2.5-1-4.9L15 6.4l-5-.5-2-4.6z"/></g></svg>',
        'time'     => '<svg class="oa-icon oa-icon-time" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="0" fill="none" width="16" height="16"/><g><path d="M8 2C4.7 2 2 4.7 2 8s2.7 6 6 6 6-2.7 6-6-2.7-6-6-6zm2.5 9.5L7.2 8.3V4h1.5v3.7l2.8 2.8-1 1z"/></g></svg>',
        'twitter'  => '<svg class="oa-icon oa-icon-twitter" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="0" fill="none" width="24" height="24"/><g><path d="M22.23 5.924a8.212 8.212 0 01-2.357.646 4.115 4.115 0 001.804-2.27 8.221 8.221 0 01-2.606.996 4.103 4.103 0 00-6.991 3.742 11.647 11.647 0 01-8.457-4.287 4.087 4.087 0 00-.556 2.063 4.1 4.1 0 001.825 3.415 4.09 4.09 0 01-1.859-.513v.052a4.104 4.104 0 003.292 4.023 4.099 4.099 0 01-1.853.07 4.11 4.11 0 003.833 2.85 8.236 8.236 0 01-5.096 1.756 8.33 8.33 0 01-.979-.057 11.617 11.617 0 006.29 1.843c7.547 0 11.675-6.252 11.675-11.675 0-.178-.004-.355-.012-.531a8.298 8.298 0 002.047-2.123z"/></g></svg>',
    );
    return apply_filters( 'openagenda_icons', $icons );
}


/**
 * Echoes or returns an svg icon.
 * 
 * @param   string  $slug  Slug of the icon to retrieve
 * @param   bool    $echo  Whether to return or echo it
 * @return  string  $icon  SVG icon
 */
function openagenda_icon( $slug, $echo = true ){
    $icon  = '';
    $icons = openagenda_icons();
    if( array_key_exists( $slug, $icons ) ){
        $icon = $icons[$slug];
    }
    $icon = apply_filters( 'openagenda_icon', $icon, $slug );
    if( $echo ) echo $icon;
    return $icon;
}


/**
 * Wrapper for the is_single() method of openagenda global object
 * 
 * @return  bool  Whether we're on a single event page or not.
 */
function openagenda_is_single(){
    global $openagenda;
    return $openagenda->is_single();
}


/**
 * Wrapper for the is_archive() method of openagenda global object
 * 
 * @return  bool  Whether we're on the event list page or not.
 */
function openagenda_is_archive(){
    global $openagenda;
    return $openagenda->is_archive();
}


/**
 * Stringifies an associative array to use in a shortcode.
 * 
 * @param   array   $array  Associative array you wish to turn to shortcode attributes
 * @return  string  $atts   Converted shortcode attributes
 */
function openagenda_get_shortcode_attributes( $array, $id = '' ){
    $atts = array();
    if( ! empty( $id ) ){
        $atts[] = sprintf('id="%s"', esc_attr( $id ) );
    }
    $atts = array_merge( $atts, array_map( function( $key, $value ){
        return sprintf( '%s="%s"', $key, 'filters' !== $key ? sanitize_text_field( $value ) : $value );
    }, array_keys( $array ), array_values( $array ) )) ;
    return join( ' ', $atts );
}


/**
 * Returns the HTML content of the content area.
 * 
 * @return  string  $html  Template HTML.
 */
function openagenda_get_events_html( $view = 'list' ){
    global $openagenda;
    ob_start();
    $openagenda->reset_index(); // Make sure we're at the start of the loop
    $template = $openagenda->is_single() ? 'single-event' : 'event'; 
    $class    = $openagenda->is_single() ? 'oa-event' : sprintf( 'oa-event-%s', sanitize_title( $view ) );
    include openagenda_get_template( 'event-loop' );
    return ob_get_clean();
}


/**
 * Returns the list header HTML, consisting of a filter widget and total number of events
 */
function openagenda_get_list_header_html( $view = 'list' ){
    global $openagenda;
    ob_start();
    $class = sprintf( 'oa-event-%s-header', sanitize_title( $view ) );
    include openagenda_get_template( 'list-header' );
    return ob_get_clean();
}


/**
 * Returns the AJAX overlay template html
 */
function openagenda_get_update_overlay_html(){
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
function openagenda_get_update_notice_html(){
    $html = sprintf( 
        '<div class="oa-notice oa-notice-error" role="alert"><p>%s</p></div>',
        __( 'There was an error updating the events. Pleaser refresh the page and try again.', 'openagenda' )
    );
    return apply_filters( 'openagenda_update_notice_html', $html );
}


/**
 * Formats a given timing for display
 * 
 * @param   array         $timing        Timing from the JSON event data
 * @param   DateTimeZone  $datetimezone  Timezone to use
 * @return  array         $timing        Timing with additionnal formatted data  
 */
function openagenda_format_timing( $timing, $datetimezone = null ){
    $start_timestamp = strtotime( $timing['begin'] );
    $end_timestamp   = strtotime( $timing['end'] );

    $timing['start_date_label'] = wp_date( get_option( 'date_format' ), $start_timestamp, $datetimezone ) ;
    $timing['start_time_label'] = wp_date( get_option( 'time_format' ), $start_timestamp, $datetimezone ) ;
    $timing['start_year']       = wp_date( 'Y', $start_timestamp, $datetimezone ) ;
    $timing['start_month']      = wp_date( 'm', $start_timestamp, $datetimezone ) ;
    $timing['start_month_label']= wp_date( 'F Y', $start_timestamp, $datetimezone ) ;
    $timing['start_week']       = wp_date( 'W', $start_timestamp, $datetimezone ) ;
    $timing['start_week_label'] = wp_date( 'W', $start_timestamp, $datetimezone ) ;
    $timing['start_day']        = wp_date( 'd', $start_timestamp, $datetimezone ) ;
    $timing['start_day_label']  = wp_date( 'l d', $start_timestamp, $datetimezone ) ;
    $timing['end_date_label']   = wp_date( get_option( 'date_format' ), $end_timestamp, $datetimezone ) ;
    $timing['end_time_label']   = wp_date( get_option( 'time_format' ), $end_timestamp, $datetimezone ) ;

    $now       = time();
    $time_diff = human_time_diff( $now, strtotime( $timing['begin'] ) );
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
 * @param   string  $month  Month to test (format Y-m)
 * @param   string  $ref    Reference month
 * @param   string  $today  This month.
 * @return  bool  
 */
function openagenda_is_month_nearer( $month, $ref, $today ){
    if ( ! $ref ) return true;
    if ( $ref < $today ) return $month > $ref;
    if ( $ref > $today ) return ( $month >= $today ) && ( $month < $ref ) ;
    return false;
}


/**
 * Format and group event timings by month and week
 * 
 * @param   array  $timings  Timings to group.
 * @return  array  $months
 */
function openagenda_group_timings( $timings ){
    $today         = new DateTime();
	$today_month   = $today->format( 'Y-m' );
    $months        = array();
    $month_cursor  = false;
    $week_cursor   = false;
    $nearest_month = false;

    foreach ( $timings as $timing ) {
        $timing_month_year = $timing['start_year'] . '-' . $timing['start_month'];

        if ( $month_cursor !== $timing_month_year ) {
            $month_cursor = $timing_month_year;
            $months[$month_cursor] = array(
                'label'   => $timing['start_month_label'],
                'nearest' => false
            );
            if ( openagenda_is_month_nearer( $month_cursor, $nearest_month, $today_month ) ) $nearest_month = $month_cursor;
        }

        if( $week_cursor !== $timing['start_week'] ){
            $week_cursor = $timing['start_week'];
            $months[$month_cursor]['weeks'][$week_cursor] = array(
                'label'   => $timing['start_week_label'],
                'current' => $timing['start_week'] === $today->format( 'W' ),
            );
        }

        $months[$month_cursor]['weeks'][$week_cursor]['timings'][] = $timing;
    }

    if ( $nearest_month ) $months[$nearest_month]['nearest'] = true;
    return $months;
}


/**
 * Reads context from URL or passed string, and returns it.
 * 
 * @param   string  $context_string  Context data stringified array. Should be base64-encoded.
 * @return  array   $context         Decoded array of context data.
 */
function openagenda_decode_context( $context_string = null ){
    if( ! $context_string ){
        $context_string = isset( $_GET['context'] ) ? $_GET['context'] : false;
    }
    $decoded_context = ! empty( $context_string ) ? base64_decode( $_GET['context'] ) : false;
    $context         = $decoded_context ? json_decode( $decoded_context, true ) : false;
    return $context;
}


/**
 * Encodes the context data into a string.
 * 
 * @param   array   $context_array    Context data
 * @return  string  $encoded_context  Bas64 encode
 */
function openagenda_encode_context( $context_array ){
    return base64_encode( json_encode( $context_array ) );
}


/**
 * Backups the main openagenda request, 
 * in case of alternate request on the main events page 
 */
function openagenda_save(){
    global $openagenda, $openagenda_backup;
    if( $openagenda && ! $openagenda_backup ){
        $openagenda_backup = $openagenda;
    }
}


/**
 * Restore the original global $openagenda,
 * after alternate request has been treated
 */
function openagenda_reset(){
    global $openagenda, $openagenda_backup;
    if( $openagenda_backup ){
        $openagenda        = $openagenda_backup;
        $openagenda_backup = null;
    }
}

/**
 * Clears transient when settings are saved.
 */
function openagenda_clear_transient(){
    global $wpdb;
    $wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_oa%'" );
    $wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_timeout_oa%'" );
}


/**
 * Parses and returns pre-filters
 * 
 * @param   string  $agenda_uid  Agenda UID to pre-filter
 * @return  array   $filters     Filters to apply to initial request
 */
function openagenda_get_pre_filters( $agenda_uid = false, $filters = [] ){
    if( ! $agenda_uid ) $agenda_uid = get_the_ID();
    $filters_url         = get_post_meta( $agenda_uid, 'oa-calendar-filters', true );
    $exclude_past_events = get_post_meta( $agenda_uid, 'oa-calendar-exclude', true );

    $prefilters = array();
    
    if ( filter_var( $filters_url, FILTER_VALIDATE_URL ) !== false ) {
        $query = parse_url( urldecode( $filters_url ), PHP_URL_QUERY );
        $query = str_replace( 'q.', '', $query );
        if( ! empty( $query ) ) parse_str( $query, $prefilters );
    }

    if( 'yes' === $exclude_past_events ){
        if( ! isset( $filters['timings'] ) && ! isset( $filters['relative'] ) ){
            $prefilters['relative'] = ['current', 'upcoming'];
        }
    }

    return apply_filters( 'openagenda_pre_filters', $prefilters, $agenda_uid );
}


/**
 * Temporary fix for older installs.
 */
if( ! function_exists( 'wp_date' ) ){
    function wp_date( $format, $timestamp = null, $timezone = null ) {
        global $wp_locale;
        
        if ( null === $timestamp ) {
            $timestamp = time();
        } elseif ( ! is_numeric( $timestamp ) ) {
            return false;
        }
        
        if ( ! $timezone ) {
            $timezone = new DateTimeZone( wp_timezone_string() );
        }
        
        $datetime = date_create( '@' . $timestamp );
        $datetime->setTimezone( $timezone );
        
        if ( empty( $wp_locale->month ) || empty( $wp_locale->weekday ) ) {
            $date = $datetime->format( $format );
        } else {
            // We need to unpack shorthand `r` format because it has parts that might be localized.
            $format = preg_replace( '/(?<!\\\\)r/', DATE_RFC2822, $format );
        
            $new_format    = '';
            $format_length = strlen( $format );
            $month         = $wp_locale->get_month( $datetime->format( 'm' ) );
            $weekday       = $wp_locale->get_weekday( $datetime->format( 'w' ) );
        
            for ( $i = 0; $i < $format_length; $i ++ ) {
                switch ( $format[ $i ] ) {
                    case 'D':
                        $new_format .= addcslashes( $wp_locale->get_weekday_abbrev( $weekday ), '\\A..Za..z' );
                        break;
                    case 'F':
                        $new_format .= addcslashes( $month, '\\A..Za..z' );
                        break;
                    case 'l':
                        $new_format .= addcslashes( $weekday, '\\A..Za..z' );
                        break;
                    case 'M':
                        $new_format .= addcslashes( $wp_locale->get_month_abbrev( $month ), '\\A..Za..z' );
                        break;
                    case 'a':
                        $new_format .= addcslashes( $wp_locale->get_meridiem( $datetime->format( 'a' ) ), '\\A..Za..z' );
                        break;
                    case 'A':
                        $new_format .= addcslashes( $wp_locale->get_meridiem( $datetime->format( 'A' ) ), '\\A..Za..z' );
                        break;
                    case '\\':
                        $new_format .= $format[ $i ];
        
                        // If character follows a slash, we add it without translating.
                        if ( $i < $format_length ) {
                            $new_format .= $format[ ++$i ];
                        }
                        break;
                    default:
                        $new_format .= $format[ $i ];
                        break;
                }
            }
        
            $date = $datetime->format( $new_format );
            $date = wp_maybe_decline_date( $date, $format );
        }
        
        /**
         * Filters the date formatted based on the locale.
         *
         * @since 5.3.0
         *
         * @param string       $date      Formatted date string.
         * @param string       $format    Format to display the date.
         * @param int          $timestamp Unix timestamp.
         * @param DateTimeZone $timezone  Timezone.
         */
        $date = apply_filters( 'wp_date', $date, $format, $timestamp, $timezone );
        
        return $date;
    }  
}


if ( ! function_exists( 'wp_timezone_string' )){
    function wp_timezone_string() {
        $timezone_string = get_option( 'timezone_string' );
     
        if ( $timezone_string ) {
            return $timezone_string;
        }
     
        $offset  = (float) get_option( 'gmt_offset' );
        $hours   = (int) $offset;
        $minutes = ( $offset - $hours );
     
        $sign      = ( $offset < 0 ) ? '-' : '+';
        $abs_hour  = abs( $hours );
        $abs_mins  = abs( $minutes * 60 );
        $tz_offset = sprintf( '%s%02d:%02d', $sign, $abs_hour, $abs_mins );
     
        return $tz_offset;
    }
}