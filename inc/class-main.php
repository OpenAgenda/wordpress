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
                'label'     => __( 'Active filters', 'openagenda' ),
                'shortcode' => 'openagenda_filter_active',
                'script'    => '//openagenda.com/js/embed/oaActiveFilters.js',
            ),
            'openagenda_filter_tags' => array(
                'label'     => __( 'Tags', 'openagenda' ),
                'shortcode' => 'openagenda_filter_tags',
                'script'    => '//openagenda.com/js/embed/cibulTagsWidget.js',
            ),
            'openagenda_filter_calendar' => array(
                'label'     => __( 'Calendar', 'openagenda' ),
                'shortcode' => 'openagenda_filter_calendar',
                'script'    => '//openagenda.com/js/embed/cibulCalendarWidget.js',
            ),
            'openagenda_filter_map' => array(
                'label'     => __( 'Map', 'openagenda' ),
                'shortcode' => 'openagenda_filter_map',
                'script'    => '//openagenda.com/js/embed/cibulMapWidget.js',
            ),
            'openagenda_filter_preview' => array(
                'label'     => __( 'Preview', 'openagenda' ),
                'shortcode' => 'openagenda_filter_preview',
                'script'    => '//openagenda.com/js/embed/oaPreviewWidget.js',
            ),
            'openagenda_filter_relative' => array(
                'label'     => __( 'Relative', 'openagenda' ),
                'shortcode' => 'openagenda_filter_relative',
                'script'    => '//openagenda.com/js/embed/oaRelativeWidget.js',
            ),
            'openagenda_filter_search' => array(
                'label'     => __( 'Search', 'openagenda' ),
                'shortcode' => 'openagenda_filter_search',
                'script'    => '//openagenda.com/js/embed/cibulSearchWidget.js',
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
        $this->dependencies['content-manager'] = new Content_Manager();

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
        } else {
            // Only needed on frontend
            require_once OPENAGENDA_PATH . 'inc/class-shortcodes.php';
            $this->dependencies['shortcodes']  = new Shortcodes();
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
        echo '<style id="oa-styles">.oa-icon{width: 24px; height: 24px;}.oa-icon-refresh{animation: rotate 1s linear infinite;}@keyframes rotate{to{transform: rotateZ(360deg)}}</style>';
    }


    /**
     * Register the filter widget
     */
    public function register_widgets(){
        require_once OPENAGENDA_PATH . 'inc/class-filter-widget.php';
        $args = array( 'available_filters' => $this->get_available_filters() );
        $filter_widget = new Filter_Widget( $args );
        register_widget( $filter_widget );
    }


    /**
     * Loads scripts and styles
     */
    public function register_scripts(){
        // Register main styles and scripts
        wp_register_style( 'openagenda-main', OPENAGENDA_URL . 'assets/css/style.css', array(), OPENAGENDA_VERSION );
        wp_register_script( 'openagenda-main', OPENAGENDA_URL . 'assets/js/main.js', array( 'jquery' ), OPENAGENDA_VERSION, true );
        
        // Register filters style and scripts
        $filters = $this->get_available_filters();
        foreach ( $filters as $slug => $data ) {
            if( ! empty( $data['script'] ) ){
                wp_register_script( sanitize_title( $slug ), esc_url( $data['script'] ) , array( 'openagenda-main' ), OPENAGENDA_VERSION, true );
            }
        }

        // Register map dependencies
        wp_register_style( 'oa-leaflet', '//unpkg.com/leaflet@1.3.4/dist/leaflet.css', array(), OPENAGENDA_VERSION );
        wp_register_script( 'oa-leaflet', '//unpkg.com/leaflet@1.3.4/dist/leaflet.js', array(), OPENAGENDA_VERSION, true );
        wp_register_script( 'oa-event-map', OPENAGENDA_URL . 'assets/js/event-map.js', array( 'jquery', 'oa-leaflet' ), OPENAGENDA_VERSION, true );
        
        // Timings calendar JS
        wp_register_script( 'oa-timings', OPENAGENDA_URL . 'assets/js/timings.js', array(), OPENAGENDA_VERSION, true );

        if( is_singular( 'oa-calendar' ) ){
            wp_enqueue_script( 'openagenda-main' );
            wp_localize_script( 'openagenda-main', 'oaData', array(
                'nonce'       => wp_create_nonce( 'update_events' ),
                'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
                'postId'      => get_the_ID(),
                'view'        => 'list',
                'overlayHtml' => \openagenda_get_update_overlay_html(),
                'errorNotice' => \openagenda_get_update_notice_html(),
            ) );

            if( \openagenda_should_enqueue_styles() ){
                wp_enqueue_style( 'openagenda-main' );
            }
        }
    }


    /**
     * Returns array of available filters
     */
    public function get_available_filters(){
        return apply_filters( 'openagenda_available_filters', $this->available_filters );
    }


    /**
     * Initialize the global open_agenda instance
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
                if( (int) $args['page'] > $openagenda->get_total_pages() ){
                    wp_safe_redirect( \openagenda_get_page_permalink() );
                    exit;
                }
            }
        }
    }
}
