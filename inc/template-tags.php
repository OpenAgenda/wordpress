<?php
/**
 * Template tags to display events information
 *
 * @package Openagenda
 */


/**
 * Returns an event, given a uid.
 * Gets the event from the ones already loaded in the  $openagenda global.
 * Defaults to the current event in the loop
 * 
 * @param  int  $uid  Uid of the event to look for.  
 */
function openagenda_get_event( $uid = false ){
    global $openagenda;
    // Default to current event in the loop.
    $event = $openagenda->get_current_event();

    if( (int) $uid ){
        $events = $openagenda->get_events();
        $events = array_values( array_filter( $events, function( $item ) use ( $uid ) {
            return $uid === $item['uid'];
        }));
        if( ! empty( $events ) ){
            $event = $events[0];
        }
    }

    return $event;
}


/**
 * Returns an event field value.
 * 
 * @param   string  $field  Slug of the field to fetch
 * @param   string  $uid    UID of the event to fetch field for. Defaults to current event.
 * @return  string  $value  Field value 
 */
function openagenda_get_field( $field, $uid = false ){
    global $openagenda;
    $event = openagenda_get_event( $uid );
    if( ! $event ) return false;
    if( ! $uid ) $uid = $event['uid'];
    
    $locale = openagenda_get_locale();
    $value  = '';
    switch ( $field ) {
        case 'permalink':
            $calendar_permalink = openagenda_get_permalink();
            $slug  = sanitize_text_field( $event['slug'] );
            $value = ! empty( get_option( 'permalink_structure' ) ) ? trailingslashit( $calendar_permalink ) . $slug : add_query_arg( 'oa-slug', urlencode( $slug ), $calendar_permalink );            
            break;
        case 'timings':
        case 'next-timings':
        case 'next-timing':
        case 'last-timing':
            $timezone     = ! empty( $event['location'] ) && ! empty( $event['location']['timezone'] ) ? $event['location']['timezone'] : null;
            $datetimezone = $timezone ? new DateTimeZone( $timezone ) : null;
            $timings      = ! empty( $event['timings'] ) ? $event['timings'] : array();
            $next_timing  = ! empty( $event['nextTiming'] ) ? $event['nextTiming'] : ''; 
            $last_timing  = ! empty( $event['lastTiming'] ) ? $event['lastTiming'] : '';
            $today        = date_create( 'today midnight', $datetimezone )->format( 'c' );

            if( 'last-timing' === $field ){
                $value = ! empty( $last_timing ) ? openagenda_format_timing( $last_timing ): array();
                if( empty( $value ) && ! empty( $timings ) ){
                    $value = openagenda_format_timing( $timings[count( $timings ) - 1], $datetimezone );
                }
                break;
            }

            if( 'timings' === $field ){
                $value = array_map( function( $timing ) use ( $datetimezone ) {
                    return openagenda_format_timing( $timing, $datetimezone );
                }, $timings );
                break;
            }

            // If we're working with next timings, filter the timings array.
            $next_timings = array_values( array_filter( $timings, function( $timing ) use( $next_timing, $today ) {
                if( ! empty( $next_timing ) ){
                    return $timing['begin'] >= $next_timing['begin']; 
                }
                return $timing['begin'] >= $today; 
            } ) );
            
            if( 'next-timing' === $field ){
                $value = ! empty( $next_timing ) ? openagenda_format_timing( $next_timing ): array();
                if( empty( $value ) && ! empty( $next_timings ) ){
                    $value = openagenda_format_timing( $next_timings[0], $datetimezone );
                }
                break;
            }

            if( 'next-timings' === $field ){
                $value = array_map( function( $timing ) use ( $datetimezone ) {
                    return openagenda_format_timing( $timing, $datetimezone );
                }, $next_timings );
                break;
            }
            break;
        case 'range':
            return openagenda_get_field( 'dateRange' );
            break;
        default:
            $end_value = array_reduce( explode( '.', $field ), function( $array, $field ) use ( $locale ) {
                if( openagenda_is_i18n_field( $field ) && isset( $array[$field] ) && is_array( $array[$field] ) ){
                    return openagenda_maybe_parse_field( $field, openagenda_get_i18n_value( $array[$field] ) );
                }
                return ! empty( $array[$field] ) ? $array[$field] : ''; 
            }, $event );
            $value = ! empty( $end_value ) ? $end_value : '';
            break;
    }

    return apply_filters( 'openagenda_field', $value, $field, $uid );
}


/**
 *  Escapes and echoes a field
 * 
 * @param   string  $field  Slug of the field to fetch
 * @param   string  $uid    UID of the event to fetch field for. Defaults to current event.
 */
function openagenda_field( $field, $uid = false ){
    $value = openagenda_get_field( $field, $uid );
    if( ! empty( $value ) ){
        echo openagenda_esc_field( $value, $field );
    }
}


/**
 * Escapes a field value to safely display it.
 * 
 * @param  mixed   $value  Value to escape  
 * @param  string  $field  Field key to provide context  
 */
function openagenda_esc_field( $value, $field ){
    global $openagenda;    
    switch ( $field ) {
        case 'permalink':
            $value = esc_url( $value );
            break;
        case 'uid':
            $value = esc_attr( $value );
            break;
        case 'title':
        case 'description':
        case 'longDescription':
            $value = wp_kses_post( $value );
            break;
        case 'html': 
            if ( ! $openagenda->include_embedded() ) {
                $value = wp_kses_post( $value );
            }
            break;
        default:
            $value = esc_html( $value );
            break;
    }
    return $value;
}


