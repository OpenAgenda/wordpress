<?php
namespace Openagenda;
/**
 * Class for handling request for the JSON Export.
 */
class Openagenda {

    /**
     * Base URL
     */
    protected $base_url = 'https://openagenda.com/agendas';
    
    /**
     * User API Key
     */
    protected $api_key = '';
    
    /**
     * Calendar id
     */
    protected $uid = '';
    
    /**
     * Source of data
     */
    public $source = '';
    
    /**
     * Query arguments 
     */
    protected $args = array();
    
    /**
     * Index when looping
     */
    protected $index = 0;

    /**
     * Number of events per page
     */
    protected $limit = '';
    
    /**
     * Number of total events
     */
    protected $total = 0;
    
    /**
     * Offset
     */
    protected $offset = 0;

    /**
     * Current page
     */
    protected $page = 1;
    
    /**
     * Previous page
     */
    protected $previous_page = false;
    
    /**
     * Next page
     */
    protected $next_page = false;
    
    /**
     * Total number of pages
     */
    protected $total_pages = 1;

    /**
     * Events count
     */
    protected $count = 0;

    /**
     * Raw response
     */
    protected $raw_response = null;
    
    /**
     * Errors
     */
    protected $errors = null;

    /**
     * Parsed JSON response
     */
    protected $json = null;
    
    /**
     * Queried events
     */
    protected $events = array();

    /**
     * Current event in the loop
     */
    protected $event = null;

    /**
     * Context data
     */
    protected $context = null;
    
    /**
     * Whether to allow for rich embeded content.
     */
    protected $include_embedded = true;

    /**
     * Is the query for a list of events ?
     */
    protected $is_archive = true;
    
    /**
     * Is the query for a single event ?
     */
    protected $is_single = false;
    
    /**
     * Whether to use caching.
     */
    protected $use_cache = true;
    
    /**
     * Whether the query should set the context cookie.
     */
    protected $use_context = true;

    /**
     * Constructor
     * 
     * @param  int    $uid   UID of the calendar
     * @param  array  $args  Array of arguments
     */
    public function __construct( $uid, $args = array(), $use_cache = true, $use_context = true ){
        $settings       = get_option( 'openagenda_general_settings' );
        $this->uid      = $uid;
        $this->api_key  = ! empty( $settings['openagenda_api_key'] ) ? $settings['openagenda_api_key'] : '';
        $this->include_embedded = ! empty( $settings ) && isset( $settings['openagenda_include_embeds'] ) ? (bool) $settings['openagenda_include_embeds'] : true; 
        $this->use_cache   = (bool) $use_cache;
        $this->use_context = (bool) $use_context;

        $this->args        = $this->parse_args( $args );
        $this->page        = ! empty ( $this->get_args() ) && ! empty( $this->get_args()['page'] ) ? (int) $this->get_args()['page'] : 1;
        $this->is_single   = $this->is_single();
        $this->is_archive  = $this->is_archive();

        $this->raw_response = $this->request( $this->args );
        $this->json         = $this->parse_response( $this->args );
        $this->events       = isset( $this->json['events'] ) && is_array( $this->json['events'] ) && ! empty( $this->json['events'] ) ? $this->json['events'] : array();
        $this->event        = ! empty( $this->get_events() ) ? $this->get_events()[0] : null;
        
        $this->count       = count( $this->events );
        $this->total       = ! empty( $this->json['total'] ) ? (int) $this->json['total'] : 0;
        $this->limit       = ! empty( $this->json['limit'] ) ? (int) $this->json['limit'] : 20;
        $this->offset      = ! empty( $this->json['offset'] ) ? (int) $this->json['offset'] : 0;
        $this->total_pages = (int) ceil( $this->total / $this->limit );
        
        $this->set_context();
        $this->maybe_cache();
    }


    /**
     * Returns the calendar uid.
     */
    public function get_uid(){
        return $this->uid;
    }


    /**
     * Returns the user API key.
     */
    public function get_api_key(){
        return $this->api_key;
    }


    /**
     * Returns the current page.
     */
    public function get_current_page(){
        return $this->page;
    }


    /**
     * Returns the total number of events.
     */
    public function get_total(){
        return $this->total;
    }


