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
            'openagenda_filter_tags'      => array( $this, 'openagenda_filter_tags' ),
            'openagenda_filter_calendar'  => array( $this, 'openagenda_filter_calendar' ),
            'openagenda_filter_map'       => array( $this, 'openagenda_filter_map' ),
            'openagenda_filter_preview '  => array( $this, 'openagenda_filter_preview' ),
            'openagenda_filter_relative ' => array( $this, 'openagenda_filter_relative' ),
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
     * open_agenda shortcode callback function
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
            'view'   => 'list',
            'limit'  => get_post_meta( get_the_ID(), 'oa-calendar-per-page', true ) ? (int) get_post_meta( get_the_ID(), 'oa-calendar-per-page', true ) : (int) get_option( 'posts_per_page' ),
        ), $atts, $tag );
        
        if( ! empty( get_query_var( 'oa-slug' ) ) ){
            $atts['oaq']['slug'] = sanitize_title( get_query_var( 'oa-slug' ) );
        }

        if( empty( $atts['uid'] ) ){
            return sprintf( '<p>%s</p>', __( 'Please provide a valid calendar UID to display in the calendar settings.', 'openagenda' ) );
        }

        if( ! $openagenda ){
            $openagenda = new Openagenda( $atts['uid'], $atts );
        }

        $html = \openagenda_get_events_html( $atts['view'] );

        return sprintf( '<div data-container-id="oa-wrapper">%s</div>', $html );
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

        wp_enqueue_script( 'openagenda_filter_active' );
        $filter = sprintf( '<div class="row filters cbpgft" data-cbctl="%s|%s">%s</div>', esc_attr( $uid ), esc_attr( \openagenda_get_locale() ), \openagenda_icon( 'refresh', false ) );
        return apply_filters( 'openagenda_filter_active', $filter, $uid );
    }

    
    /**
     * Callback function to display tags.
     * 
     * @param   array   $atts     Array of attributes passed to the shortcode
     * @param   string  $content  Content if enclosing shortcode. Defaults to null.
     * @param   string  $tag      Name of the shortcode
     * @return  string  $html     HTML to display.
     */
    public function openagenda_filter_tags( $atts = array(), $content = null, $tag = 'openagenda_filter_tags' ){
        global $openagenda;
        if( ! $openagenda ) return '';
        $uid = $openagenda->get_uid();

        $defaults = array(
            'title'     => '',
            'filter'    => 'openagenda_filter_tags',
            'tag_group' => '',
            'tags'      => '',
        );
        $atts = shortcode_atts( $defaults, $atts, 'openagenda_filter_tags' );

        wp_enqueue_script( 'openagenda_filter_tags' );
        $cbctl      = ! empty( $atts['tags'] ) ? sprintf( '%s|%s', $uid, $atts['tags'] ) : $uid;
        $data_group = ! empty( $atts['tag_group'] ) ? sprintf( 'data-group=%s', $atts['tag_group'] ) : '';
        $filter = sprintf( 
            '<div class="cbpgtg" data-oatg data-cbctl="%s" %s>%s</div>',
            esc_attr( $cbctl ), 
            $data_group, 
            openagenda_icon( 'refresh', false )
        );
        return apply_filters( 'openagenda_filter_tags', $filter, $uid, $atts );
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

        wp_enqueue_script( 'openagenda_filter_calendar' );
        $filter = sprintf( '<div class="cbpgcl cibulCalendar" data-cbctl="%s|%s">%s</div>', esc_attr( $uid ), esc_attr( openagenda_get_locale() ), openagenda_icon( 'refresh', false ) );
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

        $defaults = array(
            'map_tiles_link' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'map_zoom'       => 12,
            'map_auto'       => true,
            'map_longitude'  => '',
            'map_latitude'   => '',
        );
        $atts = shortcode_atts( $defaults, $atts, 'openagenda_filter_map' );

        $data_auto      = ! empty( $atts['map_auto'] ) ? 'data-auto="true"' : '';
        $data_event_uid = $openagenda->is_single() ? sprintf( 'data-event-uid=%s', esc_attr( \openagenda_get_field( 'uid' ) ) ) : '';
        $data_longitude = ! empty( $atts['map_longitude'] ) ? sprintf( 'data-longitude=%s', esc_attr( $atts['map_longitude'] ) ) : '';
        $data_latitude  = ! empty( $atts['map_latitude'] ) ? sprintf( 'data-latitude=%s', esc_attr( $atts['map_latitude'] ) ) : '';
        $data_zoom      = ! empty( $atts['map_zoom'] ) ? sprintf( 'data-zoom=%s', esc_attr( $atts['map_zoom'] ) ) : '';
        $data_coords    = '';
        if( ! empty( $atts['map_longitude'] ) && ! empty( $atts['map_latitude'] ) ){
            $data_coords = sprintf( 
                'data-coords="%s|%s|%d"', 
                esc_attr( $atts['map_longitude'] ),
                esc_attr( $atts['map_latitude'] ),
                esc_attr( $atts['map_zoom'] )
            );
        }
        $filter = sprintf( 
            '<div class="cbpgmp cibulMap" data-tiles="%s" data-oamp data-cbctl="%s" data-lang="%s" %s %s %s %s %s %s>%s</div>', 
            esc_attr( $atts['map_tiles_link'] ), 
            esc_attr( $uid ),
            esc_attr( \openagenda_get_locale() ),
            $data_auto,
            $data_coords,
            $data_event_uid, 
            $data_longitude, 
            $data_latitude, 
            $data_zoom, 
            \openagenda_icon( 'refresh', false )
        );

        wp_enqueue_style( 'oa-leaflet' );
        wp_enqueue_script( 'openagenda_filter_map' );
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
        $defaults = array(
            'uid'           => '',
            'preview_label' => __( 'Preview the calendar', 'openagenda' ),
            'preview_count' => 3,
        );
        $atts = shortcode_atts( $defaults, $atts, 'openagenda_filter_preview' );

        ob_start();
        printf(
            '<div data-oapr class="preview cbpgpr" data-cbctl="%s" data-count="%d"><a href="%s">%s</a>%s', 
            esc_attr( $atts['uid'] ),
            (int) $atts['preview_count'],
            esc_url( openagenda_get_permalink( $atts['uid'] ) ),
            esc_html( $atts['preview_label'] ),
            openagenda_icon( 'refresh', false ),
        );
        include openagenda_get_template( 'preview' );
        echo '</div>'; // Previous <div> was left open to insert template
        $filter = ob_get_clean();

        wp_enqueue_script( 'oa-preview-widget' );
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

        $filter = sprintf( 
            '<div class="cbpgrl relative-dates" data-cbctl="%s|%s">%s</div>', 
            esc_attr( $uid ),
            esc_attr( openagenda_get_locale() ),
            openagenda_icon( 'refresh', false )
        );
        
        wp_enqueue_script( 'openagenda_filter_relative' );
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
            'placeholder' => __( 'Search this calendar', 'openagenda' ),
        );
        $atts = shortcode_atts( $defaults, $atts, 'openagenda_filter_preview' );

        $filter = sprintf( 
            '<div class="search-form cbpgsc relative-dates" data-cbctl="%s|%s">
                <input type="text" class="form-control" placeholder="%s" />
            </div>', 
            esc_attr( $uid ),
            esc_attr( openagenda_get_locale() ),
            esc_attr( $atts['placeholder'] )
        );
        
        wp_enqueue_script( 'openagenda_filter_search' );
        return apply_filters( 'openagenda_filter_search', $filter, $uid, $atts );
    }
}