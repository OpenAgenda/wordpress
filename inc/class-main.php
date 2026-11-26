<?php
/**
 * Core class.
 *
 * Loads main files and register hooks.
 *
 * @package Openagenda
 */

namespace OpenAgenda;

/**
 * Core class.
 *
 * Loads main files and register hooks.
 */
class Main {

	/**
	 * Array of dependencies objects
	 *
	 * @var  array<string, Hookable> $dependencies
	 */
	private $dependencies = array();

	/**
	 * Widgets settings.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	private $widgets_settings = array();

	/**
	 * Loads required files.
	 *
	 * @return void
	 */
	public function init() {
		$this->load_dependencies();
		$this->register_hooks();
	}

	/**
	 * Loads necessary files and register them as dependencies
	 *
	 * @return void
	 */
	private function load_dependencies() {

		// Needed both on frontend and backend.
		require_once OPENAGENDA_PATH . 'inc/interface-hookable.php';
		require_once OPENAGENDA_PATH . 'inc/functions/helper-functions.php';
		require_once OPENAGENDA_PATH . 'inc/functions/template-tags.php';
		require_once OPENAGENDA_PATH . 'inc/functions/template-filters.php';
		require_once OPENAGENDA_PATH . 'inc/functions/compatibility.php';
		require_once OPENAGENDA_PATH . 'inc/frontend/class-content-manager.php';
		require_once OPENAGENDA_PATH . 'inc/frontend/class-openagenda.php';
		require_once OPENAGENDA_PATH . 'inc/frontend/class-shortcodes.php';
		require_once OPENAGENDA_PATH . 'inc/admin/class-customizer-settings.php';
		require_once OPENAGENDA_PATH . 'inc/tools/class-logger.php';
		require_once OPENAGENDA_PATH . 'inc/tools/class-tasks.php';
		require_once OPENAGENDA_PATH . 'inc/blocks/class-blocks.php';
		require_once OPENAGENDA_PATH . 'vendor/autoload.php';

		$this->dependencies['tasks']           = new Tasks();
		$this->dependencies['content-manager'] = new Content_Manager();
		$this->dependencies['customizer']      = new Customizer_Settings();
		$this->dependencies['shortcodes']      = new Shortcodes();
		$this->dependencies['blocks']          = new Blocks( array( $this, 'get_widgets_settings' ) );

		if ( is_admin() ) {
			// Only needed in the admin.
			require_once OPENAGENDA_PATH . 'inc/admin/class-admin-pages.php';
			require_once OPENAGENDA_PATH . 'inc/admin/class-settings.php';
			require_once OPENAGENDA_PATH . 'inc/admin/class-metaboxes.php';
			require_once OPENAGENDA_PATH . 'inc/admin/class-ajax-handler.php';
			$this->dependencies['admin-pages']  = new Admin_Pages();
			$this->dependencies['settings']     = new Settings();
			$this->dependencies['metaboxes']    = new Metaboxes();
			$this->dependencies['ajax-handler'] = new Ajax_Handler();
		}
	}

	/**
	 * Hooks all the dependencies
	 *
	 * @return void
	 */
	private function register_hooks() {
		foreach ( $this->dependencies as $dependency ) {
			$dependency->register_hooks();
		}
		add_action( 'wp', array( $this, 'init_calendar' ) );
		add_action( 'wp_head', array( $this, 'wp_head' ) );
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
	}


	/**
	 * Writes necessary <head> styles for spinner
	 *
	 * @return void
	 */
	public function wp_head() {
		$customizer_settings = get_option( 'openagenda_customizer' );
		$main_color          = isset( $customizer_settings['main_color'] ) ? $customizer_settings['main_color'] : '#41acdd';
		$openagenda_styles   = '';

		if ( $main_color ) {
			$openagenda_styles .= sprintf( ':root{--oa-main-color: %s }', sanitize_hex_color( $main_color ) );
		}

		printf( '<style id="oa-styles">%s</style>', esc_html( $openagenda_styles ) );
	}


	/**
	 * Register the filter and preview widgets
	 *
	 * @return void
	 */
	public function register_widgets() {
		require_once OPENAGENDA_PATH . 'inc/widgets/class-openagenda-widget.php';
		require_once OPENAGENDA_PATH . 'inc/widgets/class-filter-widget.php';
		require_once OPENAGENDA_PATH . 'inc/widgets/class-preview-widget.php';
		$widgets_settings = $this->get_widgets_settings();
		$filter_settings  = $widgets_settings;
		unset( $filter_settings['openagenda_preview'] );

		$filter_widget  = new Filter_Widget( array( 'available_filters' => $filter_settings ) );
		$preview_widget = new Preview_Widget(
			array(
				'additional_settings' => ! empty( $widgets_settings['openagenda_preview']['settings'] ) ? $widgets_settings['openagenda_preview']['settings'] : array(),
			)
		);
		register_widget( $filter_widget );
		register_widget( $preview_widget );
	}


