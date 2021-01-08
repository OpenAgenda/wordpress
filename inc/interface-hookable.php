<?php
namespace Openagenda;
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