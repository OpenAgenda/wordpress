<?php
namespace Openagenda;
/**
 * Class handling content types, taxonomies, and custom fields.
 */
class Content_Manager implements Hookable {

    /**
     * Post types to register
     */
    protected $post_types;

    /** 
     * Class constructor 
     */
    public function __construct() {
        $rewrite_settings = get_option( 'openagenda_permalinks_settings' );
        $rewrite_base     = ! empty( $rewrite_settings ) && ! empty ( $rewrite_settings['openagenda_calendar_base'] ) ? $rewrite_settings['openagenda_calendar_base'] :  __( 'calendar', 'openagenda' ); 
        
        $this->post_types = array(
            'oa-calendar' => array(
                'labels' => array(
                    'name'                  => _x( 'Calendars', 'Post type general name', 'openagenda' ),
                    'singular_name'         => _x( 'Calendar', 'Post type singular name', 'openagenda' ),
                    'menu_name'             => _x( 'Calendars', 'Admin Menu text', 'openagenda' ),
                    'name_admin_bar'        => _x( 'Calendar', 'Add New on Toolbar', 'openagenda' ),
                    'add_new_item'          => __( 'Add New Calendar', 'openagenda' ),
                    'new_item'              => __( 'New Calendar', 'openagenda' ),
                    'edit_item'             => __( 'Edit Calendar', 'openagenda' ),
                    'view_item'             => __( 'View Calendar', 'openagenda' ),
                    'all_items'             => __( 'All Calendars', 'openagenda' ),
                    'search_items'          => __( 'Search Calendars', 'openagenda' ),
                    'parent_item_colon'     => __( 'Parent Calendars:', 'openagenda' ),
                    'not_found'             => __( 'No Calendars found.', 'openagenda' ),
                    'not_found_in_trash'    => __( 'No Calendars found in Trash.', 'openagenda' ),
                    'featured_image'        => _x( 'Calendar Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'openagenda' ),
                    'archives'              => _x( 'Calendar archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'openagenda' ),
                    'insert_into_item'      => _x( 'Insert into Calendar', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'openagenda' ),
                    'uploaded_to_this_item' => _x( 'Uploaded to this Calendar', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'openagenda' ),
                    'filter_items_list'     => _x( 'Filter Calendars list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'openagenda' ),
                    'items_list_navigation' => _x( 'Calendars list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'openagenda' ),
                    'items_list'            => _x( 'Calendars list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'openagenda' ),
                ),
                'hierarchical'  => true,
                'public'        => true,
                'show_in_rest'  => true,
                'menu_icon'     => 'dashicons-book',
                'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
                'has_archive'   => false,
                'menu_position' => 5,
                'rewrite'       => array(
                    'slug' => sanitize_title( $rewrite_base ),
                ),
            ),
        );
    }

    /**
     * Register all the hooks
     */
    public function register_hooks(){
        add_action( 'init', array( $this, 'register_post_types' ), 10 );
        add_action( 'init', array( $this, 'register_rewrite_rules' ), 10 );
        add_action( 'wp_head', array( $this, 'wp_head_meta' ), 10 );
        add_filter( 'body_class', array( $this, 'body_class'), 10, 1 );
        add_filter( 'document_title_parts', array( $this, 'document_title_parts' ), 10, 1 );
        add_filter( 'the_content', array( $this, 'the_content' ), 10, 2 );
        add_filter( 'write_your_story', array( $this, 'write_your_story' ), 10, 2 );
        
        // Frontend meta tags and Yoast SEO Filters
        if( ! is_admin() ) {
            add_filter( 'get_canonical_url', array( $this, 'canonical_url' ), 10, 1 );
            add_filter( 'get_shortlink', array( $this, 'get_shortlink' ), 10, 4 );
            add_filter( 'wpseo_canonical', array( $this, 'canonical_url' ), 10, 1 ); 
            add_filter( 'wpseo_replacements', array( $this, 'wpseo_replacements' ), 10, 2 );
            add_filter( 'wpseo_metadesc', array( $this, 'yoast_seo_metadata' ), 10, 1 );
            add_filter( 'wpseo_twitter_description', array( $this, 'yoast_seo_metadata' ), 10, 1 );
            add_filter( 'wpseo_twitter_image', array( $this, 'yoast_seo_metadata' ), 10, 1 );
            add_filter( 'wpseo_twitter_title', array( $this, 'yoast_seo_metadata' ), 10, 1 );
            add_filter( 'wpseo_opengraph_title', array( $this, 'yoast_seo_metadata' ), 10, 1 );
            add_filter( 'wpseo_opengraph_desc', array( $this, 'yoast_seo_metadata' ), 10, 1 );
            add_filter( 'wpseo_opengraph_url', array( $this, 'yoast_seo_metadata' ), 10, 1 );
            add_filter( 'wpseo_opengraph_image', array( $this, 'yoast_seo_metadata' ), 10, 1 );
        }
    }

    
    /**
     * Registers necessary post types
     */
    public function register_post_types(){
        $post_types = $this->get_post_types();
        foreach ( $post_types as $slug => $args ) {
            register_post_type( $slug, $args );
        }
    }


    /**
     * Returns a filterable array of post types to register
     * 
     * @return  array  $post_types
     */
    public function get_post_types(){
        return apply_filters( 'openagenda_post_types', $this->post_types );
    }


    /**
     * Register rewrite rule for single events.
     */
    public function register_rewrite_rules(){

        // Add support for new query vars
        add_rewrite_tag( '%oa-slug%', '([^&]+)' );
        add_rewrite_tag( '%oa-page%', '(\d+)' );
        add_rewrite_tag( '%oaq%', '([^&]+)' );

        // If pretty permalinks are enabled, add in our rewrite rules.
        if( ! empty( get_option( 'permalink_structure' ) ) ){
            $rewrite_settings = get_option( 'openagenda_permalinks_settings' );
            $rewrite_base     = ! empty( $rewrite_settings ) && ! empty ( $rewrite_settings['openagenda_calendar_base'] ) ? $rewrite_settings['openagenda_calendar_base'] :  __( 'calendar', 'openagenda' ); 
            add_rewrite_rule( "${rewrite_base}/([^/]+)/page/(\d+)?", 'index.php?oa-calendar=$matches[1]&oa-page=$matches[2]', 'top' );
            add_rewrite_rule( "${rewrite_base}/([^/]+)/([^&]+)?", 'index.php?oa-calendar=$matches[1]&oa-slug=$matches[2]', 'top' );
        }
    }


    /**
     * Adds relevant body classes
     * 
     * @param   array  $classes  Array of registered body classes
     * @return  array  $classes
     */
    public function body_class( $classes ) {
        global $openagenda;
        if( $openagenda && is_singular( 'oa-calendar' ) ){
            $classes[] = openagenda_is_single() ? 'single-oa-calendar-event' : 'single-oa-calendar-archive';
        }
        return $classes;
    }


    /**
     * Filters the canonical URL provided by WordPress
     * 
     * @param   string  $url  Canonical Url
     * @return  string  $url  
     */
    public function canonical_url( $url ) {
        if( is_singular( 'oa-calendar' ) && \openagenda_is_single() ){
            $url = openagenda_event_permalink( false, false, false );
        }
        return $url;
    }


    /**
     * Filters the shortlink
     * 
     * @param   string  $shortlink
     * @param   int     $id          Post id
     * @param   string  $context
     * @param   bool    $allow_slug  Not used
     * @return  string  $shortlink
     */
    public function get_shortlink( $shortlink, $id, $context, $allow_slugs ) {
        if( is_singular( 'oa-calendar' ) && \openagenda_is_single() ){
            $event_slug = openagenda_get_field( 'slug' );
            $shortlink  = add_query_arg( 'oa-slug', sanitize_title( $event_slug ), $shortlink );
        }
        return $shortlink;
    }
 

    /**
     * Filters the page title
     */
    public function the_title( $title, $id ){
        if( is_singular( 'oa-calendar' ) && \openagenda_is_single() ){
            $title = \openagenda_get_field( 'title', false, false );
        }
        return $title;
    }


    /**
     * Filters the content
     */
    public function the_content( $content ){
        if( ! is_singular( 'oa-calendar' ) ) return $content;
            
        $display_content = openagenda_is_archive() ? get_post_meta( get_the_ID(), 'oa-calendar-content-on-archive', true ) : get_post_meta( get_the_ID(), 'oa-calendar-content-on-single', true );
        $filters         = openagenda_is_archive() ? openagenda_filter( 'active', array(), false ) : '';

        if( 'yes' !== $display_content ){
            $content = do_shortcode( '[openagenda]' );
        } else {
            if( ! has_shortcode( $content, 'openagenda' ) ){
                $content .= do_shortcode( '[openagenda]' );
            }
        }

        return $content;
    }


    /**
     * Filters the content prompt on calendars.
     * 
     * @param   string   $prompt  Default Prompt
     * @param   WP_Post  $post    Current post
     * @return  string   $prompt  Default Prompt
     */
    public function write_your_story( $prompt, $post ){
        if( 'oa-calendar' === $post->post_type ){
            $prompt = __( 'Please provide a calendar UID in this calendar\'s settings box first.', 'openagenda' );
        }
        return $prompt;
    }
    

    /**
     * Filters the permalink for single events.
     * 
     * @param   string   $post_link  Post permalink
     * @param   WP_Post  $post       Post object
     * @param   bool     $leavename  Whether to keep the post name
     * @param   bool     $sample     Is it a sample permalink
     * @return  string   $post_link
     */
    public function permalink( $post_link, $post, $leavename, $sample ){
        if( is_singular( 'oa-calendar' ) && \openagenda_is_single() ){
            $slug      = \openagenda_get_field( 'slug' );
            $post_link = ! empty( get_option( 'permalink_structure' ) ) ? trailingslashit( $post_link ) . $slug : add_query_arg( 'oa-slug', urlencode( $slug ), $post_link );
        }
        return $post_link;
    }


    /**
     * Writes meta tags in the <head> of the page
     */
    public function wp_head_meta() {
        global $openagenda;
        
        // Let Yoast do the heavy lifting by default
        if ( in_array( 'wordpress-seo/wp-seo.php', (array) get_option( 'active_plugins', array() ), true ) ) return;

        if( is_singular( 'oa-calendar' ) && $openagenda ){
            foreach ( $this->get_default_meta() as $name => $content ) {
                printf( '<meta name="%s" content="%s">', esc_attr( $name ), esc_attr( $content ) );
            }
            foreach ( $this->get_default_properties() as $name => $content ) {
                printf( '<meta property="%s" content="%s">', esc_attr( $name ), esc_attr( $content ) );
            }
        }
    }


    /**
     * Filters the title parts of the document.
     * 
     * @param   array  $parts  Array of title elements
     * @return  array  $parts
     */
    public function document_title_parts( $parts ){
        if( is_singular( 'oa-calendar' ) && \openagenda_is_single() ){
            $parts['title'] = strip_tags( \openagenda_get_field( 'title', false, false ) );
        }
        return $parts;
    }


    /**
     * Retrieves default <meta> tags to print in <head>
     * 
     * @return array  $metas  Associative array name => content
     */
    public function get_default_meta(){
        global $post;
        global $openagenda;
        $title = wp_get_document_title();

        $metas = array( 
            'title'         => $title,
            'twitter:site'  => get_bloginfo( 'name' ),
            'twitter:card'  => 'summary_large_image',
            'twitter:title' => $title,
        );
        
        if( $openagenda->is_single() ){
            $event          = openagenda_get_event();
            $image_filename = ! empty( $event['image']['filename'] ) ? $event['image']['filename'] : '';
            $image_url      = ! empty( $image_filename ) && ! empty( $event['image']['base'] ) ? trailingslashit( $event['image']['base'] ) . $image_filename : false;
            if( ! empty( $description = \openagenda_get_field( 'description', false ) ) ) {
                $metas['description']         = $description;
                $metas['twitter:description'] = $description;
            }
            if( $image_url ){
                $metas['twitter:image'] = esc_url( $image_url );
            }
        }

        if( $openagenda->is_archive() ){
            if( ! empty( $description = wp_strip_all_tags( $post->post_excerpt ) ) ) {
                $metas['description']         = $description;
                $metas['twitter:description'] = $description;
            }
            if( has_post_thumbnail() ){
                $metas['twitter:image'] = get_the_post_thumbnail_url( $post, 'medium' );
            }
        }

        return apply_filters( 'openagenda_default_meta', $metas );
    }


    /**
     * Retrieves default <meta> properties to print in <head>
     * 
     * @return array  $metas  Associative array property => content
     */
    public function get_default_properties(){
        global $post;
        global $openagenda;
        $title = wp_get_document_title();

        $properties = array(
            'og:locale'      => get_locale(),
            'og:site_name'   => get_bloginfo( 'name' ),
            'og:type'        => 'article',
            'og:title'       => $title,
        );
        
        if( $openagenda->is_single() ){
            $properties['og:url'] = esc_url( \openagenda_get_field( 'permalink', false ) ) ;

            $event          = openagenda_get_event();
            $image_filename = ! empty( $event['image']['filename'] ) ? $event['image']['filename'] : '';
            $image_url      = ! empty( $image_filename ) && ! empty( $event['image']['base'] ) ? trailingslashit( $event['image']['base'] ) . $image_filename : false;
            $description    = ! empty( \openagenda_get_field( 'description', false ) ) ? \openagenda_get_field( 'description', false ) : false;
            if( $description ){
                $properties['og:description'] = wp_strip_all_tags( $description );
            }
            if( $image_url ){
                $properties['og:image'] = esc_url( $image_url );
            }
        }
        
        if( $openagenda->is_archive() ){
            $properties['og:url'] = esc_url( get_permalink() ) ;
            if( ! empty( $post->post_excerpt ) ){
                $properties['og:description'] = wp_strip_all_tags( $post->post_excerpt );
            }
            if( has_post_thumbnail() ){
                $properties['og:image'] = get_the_post_thumbnail_url( $post, 'medium' );
            }
        }

        return apply_filters( 'openagenda_default_properties', $properties );
    }


    /**
     * Filters Yoast SEO replacements on single event pages
     * 
     * @param   array   $replacements  Replacements
     * @param   object  $args
     * @return  array   $replacements  
     */
    function wpseo_replacements( $replacements, $args ){
        if( is_singular( 'oa-calendar' ) && \openagenda_is_single() ){
            $replacements['%%title%%'] = strip_tags( \openagenda_get_field( 'title', false, false ) );
        }
        return $replacements;
    }


    /**
     * Filters Yoast SEO metadata on single event pages
     * 
     * @param   string  $value  Value of the metadata
     * @return  string  $value  
     */
    public function yoast_seo_metadata( $value ){
        if( is_singular( 'oa-calendar' ) && \openagenda_is_single() ){
            $meta       = $this->get_default_meta();
            $properties = $this->get_default_properties();
            $key        = current_filter();
            switch ( $key ) {
                case 'wpseo_metadesc':
                    if ( ! empty( $meta['description'] ) ) $value = $meta['description'];
                    break;
                case 'wpseo_twitter_description':
                    if ( ! empty( $meta['twitter:description'] ) ) $value = $meta['twitter:description'];
                    break;
                case 'wpseo_twitter_image':
                    if ( ! empty( $meta['twitter:image'] ) ) $value = $meta['twitter:image'];
                    break;
                case 'wpseo_twitter_title':
                    if ( ! empty( $meta['twitter:title'] ) ) $value = $meta['twitter:title'];
                    break;
                case 'wpseo_opengraph_title':
                    if ( ! empty( $properties['og:title'] ) ) $value = $properties['og:title'];
                    break;
                case 'wpseo_opengraph_desc':
                    if ( ! empty( $properties['og:description'] ) ) $value = $properties['og:description'];
                    break;
                case 'wpseo_opengraph_url':
                    if ( ! empty( $properties['og:url'] ) ) $value = $properties['og:url'];
                    break;
                case 'wpseo_opengraph_image':
                    if ( ! empty( $properties['og:image'] ) ) $value = $properties['og:image'];
                    break;
            } 
        }
        return $value;
    }
}