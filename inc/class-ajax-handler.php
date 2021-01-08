<?php
namespace Openagenda;
/**
 * Ajax Handler .
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
        
        $filter = isset( $_POST['filter'] ) ? sanitize_title( $_POST['filter'] ) : false;
        $update = isset( $_POST['update'] ) ? $_POST['update'] : false;
        $query  = isset( $_POST['query'] ) ? $_POST['query'] : false;

        $args = array(
            'limit' => get_post_meta( $post_id, 'oa-calendar-per-page', true ) ? (int) get_post_meta( $post_id, 'oa-calendar-per-page', true ) : (int) get_option( 'posts_per_page' ),
            'page'  => 1,
        );

        $updatedUrl = get_permalink( $post_id );
        if( $query ){
            $args['oaq'] = $query;
            $updatedUrl  = add_query_arg( 'oaq', $query, $updatedUrl );
        }

        $view = sanitize_title( $_POST['view'] );

        $openagenda = new Openagenda( $uid, $args );
        $response    = array(
            'totalPages' => (int)  $openagenda->get_total_pages(),
            'total'      => (int)  $openagenda->get_total(),
            'updatedUrl' => esc_url( $updatedUrl ),
            'source'     =>  $openagenda->source,
            'html'       => \openagenda_get_events_html( $view ),
        );
        
        wp_send_json_success( $response );
        wp_die();
    }
}