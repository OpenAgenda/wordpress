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
			OPENAGENDA_PATH . 'assets/blocks/filter',
			array(
				'render_callback' => array( $this, 'render_filter_block' ),
			)
		);
		wp_localize_script( 'openagenda-filter-editor-script', 'openagendaFilters', ( $this->get_available_filters )() );
	}

	/**
	 * Renders the Filter block with its corresponding shortcode.
	 *
	 * @param array<string, mixed> $attributes Block attributes.
	 * @return string Block markup.
	 */
	public function render_filter_block( $attributes = array() ) {
		$shortcode = ! empty( $attributes['shortcode'] ) ? sanitize_key( $attributes['shortcode'] ) : '';

		if ( '' === $shortcode || ! shortcode_exists( $shortcode ) ) {
			return '';
		}

		$settings = ! empty( $attributes['filterSettings'] ) && is_array( $attributes['filterSettings'] ) ? $attributes['filterSettings'] : array();
		$atts     = \openagenda_get_shortcode_attributes( $settings );

		return do_shortcode( sprintf( '[%1$s %2$s]', $shortcode, $atts ) );
	}
}
