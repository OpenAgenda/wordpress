<?php
namespace Openagenda;
/**
 * Class for handling shortcodes content.
 */
class Shortcodes implements Hookable {

    /**
     * Shortcodes to register
     */
    protected $shortcodes = array();
    
    /**
     * Constructor
     */
    public function __construct(){
        $this->shortcodes = array(
            'openagenda'                  => array( $this, 'openagenda' ),
            'openagenda_filter_active'    => array( $this, 'openagenda_filter_active' ),
            'openagenda_filter_total'     => array( $this, 'openagenda_filter_total' ),
            'openagenda_filter_choice'    => array( $this, 'openagenda_filter_choice' ),
            'openagenda_filter_tags'      => array( $this, 'openagenda_filter_tags' ),
            'openagenda_filter_calendar'  => array( $this, 'openagenda_filter_calendar' ),
            'openagenda_filter_map'       => array( $this, 'openagenda_filter_map' ),
            'openagenda_filter_preview'   => array( $this, 'openagenda_filter_preview' ),
            'openagenda_filter_relative'  => array( $this, 'openagenda_filter_relative' ),
            'openagenda_filter_search '   => array( $this, 'openagenda_filter_search' ),
        );
    }

    /**
     * Returns the shortcodes to register
     * 
     * @return  array 
     */
    public function get_shortcodes(){
        return apply_filters( 'openagenda_shortcodes', $this->shortcodes );
    }


    /**
     * Registers hooks
     */
    public function register_hooks(){
        foreach ( $this->get_shortcodes() as $slug => $callback ) {
            add_shortcode( sanitize_title( $slug ), $callback );
        }
    }


    /**
     * openagenda shortcode callback function
     * 
     * @param   array   $atts     Array of attributes passed to the shortcode
     * @param   string  $content  Content if enclosing shortcode. Defaults to null.
     * @param   string  $tag      Name of the shortcode
     * @return  string  $html     HTML to display.
     */
    public function openagenda( $atts = array(), $content = null, $tag = 'openagenda' ){
        global $openagenda;

        // Parse shortcode attributes
        $atts = shortcode_atts( array(
            'uid'    => get_post_meta( get_the_ID(), 'oa-calendar-uid', true ),
            'view'   => get_post_meta( get_the_ID(), 'oa-calendar-view', true ) ? sanitize_title( get_post_meta( get_the_ID(), 'oa-calendar-view', true ) ) : 'list',
            'size'   => get_post_meta( get_the_ID(), 'oa-calendar-per-page', true ) ? (int) get_post_meta( get_the_ID(), 'oa-calendar-per-page', true ) : (int) get_option( 'posts_per_page' ),
        ), $atts, $tag );
        
        if( ! empty( get_query_var( 'oa-slug' ) ) ){
            $atts['slug']   = sanitize_title( get_query_var( 'oa-slug' ) );
        }

        if( empty( $atts['uid'] ) ){
            return sprintf( '<p>%s</p>', __( 'Please provide a valid calendar UID to display in the calendar settings.', 'openagenda' ) );
        }
        
        if( ! $openagenda ){
            $openagenda = new Openagenda( $atts['uid'], $atts );
        }

        $list_header = \openagenda_is_archive() ? \openagenda_get_list_header_html( $atts['view'] ) : '';
        $event_html  = \openagenda_get_events_html( $atts['view'] );

        return sprintf( '%s<div data-container-id="oa-wrapper">%s</div>', $list_header, $event_html );
    }


    /**
     * Callback function to display active filters.
     * 
     * @param   array   $atts     Array of attributes passed to the shortcode
     * @param   string  $content  Content if enclosing shortcode. Defaults to null.
     * @param   string  $tag      Name of the shortcode
     * @return  string  $html     HTML to display.
     */
    public function openagenda_filter_active( $atts = array(), $content = null, $tag = 'openagenda_filter_active' ){
        global $openagenda;
        if( ! $openagenda ) return '';
        $uid = $openagenda->get_uid();

        $defaults = array( 'id' => 'active-filters' );
        $atts     = shortcode_atts( $defaults, $atts, 'openagenda_filter_active' );
                
        $params = array( 'name' => 'activeFilters' );
        $filter = sprintf( '<div class="oa-widget oa-active-filters-widget" data-oa-widget="%s" data-oa-widget-params="%s"></div>', esc_attr( $atts['id'] ), esc_attr( json_encode( $params ) ) );

        return apply_filters( 'openagenda_filter_active', $filter, $uid );
    }