	/**
	 * Registers scripts for the admin pages
	 *
	 * @param  string $hook  Page hook.
	 * @return void
	 */
	public function register_admin_scripts( $hook ) {
		wp_enqueue_style( 'openagenda-admin', OPENAGENDA_URL . 'assets/css/admin.css', array(), OPENAGENDA_VERSION );
		wp_enqueue_script( 'openagenda-admin', OPENAGENDA_URL . 'assets/js/admin.js', array(), OPENAGENDA_VERSION, true );
		wp_register_script( 'openagenda-media-uploader', OPENAGENDA_URL . 'assets/js/media-uploader.js', array(), OPENAGENDA_VERSION, true );

		if ( 'widgets.php' === $hook ) {
			wp_enqueue_script( 'openagenda-widgets', OPENAGENDA_URL . 'assets/js/widgets.js', array( 'jquery' ), OPENAGENDA_VERSION, true );
		}
	}


	/**
	 * Loads scripts and styles
	 *
	 * @return void
	 */
	public function register_scripts() {
		// Register main styles and scripts.
		wp_register_style( 'openagenda-main', OPENAGENDA_URL . 'assets/css/style.css', array(), OPENAGENDA_VERSION );
		wp_register_style( 'openagenda-legacy', OPENAGENDA_URL . 'assets/css/legacy.css', array(), OPENAGENDA_VERSION );

		wp_register_script( 'openagenda-main', OPENAGENDA_URL . 'assets/js/main.js', array(), OPENAGENDA_VERSION, true );
		wp_register_script( 'openagenda-fontawesome', OPENAGENDA_URL . 'assets/js/fontawesome.js', array(), '5.15.4', true );
		wp_register_script( 'openagenda-filters', OPENAGENDA_URL . 'assets/js/filters.js', array( 'openagenda-fontawesome' ), '3.3.0', true );

		// Register map dependencies.
		wp_register_style( 'oa-leaflet', OPENAGENDA_URL . 'assets/css/leaflet.css', array(), '1.9.4' );
		wp_register_script( 'oa-leaflet', OPENAGENDA_URL . 'assets/js/leaflet.js', array(), '1.9.4', true );
		wp_register_script( 'oa-event-map', OPENAGENDA_URL . 'assets/js/event-map.js', array( 'oa-leaflet' ), OPENAGENDA_VERSION, true );

		// Timings calendar JS.
		wp_register_script( 'oa-timings', OPENAGENDA_URL . 'assets/js/timings.js', array(), OPENAGENDA_VERSION, true );

		if ( openagenda_should_enqueue_styles() ) {
			$stylesheet = openagenda_use_legacy_templates() ? 'openagenda-legacy' : 'openagenda-main';
			wp_enqueue_style( $stylesheet );
		}

		if ( is_singular( 'oa-calendar' ) ) {
			wp_enqueue_script( 'openagenda-main' );
			wp_enqueue_script( 'openagenda-filters' );
			$settings        = get_option( 'openagenda_general_settings' );
			$manual_submit   = isset( $settings['openagenda_manual_submit'] ) ? (bool) $settings['openagenda_manual_submit'] : true;
			$post_id         = get_the_ID();
			$agenda_uid      = get_post_meta( $post_id, 'oa-calendar-uid', true );
			$view            = get_post_meta( $post_id, 'oa-calendar-view', true );
			$page_size       = get_post_meta( $post_id, 'oa-calendar-per-page', true ) ? (int) get_post_meta( $post_id, 'oa-calendar-per-page', true ) : (int) get_option( 'posts_per_page' );
			$infinite_scroll = get_post_meta( $post_id, 'oa-calendar-infinite-scroll', true ) === 'yes';
			$ajax_params     = array(
				'agendaUid' => $agenda_uid ? sanitize_text_field( $agenda_uid ) : false,
				'postId'    => $post_id,
				'view'      => $view ? sanitize_title( $view ) : 'list',
				'action'    => 'update_events',
			);
			wp_localize_script(
				'openagenda-main',
				'oaData',
				array_merge(
					$ajax_params,
					array(
						'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
						'res'            => add_query_arg( $ajax_params, admin_url( 'admin-ajax.php' ) ),
						'overlayHtml'    => \openagenda_get_update_overlay_html(),
						'errorNotice'    => \openagenda_get_update_notice_html(),
						'infiniteScroll' => $infinite_scroll,
						'isSingle'       => \openagenda_is_single(),
						'listUrl'        => \openagenda_get_permalink(),
						'locale'         => \openagenda_get_locale(),
						'page'           => ! empty( get_query_var( 'oa-page' ) ) ? (int) get_query_var( 'oa-page' ) : 1,
						'size'           => $page_size,
						'manualSubmit'   => $manual_submit,
					)
				)
			);
		}
	}


