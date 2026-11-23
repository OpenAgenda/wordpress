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
		
		if ( $openagenda && is_singular( 'oa-calendar' ) ) {
			$wrapper_attributes = get_block_wrapper_attributes();
			return sprintf( '<div %s>%s</div>', $wrapper_attributes, do_shortcode( '[openagenda]' ) );
		} else {
			if ( wp_is_serving_rest_request() ) {
				$agenda = $this->get_editor_sample_agenda();
				if( null !== $agenda ){
					$post = $agenda;
					setup_postdata( $post );
					$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'single-oa-calendar' ) );
					$html               = sprintf( '<div %s>%s</div>', $wrapper_attributes, do_shortcode( '[openagenda]' ) );
					wp_reset_postdata();
					return $html;
				}
			}
			$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'single-oa-calendar' ) );
			return sprintf( '<div %s>%s</div>', $wrapper_attributes, do_shortcode( '[openagenda]' ) );
		}
	}

	/**
	 * Gets the first registered agenda to display in site editor.
	 * 
	 * @return WP_Post|null  $agenda  First available agenda post. 
	 */
	public function get_editor_sample_agenda(){
		$agenda = null;
		$args    = array(
			'post_type'   => 'oa-calendar',
			'numberposts' => 1,
			'fields'      => 'ids',
		);
		$agendas = get_posts( $args );
		if ( ! empty( $agendas ) ) {
			$agenda = get_post( $agendas[0] );
		}
		return $agenda;
	}

	/**
	 * Renders the Filter block with its corresponding shortcode.
	 *
	 * @param array<string, mixed> $attributes Block attributes.
	 * @return string Block markup.
	 */
	public function render_filter_block( $attributes = array(), $content, $block ) {
		$shortcode = ! empty( $attributes['shortcode'] ) ? sanitize_key( $attributes['shortcode'] ) : '';

		if ( '' === $shortcode || ! shortcode_exists( $shortcode ) ) {
			return '';
		}

		$settings           = ! empty( $attributes['filterSettings'] ) && is_array( $attributes['filterSettings'] ) ? $attributes['filterSettings'] : array();
		$atts               = \openagenda_get_shortcode_attributes( $settings );
		$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => sprintf( 'wp-block-openagenda-filter-%s', sanitize_title( $attributes['filter'] ) ) ) );
		return sprintf( '<div %s>%s</div>', $wrapper_attributes, do_shortcode( sprintf( '[%1$s %2$s]', $shortcode, $atts ) ) );
	}
}