    /**
     * Callback function to display event totals.
     * 
     * @param   array   $atts     Array of attributes passed to the shortcode
     * @param   string  $content  Content if enclosing shortcode. Defaults to null.
     * @param   string  $tag      Name of the shortcode
     * @return  string  $html     HTML to display.
     */
    public function openagenda_filter_total( $atts = array(), $content = null, $tag = 'openagenda_filter_total' ){
        global $openagenda;
        if( ! $openagenda ) return '';
        $uid = $openagenda->get_uid();

        $defaults = array( 'id' => 'total' );
        $atts     = shortcode_atts( $defaults, $atts, 'openagenda_filter_total' );

        $defaultMessage = sprintf( 
            '{total, plural, =0 {%s} one {%s} other {%s}}',
            _x( 'No event found', 'Total filter message when no events found', 'openagenda' ),
            _x( '{total} event', 'Total filter message when 1 event found. Keep {total} placeholder.', 'openagenda' ),
            _x( '{total} events', 'Total filter message when multiple event found. Keep {total} placeholder.', 'openagenda' )
        );

        $params = array(
            'name'    => 'total',
            'message' => array(
                'id'             => 'eventsTotal',
                'defaultMessage' => apply_filters( 'openagenda_filter_total_messages', $defaultMessage ),
            )
        );

        $filter = sprintf( '<div class="oa-widget oa-events-total-widget" data-oa-widget="%s" data-oa-widget-params="%s"></div>', esc_attr( $atts['id'] ), esc_attr( json_encode( $params ) ) );
        return apply_filters( 'openagenda_filter_total', $filter, $uid );
    }

    
    /**
     * Callback function to display choice filter.
     * 
     * @param   array   $atts     Array of attributes passed to the shortcode
     * @param   string  $content  Content if enclosing shortcode. Defaults to null.
     * @param   string  $tag      Name of the shortcode
     * @return  string  $html     HTML to display.
     */
    public function openagenda_filter_choice( $atts = array(), $content = null, $tag = 'openagenda_filter_choice' ){
        global $openagenda;
        if( ! $openagenda ) return '';
        $uid = $openagenda->get_uid();

        $defaults = array(
            'id'        => 'choice',
            'field'     => '',
            'additional_field' => '',
            'page_size' => 10
        );
        $atts = shortcode_atts( $defaults, $atts, 'openagenda_filter_choice' );

        $filter = '';
        if( ! empty( $atts['field'] ) ){
            $inner_html = '';
            $params     = array(
                'type'     => 'choice',
                'name'     => sanitize_text_field( $atts['field'] ),
                'pageSize' => (int) $atts['page_size'],
            );
            if( 'additional_field' === $atts['field'] && ! empty( $atts['additional_field'] ) ){
                $params['name']        = sanitize_text_field( $atts['additional_field'] );
                $params['labelKey']    = 'label';
                $params['aggregation'] = array(
                    'type'  => 'additionalFields',
                    'field' => sanitize_text_field( $atts['additional_field'] ),
                    'size'  => 2000
                );
            }
            if( 'favorites' === $atts['field'] ){
                $params['type']      = 'favorites';
                $params['agendaUid'] = $uid;
                $params['activeFilterLabel'] = __( 'Favorites', 'openagenda' );
                $params['exclusive'] = true;
                $inner_html          = sprintf( 
                    '<div class="checkbox inactive">
                        <label class="oa" for="%1$s">
                            <input id="%1$s" name="%1$s" type="checkbox">
                            %2$s
                        </label>
                    </div>',
                    esc_attr( 'favorites-' . $uid ),
                    esc_html__( 'Favorites', 'openagenda' )
                ); 
            }

            $filter = sprintf( '<div class="oa-widget oa-choice-widget" data-oa-filter="%s" data-oa-filter-params="%s">%s</div>', esc_attr( $atts['id'] ), esc_attr( json_encode( $params ) ), $inner_html );
        }

        return apply_filters( 'openagenda_filter_choice', $filter, $uid, $atts );
    }

