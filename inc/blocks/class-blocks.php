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
	 * Blocks settings callback.
	 *
	 * @var \Closure(): array<string, array<string, mixed>>
	 */
	private $get_blocks_settings;

	/**
	 * Constructor.
	 *
	 * @param array{0: Main, 1: 'get_widgets_settings'} $get_blocks_settings Callback returning widget settings.
	 */
	public function __construct( array $get_blocks_settings ) {
		$this->get_blocks_settings = \Closure::fromCallable( $get_blocks_settings );
	}

	/**
	 * Returns preview widget settings.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public function get_preview_settings() {
		$settings         = ( $this->get_blocks_settings )();
		$preview_settings = array_merge(
			array(
				'title' => array(
					'name'    => 'title',
					'label'   => __( 'Title :', 'openagenda' ),
					'type'    => 'text',
					'default' => '',
				),
				'uid'   => array(
					'name'    => 'uid',
					'label'   => __( 'Agenda UID :', 'openagenda' ),
					'type'    => 'text',
					'default' => '',
				),
			),
			$settings['openagenda_preview']['settings'] ?? array()
		);
		return apply_filters( 'openagenda_preview_block_settings', $preview_settings );
	}

	/**
	 * Returns filter widget settings.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public function get_filter_settings() {
		$settings = ( $this->get_blocks_settings )();
		unset( $settings['openagenda_preview'] );
		return apply_filters( 'openagenda_filter_block_settings', $settings );
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
	 * Register custom OpenAgenda blocks.
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
		wp_localize_script( 'openagenda-filter-editor-script', 'openagendaFilters', $this->get_filter_settings() );

		register_block_type(
			OPENAGENDA_PATH . 'assets/blocks/preview',
			array(
				'render_callback' => array( $this, 'render_preview_block' ),
			)
		);
		wp_localize_script( 'openagenda-preview-editor-script', 'openagendaPreviewSettings', $this->get_preview_settings() );
	}

	/**
	 * Initializes the agenda globals for a calendar post or editor preview.
	 *
	 * @param int $post_id Optional calendar post ID.
	 * @return \WP_Post|null Agenda post or null if not loaded.
	 */
	public function init_editor_agenda( $post_id = 0 ) {
		global $post;
		global $openagenda;

		if ( 0 === (int) $post_id && isset( $post->ID ) && 'oa-calendar' === get_post_type( $post ) ) {
			$post_id = (int) $post->ID;
		}

		if ( 0 === (int) $post_id && wp_is_serving_rest_request() ) {
			$post_id = $this->get_editor_sample_agenda_post_id();
		}

		if ( 0 === (int) $post_id ) {
			return null;
		}

		$agenda = get_post( $post_id );
		if ( ! $agenda || 'oa-calendar' !== get_post_type( $agenda ) ) {
			return null;
		}

		$uid = (string) get_post_meta( $post_id, 'oa-calendar-uid', true );
		if ( '' === $uid ) {
			return null;
		}

		$post      = $agenda; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$page_size = get_post_meta( $post_id, 'oa-calendar-per-page', true ) ? (int) get_post_meta( $post_id, 'oa-calendar-per-page', true ) : (int) get_option( 'posts_per_page' );
		$args      = array(
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
		return $post;
	}

	/**
	 * Gets the first registered agenda to display in site editor.
	 *
	 * @return int First available agenda post ID, or zero when none exists.
	 */
	public function get_editor_sample_agenda_post_id() {
		$agenda_post_id = 0;
		$args           = array(
			'post_type'   => 'oa-calendar',
			'numberposts' => 1,
			'fields'      => 'ids',
		);
		$agendas        = get_posts( $args );
		if ( ! empty( $agendas ) ) {
			$agenda_post_id = $agendas[0];
		}
		return $agenda_post_id;
	}

	/**
	 * Disables links in block previews.
	 *
	 * @param string $html Block markup.
	 * @return string Updated block markup.
	 */
	private function disable_links( $html ) {
		if ( ! class_exists( '\WP_HTML_Tag_Processor' ) ) {
			return $html;
		}

		$processor = new \WP_HTML_Tag_Processor( $html );
		while ( $processor->next_tag( array( 'tag_name' => 'A' ) ) ) {
			$processor->remove_attribute( 'href' );
			$processor->remove_attribute( 'target' );
			$processor->remove_attribute( 'tabindex' );
			$processor->set_attribute( 'aria-disabled', 'true' );
		}

		return $processor->get_updated_html();
	}

	/**
	 * Renders the Events block with the OpenAgenda shortcode.
	 *
	 * @param array<string,mixed> $attributes  Array of block attributes.
	 * @param string              $content     Inner block content.
	 * @param \WP_Block|null      $block       Block instance.
	 * @return string Block markup.
	 */
	public function render_events_block( $attributes = array(), $content = '', $block = null ) {
		global $openagenda;

		$is_editor_preview = ! $openagenda && wp_is_serving_rest_request() && ! is_singular( 'oa-calendar' );

		if ( $is_editor_preview ) {
			$post_id = ! empty( $attributes['postId'] ) ? absint( $attributes['postId'] ) : 0;
			$this->init_editor_agenda( $post_id );
			$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'single-oa-calendar' ) );
			if ( ! class_exists( '\WP_HTML_Tag_Processor' ) ) {
				// Older WordPress versions lack the HTML tag processor.
				$wrapper_attributes = sprintf( '%s inert', $wrapper_attributes );
			}
			$html = sprintf( '<div %s>%s</div>', $wrapper_attributes, do_shortcode( '[openagenda]' ) );
			$html = $this->disable_links( $html );
			wp_reset_postdata();
			return apply_filters( 'openagenda_render_events_block', $html, $attributes, $content, $block );
		}

		$wrapper_attributes = get_block_wrapper_attributes();
		$html               = sprintf( '<div %s>%s</div>', $wrapper_attributes, do_shortcode( '[openagenda]' ) );
		return apply_filters( 'openagenda_render_events_block', $html, $attributes, $content, $block );
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

		$this->init_editor_agenda();
		$is_editor_preview  = wp_is_serving_rest_request() && ! is_singular( 'oa-calendar' );
		$settings           = ! empty( $attributes['filterSettings'] ) && is_array( $attributes['filterSettings'] ) ? $attributes['filterSettings'] : array();
		$atts               = \openagenda_get_shortcode_attributes( $settings );
		$content            = do_shortcode( sprintf( '[%1$s %2$s]', $shortcode, $atts ), true );
		$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => sprintf( 'wp-block-openagenda-filter-%s', sanitize_title( $attributes['filter'] ) ) ) );
		$html               = sprintf( '<div %s>%s</div>', $wrapper_attributes, $content );
		return apply_filters( 'openagenda_render_filter_block', $html, $attributes, $content, $block );
	}

	/**
	 * Renders the Preview block with its corresponding shortcode.
	 *
	 * @param array<string, mixed> $attributes Block attributes.
	 * @param string               $content    Inner block content.
	 * @param \WP_Block|null       $block      Block instance.
	 * @return string Block markup.
	 */
	public function render_preview_block( $attributes = array(), $content = '', $block = null ) {
		global $openagenda;

		$shortcode = 'openagenda_filter_preview';
		if ( ! shortcode_exists( $shortcode ) ) {
			return '';
		}

		$is_editor_preview  = ! $openagenda && wp_is_serving_rest_request() && ! is_singular( 'oa-calendar' );
		$settings           = ! empty( $attributes['settings'] ) && is_array( $attributes['settings'] ) ? $attributes['settings'] : array();
		$settings['links']  = ! empty( $settings['links'] ) ? 'oa' : '';
		$atts               = \openagenda_get_shortcode_attributes( $settings );
		$content            = do_shortcode( sprintf( '[%1$s %2$s]', $shortcode, $atts ), true );
		$wrapper_attributes = get_block_wrapper_attributes();
		if ( $is_editor_preview && ! class_exists( '\WP_HTML_Tag_Processor' ) ) {
			$wrapper_attributes = sprintf( '%s inert', $wrapper_attributes );
		}
		$html = sprintf( '<div %1$s>%2$s</div>', $wrapper_attributes, $content );
		if ( $is_editor_preview ) {
			$html = $this->disable_links( $html );
		}

		return apply_filters( 'openagenda_render_preview_block', $html, $attributes, $content, $block );
	}
}
