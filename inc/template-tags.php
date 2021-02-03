<?php
/**
 * Template tags to display events information
 *
 * @package Open_Agenda
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
    if( ! $uid ) $uid = $event['uid'];
    
    $locale = openagenda_get_locale();
    $value  = '';
    switch ( $field ) {
        case 'thumbnail':
        case 'image':
            $value = openagenda_get_event_image( $uid, $field );
            break;
        case 'permalink':
            $calendar_permalink = openagenda_get_permalink();
            $slug  = sanitize_title( $event['slug'] );
            $value = ! empty( get_option( 'permalink_structure' ) ) ? trailingslashit( $calendar_permalink ) . $slug : add_query_arg( 'oa-slug', urlencode( $slug ), $calendar_permalink );            
            break;
        case 'timings':
        case 'next-timings':
        case 'next-timing':
        case 'last-timing':
            $timezone     = ! empty( $event['location'] ) && ! empty( $event['location']['timezone'] ) ? $event['location']['timezone'] : null;
            $datetimezone = $timezone ? new DateTimeZone( $timezone ) : null;
            $timings      = ! empty( $event['timings'] ) ? $event['timings'] : array();
            
            if( 'last-timing' === $field ){
                $value = ! empty( $timings ) ? openagenda_format_timing( $timings[count( $timings ) - 1], $datetimezone ) : array();
                break;
            }

            if( 'timings' === $field ){
                $value = array_map( function( $timing ) use ( $datetimezone ) {
                    return openagenda_format_timing( $timing, $datetimezone );
                }, $timings );
                break;
            }

            // If we're working with next timings, filter the timings array.
            $next_timings = array_values( array_filter( $timings, function( $timing ) {
                return strtotime( $timing['start'] ) >= time(); 
            } ) );

            if( 'next-timing' === $field ){
                $value = ! empty( $next_timings ) ? openagenda_format_timing( $next_timings[0], $datetimezone ) : array();
                break;
            }

            if( 'next-timings' === $field ){
                $value = array_map( function( $timing ) use ( $datetimezone ) {
                    return openagenda_format_timing( $timing, $datetimezone );
                }, $next_timings );;
                break;
            }
            break;
        default:
            $end_value = array_reduce( explode( '.', $field ), function( $array, $field ) use ( $locale ) {
                if( openagenda_is_i18n_field( $field ) && is_array( $array[$field] ) ){
                    if( array_key_exists( $locale, $array[$field] ) ){
                        return ! empty( $array[$field][$locale] ) ? $array[$field][$locale] : '';
                    } else {
                        return ! empty( array_values( $array[$field] )[0] ) ? array_values( $array[$field] )[0] : '';
                    }
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
 * Returns the permalink to the current event, with or without context
 */
function openagenda_event_permalink( $use_context = false, $uid = false, $echo = true ){
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
 * Retrieves or displays the current event thumbnail
 * 
 * @param   string  $size  Size slug for the image
 * @param   string  $uid   UID of the event to get image from.
 * @return  string  $html  The corresponding <img> tag
 */
function openagenda_get_event_image( $size = 'thumbnail', $uid = '' ){
    $event = openagenda_get_event( $uid );
    $html  = '';

    if( $image_url  = ! empty( $event[$size] ) ? $event[$size] : false ){
        $dimensions = openagenda_get_image_dimensions( $size );
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
 * Displays an event image
 * 
 * @param   string  $size  Size slug for the image
 * @param   string  $uid   UID of the event to get image from.
 */
function openagenda_event_image( $size = 'thumbnail', $uid = '' ){
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
                $html = sprintf( '<span class="oa-timing oa-no-timing">%s</span>', esc_html( __( 'No timing avilable', 'openagenda' ) ) );
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
            $class = true === $month['current'] ? 'oa-current' : 'oa-hidden';
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
 * Displays a map for a single event.
 * 
 * @param  string  $uid   UID of the event to get image from.
 * @param  bool    $echo  Whether to echo or just return the html
 */
function openagenda_event_map( $uid = false, $echo = true ){
    global $openagenda;
    $event = openagenda_get_event( $uid );
    if( ! $uid ) $uid = $event['uid'];

    $settings  = get_option('openagenda_general_settings');
    
    $latitude    = openagenda_get_field( 'location.latitude', $uid );
    $longitude   = openagenda_get_field( 'location.longitude', $uid );
    $tiles       = ! empty( $settings['openagenda_map_tiles_link'] ) ? $settings['openagenda_map_tiles_link'] : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    $attribution = ! empty( $settings['openagenda_map_tiles_attribution_link'] ) ? $settings['openagenda_map_tiles_attribution_link'] : sprintf( '<a href="%s">%s</a>', 'https://www.openstreetmap.org/copyright', __( 'OpenStreetMap contributors', 'open_agenda' ) );

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

    return apply_filters( 'openagenda_page_links', $links,  $openagenda->get_uid() );
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
        $permalink = add_query_arg( 'oaq', $filters, $permalink );
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

    if ( $openagenda && ! $uid ) $uid = $openagenda->get_uid();
    
    if( is_singular( 'oa-calendar' ) ) {
        $permalink = get_permalink();
    }
    
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
                esc_html__( 'Download :', 'openagenda' ), 
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
 * @param  $args  Array of arguments to pass to the filter
 */
function openagenda_filter( $filter, $args = array() ){
    $atts = openagenda_get_shortcode_attributes( $args );
    echo do_shortcode( sprintf( '[openagenda_filter_%s %s]', sanitize_key( $filter ), $atts ) );
}


/**
 * Displays navigation between events on single events page
 */
function open_agenda_navigation( $echo = true ){
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
    
    $encoded_context = isset( $_GET['context'] ) ? sanitize_text_field( $_GET['context'] ) : false ;
    $context = openagenda_decode_context();
    $total   = $context && isset( $context['total'] ) ? (int) $context['total'] : 0;
    $event_offset = $context && isset( $context['event_offset'] ) ? (int) $context['event_offset'] : 0;

    $html = '';
    $invalid = 'next' === $direction ? (bool) ( ( $event_offset + 1 ) >= $total ) : (bool) ( $event_offset <= 0 ) ;

    if( $encoded_context ){
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
    
    $filters = $context && isset( $context['oaq'] ) ? $context['oaq'] : array();
    $total   = $context && isset( $context['total'] ) ? (int) $context['total'] : 0;
    $limit   = $context && isset( $context['limit'] ) ? (int) $context['limit'] : $openagenda->get_limit();
    $event_offset = $context && isset( $context['event_offset'] ) ? (int) $context['event_offset'] : 0;
    $event_number = $event_offset + 1;
    
    $page = (int) ceil( $event_number / $limit );
    $page_link = openagenda_get_page_permalink( $page, $filters );

    $html = '';
    if( $page_link ){
        $html = sprintf( 
            '<a class="oa-nav-link oa-back-link" href="%s">%s<span>%d / %d</span></a>',
            esc_url( $page_link ),
            openagenda_icon( 'home', false ),
            (int) $event_number,
            (int) $total
        );
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