	/**
	 * Returns widgets settings.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public function get_widgets_settings() {
		if ( empty( $this->widgets_settings ) ) {
			$settings      = get_option( 'openagenda_integrations_settings' );
			$default_tiles = ! empty( $settings['openagenda_map_tiles_link'] ) ? $settings['openagenda_map_tiles_link'] : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

			$this->widgets_settings = array(
				'openagenda_preview'         => array(
					'settings' => array(
						'size'    => array(
							'name'    => 'size',
							'type'    => 'number',
							'label'   => __( 'Number of events to display&nbsp;:', 'openagenda' ),
							'class'   => 'widefat',
							'default' => 3,
						),
						'view'    => array(
							'name'    => 'view',
							'type'    => 'radio',
							'label'   => __( 'Display setting', 'openagenda' ),
							'default' => 'list',
							'class'   => 'widefat',
							'options' => array(
								'list' => array(
									'label' => __( 'Display as list', 'openagenda' ),
									'value' => 'list',
								),
								'grid' => array(
									'label' => __( 'Display as grid', 'openagenda' ),
									'value' => 'grid',
								),
							),
						),
						'sort'    => array(
							'name'    => 'sort',
							'type'    => 'select',
							'label'   => __( 'Default event sort', 'openagenda' ),
							'default' => 'lastTimingWithFeatured.asc',
							'class'   => 'widefat',
							'options' => array(
								'lastTimingWithFeatured.asc' => __( 'Featured first, followed by ascending last occurrence (default)', 'openagenda' ),
								'timingsWithFeatured.asc' => __( 'Featured first, followed by ascending upcoming occurrence', 'openagenda' ),
								'lastTiming.asc'          => __( 'Ascending last occurrence', 'openagenda' ),
								'timings.asc'             => __( 'Ascending upcoming occurrence', 'openagenda' ),
								'updatedAt.desc'          => __( 'Descending update date', 'openagenda' ),
								'updatedAt.asc'           => __( 'Ascending update date', 'openagenda' ),
							),
						),
						'filters' => array(
							'name'        => 'filters',
							'type'        => 'text',
							'label'       => __( 'Default filters (advanced)', 'openagenda' ),
							'class'       => 'widefat',
							'placeholder' => '?relative[]=upcoming',
							'default'     => '',
							'description' => __( 'Use a query string representing a filtered query. Only events corresponding to these filters will be displayed.', 'openagenda' ),
						),
						'links'   => array(
							'name'        => 'links',
							'type'        => 'checkbox',
							'label'       => __( 'Use external links', 'openagenda' ),
							'class'       => 'widefat',
							'default'     => false,
							'description' => __( 'Check to make event permalinks point to event pages on https://openagenda.com instead of local pages.', 'openagenda' ),
						),
					),
				),
				'openagenda_filter_active'   => array(
					'label'     => _x( 'Active filters', 'Filter name', 'openagenda' ),
					'shortcode' => 'openagenda_filter_active',
					'settings'  => array(),
				),
				'openagenda_filter_choice'   => array(
					'label'     => _x( 'Choice', 'Filter name', 'openagenda' ),
					'shortcode' => 'openagenda_filter_choice',
					'settings'  => array(
						'field'            => array(
							'name'        => 'field',
							'label'       => __( 'Choose field: ', 'openagenda' ),
							'type'        => 'select',
							'class'       => 'openagenda-filter-choice-field widefat',
							'option_none' => __( 'Choose a field to display', 'openagenda' ),
							'options'     => array(
								'favorites'        => __( 'Favorites', 'openagenda' ),
								'city'             => __( 'Cities', 'openagenda' ),
								'district'         => __( 'Districts', 'openagenda' ),
								'keyword'          => __( 'Keywords', 'openagenda' ),
								'adminLevel3'      => __( 'Admin Level 3', 'openagenda' ),
								'department'       => __( 'Departments', 'openagenda' ),
								'region'           => __( 'Regions', 'openagenda' ),
								'attendanceMode'   => __( 'Attendance Mode', 'openagenda' ),
								'additional_field' => __( 'Additional field', 'openagenda' ),
							),
						),
						'additional_field' => array(
							'name'        => 'additional_field',
							'label'       => __( 'Additional field name: ', 'openagenda' ),
							'class'       => 'openagenda-filter-choice-additional-field widefat',
							'default'     => '',
							'description' => sprintf(
								__( 'You can find the list of available additional fields in the Forms section of your agenda settings on openagenda.com (ex: https://openagenda.com/[your-agenda]/admin/schema )', 'openagenda' )
							),
						),
						'page_size'        => array(
							'name'    => 'page_size',
							'type'    => 'number',
							'label'   => __( 'Number of options to display at once: ', 'openagenda' ),
							'class'   => 'openagenda-filter-choice-pagesize widefat',
							'default' => 10,
						),
						'sort'             => array(
							'name'        => 'sort',
							'label'       => __( 'Sort options by ', 'openagenda' ),
							'type'        => 'select',
							'class'       => 'openagenda-filter-choice-sort widefat',
							'option_none' => __( 'Decreasing count', 'openagenda' ),
							'options'     => array(
								'alphabetical' => __( 'Alphabetical order', 'openagenda' ),
							),
						),
					),
				),
				'openagenda_filter_calendar' => array(
					'label'     => _x( 'Calendar', 'Filter name', 'openagenda' ),
					'shortcode' => 'openagenda_filter_calendar',
					'settings'  => array(
						'display_ranges' => array(
							'name'    => 'display_ranges',
							'label'   => __( 'Display defined ranges shortcuts ?', 'openagenda' ),
							'default' => false,
							'type'    => 'checkbox',
						),
						'type'           => array(
							'name'    => 'type',
							'label'   => __( 'Type of filter', 'openagenda' ),
							'default' => 'dateRange',
							'type'    => 'select',
							'options' => array(
								'dateRange'       => __( 'Calendar picker', 'openagenda' ),
								'simpleDateRange' => __( 'Native date input fields', 'openagenda' ),
							),
						),
						'ranges'         => array(
							'label'       => __( 'Ranges to display: ', 'openagenda' ),
							'name'        => 'ranges',
							'description' => __( 'Ranges to display: ', 'openagenda' ),
							'default'     => array( 'today', 'tomorrow', 'thisWeekend', 'currentWeek', 'currentMonth' ),
							'type'        => 'multi-checkbox',
							'options'     => array(
								'today'        => __( 'Today', 'openagenda' ),
								'tomorrow'     => __( 'Tomorrow', 'openagenda' ),
								'thisWeekend'  => __( 'This week end', 'openagenda' ),
								'currentWeek'  => __( 'This week', 'openagenda' ),
								'currentMonth' => __( 'This month', 'openagenda' ),
							),
						),
					),
				),
				'openagenda_filter_ranges'   => array(
					'label'     => _x( 'Defined Ranges', 'Filter name', 'openagenda' ),
					'shortcode' => 'openagenda_filter_ranges',
					'settings'  => array(
						'static_ranges' => array(
							'label'       => __( 'Ranges to display: ', 'openagenda' ),
							'name'        => 'static_ranges',
							'description' => __( 'Ranges to display: ', 'openagenda' ),
							'default'     => array( 'today', 'tomorrow', 'thisWeekend', 'currentWeek', 'currentMonth' ),
							'type'        => 'multi-checkbox',
							'options'     => array(
								'today'        => __( 'Today', 'openagenda' ),
								'tomorrow'     => __( 'Tomorrow', 'openagenda' ),
								'thisWeekend'  => __( 'This week end', 'openagenda' ),
								'currentWeek'  => __( 'This week', 'openagenda' ),
								'currentMonth' => __( 'This month', 'openagenda' ),
							),
						),
					),
				),
				'openagenda_filter_map'      => array(
					'label'     => _x( 'Map', 'Filter name', 'openagenda' ),
					'shortcode' => 'openagenda_filter_map',
					'settings'  => array(
						'map_tiles_link' => array(
							'name'        => 'map_tiles_link',
							'label'       => __( 'Map tiles link:', 'openagenda' ),
							'class'       => 'widefat',
							'default'     => $default_tiles,
							'description' => __( 'The default map tile link can be found in your Integrations settings.', 'openagenda' ),
						),
						'map_auto'       => array(
							'name'    => 'map_auto',
							'label'   => __( 'Automatically update map on scroll ?', 'openagenda' ),
							'type'    => 'checkbox',
							'default' => false,
						),
					),
				),
				'openagenda_filter_relative' => array(
					'label'     => _x( 'Upcoming', 'Filter name', 'openagenda' ),
					'shortcode' => 'openagenda_filter_relative',
					'settings'  => array(),
				),
				'openagenda_filter_search'   => array(
					'label'     => _x( 'Search', 'Filter name', 'openagenda' ),
					'shortcode' => 'openagenda_filter_search',
					'settings'  => array(
						'placeholder' => array(
							'name'    => 'placeholder',
							'label'   => __( 'Placeholder:', 'openagenda' ),
							'class'   => 'widefat',
							'default' => '',
						),
					),
				),
				'openagenda_filter_sort'     => array(
					'label'     => _x( 'Sort', 'Filter name', 'openagenda' ),
					'shortcode' => 'openagenda_filter_sort',
					'settings'  => array(
						'options' => array(
							'label'       => __( 'Sort options to display: ', 'openagenda' ),
							'name'        => 'options',
							'description' => __( 'Sort options to display: ', 'openagenda' ),
							'default'     => array( 'score', 'lastTimingWithFeatured.asc', 'timingsWithFeatured.asc' ),
							'type'        => 'multi-checkbox',
							'options'     => array(
								'score'                   => __( 'Score', 'openagenda' ),
								'lastTimingWithFeatured.asc' => __( 'Featured first, followed by ascending last occurrence', 'openagenda' ),
								'timingsWithFeatured.asc' => __( 'Featured first, followed by ascending upcoming occurrence', 'openagenda' ),
								'lastTiming.asc'          => __( 'Ascending last occurrence', 'openagenda' ),
								'timings.asc'             => __( 'Ascending upcoming occurrence', 'openagenda' ),
								'updatedAt.desc'          => __( 'Descending update date', 'openagenda' ),
								'updatedAt.asc'           => __( 'Ascending update date', 'openagenda' ),
							),
						),
					),
				),
				'openagenda_filter_submit'   => array(
					'label'     => _x( 'Filter submit', 'Filter name', 'openagenda' ),
					'shortcode' => 'openagenda_filter_submit',
					'settings'  => array(
						'buttonLabel' => array(
							'name'    => 'button_label',
							'label'   => __( 'Button label', 'openagenda' ),
							'class'   => 'widefat',
							'default' => __( 'Refresh events', 'openagenda' ),
						),
					),
				),
			);
		}
		$this->widgets_settings = apply_filters( 'openagenda_available_filters', $this->widgets_settings );
		return apply_filters( 'openagenda_widgets_settings', $this->widgets_settings );
	}


	/**
	 * Initialize the global openagenda instance
	 *
	 * @return void
	 */
	public function init_calendar() {
		global $openagenda;
		if ( is_singular( 'oa-calendar' ) ) {
			$post_id         = get_the_ID();
			$uid             = (string) get_post_meta( $post_id, 'oa-calendar-uid', true );
			$page_size       = get_post_meta( $post_id, 'oa-calendar-per-page', true ) ? (int) get_post_meta( $post_id, 'oa-calendar-per-page', true ) : (int) get_option( 'posts_per_page' );
			$infinite_scroll = get_post_meta( $post_id, 'oa-calendar-infinite-scroll', true ) === 'yes';
			$api_key         = get_post_meta( $post_id, 'oa-calendar-api-key', true );

			$args = array(
				'size'      => $page_size,
				'page_size' => $page_size,
				'page'      => ! empty( get_query_var( 'oa-page' ) ) ? (int) get_query_var( 'oa-page' ) : 1,
				'slug'      => ! empty( get_query_var( 'oa-slug' ) ) ? sanitize_text_field( get_query_var( 'oa-slug' ) ) : '',
			);

			$options = array(
				'infinite_scroll' => $infinite_scroll,
				'api_key'         => $api_key,
			);

			// If using infinite scroll, archive page number will always be 1.
			if ( $infinite_scroll ) {
				$args['size'] *= $args['page'];
				$args['page']  = 1;
			}

			// Merge filters in URL.
			if ( ! empty( $_GET ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				$args = array_merge( $args, $_GET ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			}

			// Merge default filters.
			$prefilters = openagenda_get_pre_filters( $post_id, $args );
			if ( ! empty( $prefilters ) ) {
				$args = array_merge( $args, $prefilters );
			}

			if ( '' !== $uid ) {
				$openagenda = new OpenAgenda( $uid, $args, $options );
			}
		}
	}
}
