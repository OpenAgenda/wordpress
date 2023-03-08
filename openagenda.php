<?php
/*
Plugin Name: OpenAgenda
Plugin URI:  https://wordpress.org/plugins/openagenda/
Description: Display your OpenAgenda data on your WordPress site.
Version:     2.5.0
Author:      OpenAgenda
Author URI:  https://openagenda.com/
Text Domain: openagenda
Domain Path: /languages
License:     GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires PHP: 7.0
Requires at least: 5.0
Tested up to: 6.1.1

OpenAgenda is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
OpenAgenda is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with OpenAgenda. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

defined( 'ABSPATH' ) || die();

define( 'OPENAGENDA_PATH', plugin_dir_path( __FILE__ ) );
define( 'OPENAGENDA_URL', plugin_dir_url( __FILE__ ) );
define( 'OPENAGENDA_VERSION', '2.5.0' );


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


register_uninstall_hook(__FILE__, 'openagenda_uninstallation' );
/**
 * Uninstall procedure
 */
function openagenda_uninstallation(){
    $settings = get_option( 'openagenda_general_settings' );
    $should_delete_content = ! empty( $settings ) && ! empty( $settings['openagenda_delete_content_on_uninstall'] ) ? (bool) $settings['openagenda_delete_content_on_uninstall'] : false;
    $should_delete_options = ! empty( $settings ) && ! empty( $settings['openagenda_delete_options_on_uninstall'] ) ? (bool) $settings['openagenda_delete_options_on_uninstall'] : false;

    if( $should_delete_content ){
        $calendar_ids = get_posts( array(
            'post_type' => 'oa-calendar',
            'fields'    => 'ids',
        ) );
        if( ! empty( $calendar_ids ) ){
            foreach ( $calendar_ids as $calendar_id) {
                wp_delete_post( $calendar_id, true );
            }
        }
    }

    if( $should_delete_options ){
        delete_option( 'openagenda_general_settings' );
        delete_option( 'openagenda_integrations_settings' );
        delete_option( 'openagenda_permalinks_settings' );
        delete_option( 'openagenda_customizer' );
        delete_expired_transients();
    }
}


add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'openagenda_plugin_action_links', 10, 4 );
/**
 * Adds plugin action links
 * 
 * @param   array   $actions  Available actions
 * @param   string  $file  Plugin file
 * @param   array   $data  $plugin data
 * @param   string  $context  Context
 * @return  array   $actions
 */
function openagenda_plugin_action_links( $actions, $file, $data, $context ){
    $actions['settings'] = sprintf( 
        '<a href="%s">%s</a>', 
        esc_url( menu_page_url( 'openagenda', false ) ),
        esc_html__( 'Settings', 'openagenda' ) 
    );
    $actions['documentation'] = sprintf( 
        '<a href="%s" target="_blank" rel="nooepener noreferrer">%s</a>', 
        esc_url( 'https://developers.openagenda.com/extension-wordpress/' ),
        esc_html__( 'Documentation', 'openagenda' ) 
    );
    return $actions;
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