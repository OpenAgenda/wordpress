<?php
namespace Openagenda;
/**
 * Core class.
 * 
 * Loads main files and register hooks.
 */
class Main {

    /**
     * Array of dependencies objects
     */
    private $dependencies = array();
    
    /**
     * Array of available filters
     */
    private $available_filters = array();

    /**
     * Constructor
     */
    public function __construct(){
        $this->available_filters = array(
            'openagenda_filter_active' => array(
                'label'     => _x( 'Active filters', 'Filter name', 'openagenda' ),
                'shortcode' => 'openagenda_filter_active',
                'script'    => 'assets/js/filters/oaActiveFilters.min.js',
            ),
            'openagenda_filter_tags' => array(
                'label'     => _x( 'Tags', 'Filter name', 'openagenda' ),
                'shortcode' => 'openagenda_filter_tags',
                'script'    => 'assets/js/filters/cibulTagsWidget.min.js',
            ),
            'openagenda_filter_calendar' => array(
                'label'     => _x( 'Calendar', 'Filter name', 'openagenda' ),
                'shortcode' => 'openagenda_filter_calendar',
                'script'    => 'assets/js/filters/cibulCalendarWidget.min.js',
            ),
            'openagenda_filter_map' => array(
                'label'     => _x( 'Map', 'Filter name', 'openagenda' ),
                'shortcode' => 'openagenda_filter_map',
                'script'    => 'assets/js/filters/cibulMapWidget.min.js',
            ),
            'openagenda_filter_relative' => array(
                'label'     => _x( 'Upcoming', 'Filter name', 'openagenda' ),
                'shortcode' => 'openagenda_filter_relative',
                'script'    => 'assets/js/filters/oaRelativeWidget.min.js',
            ),
            'openagenda_filter_search' => array(
                'label'     => _x( 'Search', 'Filter name', 'openagenda' ),
                'shortcode' => 'openagenda_filter_search',
                'script'    => 'assets/js/filters/cibulSearchWidget.min.js',
            ),
        );
    }
    
    /**
     * Loads required files. 
     */
    public function init(){
        $this->load_dependencies();
        $this->register_hooks();
    }

    /**
     * Loads necessary files and register them as dependencies
     */
    private function load_dependencies(){
        
        // Needed both on frontend and backend
        require_once OPENAGENDA_PATH . 'inc/interface-hookable.php';
        require_once OPENAGENDA_PATH . 'inc/helper-functions.php';
        require_once OPENAGENDA_PATH . 'inc/template-tags.php';
        require_once OPENAGENDA_PATH . 'inc/class-content-manager.php';
        require_once OPENAGENDA_PATH . 'inc/class-openagenda.php';
        require_once OPENAGENDA_PATH . 'inc/class-customizer-settings.php';
        require_once OPENAGENDA_PATH . 'inc/class-shortcodes.php';
        $this->dependencies['content-manager'] = new Content_Manager();
        $this->dependencies['customizer']      = new Customizer_Settings();
        $this->dependencies['shortcodes']      = new Shortcodes();

        if( is_admin() ){
            // Only needed in the admin
            require_once OPENAGENDA_PATH . 'inc/class-admin-pages.php';
            require_once OPENAGENDA_PATH . 'inc/class-settings.php';
            require_once OPENAGENDA_PATH . 'inc/class-metaboxes.php';
            require_once OPENAGENDA_PATH . 'inc/class-ajax-handler.php';
            $this->dependencies['admin-pages']  = new Admin_Pages();
            $this->dependencies['settings']     = new Settings();
            $this->dependencies['metaboxes']    = new Metaboxes();
            $this->dependencies['ajax-handler'] = new Ajax_Handler();
        }
    }