/**
 * Maybe parse markdown field if needed
 * 
 * @param   string  $field  Field key
 * @param   string  $value  Field value to maybe parse.
 * @return  string  $value  Parsed value
 */
function openagenda_maybe_parse_field( $field, $value ){
    global $openagenda;
    if( 'longDescription' === $field ){
        $format = $openagenda->get_longDescription_format();
        if( 'markdown' === $format ){
            $Parsedown = new Parsedown();
            $value = $Parsedown->text($value);
        }
    }
    return $value;
}


/**
 * Returns the value corresponding to the locale
 * 
 * @param   array   $i18n_field  Array of locale => label
 * @return  string  $value       Value corresponding to the current locale, or first available value, or empty.
 */
function openagenda_get_i18n_value( $i18n_field ){
    $locale = openagenda_get_locale();
    $value  = '';
    
    if( is_string( $i18n_field ) ) $value = $i18n_field;
    if( is_array( $i18n_field ) ){
        if( array_key_exists( $locale, $i18n_field ) ){
            $value = ! empty( $i18n_field[$locale] ) ? $i18n_field[$locale] : '';
        } else {
            $value = ! empty( $i18n_field['en'] ) ? $i18n_field['en'] : array_values( $i18n_field )[0];
        }
    }

    return $value;
}


/**
 * Returns the permalink to the current event, with or without context
 * 
 * @param   string  $uid          Uid of the event.
 * @param   bool    $echo         Whether to display url or not
 * @param   bool    $use_context  Whether to append context to link or not
 * @return  string  $permalink
 */
function openagenda_event_permalink( $uid = false, $echo = true, $use_context = true ){
    global $openagenda;

    $permalink = openagenda_get_field( 'permalink', $uid );
    if( $openagenda->is_archive() && $openagenda->use_context() && $use_context ){
        $context = $openagenda->get_context();
        $context['event_offset'] = $openagenda->get_event_offset();
        $encoded_context = openagenda_encode_context( $context );
        $permalink = add_query_arg( 'context', $encoded_context, $permalink ); 
    }

    $permalink = apply_filters( 'openagenda_event_permalink', $permalink, $uid, $use_context );
    if( $echo ) echo openagenda_esc_field( $permalink, 'permalink' );
    return $permalink;
}


/**
 * Retrieves the current event thumbnail HTML
 * 
 * @param   string  $size  Size slug for the image
 * @param   string  $uid   UID of the event to get image from.
 * @return  string  $html  The corresponding <img> tag
 */
function openagenda_get_event_image( $size = '', $uid = false ){
    
    $html       = '';
    $image_data = openagenda_get_event_image_data( $size, $uid );
    $image_url  = ! empty( $image_data['url'] ) ? $image_data['url'] : '';
    $dimensions = ! empty( $image_data['dimensions'] ) ? $image_data['dimensions'] : array();
    
    if( $image_url ){
        $width      = ! empty( $dimensions['width'] ) ? sprintf( 'width="%s"', esc_attr( $dimensions['width'] ) )  : '';
        $height     = ! empty( $dimensions['height'] ) ? sprintf( 'height="%s"', esc_attr( $dimensions['height'] ) )  : '';
        $html = sprintf( 
            '<img src="%s" %s %s alt="%s" />', 
            esc_url( $image_url ),
            $width,
            $height,
            esc_attr( openagenda_get_field( 'title', $uid ) )
        );
    }

    $html = apply_filters( 'openagenda_event_image', $html, $uid, $size );
    return $html;
}


/**
 * Retrieves the current event image url and dimensions
 * 
 * @param   string  $size  Size slug for the image
 * @param   string  $uid   UID of the event to get image from.
 * @return  string  $html  The corresponding <img> tag
 */
function openagenda_get_event_image_data( $size = '', $uid = false ){
    $event      = openagenda_get_event( $uid );
    $image_url  = '';
    $dimensions = openagenda_get_image_dimensions( $size );
    
    if( ! empty( $event['image'] ) ){
        $filename   = $event['image']['filename'];
        $dimensions = ! empty( $event['image']['size'] ) ? $event['image']['size'] : array();
        if( ! empty( $size ) && is_string( $size ) && ! empty( $event['image']['variants'] ) ){
            $variant = array_values( array_filter( $event['image']['variants'], function( $variant ) use ( $size ) { return $size === $variant['type']; } ) );
            if( ! empty( $variant ) ) {
                $filename   = $variant[0]['filename'];
                $dimensions = $variant[0]['size'];
            }
        }
        $image_url = trailingslashit( $event['image']['base'] ) . $filename;
    }

    if( is_array( $size ) ){
        // If an array was passed, that means a resize has been asked to CloudImage
        $image_url  = openagenda_get_cloudimage_image_url( $image_url, $size );
        $dimensions = openagenda_get_image_dimensions( $size );
    }

    $data = array(
        'url'        => $image_url,
        'dimensions' => $dimensions
    ); 

    return apply_filters( 'openagenda_event_image_data', $data, $uid, $size );
}


/**
 * Displays an event image
 * 
 * @param   string  $size  Size slug for the image
 * @param   string  $uid   UID of the event to get image from.
 */
