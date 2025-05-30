<?php
/**
 * Interface for hookable services
 *
 * @package Openagenda
 */

namespace OpenAgenda;

/**
 * Defines the function all classes that should hook into WordPress must have
 */
interface Hookable {
	/**
	 * Registers all the hooks
	 * Basically contains `add_action()` and `add_filter()` calls
	 */
	public function register_hooks();
}
