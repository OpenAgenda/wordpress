<?php
/**
 * Class handling content types, taxonomies, and custom fields.
 *
 * @package Openagenda
 */

namespace OpenAgenda;

/**
 * Class handling content types, taxonomies, and custom fields.
 */
class Content_Manager implements Hookable {

	/**
	 * Post types to register
	 *
	 * @var  array<string, array<string, mixed>> $post_types
	 */
	protected $post_types;

	/**
	 * Whether the current template being rendered has the openagenda/events block already
	 *
	 * @var  bool
	 */
	protected $template_has_block = false;

	/**
	 * Register all the hooks
	 */
	public function register_hooks() {
		add_action( 'init', array( $this, 'register_post_types' ), 10 );
		add_action( 'init', array( $this, 'register_post_metas' ), 10 );
		add_action( 'init', array( $this, 'register_rewrite_rules' ), 10 );
		add_filter( 'template_include', array( $this, 'template_has_block' ), 10, 1 );
		add_action( 'wp_head', array( $this, 'wp_head_meta' ), 10 );
		add_action( 'wp_head', array( $this, 'print_schema' ), 10 );
		add_filter( 'body_class', array( $this, 'body_class' ), 10, 1 );
		add_filter( 'document_title_parts', array( $this, 'document_title_parts' ), 10, 1 );
		add_filter( 'the_content', array( $this, 'the_content' ), 8, 1 );
		add_filter( 'write_your_story', array( $this, 'write_your_story' ), 10, 2 );
		add_filter( 'get_pages', array( $this, 'get_front_pages' ), 10, 2 );
		add_action( 'pre_get_posts', array( $this, 'allow_calendars_front_page' ) );

		// Frontend meta tags and Yoast SEO Filters.
		if ( ! is_admin() ) {
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
	 *
	 * @return void
	 */
	public function register_post_types() {
		$post_types = $this->get_post_types();
		foreach ( $post_types as $slug => $args ) {
			register_post_type( $slug, $args );
		}
	}

	/**
	 * Registers metadata for each post type.
	 *
	 * @return void
	 */
	public function register_post_metas() {
		foreach ( $this->get_post_metas() as $post_type => $metas ) {
			foreach ( $metas as $meta_key => $args ) {
				register_post_meta( $post_type, $meta_key, $args );
			}
		}
	}


	/**
	 * Returns metadata to register for each post type.
	 *
	 * @return array<string, array<string, array<string, mixed>>> Metadata keyed by post type and meta key.
	 */
	public function get_post_metas() {
		$post_metas = array(
			OPENAGENDA_POST_TYPE_SLUG => array(
				'oa-calendar-uid'                     => array(
					'type'         => 'string',
					'single'       => true,
					'show_in_rest' => true,
				),
				'oa-calendar-per-page'                => array(
					'type'         => 'integer',
					'single'       => true,
					'show_in_rest' => true,
				),
				'oa-calendar-view'                    => array(
					'type'         => 'string',
					'single'       => true,
					'show_in_rest' => true,
				),
				'oa-calendar-sort'                    => array(
					'type'         => 'string',
					'single'       => true,
					'show_in_rest' => true,
				),
				'oa-calendar-content-on-archive'      => array(
					'type'         => 'string',
					'single'       => true,
					'show_in_rest' => true,
				),
				'oa-calendar-content-on-single'       => array(
					'type'         => 'string',
					'single'       => true,
					'show_in_rest' => true,
				),
				'oa-calendar-display-default-filters' => array(
					'type'         => 'string',
					'single'       => true,
					'show_in_rest' => true,
				),
				'oa-calendar-exclude'                 => array(
					'type'         => 'string',
					'single'       => true,
					'show_in_rest' => true,
				),
				'oa-calendar-display-all-states'      => array(
					'type'         => 'string',
					'single'       => true,
					'show_in_rest' => true,
				),
				'oa-calendar-infinite-scroll'         => array(
					'type'         => 'string',
					'single'       => true,
					'show_in_rest' => true,
				),
				'oa-calendar-filters'                 => array(
					'type'         => 'string',
					'single'       => true,
					'show_in_rest' => true,
				),
			),
		);

		return apply_filters( 'openagenda_post_metas', $post_metas );
	}


	/**
	 * Returns a filterable array of post types to register
	 *
	 * @return  array<string, array<string, mixed>> $post_types
	 */
	public function get_post_types() {
		if ( empty( $this->post_types ) ) {
			$rewrite_settings = get_option( 'openagenda_permalinks_settings' );
			$rewrite_base     = ! empty( $rewrite_settings ) && ! empty( $rewrite_settings['openagenda_calendar_base'] ) ? $rewrite_settings['openagenda_calendar_base'] : __( 'calendar', 'openagenda' );

			$this->post_types = array(
				OPENAGENDA_POST_TYPE_SLUG => array(
					'labels'        => array(
						'name'                  => _x( 'Agendas', 'Post type general name', 'openagenda' ),
						'singular_name'         => _x( 'Agenda', 'Post type singular name', 'openagenda' ),
						'menu_name'             => _x( 'Agendas', 'Admin Menu text', 'openagenda' ),
						'name_admin_bar'        => _x( 'Agenda', 'Add New on Toolbar', 'openagenda' ),
						'add_new_item'          => __( 'Add New Agenda', 'openagenda' ),
						'new_item'              => __( 'New Agenda', 'openagenda' ),
						'edit_item'             => __( 'Edit Agenda', 'openagenda' ),
						'view_item'             => __( 'View Agenda', 'openagenda' ),
						'all_items'             => __( 'All Agendas', 'openagenda' ),
						'search_items'          => __( 'Search Agendas', 'openagenda' ),
						'parent_item_colon'     => __( 'Parent Agendas:', 'openagenda' ),
						'not_found'             => __( 'No Agendas found.', 'openagenda' ),
						'not_found_in_trash'    => __( 'No Agendas found in Trash.', 'openagenda' ),
						'featured_image'        => _x( 'Agenda Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'openagenda' ),
						'archives'              => _x( 'Agenda archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'openagenda' ),
						'insert_into_item'      => _x( 'Insert into Agenda', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'openagenda' ),
						'uploaded_to_this_item' => _x( 'Uploaded to this Agenda', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'openagenda' ),
						'filter_items_list'     => _x( 'Filter Agendas list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'openagenda' ),
						'items_list_navigation' => _x( 'Agendas list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'openagenda' ),
						'items_list'            => _x( 'Agendas list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'openagenda' ),
					),
					'hierarchical'  => true,
					'public'        => true,
					'show_in_rest'  => true,
					'menu_icon'     => 'dashicons-book',
					'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
					'has_archive'   => false,
					'menu_position' => 5,
					'rewrite'       => array(
						'slug'       => sanitize_title( $rewrite_base ),
						'with_front' => false,
					),
				),
			);
		}
		return apply_filters( 'openagenda_post_types', $this->post_types );
	}


	/**
	 * Register rewrite rule for single events.
	 *
	 * @return void
	 */
	public function register_rewrite_rules() {

		// Add support for new query vars.
		add_rewrite_tag( '%oa-slug%', '([^&]+)' );
		add_rewrite_tag( '%oa-page%', '(\d+)' );
		add_rewrite_tag( '%oaq%', '([^&]+)' );

		// If pretty permalinks are enabled, add in our rewrite rules.
		if ( ! empty( get_option( 'permalink_structure' ) ) ) {
			$rewrite_settings = get_option( 'openagenda_permalinks_settings' );
			$rewrite_base     = ! empty( $rewrite_settings ) && ! empty( $rewrite_settings['openagenda_calendar_base'] ) ? $rewrite_settings['openagenda_calendar_base'] : __( 'calendar', 'openagenda' );
			add_rewrite_rule( "{$rewrite_base}/([^/]+)/page/(\d+)?", 'index.php?' . OPENAGENDA_POST_TYPE_SLUG . '=$matches[1]&oa-page=$matches[2]', 'top' );
			add_rewrite_rule( "{$rewrite_base}/([^/]+)/([^&]+)?", 'index.php?' . OPENAGENDA_POST_TYPE_SLUG . '=$matches[1]&oa-slug=$matches[2]', 'top' );
		}
	}


	/**
	 * Adds relevant body classes
	 *
	 * @param   array<string> $classes Array of registered body classes.
	 * @return  array<string> Body classes.
	 */
	public function body_class( $classes ) {
		global $openagenda;
		if ( $openagenda && is_singular( OPENAGENDA_POST_TYPE_SLUG ) ) {
			$classes[] = openagenda_is_single() ? 'single-oa-calendar-event' : 'single-oa-calendar-archive';
			// Styles are scoped to the legacy post type class.
			if ( ! in_array( 'single-oa-calendar', $classes, true ) ) {
				$classes[] = 'single-oa-calendar';
			}
		}
		return $classes;
	}


	/**
	 * Filters the canonical URL provided by WordPress
	 *
	 * @param   string $url  Canonical Url.
	 * @return  string  $url
	 */
	public function canonical_url( $url ) {
		if ( is_singular( OPENAGENDA_POST_TYPE_SLUG ) && \openagenda_is_single() ) {
			$url = openagenda_event_permalink( '', false, false );
		}
		return $url;
	}


	/**
	 * Filters the shortlink
	 *
	 * @param   string $shortlink  Initial shortlink.
	 * @param   int    $id          Post id.
	 * @param   string $context  Not used.
	 * @param   bool   $allow_slugs  Not used.
	 * @return  string  $shortlink
	 */
	public function get_shortlink( $shortlink, $id, $context, $allow_slugs ) {
		if ( is_singular( OPENAGENDA_POST_TYPE_SLUG ) && \openagenda_is_single() ) {
			$event_slug = openagenda_get_field( 'slug' );
			$shortlink  = add_query_arg( 'oa-slug', sanitize_title( $event_slug ), $shortlink );
		}
		return $shortlink;
	}


	/**
	 * Filters the page title
	 *
	 * @param  string $title  Initial title.
	 * @param  int    $id  Post ID.
	 * @return  string  $title  Filtered title.
	 */
	public function the_title( $title, $id ) {
		if ( is_singular( OPENAGENDA_POST_TYPE_SLUG ) && \openagenda_is_single() ) {
			$title = \openagenda_get_field( 'title' );
		}
		return $title;
	}


	/**
	 * Filters the content
	 *
	 * @param  string $content  Initial content.
	 * @return  string  $content  Filtered content.
	 */
	public function the_content( $content ) {
		if ( ! is_singular( OPENAGENDA_POST_TYPE_SLUG ) ) {
			return $content;
		}
		if ( ! is_main_query() || ! in_the_loop() ) {
			return $content;
		}
		$display_content = openagenda_is_archive() ? get_post_meta( get_the_ID(), 'oa-calendar-content-on-archive', true ) : get_post_meta( get_the_ID(), 'oa-calendar-content-on-single', true );

		if ( (bool) ! $this->template_has_block ) {
			if ( 'yes' !== $display_content ) {
				$content = '[openagenda]';
			} elseif ( ! has_shortcode( $content, 'openagenda' ) && ! has_block( 'openagenda/events' ) ) {
				$content .= '[openagenda]';
			}
		}

		return $content;
	}


	/**
	 * Checks whether the current template has the openagenda/events block already
	 *
	 * @param  string $template  Template to render.
	 * @return string $template
	 */
	public function template_has_block( $template ) {
		global $_wp_current_template_content;
		if ( isset( $_wp_current_template_content ) && is_string( $_wp_current_template_content ) ) {
			$this->template_has_block = has_block( 'openagenda/events', $_wp_current_template_content );
		}
		return $template;
	}


	/**
	 * Filters the content prompt on calendars.
	 *
	 * @param   string   $prompt  Default Prompt.
	 * @param   \WP_Post $post Current post.
	 * @return  string   $prompt  Filtered Prompt.
	 */
	public function write_your_story( $prompt, $post ) {
		if ( OPENAGENDA_POST_TYPE_SLUG === $post->post_type ) {
			$prompt = __( 'Please provide an agenda UID in this agenda\'s settings box first. You can leave your content empty, as the event list is automatically inserted after your content.', 'openagenda' );
		}
		return $prompt;
	}


	/**
	 * Filters the permalink for single events.
	 *
	 * @param   string   $post_link  Post permalink.
	 * @param   \WP_Post $post Post object.
	 * @param   bool     $leavename  Whether to keep the post name.
	 * @param   bool     $sample     Is it a sample permalink.
	 * @return  string   $post_link
	 */
	public function permalink( $post_link, $post, $leavename, $sample ) {
		if ( is_singular( OPENAGENDA_POST_TYPE_SLUG ) && \openagenda_is_single() ) {
			$slug      = \openagenda_get_field( 'slug' );
			$post_link = ! empty( get_option( 'permalink_structure' ) ) ? trailingslashit( $post_link ) . $slug : add_query_arg( 'oa-slug', rawurlencode( $slug ), $post_link );
		}
		return $post_link;
	}


	/**
	 * Writes meta tags in the <head> of the page
	 *
	 * @return void
	 */
	public function wp_head_meta() {
		global $openagenda;

		// Let Yoast do the heavy lifting by default.
		if ( in_array( 'wordpress-seo/wp-seo.php', (array) get_option( 'active_plugins', array() ), true ) ) {
			return;
		}

		if ( is_singular( OPENAGENDA_POST_TYPE_SLUG ) && $openagenda ) {
			foreach ( $this->get_default_meta() as $name => $content ) {
				printf( '<meta name="%s" content="%s">', esc_attr( $name ), esc_attr( $content ) );
			}
			foreach ( $this->get_default_properties() as $name => $content ) {
				printf( '<meta property="%s" content="%s">', esc_attr( $name ), esc_attr( $content ) );
			}
		}
	}

	/**
	 * Prints <script> tag with Rich Snippet data for the event on single event pages
	 *
	 * @return void
	 */
	public function print_schema() {
		global $openagenda;
		if ( $openagenda && is_singular( OPENAGENDA_POST_TYPE_SLUG ) && $openagenda->is_single() ) {
			openagenda_event_schema();
		}
	}


	/**
	 * Filters the title parts of the document.
	 *
	 * @param   array<string, string> $parts Array of title elements.
	 * @return  array<string, string> Title elements.
	 */
	public function document_title_parts( $parts ) {
		if ( is_singular( OPENAGENDA_POST_TYPE_SLUG ) && \openagenda_is_single() ) {
			$parts['title'] = wp_strip_all_tags( \openagenda_get_field( 'title' ) );
		}
		return $parts;
	}


	/**
	 * Retrieves default <meta> tags to print in <head>
	 *
	 * @return array<string, string|false> Associative array name => content.
	 */
	public function get_default_meta() {
		global $post;
		global $openagenda;
		$title = wp_get_document_title();

		$metas = array(
			'title'         => $title,
			'twitter:site'  => get_bloginfo( 'name' ),
			'twitter:card'  => 'summary_large_image',
			'twitter:title' => $title,
		);

		if ( $openagenda->is_single() ) {
			$event          = openagenda_get_event();
			$image_filename = ! empty( $event['image']['filename'] ) ? $event['image']['filename'] : '';
			$image_url      = ! empty( $image_filename ) && ! empty( $event['image']['base'] ) ? trailingslashit( $event['image']['base'] ) . $image_filename : false;
			$description    = \openagenda_get_field( 'description' );

			if ( ! empty( $description ) ) {
				$metas['description']         = $description;
				$metas['twitter:description'] = $description;
			}

			if ( $image_url ) {
				$metas['twitter:image'] = esc_url( $image_url );
			}
		}

		if ( $openagenda->is_archive() ) {
			$description = wp_strip_all_tags( $post->post_excerpt );
			if ( ! empty( $description ) ) {
				$metas['description']         = $description;
				$metas['twitter:description'] = $description;
			}
			if ( has_post_thumbnail() ) {
				$metas['twitter:image'] = get_the_post_thumbnail_url( $post, 'medium' );
			}
		}

		return apply_filters( 'openagenda_default_meta', $metas );
	}


	/**
	 * Retrieves default <meta> properties to print in <head>
	 *
	 * @return array<string, string|false> Associative array property => content.
	 */
	public function get_default_properties() {
		global $post;
		global $openagenda;
		$title = wp_get_document_title();

		$properties = array(
			'og:locale'    => get_locale(),
			'og:site_name' => get_bloginfo( 'name' ),
			'og:type'      => 'article',
			'og:title'     => $title,
		);

		if ( $openagenda->is_single() ) {
			$properties['og:url'] = esc_url( \openagenda_get_field( 'permalink' ) );

			$event          = openagenda_get_event();
			$image_filename = ! empty( $event['image']['filename'] ) ? $event['image']['filename'] : '';
			$image_url      = ! empty( $image_filename ) && ! empty( $event['image']['base'] ) ? trailingslashit( $event['image']['base'] ) . $image_filename : false;
			$description    = \openagenda_get_field( 'description' );
			if ( '' !== $description ) {
				$properties['og:description'] = wp_strip_all_tags( $description );
			}
			if ( $image_url ) {
				$properties['og:image'] = esc_url( $image_url );
			}
		}

		if ( $openagenda->is_archive() ) {
			$properties['og:url'] = esc_url( get_permalink() );
			if ( ! empty( $post->post_excerpt ) ) {
				$properties['og:description'] = wp_strip_all_tags( $post->post_excerpt );
			}
			if ( has_post_thumbnail() ) {
				$properties['og:image'] = get_the_post_thumbnail_url( $post, 'medium' );
			}
		}

		return apply_filters( 'openagenda_default_properties', $properties );
	}


	/**
	 * Filters Yoast SEO replacements on single event pages
	 *
	 * @param   array<string, mixed> $replacements Replacements.
	 * @param   object               $args  Arguments.
	 * @return  array<string, mixed> Filtered replacements.
	 */
	public function wpseo_replacements( $replacements, $args ) {
		if ( is_singular( OPENAGENDA_POST_TYPE_SLUG ) && \openagenda_is_single() ) {
			$replacements['%%title%%'] = wp_strip_all_tags( \openagenda_get_field( 'title' ) );
		}
		return $replacements;
	}


	/**
	 * Filters Yoast SEO metadata on single event pages
	 *
	 * @param   string $value  Value of the metadata.
	 * @return  string  $value
	 */
	public function yoast_seo_metadata( $value ) {
		if ( is_singular( OPENAGENDA_POST_TYPE_SLUG ) && \openagenda_is_single() ) {
			$meta       = $this->get_default_meta();
			$properties = $this->get_default_properties();
			$key        = current_filter();
			switch ( $key ) {
				case 'wpseo_metadesc':
					if ( ! empty( $meta['description'] ) ) {
						$value = $meta['description'];
					}
					break;
				case 'wpseo_twitter_description':
					if ( ! empty( $meta['twitter:description'] ) ) {
						$value = $meta['twitter:description'];
					}
					break;
				case 'wpseo_twitter_image':
					if ( ! empty( $meta['twitter:image'] ) ) {
						$value = $meta['twitter:image'];
					}
					break;
				case 'wpseo_twitter_title':
					if ( ! empty( $meta['twitter:title'] ) ) {
						$value = $meta['twitter:title'];
					}
					break;
				case 'wpseo_opengraph_title':
					if ( ! empty( $properties['og:title'] ) ) {
						$value = $properties['og:title'];
					}
					break;
				case 'wpseo_opengraph_desc':
					if ( ! empty( $properties['og:description'] ) ) {
						$value = $properties['og:description'];
					}
					break;
				case 'wpseo_opengraph_url':
					if ( ! empty( $properties['og:url'] ) ) {
						$value = $properties['og:url'];
					}
					break;
				case 'wpseo_opengraph_image':
					if ( ! empty( $properties['og:image'] ) ) {
						$value = $properties['og:image'];
					}
					break;
			}
		}
		return $value;
	}

	/**
	 * Adds OpenAgenda calendars to list of available front end options.
	 *
	 * @param   array<\WP_Post>      $pages Pages listed in the options.
	 * @param   array<string, mixed> $args Arguments.
	 * @return  array<\WP_Post> Filtered list of pages.
	 */
	public function get_front_pages( $pages, $args ) {
		if ( is_admin() && function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
			if ( $screen && 'options-reading' === $screen->id ) {
				if ( isset( $args['name'] ) && 'page_on_front' === $args['name'] ) {
					$calendars = get_posts(
						array(
							'post_type'   => OPENAGENDA_POST_TYPE_SLUG,
							'numberposts' => -1,
						)
					);
					$pages     = array_merge( $pages, $calendars );
				}
			}
		}
		return $pages;
	}

	/**
	 * Allows for calendars on the front page
	 *
	 * @param  \WP_Query $query Main query.
	 * @return void
	 */
	public function allow_calendars_front_page( $query ) {
		if ( $query->is_main_query() ) {
			$post_type = $query->get( 'post_type' );
			$page_id   = $query->get( 'page_id' );
			if ( empty( $post_type ) && ! empty( $page_id ) ) {
				$query->set( 'post_type', array( 'page', OPENAGENDA_POST_TYPE_SLUG ) );
			}
		}
	}
}