function openagenda_event_image( $size = '', $uid = '' ){
    $image = openagenda_get_event_image( $size, $uid );
    echo wp_kses_post( $image );
}


/**
 * Displays next and last timings for a event.
 * 
 * @param  string  $display   Accepts 'relative' or 'date'.
 * @param  string  $uid       UID of the event to get image from.
 * @param  bool    $echo      Whether to echo or just return the html
 */
function openagenda_event_timing( $display = 'date', $uid = false, $echo = true ){
    global $openagenda;
    $event = openagenda_get_event( $uid );
    if( ! $uid ) $uid = $event['uid'];

    $next_timing = openagenda_get_field( 'next-timing', $uid );
    $last_timing = openagenda_get_field( 'last-timing', $uid );

    $html = '';
    switch ( $display ) {
        case 'relative':
            if( ! empty( $next_timing ) ){
                $html = sprintf( '<span class="oa-timing oa-next-timing">%s</span>', esc_html( $next_timing['relative_label'] ) );
            } elseif ( ! empty( $last_timing ) ) {
                $html = sprintf( '<span class="oa-timing oa-last-timing">%s</span>', esc_html( $last_timing['relative_label'] ) );
            } else {
                $html = sprintf( '<span class="oa-timing oa-no-timing">%s</span>', esc_html( __( 'No timing available', 'openagenda' ) ) );
            }
            break;
        default:
            $timing = ! empty( $next_timing ) ? $next_timing : $last_timing;
            if( ! empty( $timing ) ){
                $html = sprintf( 
                    '<span class="oa-timing">
                        %s
                        <span class="oa-timing-date">%s</span>
                        <span class="oa-timing-seperator"> | </span> 
                        <span class="oa-timing-times">
                            <span class="oa-timing-start-time">%s</span>
                            <span class="oa-timing-seperator">-</span> 
                            <span class="oa-timing-end-time">%s</span>
                        </span>
                    </span>',
                    openagenda_icon( 'month', false ),
                    esc_html( $timing['start_date_label'] ),
                    esc_html( $timing['start_time_label'] ),
                    esc_html( $timing['end_time_label'] )
                );
            }
            break;
    }

    $html = apply_filters( 'openagenda_event_timing', $html, $uid, $display );
    if ( $echo ) echo wp_kses_post( $html );
    return $html;
}


/**
 * Displays a list of event timings
 * 
 * @param  string  $uid   UID of the event.
 * @param  bool    $echo  Whether to echo or just return the html
 */
