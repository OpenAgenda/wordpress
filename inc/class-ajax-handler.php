<?php
namespace Openagenda;
/**
 * Ajax Handler
 * 
 * Handles all Ajax requests.
 */
class Ajax_Handler {
    
    /**
     * Debug
     */
    protected $debug = false;

    /**
     * Constructor
     */
    public function __construct(){
        $this->debug = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG;
    }

    /**
     * Registers hooks
     */
    public function register_hooks(){
        add_action( 'wp_ajax_update_events', array( $this, 'update_events' ) );
        add_action( 'wp_ajax_nopriv_update_events', array( $this, 'update_events' ) );
        add_action( 'admin_post_get_adjacent_event', array( $this, 'get_adjacent_event' ) );
        add_action( 'admin_post_nopriv_get_adjacent_event', array( $this, 'get_adjacent_event' ) );
    }

    /**
     * Handles filter AJAX request and returns events HTML
     * 
     * @return  array  $response  Array with total number of events, and events HTML.
     */
    public function update_events(){
        global $openagenda;
        global $post;
        check_ajax_referer( 'update_events', 'nonce' );

        $post_id = isset( $_REQUEST['postId'] ) ? (int) $_REQUEST['postId'] : false;
        if( ! $post_id ){
            wp_send_json_error( new \WP_Error( 'missing-postid', __( 'No post ID was provided.', 'openagenda' ) ) );
            exit;
        }

        // Setup $post global to allow for basic template tags to work
        $post = get_post( $post_id );
        setup_postdata( $post );
        
        $uid = get_post_meta( $post_id, 'oa-calendar-uid', true );
        if( ! $uid ){
            wp_send_json_error( new \WP_Error( 'wrong-calendar-id', __( 'The post ID provided does not refer to a calendar.', 'openagenda' ) ) );
            exit;
        }
        
        $query     = array();
        $view      = get_post_meta( $post_id, 'oa-calendar-view', true );
        $page_size = get_post_meta( $post_id, 'oa-calendar-per-page', true ) ? (int) get_post_meta( $post_id, 'oa-calendar-per-page', true ) : (int) get_option( 'posts_per_page' );
        $args      = array(
            'size'      => $page_size,
            'page_size' => $page_size,
            'page'      => 1,
        );

        // Read POST query param
        if( isset( $_POST['query'] ) ){
            $query = json_decode( stripslashes( html_entity_decode( $_POST['query'] ) ), true );
        }

        // Read GET query param
        if( ! empty( $_GET ) ){
            $query = array_filter( $_GET, function( $value, $key ){
                return ! in_array( $key, array( 'nonce', 'action', 'postId', 'view' ) );
            }, ARRAY_FILTER_USE_BOTH );
        }

        if( $query ){
            $args = array_merge( $args, $query );
        }

        // Merge default filters
        if( ! empty( $prefilters = openagenda_get_pre_filters( $post_id, $query ) ) ){
            $args = array_merge( $args, $prefilters );
        }

        $openagenda = new Openagenda( $uid, $args, false, true );
        $response   = array_merge( $openagenda->get_json(), array(
            'source'      => sanitize_key( $openagenda->get_source() ),
            'html'        => \openagenda_get_events_html( $view ),
        ) );

        echo wp_send_json( $response );
        wp_die();
    }


    /**
     * Handler for event navigation on single event pages.
     */
    public function get_adjacent_event(){
        global $openagenda;

        if( ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( $_GET['nonce'], 'get_adjacent_event' ) ){
            wp_die();
        }
        
        // Read request
        $referer   = wp_get_referer();
        $context   = openagenda_decode_context();
        $direction = 'next' === $_GET['direction'] ? 'next' : 'previous';
        $uid       = isset( $_GET['uid'] ) ? (int) $_GET['uid'] : false;
        
        if( ! $context || ! $uid ) {
            wp_safe_redirect( $referer );
            exit;
        }
                
        // Read referer event
        $event_offset = isset( $context['event_offset'] ) ? (int) $context['event_offset'] : null;
        if( null === $event_offset ) {
            wp_safe_redirect( $referer );
            exit;
        }

        // Prepare another query to fetch adjacent event
        $params  = $context['params'];
        $filters = $context['filters'];
        $from = 'next' === $direction ? (int) $event_offset + 1 : (int) $event_offset - 1;
        if ( 0 >= $from ) $from = 0;
        
        $args = array(
            'from' => $from,
            'size' => 1,
            'longDescriptionFormat' => ! empty( $params['longDescriptionFormat'] ) ? $params['longDescriptionFormat'] : 'markdown',
        );       

        // Fetch the event
        $openagenda = new Openagenda( $uid, array_merge( $args, $filters ), false, false );
        $event      = $openagenda->get_current_event();
        
        if( ! empty( $event ) ){
            $event_permalink = openagenda_get_field( 'permalink' );
            
            // Update context
            $context['event_offset']   = (int) $from;
            $context['page']           = (int) ceil( ( $from + 1 ) / (int) $context['params']['size'] );
            $context['params']['from'] = ( $context['page'] - 1 ) * $context['params']['size'];

            $encoded_context = openagenda_encode_context( $context );
            $event_permalink = add_query_arg( 'context', $encoded_context, $event_permalink );
            wp_safe_redirect( $event_permalink );
            exit;
        }

        wp_safe_redirect( $referer );
        exit;        
    }


    /**
     * Sanitizes the received oaq query data
     * 
     * @param  array  $query 
     */
    public function sanitize_query( $query ){
        $clean = array();
        if( is_array( $query ) ){
            foreach ( $query as $filter_key => $filter_value ) {
                switch ( $filter_key ) {
                    case 'tags':
                        if( is_array( $filter_value ) ){
                            $filter_value = array_map( 'sanitize_text_field', $filter_value );
                        }
                        break; 
                    default:
                        $filter_value = sanitize_text_field( $filter_value );
                        break;
                }
                $clean[ sanitize_text_field( $filter_key ) ] = $filter_value;
            }
        }
        return $clean;
    }
}