    /**
     * Callback function to display former tags filter.
     * Displays a choice widget with keywords param
     * 
     * @param   array   $atts     Array of attributes passed to the shortcode
     * @param   string  $content  Content if enclosing shortcode. Defaults to null.
     * @param   string  $tag      Name of the shortcode
     * @return  string  $html     HTML to display.
     */
    public function openagenda_filter_tags( $atts = array(), $content = null, $tag = 'openagenda_filter_tags' ){
        $defaults = array(
            'id'        => 'choice',
            'field'     => 'keyword',
            'additional_field' => '',
            'page_size' => 10
        );
        $atts = shortcode_atts( $defaults, $atts, 'openagenda_filter_tags' );
        return $this->openagenda_filter_choice( $atts );
    }


    /**
     * Callback function to display Calendar.
     * 
     * @param   array   $atts     Array of attributes passed to the shortcode
     * @param   string  $content  Content if enclosing shortcode. Defaults to null.
     * @param   string  $tag      Name of the shortcode
     * @return  string  $html     HTML to display.
     */
    public function openagenda_filter_calendar( $atts = array(), $content = null, $tag = 'openagenda_filter_calendar' ){
        global $openagenda;
        if( ! $openagenda ) return '';
        $uid =  $openagenda->get_uid();

        $defaults = array( 'id' => 'date-range' );
        $atts     = shortcode_atts( $defaults, $atts, 'openagenda_filter_calendar' );

        $params = array(
            'type' => 'dateRange',
            'name' => 'timings',
        );

        $filter = sprintf( '<div class="oa-widget oa-calendar-widget" data-oa-filter="%s" data-oa-filter-params="%s"></div>', esc_attr( $atts['id'] ), esc_attr( json_encode( $params ) ) );
        return apply_filters( 'openagenda_filter_calendar', $filter, $uid, $atts );
    }


    /**
     * Callback function to display Map.
     * 
     * @param   array   $atts     Array of attributes passed to the shortcode
     * @param   string  $content  Content if enclosing shortcode. Defaults to null.
     * @param   string  $tag      Name of the shortcode
     * @return  string  $html     HTML to display.
     */
    public function openagenda_filter_map( $atts = array(), $content = null, $tag = 'openagenda_filter_map' ){
        global $openagenda;
        if( ! $openagenda ) return '';
        $uid = $openagenda->get_uid();

        $settings            = get_option( 'openagenda_integrations_settings' );
        $default_tiles       = ! empty( $settings['openagenda_map_tiles_link'] ) ? $settings['openagenda_map_tiles_link'] : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        $default_attribution = ! empty( $settings['openagenda_map_tiles_attribution_link'] ) ? $settings['openagenda_map_tiles_attribution_link'] : sprintf( '<a href="%s">%s</a>', 'https://www.openstreetmap.org/copyright', __( 'OpenStreetMap contributors', 'openagenda' ) );

        $defaults = array(
            'id'               => 'map',
            'map_tiles_link'   => $default_tiles,
            'map_attribution'  => $default_attribution,
            'map_zoom'         => 12,
            'map_auto'         => true,
            'map_auto_message' => __( 'Search while moving the map', 'openagenda' ),
            'map_longitude'    => '',
            'map_latitude'     => '',
        );
        $atts = shortcode_atts( $defaults, $atts, 'openagenda_filter_map' );

        $params = array(
            'type'    => 'map',
            'name'    => 'geo',
            'tileUrl' => $atts['map_tiles_link'],
            'tileAttribution' => $atts['map_attribution'],
            'searchWithMap'   => (bool) $atts['map_auto'],
            'searchMessage'   => $atts['map_auto_message'],
            // 'defaultViewport' => ''
        );

        $filter = sprintf( 
            '<div class="oa-widget oa-map-widget map-container" data-oa-filter="%s" data-oa-filter-params="%s"></div>',
            esc_attr( $atts['id'] ), 
            esc_attr( json_encode( $params ) )
        );

        wp_enqueue_style( 'oa-leaflet' );
        return apply_filters( 'openagenda_filter_map', $filter, $uid, $atts );
    }
    