function openagenda_event_timings( $uid = false, $echo = true ){
    global $openagenda;
    $event = openagenda_get_event( $uid );
    if( ! $uid ) $uid = $event['uid'];

    $timings = openagenda_get_field( 'timings', $uid );
    $months  = openagenda_group_timings( $timings );

    $html = '';
    if( $timings ){
        $html .= '<ul class="oa-months">';
        foreach ( $months as $number => $month ) {
            $class = true === $month['nearest'] ? 'oa-current' : 'oa-hidden';
            $html .= sprintf( 
                '<li class="oa-month %s">
                    <div class="oa-month-header">
                        <button class="oa-button oa-button-previous">%s<span class="oa-sr-text">%s</span></button>
                        <span class="oa-month-label">%s</span>
                        <button class="oa-button oa-button-next">%s<span class="oa-sr-text">%s</span></button>
                    </div>',
                $class,
                openagenda_icon( 'previous', false ),
                esc_html( __( 'View previous month', 'openagenda' ) ),
                esc_html( $month['label'] ),
                openagenda_icon( 'next', false ),
                esc_html( __( 'View next month', 'openagenda' ) )
            );
            foreach( $month['weeks'] as $week ){
                $html .= '<ul class="oa-week">';
                foreach( $week['timings'] as $timing ){
                    $html .= sprintf(
                        '<li class="oa-timing">
                            <span class="oa-timing-date">%s</span>
                            <span class="oa-timing-times">
                            <span class="oa-timing-start-time">%s</span>
                            <span class="oa-timing-seperator">-</span> 
                            <span class="oa-timing-end-time">%s</span>
                            </span>
                        </li>',
                        esc_html( $timing['start_day_label'] ),
                        esc_html( $timing['start_time_label'] ),
                        esc_html( $timing['end_time_label'] )
                    );
                }
                $html .= '</ul>';
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
    }

    $html = apply_filters( 'openagenda_event_timings', $html, $uid, $months );

    if ( $echo ) {
        echo $html;
        wp_enqueue_script( 'oa-timings' );
    } 
    return $html;
}


/**
 * Returns the HTML content of the events total in the list header.
 * 
 * @return  string  $html  Template HTML.
 */
function openagenda_get_events_total_html( $echo = true ){
    global $openagenda;
    $total  = (int) $openagenda->get_total();
    $args   = $openagenda->get_args();
    $passed = ! empty( $args['oaq'] ) && ! empty( $args['oaq']['passed'] ) && $args['oaq']['passed'];
    
    /* translators: %d: number of upcoming events */
    $events_total = $total > 0 ? sprintf( _n( '%d upcoming event.', '%d upcoming events.', $total, 'openagenda' ), (int) $total ) : __( 'No upcoming event.', 'openagenda' );
    if( $passed ){
        /* translators: %d: number of passed events */
        $events_total = $total > 0 ? sprintf( _n( '%d passed event.', '%d passed events.', $total, 'openagenda' ), (int) $total ) : __( 'No passed event.', 'openagenda' );
    }
    
    $html = sprintf( '<p class="oa-events-total">%s</p>', esc_html( $events_total ) );
    $html = apply_filters( 'openagenda_events_total_html', $html );
    if ( $echo ) echo $html;
    return $html;
}


/**
 * Displays a map for a single event.
 * 
 * @param  string  $uid   UID of the event to get image from.
 * @param  bool    $echo  Whether to echo or just return the html
 */
function openagenda_event_map( $uid = false, $echo = true ){
    global $openagenda;
    $event = openagenda_get_event( $uid );
    if( ! $uid ) $uid = $event['uid'];

    $settings  = get_option( 'openagenda_integrations_settings' );
    
    $latitude    = openagenda_get_field( 'location.latitude', $uid );
    $longitude   = openagenda_get_field( 'location.longitude', $uid );
    $tiles       = ! empty( $settings['openagenda_map_tiles_link'] ) ? $settings['openagenda_map_tiles_link'] : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    $attribution = ! empty( $settings['openagenda_map_tiles_attribution_link'] ) ? $settings['openagenda_map_tiles_attribution_link'] : sprintf( '<a href="%s">%s</a>', 'https://www.openstreetmap.org/copyright', __( 'OpenStreetMap contributors', 'openagenda' ) );

    $html = sprintf( 
        '<div id="event-map" class="event-map" latitude="%s" longitude="%s" tiles="%s" attribution="%s"></div>',
        esc_attr( $latitude ),
        esc_attr( $longitude ),
        esc_attr( $tiles ),
        esc_attr( $attribution )
    );

    $html = apply_filters( 'openagenda_event_map_html', $html, $uid );

    if ( $echo ){
        echo $html;
        wp_enqueue_style( 'oa-leaflet' );
        wp_enqueue_script( 'oa-event-map' );
    }
    return $html;
}


/**
 * Displays or returns share buttons
 * 
 * @param  string  $uid   UID of the event.
 * @param  bool    $echo  Whether to echo or just return the html
 */
function openagenda_event_share_buttons( $uid = false, $echo = true ){
    global $openagenda;
    $event = openagenda_get_event( $uid );
    if( ! $uid ) $uid = $event['uid'];

    $event_permalink = openagenda_get_field( 'permalink', $uid );

    $sharers = array(
        'facebook' => array(
            'label' => __( 'Share on Facebook', 'openagenda' ),
            'icon'  => openagenda_icon( 'facebook', false ),
            'url'   => add_query_arg( 'u', urlencode( $event_permalink ), 'https://facebook.com/sharer.php' ),
        ),
        'twitter' => array(
            'label' => __( 'Share on Twitter', 'openagenda' ),
            'icon'  => openagenda_icon( 'twitter', false ),
            'url'   => add_query_arg( array(
                'url'  => urlencode( $event_permalink ),
                'text' => urlencode( openagenda_get_field( 'title', $uid ) ),
            ), 'https://twitter.com/share' ),
        ),
        'linkedin' => array(
            'label' => __( 'Share on Linkedin', 'openagenda' ),
            'icon'  => openagenda_icon( 'linkedin', false ),
            'url'   => add_query_arg( array(
                'url'     => urlencode( $event_permalink ),
                'title'   => urlencode( openagenda_get_field( 'title', $uid ) ),
                'summary' => urlencode( openagenda_get_field( 'description', $uid ) ),
                'source'  => urlencode( get_permalink() ),
            ), 'https://linkedin.com/shareArticle' ),
        ),
    );

    $sharers = apply_filters( 'openagenda_sharers', $sharers, $uid, $event );

    $html = '';
    if( ! empty( $sharers ) ){
        $links = '';
        foreach ( $sharers as $id => $sharer ) {
            $links .= sprintf( 
                '<li><a role="button" class="oa-sharer-button oa-sharer-%s" href="%s" rel="noopener noreferrer" target="_blank">%s<span class="oa-sharer-label oa-sr-text">%s</span></a></li>',
                sanitize_html_class( $id ),
                esc_url( $sharer['url'] ),
                $sharer['icon'],
                esc_html( $sharer['label'] )
            );
        }
        $html = sprintf(
            '<div class="oa-sharers">
                <span class="oa-sharers-label">%s</span>
                <ul class="oa-sharers-links">%s</ul>
            </div>',
            esc_html__( 'Share :', 'openagenda' ), 
            $links 
        );
    }

    $html = apply_filters( 'openagenda_sharers_html', $html, $uid, $event );
    if ( $echo ) echo $html;
    return $html;
}


/**
 * Displays a list of registration methods for the event
 * 
 * @param  string  $uid   UID of the event.
 * @param  bool    $echo  Whether to echo or just return the html
 */
function openagenda_event_registration_methods( $uid = false, $echo = true ){
    global $openagenda;
    $event = openagenda_get_event( $uid );
    if( ! $uid ) $uid = $event['uid'];

    $methods = openagenda_get_field( 'registration', $uid );
    $html    = '';

    if( $methods && is_array( $methods ) ) {
        $items = array_map( function( $method ){
            switch ( $method['type'] ) {
                case 'link':
                    $icon   = openagenda_icon( 'link', false );
                    $prefix = '';
                    $value  = esc_url( $method['value'] );
                    break;
                case 'email':
                    $icon   = openagenda_icon( 'email', false );
                    $prefix = 'mailto://';
                    $value  = sanitize_email( $method['value'] );
                    break;
                case 'phone':
                    $icon   = openagenda_icon( 'phone', false );
                    $prefix = '';
                    $value  = sanitize_text_field( $method['value'] );
                    break;
                default:
                    $icon   = '';
                    $prefix = '';
                    $value  = sanitize_text_field( $method['value'] );
                    break;
            }
            $href  = sprintf( '%s%s', sanitize_text_field( $prefix ), $value );
            $item  = sprintf( 
                '<li class="oa-registration-method"><span class="oa-registration-method-wrapper">%s<a href="%s" class="oa-registration-method-label">%s</a></span></li>',
                $icon,
                esc_url( $href ),
                esc_html( $method['value'] )
            );
            return $item;
        }, $methods );

        $html = sprintf( '<ul class="oa-registration-methods">%s</ul>', join( '', $items )  );
    } 
    
    $html = apply_filters( 'openagenda_event_registration_methods', $html, $uid );
    if ( $echo ) echo $html;
    return $html;
}

/**
 * Displays the attendance mode of the event, as well as a link if online
 * 
 * @param  string  $uid   UID of the event.
 * @param  bool    $echo  Whether to echo or just return the html
 */
function openagenda_event_attendance_mode( $uid = false, $echo = true ){
    global $openagenda;
    $event = openagenda_get_event( $uid );
    if( ! $uid ) $uid = $event['uid'];

    $attendance_mode = openagenda_get_field( 'attendanceMode', $uid );
    $access_url      = openagenda_get_field( 'onlineAccessLink', $uid );
    $locale          = openagenda_get_locale();
    $default_labels  = apply_filters( 'openagenda_attendance_mode_labels', array(
        1 => __( 'On site', 'openagenda' ),
        2 => __( 'Online', 'openagenda' ),
        3 => __( 'Mixed', 'openagenda' ),
    ) );

    if( is_array( $attendance_mode ) ){
        $labels = ! empty( $attendance_mode['label'] ) ? $attendance_mode['label'] : array();
        $label  = openagenda_get_i18n_value( $labels );
    } else {
        $label = array_key_exists( $attendance_mode, $default_labels ) ? $default_labels[$attendance_mode] : $default_labels[1];
    }

    $link  = ! empty( $access_url ) ? sprintf( '<span class="oa-seperator">|</span><a href="%s" target="_blank" rel="noopener">%s</a>', esc_url( $access_url ), esc_html__( 'Access the event', 'openagenda' ) ) : '';
    $html  = sprintf( '%s%s', esc_html( $label ), $link );
    $html  = apply_filters( 'openagenda_event_attendance_mode', $html, $uid );
    if ( $echo ) echo $html;
    return $html;
}


/**
 * Displays or return an event additional field links
 * 
 * @param  string  $field  Additional field to display
 * @param  string  $uid   UID of the event.
 * @param  bool    $echo  Whether to echo or just return the html
 */
function openagenda_event_additional_field( $field, $uid = false, $echo = true ){
    global $openagenda;
    $event = openagenda_get_event( $uid );
    if( ! $uid ) $uid = $event['uid'];

    $values = openagenda_get_field( $field, $uid );
    // If we have a single value and not an array of values, make it an array
    if( isset( $values['id'] ) ) $values = array( $values );
    
    $links  = array();
    foreach ( $values as $value ) {
        $id     = ! empty( $value['id'] ) ? (int) $value['id'] : 0;
        $labels = ! empty( $value['label'] ) ? $value['label'] : array();
        $label  = openagenda_get_i18n_value( $labels );
        if( $id && $label ){
            $links[] = sprintf( '<a href="%s">%s</a>', add_query_arg( sanitize_title( $field ), $id, openagenda_get_permalink() ), $label );
        }
    }

    $html = ! empty( $links ) ? join( ', ', $links ) : '';
    $html = apply_filters( 'openagenda_event_additional_field', $html, $field, $uid );
    if ( $echo ) echo $html;
    return $html;
}


/**
 * Displays pagination on single calendar pages.
 * 
 * @param  array  $args  Array of arguments passed to openagenda_get_page_links()
 */
function openagenda_pagination( $args = array() ){
    $pages = openagenda_get_page_links( $args );
    if( ! empty( $pages ) ) : ?>
        <?php if( ! empty( $args['title'] ) ): ?>
            <h2 class="oa-pagination"><?php echo esc_html( $args['title'] ); ?></h2>
        <?php endif; ?>
        <ul class="oa-pagination">
            <?php foreach ( $pages as $link ) : ?>
                <li class="oa-page">
                    <?php 
                        if( $link['url'] ) {
                            $classes = $link['active'] ? 'oa-page-link active' : 'oa-page-link';
                            $aria    = $link['active'] ? 'aria-current="page"' : '';
                            if( $link['active'] ) {
                                printf( '<span class="%s" %s >%s</span>', esc_attr( $classes ), $aria, esc_html( $link['label'] ) );
                            } else {
                                printf( '<a href="%s" class="%s" %s >%s</a>', esc_url( $link['url'] ), esc_attr( $classes ), $aria, esc_html( $link['label'] )  );
                            }
                        } else {
                            printf( '<span class="oa-dots">%s</span>', esc_html( $link['label'] ) );
                        }
                    ?>
                </li>      
            <?php endforeach; ?>
        </ul>
    <?php endif;
}


/**
 * Returns an array of page links.
 * 
 * @param   array  $args   Array of arguments
 * @return  array  $links  Array of page links arays with 'label' and 'url' keys 
 */
function openagenda_get_page_links( $args = array() ){
    global $openagenda;
    $total_pages  =  $openagenda->get_total_pages();
    $current_page =  $openagenda->get_current_page();

    if( 1 == $total_pages ){
        return false;
    }

    $args = wp_parse_args( $args, array(
        'end_size'     => 2,
        'mid_size'     => 2,
        'label_format' => '%s',
        'prev_label'   => __( 'Previous page', 'openagenda' ),
        'next_label'   => __( 'Next page', 'openagenda' ),
    ) );

    $args = apply_filters( 'openagenda_page_links_args', $args, $openagenda->get_uid() );

    $links = array();
    $dots  = false;

    if( $current_page > 1 ){
        $links[] = array(
            'label'  => $args['prev_label'],
            'url'    => openagenda_get_page_permalink( $current_page - 1 ),
            'active' => false
        );
    }        

    for ( $i = 1 ; $i <= $total_pages; $i++ ) {
        if ( $i <= $args['end_size'] || ( $current_page - $args['mid_size'] ) <= $i && $i <= ( $current_page + $args['mid_size'] ) || $i > ( $total_pages - $args['end_size'] ) ){
            $links[] = array(
                'label'  => sprintf( $args['label_format'], $i ),
                'url'    => openagenda_get_page_permalink( $i ),
                'active' => $current_page === $i,
            );
            $dots = true;
        } else {
            if( $dots ){
                $links[] = array(
                    'label'  => '...',
                    'url'    => false,
                    'active' => false
                );
                $dots = false;
            }  
        }   
    }

    if( $current_page < $total_pages ){
        $links[] = array(
            'label'  => $args['next_label'],
            'url'    => openagenda_get_page_permalink( $current_page + 1 ),
            'active' => false
        );
    }

    return apply_filters( 'openagenda_page_links', $links, $openagenda->get_uid() );
}


/**
 * Returns the url to a given events page.
 * 
 * @param   int     $page       Page to get link for.
 * @return  string  $permalink  Permalink to the page
 */
function openagenda_get_page_permalink( $page = 1, $filters = null ){
    global $openagenda;    
    
    if( ! empty( get_option( 'permalink_structure' ) ) ){
        $permalink = sprintf( '%spage/%d', trailingslashit( openagenda_get_permalink() ), (int) $page );
    } else {
        $permalink = add_query_arg( 'oa-page', (int) $page, openagenda_get_permalink() );
    }

    if( 1 === $page ){
        $permalink = openagenda_get_permalink();
    }

    if( null === $filters && ! empty( $openagenda->get_filters() ) ){
        $filters = $openagenda->get_filters();
    }
    
    if( ! empty( $filters ) ){
        $permalink = add_query_arg( $filters, $permalink );
    }

    return apply_filters( 'openagenda_page_permalink', $permalink,  $openagenda->get_uid(), $page );
}


/**
 * Returns a calendar permalink. Defaults to current calendar.
 * 
 * @param   string  $uid        UID of calendar to get permalink for.
 * @return  string  $permalink
 */
function openagenda_get_permalink( $uid = false ){
    global $openagenda;
    $permalink = false;

    if( $openagenda && ! $uid ) $uid = $openagenda->get_uid();
    if( 'oa-calendar' === get_post_type() && ! $openagenda->is_preview() ) $permalink = get_permalink();
    
    if( ! $permalink && $uid ) {
        $posts = get_posts( array(
            'post_type'   => 'oa-calendar',
            'meta_key'    => 'oa-calendar-uid',
            'meta_value'  => sanitize_text_field( $uid ),
            'numberposts' => 1,
            'fields'      => 'ids',
        ) );
        if( ! empty( $posts ) ){
            $post_id   = $posts[0];
            $permalink = get_permalink( $post_id );
        }
    }        
    return apply_filters( 'openagenda_permalink', $permalink, $uid );
}


/**
 * Displays exports links
 * 
 * @param  string  $uid   UID of the calendar.
 * @param  bool    $echo  Whether to echo or just return the html
 */
function openagenda_exports( $uid = false, $echo = true ) {
    global $openagenda;
    if( ! $uid ) $uid = $openagenda->get_uid();

    $formats = $openagenda->get_exports_formats();
    $html    = '';
    if ( $openagenda->is_archive() && ! empty( $formats ) ) {
        $links = '';
        foreach ( $formats as $extension => $label ) {
            $class = sprintf( 'oa-%s-export-button', esc_attr( $extension ) ); 
            $links .= sprintf( 
                '<li><a role="button" class="oa-button oa-export-button %s" href="%s">%s<span>%s</span></a></li>',
                esc_attr( $class ),
                esc_url( $openagenda->get_request_url( $extension ) ),
                openagenda_icon( 'download', false ),
                esc_html( $label )
            );
        }
        if( ! empty( $links ) ){
            $html .= sprintf( 
                '<div class="oa-exports">
                    <span class="oa-exports-label">%s</span>
                    <ul class="oa-exports-links">%s</ul>
                </div>', 
                apply_filters( 'openagenda_exports_label', esc_html__( 'Download :', 'openagenda' ) ), 
                $links
            );
        }    
    }

    $html = apply_filters( 'openagenda_exports_html', $html, $uid );
    if ( $echo ) echo $html;
    return $html;
}


/**
 * Displays a filter widget
 * 
 * @param  string  $filter  Filter to display.
 * @param  array   $args    Array of arguments to pass to the filter
 * @param  bool    $echo    Whether to display or return HTML.
 */
function openagenda_filter( $filter, $args = array(), $echo = true ){
    $atts = openagenda_get_shortcode_attributes( $args );
    $html = do_shortcode( sprintf( '[openagenda_filter_%s %s]', sanitize_key( $filter ), $atts ) );
    if( $echo ) echo $html;
    return $html;
}


/**
 * Displays navigation between events on single events page
 */
function openagenda_navigation( $echo = true ){
    global $openagenda;
    if( ! $openagenda->is_single() ) return;
        
    $previous_link = openagenda_get_previous_event_link();
    $next_link     = openagenda_get_next_event_link();
    $back_link     = openagenda_get_back_link();

    if( ! $previous_link && ! $next_link ){
        return;
    }

    $html = sprintf( 
        '<nav class="oa-event-navigation">%s%s%s</nav>',
        $previous_link,
        $back_link,
        $next_link
    );

    $html = apply_filters( 'openagenda_event_navigation', $html, $previous_link, $next_link );
    if ( $echo ) echo $html;
    return $html;
}


/**
 * Returns a link to an adjacent event, if any
 * 
 * @param   string  $direction  'next' or 'previous'
 * @return  string  $html        Link html  
 */
function openagenda_get_adjacent_event_link( $direction = 'next', $uid = false ){
    global $openagenda;
    $event = openagenda_get_event( $uid );
    if( ! $uid ) $uid = $event['uid'];
    if( ! $openagenda->is_single() ) return false;
    
    $encoded_context = isset( $_GET['context'] ) ? $_GET['context'] : false;
    $context         = openagenda_decode_context( $encoded_context );

    $html    = '';
    if( $context ){
        $total           = ! empty( $context['total'] ) ? (int) $context['total'] : 0;
        $event_offset    = ! empty( $context['event_offset'] ) ? (int) $context['event_offset'] : 0;
        $invalid         = 'next' === $direction ? (bool) ( ( $event_offset + 1 ) >= $total ) : (bool) ( $event_offset <= 0 ) ;

        $url = add_query_arg( array(
            'action'    => 'get_adjacent_event',
            'nonce'     => wp_create_nonce( 'get_adjacent_event' ),
            'uid'       => $openagenda->get_uid(),
            'direction' => 'next' === $direction ? 'next' : 'previous',
            'context'   => $encoded_context,
        ), admin_url( 'admin-post.php' ) );

        $next_label     = sprintf( '<span>%s</span>%s', esc_html_x( 'Next event', 'event navigation', 'openagenda' ), openagenda_icon( 'next', false ) );
        $previous_label = sprintf( '%s<span>%s</span>', openagenda_icon( 'previous', false ), esc_html_x( 'Previous event', 'event navigation', 'openagenda' ) );

        if( $invalid ){
            $html = sprintf( 
                '<span class="oa-nav-link oa-%1$s-link oa-nav-link-disabled">%2$s</span>',
                esc_attr( $direction ),
                'previous' === $direction ? $previous_label : $next_label
            );
        } else {
            $html = sprintf( 
                '<a class="oa-nav-link oa-%1$s-link" href="%2$s">%3$s</a>',
                esc_attr( $direction ),
                esc_url( $url ),
                'previous' === $direction ? $previous_label : $next_label
            );
        }
    }

    $html = apply_filters( 'openagenda_adjacent_event_link', $html, $uid, $direction );
    return $html;
}

/**
 * Returns a 'Back to list' button on single events pages.
 */
function openagenda_get_back_link(){
    global $openagenda;
    $context = openagenda_decode_context();
    
    $html      = '';
    $page_link = '';
    $page      = 1;
    
    if( $context ){
        $filters = ! empty( $context['filters'] ) ? $context['filters'] : array();
        $params  = ! empty( $context['params'] ) ? $context['params'] : array();
        $size    = ! empty( $params['size'] ) ? (int) $params['size'] : $openagenda->get_size();
        $total   = ! empty( $context['total'] ) ? (int) $context['total'] : 0;
        $page    = ! empty( $context['page'] ) ? (int) $context['page'] : 1;
        $event_offset = ! empty( $context['event_offset'] ) ? (int) $context['event_offset'] : 0;
        $event_number = $event_offset + 1;

        $page_link = openagenda_get_page_permalink( $page, $filters );
        if( $page_link ){
            $html = sprintf( 
                '<a class="oa-nav-link oa-back-link" href="%s">%s<span>%d / %d</span></a>',
                esc_url( $page_link ),
                openagenda_icon( 'home', false ),
                (int) $event_number,
                (int) $total
            );
        }
    }

    $html = apply_filters( 'openagenda_back_link', $html, $page_link, $page, $context );
    return $html;
}


/**
 * Returns previous event link
 */
function openagenda_get_previous_event_link(){
    return openagenda_get_adjacent_event_link( 'previous' );
}


/**
 * Returns next event link
 */
function openagenda_get_next_event_link(){
    return openagenda_get_adjacent_event_link( 'next' );
}


/**
 * Displays a favorite badge to add to favorites
 * 
 * @param  string  $uid   UID of the event.
 * @param  bool    $echo  Whether to echo or just return the html
 */
function openagenda_favorite_badge( $uid = false, $echo = true ){
    global $openagenda;
    $agenda_uid = $openagenda->get_uid();
    $event      = openagenda_get_event( $uid );
    if( ! $event ) return false;
    if( ! $uid ) $uid = $event['uid'];

    $params = array(
        'name'      => 'favorite',
        'eventUid'  => $uid,
        'agendaUid' => $agenda_uid,
    );

    $icon_active   = openagenda_icon( 'star', false );
    $icon_inactive = openagenda_icon( 'star-empty', false );
    /* translators: %s: event title */ 
    $text = sprintf( __( 'Add %s to favorites.', 'openagenda' ), openagenda_get_field( 'title', $uid ) );

    $html = sprintf( 
        '<button class="oa-event-favorite-badge" data-oa-widget="%s" data-oa-widget-params="%s">
            <span class="screen-reader-text">%s</span>
            <span class="active-icon">%s</span>
            <span class="inactive-icon">%s</span>
        </button>',
        esc_attr( 'favorite-' . $uid ),
        esc_attr( json_encode( $params ) ),
        esc_html( $text ),
        $icon_active,
        $icon_inactive
    );

    $html = apply_filters( 'openagenda_event_favorite_badge', $html, $uid, $agenda_uid, $icon_active, $icon_inactive, $text );
    if( $echo ) echo $html;
    return $html;
}


/**
 * Displays the language switcher
 * 
 * @param   string  $uid   UID of the event or agenda, depending on page type.
 * @param   bool    $echo  Whether to echo or just return the html
 * @return  string  $html  Language switcher HTML
 */
function openagenda_language_switcher( $uid = false, $echo = true ){
    global $openagenda;
     
    if( openagenda_is_single() ){
        $event = openagenda_get_event( $uid );
        if( ! $event ) return false;
        if( ! $uid ) $uid = $event['uid'];
        $base_url      = openagenda_event_permalink( $uid, false, false );
        $all_languages = array_unique( array_keys( $event['title'] ) );
    } else {
        if( ! $uid ) $uid = $openagenda->get_uid();
        $base_url      = openagenda_get_permalink();
        $all_languages = get_post_meta( get_the_ID(), 'oa-calendar-languages', true );
        if( ! empty( $filters = $openagenda->get_filters() ) ){
            $base_url = add_query_arg( $filters, $base_url );
        }
    }

    $all_languages  = apply_filters( 'openagenda_switcher_languages', $all_languages, $uid );
    $current_locale = openagenda_get_locale();
    $html = '';
    if( ! empty( $all_languages ) ){
        $links = '';
        foreach ( $all_languages as $lang ) {
            $url    = add_query_arg( 'oa-lang', sanitize_key( $lang ), $base_url );
            $links .= sprintf( '<li class="oa-language-link %s"><a hreflang="%s" href="%s">%s</a></li>', $lang === $current_locale ? 'active' : '', esc_attr( $lang ), esc_url( $url ), esc_html( $lang ) );
        }
        $html = sprintf( '<div class="oa-language-switcher"><ul class="oa-languages">%s</ul></div>', $links );
    }

    $html = apply_filters( 'openagenda_language_switcher', $html, $uid );
    if( $echo ) echo $html;
    return $html;
}


/**
 * Retrieves the Event Rich Snippet object
 * 
 * @param   string  $uid     UID of the event.
 * @return  string  $schema  JSON encoded schema object
 */
function openagenda_get_event_schema( $uid = false ){
    $event       = openagenda_get_event( $uid );
    $permalink   = openagenda_event_permalink( $uid, false, false );
    $image_data  = openagenda_get_event_image_data( '', $uid );
    $image_url   = ! empty( $image_data['url'] ) ? $image_data['url'] : '';
    $next_timing = openagenda_get_field( 'next-timing', $uid );
    $duration    = date_diff(date_create( $next_timing['end'] ), date_create( $next_timing['begin']) , true );
    $schema      = array(
        '@id'         => $permalink,
        '@context'    => 'https://schema.org',
        '@type'       => 'Event',
        'name'        => openagenda_get_field( 'title', $uid ),
        'description' => openagenda_get_field( 'description', $uid ),
        'url'         => $permalink,
        'image'       => $image_url,
        'startDate'   => $next_timing['begin'],
        'endDate'     => $next_timing['end'],
        'duration'    => $duration->format('c'),
    //   eventAttendanceMode: getEventAttendanceMode(event.attendanceMode),
    //   eventStatus: getEventStatus(event.status),
    );
    return json_encode( $schema );
}


/**
 * Displays the Copy to Clipboard modal
 */
function openagenda_share_modal(){
    ?>
    <div class="modal fade" id="share" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Intégrer cette sélection dans votre site</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                <input class="js_share form-control" type="text" value="" disabled/>
                <button data-copy-share data-copy-label="Copier" data-copied-label="Copié!" data-copied-class="btn btn-success" data-copy-class="btn btn-outline-secondary" type="button"></button>
                </div>
            </div>
            </div>
        </div>
    </div>
    <?php
}