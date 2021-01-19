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
            $updatedUrl  = esc_url( add_query_arg( 'oaq', $query, $updatedUrl ) );
            $updatedPath = wp_parse_url( $updatedUrl, PHP_URL_PATH ) . '?' . wp_parse_url( $updatedUrl, PHP_URL_QUERY ); 
        }

        $view = sanitize_title( $_POST['view'] );

        $openagenda = new Openagenda( $uid, $args );
        $response    = array(
            'totalPages'  => (int) $openagenda->get_total_pages(),
            'total'       => (int) $openagenda->get_total(),
            'updatedUrl'  => $updatedUrl,
            'updatedPath' => $updatedPath,
            'source'      => sanitize_key( $openagenda->source ),
            'html'        => \openagenda_get_events_html( $view ),
        );
        
        wp_send_json_success( $response );
        wp_die();
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
                            $filter_value = array_map( 'sanitize_title', $filter_value );
                        }
                        break; 
                    default:
                        $filter_value = sanitize_title( $filter_value );
                        break;
                }
                $clean[sanitize_key( $filter_key )] = $filter_value;
            }
        }
        return $clean;
    }
}