    /**
     * Callback function to display preview.
     * 
     * @param   array   $atts     Array of attributes passed to the shortcode
     * @param   string  $content  Content if enclosing shortcode. Defaults to null.
     * @param   string  $tag      Name of the shortcode
     * @return  string  $html     HTML to display.
     */
    public function openagenda_filter_preview( $atts = array(), $content = null, $tag = 'openagenda_filter_preview' ){
        global $openagenda;

        $defaults = array(
            'id'      => 'preview',
            'uid'     => '',
            'size'    => 3,
            'filters' => ''
        );
        $atts = shortcode_atts( $defaults, $atts, 'openagenda_filter_preview' );
        
        $uid = $atts['uid'];
        unset( $atts['uid'] );
        $atts['size'] = (int) $atts['size'];

        // Parse filters
        $filters = [];
        parse_str( trim( str_replace( 'q.', '', urldecode( $atts['filters'] ) ), '?' ), $filters );
        if( $filters ){
            $atts = array_merge( $atts, $filters );
            unset( $atts['filters'] );
        }

        // If we're on a events page, backup the main events.
        openagenda_save();
        $openagenda = new Openagenda( $uid, $atts, false, false );
        ob_start();
        include openagenda_get_template( 'preview-loop' );
        $filter = ob_get_clean();
        
        openagenda_reset();
        return apply_filters( 'openagenda_filter_preview', $filter, $atts );        
    }


    /**
     * Callback function to display relative widget.
     * 
     * @param   array   $atts     Array of attributes passed to the shortcode
     * @param   string  $content  Content if enclosing shortcode. Defaults to null.
     * @param   string  $tag      Name of the shortcode
     * @return  string  $html     HTML to display.
     */
    public function openagenda_filter_relative( $atts = array(), $content = null, $tag = 'openagenda_filter_relative' ){
        global $openagenda;
        if( !  $openagenda ) return '';
        $uid =  $openagenda->get_uid();

        $defaults = array( 'id' => 'relative' );
        $atts     = shortcode_atts( $defaults, $atts, 'openagenda_filter_relative' );

        $params = array(
            'type' => 'choice',
            'name' => 'relative'
        );

        $filter = sprintf( '<div class="oa-widget oa-relative-widget" data-oa-filter="%s" data-oa-filter-params="%s"></div>', esc_attr( $atts['id'] ), esc_attr( json_encode( $params ) ) );
        return apply_filters( 'openagenda_filter_relative', $filter, $uid, $atts );
    }


    /**
     * Callback function to display search widget.
     * 
     * @param   array   $atts     Array of attributes passed to the shortcode
     * @param   string  $content  Content if enclosing shortcode. Defaults to null.
     * @param   string  $tag      Name of the shortcode
     * @return  string  $html     HTML to display.
     */
    public function openagenda_filter_search( $atts = array(), $content = null, $tag = 'openagenda_filter_search' ){
        global $openagenda;
        if( ! $openagenda ) return '';
        $uid = $openagenda->get_uid();

        $defaults = array( 
            'id'          => 'search',
            'placeholder' => '',
        );
        $atts = shortcode_atts( $defaults, $atts, 'openagenda_filter_preview' );

        $params = array(
            'type'        => 'search',
            'name'        => 'search',
            'placeholder' => $atts['placeholder']
        );

        $filter = sprintf( 
            '<div class="oa-widget oa-search-widget" data-oa-filter="%s" data-oa-filter-params="%s"></div>',
            esc_attr( $atts['id'] ),
            esc_attr( json_encode( $params ) )
        );
        
        return apply_filters( 'openagenda_filter_search', $filter, $uid, $atts );
    }
}