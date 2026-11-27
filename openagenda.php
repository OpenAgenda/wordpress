<?php
/**
 * Plugin Name: OpenAgenda
 * Plugin URI:  https://wordpress.org/plugins/openagenda/
 * Description: Display your OpenAgenda data on your WordPress site.
 * Version:     3.1.0
 * Author:      OpenAgenda
 * Author URI:  https://openagenda.com/
 * Text Domain: openagenda
 * Domain Path: /languages
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP: 7.4.1
 * Requires at least: 5.0
 * Tested up to: 7.1.5
 *
 * @package OpenAgenda
 * @version 3.1.0
 *
 * OpenAgenda is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * OpenAgenda is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OpenAgenda. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

use OpenAgenda\Content_Manager;
use OpenAgenda\Main;

defined( 'ABSPATH' ) || die();

define( 'OPENAGENDA_PATH', plugin_dir_path( __FILE__ ) );
define( 'OPENAGENDA_URL', plugin_dir_url( __FILE__ ) );
define( 'OPENAGENDA_VERSION', '3.1.0' );


add_action( 'init', 'openagenda_load_textdomain' );
/**
 * Load translations
 *
 * @return void
 */
function openagenda_load_textdomain() {
	load_plugin_textdomain( 'openagenda', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}


register_activation_hook( __FILE__, 'openagenda_activation' );
/**
 * Activation procedure
 *
 * @return void
 */
function openagenda_activation() {
	// The activation request does not run the plugin's own hooks.
	openagenda_update_version();
	openagenda_set_rewrite_base();
	require_once OPENAGENDA_PATH . 'inc/interface-hookable.php';
	require_once OPENAGENDA_PATH . 'inc/frontend/class-content-manager.php';
	$manager = new Content_Manager();
	$manager->register_post_types();
	$manager->register_rewrite_rules();
	flush_rewrite_rules();
}


register_deactivation_hook( __FILE__, 'openagenda_deactivation' );
/**
 * Deactivation procedure
 *
 * @return void
 */
function openagenda_deactivation() {
	wp_clear_scheduled_hook( 'openagenda_cleanup_logs' );
	flush_rewrite_rules();
}


register_uninstall_hook( __FILE__, 'openagenda_uninstallation' );
/**
 * Uninstall procedure
 *
 * @return void
 */
function openagenda_uninstallation() {
	$settings              = get_option( 'openagenda_general_settings' );
	$should_delete_content = ! empty( $settings ) && ! empty( $settings['openagenda_delete_content_on_uninstall'] ) ? (bool) $settings['openagenda_delete_content_on_uninstall'] : false;
	$should_delete_options = ! empty( $settings ) && ! empty( $settings['openagenda_delete_options_on_uninstall'] ) ? (bool) $settings['openagenda_delete_options_on_uninstall'] : false;

	if ( $should_delete_content ) {
		$calendar_ids = get_posts(
			array(
				'post_type'   => array( 'oa-calendar', 'oa-agenda' ),
				'post_status' => 'any',
				'numberposts' => -1,
				'fields'      => 'ids',
			)
		);
		if ( ! empty( $calendar_ids ) ) {
			foreach ( $calendar_ids as $calendar_id ) {
				wp_delete_post( $calendar_id, true );
			}
		}
	}

	if ( $should_delete_options ) {
		delete_option( 'openagenda_general_settings' );
		delete_option( 'openagenda_integrations_settings' );
		delete_option( 'openagenda_permalinks_settings' );
		delete_option( 'openagenda_customizer' );
		delete_option( 'openagenda_post_type_slug' );
		delete_option( 'openagenda_former_rewrite_bases' );
		delete_expired_transients();
	}
}

add_action( 'plugins_loaded', 'openagenda_update_version' );
/**
 * Maybe update version in database.
 *
 * @return void
 */
function openagenda_update_version() {

	$db_version = get_option( 'openagenda_version' );
	if ( ! $db_version ) {
		$settings = get_option( 'openagenda_general_settings' );
		if ( ! empty( $settings ) && ! isset( $settings['openagenda_use_legacy_templates'] ) ) {
			$settings['openagenda_use_legacy_templates'] = true;
			update_option( 'openagenda_general_settings', $settings );
		}
	}

	if ( false !== $db_version && version_compare( $db_version, '3.1.0', '<' ) ) {
		$settings = get_option( 'openagenda_general_settings' );
		if ( ! empty( $settings ) && ! isset( $settings['openagenda_manual_submit'] ) ) {
			$settings['openagenda_manual_submit'] = false;
			update_option( 'openagenda_general_settings', $settings );
		}
	}

	// Decide once which post type the agendas use : existing sites keep "oa-calendar".
	if ( ! get_option( 'openagenda_post_type_slug' ) ) {
		$is_existing_install = openagenda_is_existing_install();
		update_option( 'openagenda_post_type_slug', $is_existing_install ? 'oa-calendar' : 'oa-agenda' );
		if ( ! $is_existing_install ) {
			// Have WordPress rebuild its URL rules with the new names.
			delete_option( 'rewrite_rules' );
		}
	}

	// Maybe update version.
	if ( ! $db_version || version_compare( $db_version, OPENAGENDA_VERSION, '!=' ) ) {
		update_option( 'openagenda_version', OPENAGENDA_VERSION );
	}

	if ( ! defined( 'OPENAGENDA_POST_TYPE_SLUG' ) ) {
		define( 'OPENAGENDA_POST_TYPE_SLUG', 'oa-agenda' === get_option( 'openagenda_post_type_slug' ) ? 'oa-agenda' : 'oa-calendar' );
	}
}


/**
 * Tells whether the plugin was already in use on this site before the "oa-agenda" post type existed.
 *
 * @return bool
 */
function openagenda_is_existing_install() {
	$calendars = get_posts(
		array(
			'post_type'   => 'oa-calendar',
			'post_status' => array( 'publish', 'future', 'draft', 'pending', 'private', 'trash' ),
			'numberposts' => 1,
			'fields'      => 'ids',
		)
	);
	if ( ! empty( $calendars ) ) {
		return true;
	}
	// The version alone is not enough : it is kept in the database when the plugin is uninstalled.
	return false !== get_option( 'openagenda_version' ) && ! empty( get_option( 'openagenda_general_settings' ) );
}


add_action( 'init', 'openagenda_set_rewrite_base', 1 );
/**
 * Stores the URL prefix of the agendas when none is saved yet.
 *
 * New sites get "agenda". Existing sites keep the prefix they already use,
 * which was the translation of "calendar" and was never saved.
 * Runs on init because translations cannot be read earlier.
 *
 * @return void
 */
function openagenda_set_rewrite_base() {
	$settings = get_option( 'openagenda_permalinks_settings' );
	if ( is_array( $settings ) && ! empty( $settings['openagenda_calendar_base'] ) ) {
		return;
	}

	$base = __( 'agenda', 'openagenda' );
	if ( 'oa-calendar' === OPENAGENDA_POST_TYPE_SLUG ) {
		// The prefix in use is the one of the stored URL rules. Otherwise translate it in the site language, not the user's.
		$found = preg_grep( '/^index\.php\?oa-calendar=\$matches\[1\]&oa-page=/', (array) get_option( 'rewrite_rules' ) );
		if ( ! empty( $found ) ) {
			$base = strtok( (string) key( $found ), '/' );
		} else {
			$switched = switch_to_locale( get_locale() );
			$base     = __( 'calendar', 'openagenda' );
			if ( $switched ) {
				restore_previous_locale();
			}
		}
	}

	$settings                             = is_array( $settings ) ? $settings : array();
	$settings['openagenda_calendar_base'] = sanitize_title( $base );
	update_option( 'openagenda_permalinks_settings', $settings );
}


add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'openagenda_plugin_action_links', 10 );
/**
 * Adds plugin action links
 *
 * @param   array<string,string> $actions  Available actions.
 * @return  array<string,string>   $actions Actions.
 */
function openagenda_plugin_action_links( array $actions ) {
	$actions['settings']      = sprintf(
		'<a href="%s">%s</a>',
		esc_url( menu_page_url( 'openagenda', false ) ),
		esc_html__( 'Settings', 'openagenda' )
	);
	$actions['documentation'] = sprintf(
		'<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>',
		esc_url( 'https://developers.openagenda.com/extension-wordpress/' ),
		esc_html__( 'Documentation', 'openagenda' )
	);
	return $actions;
}


add_action( 'plugins_loaded', 'openagenda_init' );
/**
 * Loads core class and initialize it.
 *
 * @return void
 */
function openagenda_init() {
	require_once OPENAGENDA_PATH . 'inc/class-main.php';
	$oa_main = new Main();
	$oa_main->init();
}
