<?php
namespace Openagenda;
/**
 * Class for handling request to Openagenda API.
 */
class Openagenda {

    /**
     * Base API URL
     */
    protected $base_api_url = 'https://api.openagenda.com/v2';

    /**
     * Base Exports URL
     */
    protected $base_exports_url = 'https://openagenda.com';
    
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
    protected $source = '';
    
    /**
     * Arguments 
     */
    protected $args = array();
    
    /**
     * Query params 
     */
    protected $params = array();
    
    /**
     * Query filters 
     */
    protected $filters = array();
    
    /**
     * Index when looping
     */
    protected $index = 0;

    /**
     * Number of events per page
     */
    protected $size = '';
    
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
     * Debug
     */
    protected $debug = false;

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
     * Is the query to preview another agenda ?
     */
    protected $is_preview = false;
    
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
        $this->debug    = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG;

        $this->use_cache    = (bool) $use_cache;
        $this->use_context  = (bool) $use_context;

        $this->args         = $this->parse_args( $args );
        $this->raw_response = $this->request( $this->get_args() );
        $this->json         = $this->parse_response();

        if( $this->is_single() ){
            $this->events = ! empty( $this->json['event'] ) ? array( $this->json['event'] ) : array();
            $this->total  = ! empty( $this->json['event'] ) ? 1 : 0;
        } else {
            $this->events = ! empty ( $this->json['events'] ) && is_array( $this->json['events'] ) ? $this->json['events'] : array();
            $this->total  = ! empty( $this->json['total'] ) ? (int) $this->json['total'] : 0;
        }
        