    /**
     * Returns the total number of events.
     */
    public function get_limit(){
        return $this->limit;
    }


    /**
     * Returns the total number of pages.
     */
    public function get_total_pages(){
        return $this->total_pages;
    }


    /**
     * Returns query_arguments
     */
    public function get_args(){
        return apply_filters( 'openagenda_request_args', $this->args, $this->uid );
    }


    /**
     * Returns oaq filters
     */
    public function get_filters(){
        $args    = $this->get_args();
        $filters = ! empty( $args ) && ! empty( $args['oaq'] ) ? $args['oaq'] : array();
        return apply_filters( 'openagenda_filters', $filters, $this->uid );
    }


    /**
     * Returns events
     * 
     * @param  array  $args  Query arguments passed to the JSON export query  
     */
    public function get_events(){
        return apply_filters( 'openagenda_events', $this->events, $this->uid );
    }


    /**
     * Returns the current event in the loop.
     */
    public function get_current_event(){
        return $this->event;
    }


    /**
     * Returns whether to allow for embedded content.
     */
    public function include_embedded(){
        return apply_filters( 'openagenda_include_embedded', $this->include_embedded, $this->uid );
    }


    /**
     * Returns whether we're on a listing page or not.
     * 
     * @return  bool  $is_archive
     */
    public function is_archive(){
        $is_archive = ! $this->is_single(); 
        return apply_filters( 'openagenda_is_archive', $is_archive, $this->uid );
    }


    /**
     * Returns whether we're on a single page
     * 
     * @return  bool  $is_single
     */
    public function is_single(){
        $args      = $this->get_args();
        $is_single = ! empty( $args['oaq'] ) && ! empty( $args['oaq']['slug'] ); 
        return apply_filters( 'openagenda_is_single', $is_single, $this->uid );
    }


    /**
     * Retrieve an array of supported exports formats
     * 
     * @return  array  $formats
     */ 
    public function get_exports_formats(){
        $formats = array(
            'xlsx' => __( 'XLSX', 'openagenda' ),
            'json' => __( 'JSON', 'openagenda' ),
            'rss'  => __( 'RSS', 'openagenda' ),
            'pdf'  => __( 'PDF', 'openagenda' ),
        );
        return apply_filters( 'openagenda_exports_formats', $formats, $this->uid );
    }


    /**
     * Returns the Base export URL.
     * 
     * @param   string  $uid              Calendar identifier
     * @return  string  $base_export_url  URL to the root events export, based on UID. 
     */
    public function get_export_url( $format = 'json' ){
        $base_export_url = sprintf( '%s/%s/events.%s', $this->base_url, $this->uid, sanitize_title( $format ) );
        return $base_export_url;
    }


    /**
     * Returns a usable request URL
     * Finalizes the request URL by adding user API key.
     * 
     * @param   string  $uid  Calendar identifier
     * @return  string  $url  URL for the export event. 
     */
    public function get_request_url( $format = 'json' ){
        
        // Add key query var
        $url = add_query_arg( 'key', $this->get_api_key(), $this->get_export_url( $format ) );

        // Add include_embedded key, to allow for rich content.
        if( $this->include_embedded() ){
            $url = add_query_arg( 'include_embedded', $this->include_embedded, $url );
        }

        // Add other query args
        $args   = $this->get_args();
        $string = http_build_query( $args );
        
        if( ! empty( $string ) ){
            $url .= sprintf( '&%s', $string );
        }

        return apply_filters( 'openagenda_request_url', $url, $this->uid, $args, $format );
    }


    /**
     * Parse query arguments
     */
    public function parse_args( $args = array() ){
        
        // Parse nested filters first
        $filters = array();
        
        if( ! empty( $args['oaq'] ) ){
            $filters     = wp_parse_args( $args['oaq'], $filters );
            $args['oaq'] = array_filter( $filters );
        }
        
        // Parse query args
        $defaults = array(
            'limit'  => 20,
        );
        
        $args = wp_parse_args( $args, $defaults );
        $args = array_filter( $args );

        return $args;
    }