    /**
     * Hooks all the dependencies
     */
    private function register_hooks(){
        foreach ( $this->dependencies as $key => $dependency ) {
            $dependency->register_hooks();
        }
        add_action( 'wp', array( $this, 'init_calendar' ) );
        add_action( 'wp_head', array( $this, 'wp_head' ) );
        add_action( 'widgets_init', array( $this, 'register_widgets' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
    }


    /**
     * Writes necessary <head> styles for spinner
     */
    public function wp_head(){
        $customizer_settings = get_option( 'openagenda_customizer' );
        $main_color = isset( $customizer_settings['main_color'] ) ? $customizer_settings['main_color'] : '#41acdd';
        $oa_styles = '.oa-icon{width: 24px; height: 24px;}.oa-icon-refresh{animation: rotate 1s linear infinite;}@keyframes rotate{to{transform: rotateZ(360deg)}}';
        
        if( $main_color ){
            $oa_styles .= sprintf( ':root{--oa-main-color: %s }', sanitize_hex_color( $main_color ));
        }

        printf( '<style id="oa-styles">%s</style>', $oa_styles );
    }


    /**
     * Register the filter widget
     */
    public function register_widgets(){
        require_once OPENAGENDA_PATH . 'inc/class-filter-widget.php';
        require_once OPENAGENDA_PATH . 'inc/class-preview-widget.php';
        $args = array( 'available_filters' => $this->get_available_filters() );
        $filter_widget = new Filter_Widget( $args );
        register_widget( $filter_widget );
        register_widget( 'Openagenda\Preview_Widget' );
    }


    /**
     * Loads scripts and styles
     */
    public function register_scripts(){

        $css_suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';
        $js_suffix  = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';

        // Register main styles and scripts
        wp_register_style( 'openagenda-main', OPENAGENDA_URL . 'assets/css/style' . $css_suffix, array(), OPENAGENDA_VERSION );
        wp_register_script( 'openagenda-main', OPENAGENDA_URL . 'assets/js/main' . $js_suffix, array( 'jquery' ), OPENAGENDA_VERSION, true );
        wp_register_script( 'openagenda-controllers', OPENAGENDA_URL . 'assets/js/filters/cibulControllers.min.js', array(), OPENAGENDA_VERSION, true );
        
        // Register filters style and scripts
        $filters = $this->get_available_filters();
        foreach ( $filters as $slug => $data ) {
            if( ! empty( $data['script'] ) ){
                wp_register_script( sanitize_title( $slug ), esc_url( OPENAGENDA_URL . $data['script'] ) , array( 'openagenda-main' ), OPENAGENDA_VERSION, true );
            }
        }

        // Preview widget JS
        wp_register_script( 'oa-preview-widget', OPENAGENDA_URL . 'assets/js/filters/oaPreviewWidget.min.js', array( 'openagenda-controllers' ), OPENAGENDA_VERSION, true );

        // Register map dependencies
        wp_register_style( 'oa-leaflet', OPENAGENDA_URL . 'assets/css/leaflet' . $css_suffix, array(), OPENAGENDA_VERSION );
        wp_register_script( 'oa-leaflet', OPENAGENDA_URL . 'assets/js/leaflet.min.js', array(), OPENAGENDA_VERSION, true );
        wp_register_script( 'oa-event-map', OPENAGENDA_URL . 'assets/js/event-map' . $js_suffix, array( 'jquery', 'oa-leaflet' ), OPENAGENDA_VERSION, true );
        
        // Timings calendar JS
        wp_register_script( 'oa-timings', OPENAGENDA_URL . 'assets/js/timings' . $js_suffix, array(), OPENAGENDA_VERSION, true );
        
        if( openagenda_should_enqueue_styles() ){
            wp_enqueue_style( 'openagenda-main' );
        }
        
        if( is_singular( 'oa-calendar' ) ){
            wp_enqueue_script( 'openagenda-main' );
            wp_enqueue_script( 'openagenda-controllers' );
            wp_localize_script( 'openagenda-main', 'oaData', array(
                'nonce'       => wp_create_nonce( 'update_events' ),
                'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
                'postId'      => get_the_ID(),
                'view'        => get_post_meta( get_the_ID(), 'oa-calendar-view', true ) ? sanitize_title( get_post_meta( get_the_ID(), 'oa-calendar-view', true ) ) : 'list',
                'overlayHtml' => \openagenda_get_update_overlay_html(),
                'errorNotice' => \openagenda_get_update_notice_html(),
                'isSingle'    => \openagenda_is_single()
            ) );       
        }
    }


    /**
     * Returns array of available filters
     */
    public function get_available_filters(){
        return apply_filters( 'openagenda_available_filters', $this->available_filters );
    }


    /**
     * Initialize the global openagenda instance
     */
    public function init_calendar(){
        global $openagenda;     
        if( is_singular( 'oa-calendar' ) ){
    
            // Parse URL structure
            $uid  = get_post_meta( get_the_ID(), 'oa-calendar-uid', true );
            $args = array(
                'limit'  => get_post_meta( get_the_ID(), 'oa-calendar-per-page', true ) ? (int) get_post_meta( get_the_ID(), 'oa-calendar-per-page', true ) : (int) get_option( 'posts_per_page' ),
                'page'   => ! empty( get_query_var( 'oa-page' ) ) ? sanitize_title( get_query_var( 'oa-page' ) ) : 1,
                'oaq'    => array(
                    'slug' => ! empty( get_query_var( 'oa-slug' ) ) ? sanitize_title( get_query_var( 'oa-slug' ) ) : '',
                ),
            );

            if( ! empty( $filters = get_query_var( 'oaq' ) ) ){
                $args['oaq'] = array_merge( $args['oaq'], $filters );
            }

            if( $uid ){
                $openagenda = new Openagenda( $uid, $args );
            }
        }
    }
}
