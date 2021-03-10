<?php
namespace Openagenda;
/**
 * Ajax Handler
 * 
 * Handles all Ajax requests.
 */
class Ajax_Handler {

    /**
     * Constructor
     */
    public function __construct(){}

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
        check_ajax_referer( 'update_events', 'nonce' );

        $post_id = isset( $_POST['postId'] ) ? (int) $_POST['postId'] : false;
        if( ! $post_id ){
            wp_send_json_error( new \WP_Error( 'missing-postid', __( 'No post ID was provided.', 'openagenda' ) ) );
            exit;
        }
        
        $uid  = get_post_meta( $post_id, 'oa-calendar-uid', true );
        if( ! $uid ){
            wp_send_json_error( new \WP_Error( 'wrong-calendar-id', __( 'The post ID provided does not refer to a calendar.', 'openagenda' ) ) );
            exit;
        }
        
        $query = isset( $_POST['query'] ) ? $this->sanitize_query( $_POST['query'] ) : false;

        $args = array(
            'limit' => get_post_meta( $post_id, 'oa-calendar-per-page', true ) ? (int) get_post_meta( $post_id, 'oa-calendar-per-page', true ) : (int) get_option( 'posts_per_page' ),
            'page'  => 1,
        );

        $updatedUrl = get_permalink( $post_id );
        if( $query ){
            $args['oaq'] = $query;
            $updatedUrl  = add_query_arg( 'oaq', $query, $updatedUrl );
            $updatedPath = wp_parse_url( $updatedUrl, PHP_URL_PATH ) . '?' . wp_parse_url( $updatedUrl, PHP_URL_QUERY ); 
        }

        $view = sanitize_title( $_POST['view'] );

        $openagenda = new Openagenda( $uid, $args, false );
        $response    = array(
            'totalPages'  => (int) $openagenda->get_total_pages(),
            'total'       => (int) $openagenda->get_total(),
            'updatedUrl'  => esc_url( $updatedUrl ),
            'updatedPath' => $updatedPath,
            'source'      => sanitize_key( $openagenda->source ),
            'html'        => \openagenda_get_events_html( $view ),
        );
        
        wp_send_json_success( $response );
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
        
        // Read context
        $event_offset = isset( $context['event_offset'] ) ? (int) $context['event_offset'] : null;
        $filters      = isset( $context['oaq'] ) ? $this->sanitize_query( $context['oaq'] ): null;
        
        if( null === $event_offset ) {
            wp_safe_redirect( $referer );
            exit;
        }
        
        // Prepare another query to fetch adjacent event
        $offset = 'next' === $direction ? $event_offset + 1 : $event_offset - 1;
        if ( 0 >= $offset ) $offset = 0;
        
        $args = array(
            'offset' => $offset,
            'limit'  => 1,
        );
        if ( ! empty( $filters ) ) {
            $args['oaq'] = $filters;
        }
        
        // Fetch the event
        $openagenda = new Openagenda( $uid, $args, false, false );
        $event      = $openagenda->get_current_event();
        
        if( ! empty( $event ) ){
            $event_permalink = openagenda_get_field( 'permalink' );
            
            // Update context
            $context['event_offset'] = $offset;
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