<?php
/*
Plugin Name: OpenAgenda
Plugin URI:  https://vincentdubroeucq.com/
Description: Display your Open Agenda data on your WordPress site.
Version:     0.1
Author:      Vincent Dubroeucq
Author URI:  https://vincentdubroeucq.com/
Text Domain: openagenda
Domain Path: /languages
License:     GPL v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Requires at least: 4.6.
*/

defined( 'ABSPATH' ) || die();

define( 'OPENAGENDA_PATH', plugin_dir_path( __FILE__ ) );
define( 'OPENAGENDA_URL', plugin_dir_url( __FILE__ ) );
define( 'OPENAGENDA_VERSION', 0.1 );


add_action( 'plugins_loaded', 'openagenda_load_textdomain' );
/**
 * Load translations
 */
function openagenda_load_textdomain() {
    load_plugin_textdomain( 'openagenda', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}


register_activation_hook( __FILE__, 'openagenda_activation' );
/**
 * Activation procedure
 */
function openagenda_activation(){
    require_once OPENAGENDA_PATH . 'inc/interface-hookable.php';
    require_once OPENAGENDA_PATH . 'inc/class-content-manager.php';
    $manager = new Openagenda\Content_Manager();
    $manager->register_post_types();
    $manager->register_rewrite_rules();
    flush_rewrite_rules();
}


register_deactivation_hook( __FILE__, 'openagenda_deactivation' );
/**
 * Deactivation procedure
 */
function openagenda_deactivation(){
    flush_rewrite_rules();
}


add_action( 'plugins_loaded', 'openagenda_init' );
/**
 * Loads core class and initialize it. 
 */ 
function openagenda_init(){
    require_once OPENAGENDA_PATH . 'inc/class-main.php';
    $oa_main = new Openagenda\Main();
    $oa_main->init();
}