    /**
     * Performs the actual request
     * 
     * @param  string  $uid  Calendar UID to get events for
     * @param  array   $args
     */
    public function request( $args = array() ){
        
        // Check if the request response is not already cached.
        $cache = get_transient( $this->get_transient_name() );
        if( ! empty( $cache ) && $this->should_serve_cache()){
            $response     = $cache;
            $this->source = 'cache';
        } else {
            $response     = wp_safe_remote_get( $this->get_request_url() );
            $this->source = 'request';
        }

        if( is_wp_error( $response ) ){
            $this->errors[] = $response;
        }

        return $response;
    }


    /**
     * Parses the raw response to get the JSON
     */
    public function parse_response(){
        $body = wp_remote_retrieve_body( $this->raw_response );
        $json = json_decode( $body, true );
        if( null === $json ){
            $this->errors[] = new \WP_Error( 'parsing-error', __( 'There was an error parsing the JSON.', 'openagenda' ), $body );
        }
        return $json;
    }


    /**
     * Maybe cache the raw reponse.
     */
    public function maybe_cache(){
        if( $this->should_cache() ){
            $settings        = get_option( 'openagenda_general_settings' );
            $cache_duration  = ! empty( $settings['openagenda_cache_duration'] ) ? (int) $settings['openagenda_cache_duration'] : HOUR_IN_SECONDS;
            set_transient( $this->get_transient_name(), $this->raw_response, $cache_duration );
        }
    }


    /**
     * Returns the transient in which data should be stored for this request.
     * 
     * @return  string  $transient_name
     */
    public function get_transient_name(){
        $suffix = $this->is_single() ? sanitize_title( $this->get_args()['oaq']['slug'] ) : 'p' . (int) $this->page;
        $transient_name = sprintf( 'oa-%d-%s', (int) $this->uid, $suffix );
        return $transient_name;
    }


    /**
     * Returns whether the current request should be cached or not.
     * 
     * @return  bool  $should_cache
     */
    public function should_cache(){
        if( defined( 'DOING_AJAX' ) && DOING_AJAX ) return false;
        if( $this->total_pages === 0 ) return false;
        if( ! $this->use_cache ) return false;
        $should_cache = empty( $this->get_filters() ) || $this->is_single();
        return $should_cache;
    }


    /**
     * Returns whether the current request should be cached or not.
     * 
     * @return  bool  $should_cache
     */
    public function should_serve_cache(){
        if( defined( 'DOING_AJAX' ) && DOING_AJAX ) return false;
        if( ! $this->use_cache ) return false;
        $should_serve_cache = empty( $this->get_filters() ) || $this->is_single();
        return $should_serve_cache;
    }


    /**
     * Flushes cache
     */
    public function openagenda_flush_cache(){
        global $wpdb;
        $wpdb->query( "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('_transient_oa_%')" );
        $wpdb->query( "DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('_transient_timeout_oa_%')" );
    }


    /**
     * Returns whether there are events to display.
     */
    public function have_events(){
        return ! empty( $this->events ) && $this->count > 0 && $this->count > $this->index;
    }


    /**
     * Prepares the event to display.
     */
    public function the_event(){
        $events       = $this->get_events();
        $this->event  = $events[$this->index];
        $this->index += 1;
    }


    /**
     * Returns whether there are pages to go through
     */
    public function have_pages(){
        return $this->total_pages > 1;
    }


    /**
     * Returns the offset of the current event in the loop
     */
    public function get_event_offset(){
        $offset = (int) $this->offset;
        $index  = (int) $this->index === 0 ? 0 : (int) $this->index - 1;
        $event_offset = $offset + $index;
        return $event_offset;
    }


    /**
     * Returns whether this instance uses context
     */
    public function use_context(){
        return (bool) $this->use_context;
    }


    /**
     * Gets the navigation context
     */
    function get_context(){
        if( ! $this->use_context ) return false;
        $context = ! empty( $this->context ) ? $this->context : false;
        return $context;            
    }
    

    /**
     * Sets the navigation context
     */
    function set_context(){
        if( ! $this->use_context ) return;
        if( $this->is_archive() ){
            $args = $this->get_args();
            $this->context = $this->get_args();
            $this->context['total'] = (int) $this->total;
        } else {
            $context = openagenda_decode_context();
            if( $context ){
                $this->context = $context;
            }
        }
    }
}
