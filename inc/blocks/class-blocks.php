<?php
/**
 * Blocks class.
 *
 * Register blocks and render callbacks.
 *
 * @since 3.1.0
 * @package Openagenda
 */

namespace OpenAgenda;

/**
 * Blocks class.
 *
 * Register blocks and render callbacks.
 */
class Blocks implements Hookable {
	/**
	 * Available filters and their settings.
	 *
	 * @var \Closure(): array<string, array<string, mixed>>
	 */
	private $get_available_filters;

	/**
	 * Constructor.
	 *
	 * @param array{0: Main, 1: 'get_available_filters'} $get_available_filters Callback returning available filters and their settings.
	 */
	public function __construct( array $get_available_filters ) {
		$this->get_available_filters = \Closure::fromCallable( $get_available_filters );
	}

	/**
	 * Registers hooks
	 *
	 * @return void
	 */
	public function register_hooks() {
		add_filter( 'block_categories_all', array( $this, 'register_block_category' ), 10 );
		add_action( 'init', array( $this, 'register_block_types' ) );
	}

	/**
	 * Register custom openagenda category
	 *
	 * @param  array<array<string,mixed>> $categories  Existing categories.
	 * @return  array<array<string,mixed>> $categories
	 */
	public function register_block_category( $categories ) {
		$custom_category = array(
			array(
				'slug'  => 'openagenda',
				'title' => __( 'Openagenda', 'openagenda' ),
				'icon'  => null,
			),
		);
		return array_merge( $categories, $custom_category );
	}

	/**
	 * Register main filter block and its variations
	 *
	 * @return void
	 */
	public function register_block_types() {
		register_block_type(
			OPENAGENDA_PATH . 'assets/blocks/events',
			array(
				'render_callback' => array( $this, 'render_events_block' ),
			)
		);

		register_block_type(
			OPENAGENDA_PATH . 'assets/blocks/filter',
			array(
				'render_callback' => array( $this, 'render_filter_block' ),
			)
		);
		wp_localize_script( 'openagenda-filter-editor-script', 'openagendaFilters', ( $this->get_available_filters )() );
	}

	/**
	 * Renders the Events block with the OpenAgenda shortcode.
	 *
	 * @param array<string,mixed> $attributes  Array of block attributes.
	 * @return string Block markup.
	 */
	public function render_events_block( $attributes = array() ) {
		global $openagenda;
		global $post;

		$is_editor_preview = ! $openagenda && wp_is_serving_rest_request() && ! is_singular( 'oa-calendar' );
		
		if ( $is_editor_preview ) {
			$this->init_editor_agenda();
			$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'single-oa-calendar' ) );
			$html               = sprintf( '<div %s>%s</div>', $wrapper_attributes, do_shortcode( '[openagenda]' ) );
			wp_reset_postdata();
			return $html;
		}

		$wrapper_attributes = get_block_wrapper_attributes();
		return sprintf( '<div %s>%s</div>', $wrapper_attributes, do_shortcode( '[openagenda]' ) );
	}


	/**
	 * Initializes the agenda globals for a calendar post or editor preview.
	 *
	 * @param int $post_id Optional calendar post ID.
	 * @return void
	 */
	public function init_editor_agenda( $post_id = 0 ) {
		global $post;
		global $openagenda;

		if ( 0 === (int) $post_id && isset( $post->ID ) && 'oa-calendar' === get_post_type( $post ) ) {
			$post_id = (int) $post->ID;
		}

		if ( 0 === (int) $post_id && wp_is_serving_rest_request() ) {
			$post_id  = $this->get_editor_sample_agenda_post_id();
		}

		if ( 0 === (int) $post_id ) {
			return;
		}

		$agenda = get_post( $post_id );
		if ( ! $agenda || 'oa-calendar' !== get_post_type( $agenda ) ) {
			return;
		}

		$uid = (string) get_post_meta( $post_id, 'oa-calendar-uid', true );
		if ( '' === $uid ) {
			return;
		}

		$post            = $agenda; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$page_size       = get_post_meta( $post_id, 'oa-calendar-per-page', true ) ? (int) get_post_meta( $post_id, 'oa-calendar-per-page', true ) : (int) get_option( 'posts_per_page' );
		$args            = array(
			'size'      => $page_size,
			'page_size' => $page_size,
			'page'      => ! empty( get_query_var( 'oa-page' ) ) ? (int) get_query_var( 'oa-page' ) : 1,
			'slug'      => ! empty( get_query_var( 'oa-slug' ) ) ? sanitize_text_field( get_query_var( 'oa-slug' ) ) : '',
		);

		if ( ! empty( $_GET ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$args = array_merge( $args, $_GET ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		$prefilters = openagenda_get_pre_filters( $post_id, $args );
		if ( ! empty( $prefilters ) ) {
			$args = array_merge( $args, $prefilters );
		}

		$options    = array(
			'infinite_scroll' => false,
			'api_key'         => get_post_meta( $post_id, 'oa-calendar-api-key', true ),
			'post_id'         => $post_id,
		);
		$openagenda = new OpenAgenda( $uid, $args, $options );
		setup_postdata( $post );
	}

	/**
	 * Gets the first registered agenda to display in site editor.
	 *
	 * @return \WP_Post|null First available agenda post.
	 */
	public function get_editor_sample_agenda_post_id() {
		$agenda_post_id  = 0;
		$args    = array(
			'post_type'   => 'oa-calendar',
			'numberposts' => 1,
			'fields'      => 'ids',
		);
		$agendas = get_posts( $args );
		if ( ! empty( $agendas ) ) {
			$agenda_post_id = $agendas[0];
		}
		return $agenda_post_id;
	}

	/**
	 * Renders the Filter block with its corresponding shortcode.
	 *
	 * @param array<string, mixed> $attributes Block attributes.
	 * @param string               $content    Inner block content.
	 * @param \WP_Block|null       $block      Block instance.
	 * @return string Block markup.
	 */
	public function render_filter_block( $attributes = array(), $content = '', $block = null ) {
		$shortcode = ! empty( $attributes['shortcode'] ) ? sanitize_key( $attributes['shortcode'] ) : '';

		if ( '' === $shortcode || ! shortcode_exists( $shortcode ) ) {
			return '';
		}

		global $openagenda;
		global $post;

		$is_editor_preview = ! $openagenda && wp_is_serving_rest_request() && ! is_singular( 'oa-calendar' );
		
		if( $is_editor_preview ){
			$this->init_editor_agenda();
		}

		$settings           = ! empty( $attributes['filterSettings'] ) && is_array( $attributes['filterSettings'] ) ? $attributes['filterSettings'] : array();
		$atts               = \openagenda_get_shortcode_attributes( $settings );
		$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => sprintf( 'wp-block-openagenda-filter-%s', sanitize_title( $attributes['filter'] ) ) ) );
		$html               = sprintf( '<div %s>%s</div>', $wrapper_attributes, do_shortcode( sprintf( '[%1$s %2$s]', $shortcode, $atts ), true ) );
		return apply_filters( 'openagenda_render_filter_block', $html, $attributes, $content, $block );
	}
}