        $this->event        = ! empty( $this->get_events() ) ? $this->get_events()[0] : null;
        $this->count        = count( $this->get_events() );
        $page_size          = ! empty( $args['page_size'] ) ? (int) $args['page_size'] : (int) get_option( 'posts_per_page' );
        $this->total_pages  = (int) ceil( $this->total / $page_size );

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
     * Returns the number of events per request.
     */
    public function get_size(){
        return $this->size;
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
     * Returns query params
     */
    public function get_params(){
        return apply_filters( 'openagenda_params', $this->params, $this->uid );
    }


    /**
     * Returns query filters
     */
    public function get_filters(){
        return apply_filters( 'openagenda_filters', $this->filters, $this->uid );
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
     * Returns the raw response.
     */
    public function get_raw_response(){
        return $this->raw_response;
    }


    /**
     * Returns the JSON reponse.
     */
    public function get_json(){
        return $this->json;
    }


    /**
     * Returns the source.
     */
    public function get_source(){
        return $this->source;
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
        return apply_filters( 'openagenda_is_archive', $this->is_archive, $this->uid );
    }


    /**
     * Returns whether we're on a single page
     * 
     * @return  bool  $is_single
     */
    public function is_single(){
        return apply_filters( 'openagenda_is_single', $this->is_single, $this->uid );
    }

    
    /**
     * Returns whether we're previewing another agenda
     * 
     * @return  bool  $is_preview
     */
    public function is_preview(){
        return apply_filters( 'openagenda_is_preview', $this->is_preview, $this->uid );
    }


    /**
     * Retrieve the longDescription field format
     */
    public function get_longDescription_format(){
        return $this->include_embedded ? 'HTMLWithEmbeds' : 'markdown';
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
        );
        return apply_filters( 'openagenda_exports_formats', $formats, $this->uid );
    }      


    /**
     * Returns the Base export URL.
     * 
     * @param   string  $format           Format to get export in.
     * @return  string  $base_export_url  URL to the root events export, based on UID. 
     */
    public function get_export_url( $format = 'json' ){
        $base_export_url = sprintf( '%s/agendas/%s/events.v2.%s', $this->base_exports_url, $this->uid, sanitize_title( $format ) );
        return $base_export_url;
    }


    /**
     * Returns the base API URL.
     * 
     * @return  string  $base_API_url  URL to the root events export, based on UID. 
     */
    public function get_api_url( $slug = false ){
        $base_api_url = sprintf( '%s/agendas/%s/events', $this->base_api_url, $this->uid );
        if ( $this->is_single() && $slug ) {
            $base_api_url = sprintf( '%s/agendas/%s/events/slug/%s', $this->base_api_url, $this->uid, sanitize_text_field( $slug ) );
        }
        return $base_api_url;
    }


    /**
     * Returns a usable request URL
     * Finalizes the request URL by adding user API key and other params.
     * 
     * @param   string  $export  Export format, if request is for an export.
     * @return  string  $url     URL for the export event. 
     */
    public function get_request_url( $export = false ){

        // Get the base url
        $args    = $this->get_args();
        $params  = $this->get_params();
        $filters = $this->get_filters();
        $slug    = ! empty( $args['slug'] ) ? $args['slug'] : false;
        $url     = ! empty( $export ) ? $this->get_export_url( $export ) : $this->get_api_url( $slug );      
        
        // Remove slug and context from params
        unset( $filters['context'] );
        if( $slug ) {
            unset( $filters['slug'] );
            $params['detailed'] = 1;
        }

        // Add key query var
        $url = add_query_arg( 'key', $this->get_api_key(), $url );

        // Add params and filters
        $string = http_build_query( array_merge( $params, $filters ) );
        if( ! empty( $string ) ){
            $url .= sprintf( '&%s', $string );
        }

        return apply_filters( 'openagenda_request_url', $url, $this->uid, $args, $export );
    }


    /**
     * Parse query arguments
     */
    public function parse_args( $args = array() ){
        $defaults = $this->get_default_params();
        if ( 'markdown' !== $this->get_longDescription_format() ){
            $defaults['longDescriptionFormat'] = $this->get_longDescription_format();
        }
        $args = array_filter( wp_parse_args( $args, $defaults ), function( $value ){ return '' !== $value; } );

        $this->is_single   = ! empty( $args['slug'] );
        $this->is_archive  = ! $this->is_single;
        $this->page        = ! empty ( $args['page'] ) ? (int) $args['page'] : 1;
        $this->size        = $this->is_single() ? 1 : (int) $args['size'];
        $this->offset      = ( $this->page - 1 ) * $this->size;
        $this->is_preview  = ! empty( $args['id'] ) && 'preview' === $args['id'];
        if( $this->page > 1 )    $args['from'] = (int) $this->offset;
        if( $this->is_single() ) $args['size'] = 1;
        unset( $args['page_size'] );
        unset( $args['page'] );
        unset( $args['id'] );

        $this->params  = $this->extract_params( $args );
        $this->filters = $this->extract_filters( $args );
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
            if( $this->debug ) error_log( sprintf( 'Openagenda request URL : %s', esc_url( $this->get_request_url() ) ) );
        }

        if( is_wp_error( $response ) ){
            $this->errors[] = $response;
            if( $this->debug ) error_log( sprintf( 'Openagenda request error : %s', sanitize_text_field( $response->get_error_message() ) ) );
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
        $suffix = $this->is_single() ? sanitize_title( $this->get_args()['slug'] ) : 'p' . (int) $this->page;
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
     * Resets the index
     */
    public function reset_index(){
        $this->index = 0;
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
            $params  = $this->get_params();
            $filters = $this->get_filters();
            $this->context = array(
                'params'  => $params,
                'filters' => $filters,
                'page'    => (int) $this->get_current_page(),
                'total'   => (int) $this->get_total(),
            );
        } else {
            $context = openagenda_decode_context();
            if( $context ){
                $this->context = $context;
            }
        }
    }

    /**
     * Extract API params from an array or arguments
     * 
     * @param   array  $args     Array of args
     * @return  array  $params   Array of params
     */
    public function extract_params( $args = array() ){
        if( empty( $args ) ){
            $args = $this->get_args();
        }
        $params   = array();
        $defaults = array_keys( $this->get_default_params() );
        $params   = array_filter( $args, function( $arg, $key ) use ( $defaults ) {
            return in_array( $key, $defaults );
        }, ARRAY_FILTER_USE_BOTH );
        return apply_filters( 'openagenda_extracted_params', $params, $args );
    }


    /**
     * Cleans up an array of api query argument to get only filters
     * 
     * @param   array  $args     Array of args
     * @return  array  $filters  Array of filters
     */
    public function extract_filters( $args ){
        $filters  = array();
        $defaults = array_keys( $this->get_default_params() );
        $filters  = array_filter( $args, function( $value, $key ) use ( $defaults ) {
            return ! in_array( $key, $defaults );
        }, ARRAY_FILTER_USE_BOTH );
        return apply_filters( 'openagenda_extracted_filters', $filters, $args );
    }


    /**
     * Returns default api params keys
     */
    public function get_default_params(){
        $defaults = array( 
            'agendaUid'     => '', 
            'detailed'      => '', 
            'size'          => 20, 
            'after'         => '', 
            'from'          => '', 
            'longDescriptionFormat' => '',
            'includeLabels' => true,
        );
        return apply_filters( 'openagenda_api_default_params', $defaults );
    }
}
