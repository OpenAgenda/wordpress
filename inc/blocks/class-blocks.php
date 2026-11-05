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
	 * Registers hooks
	 *
	 * @return void
	 */
	public function register_hooks() {
		add_action( 'init', array( $this, 'register_block_types' ) );
	}

	/**
	 * Register main filter block and its variations
	 *
	 * @return void
	 */
	public function register_block_types() {
		register_block_type( OPENAGENDA_PATH . 'assets/blocks/filter' );
	}
}
