<?php
/**
 * Plugin Name: OpenAgenda
 * Plugin URI:  https://wordpress.org/plugins/openagenda/
 * Description: Display your OpenAgenda data on your WordPress site.
 * Version:     3.0.2
 * Author:      OpenAgenda
 * Author URI:  https://openagenda.com/
 * Text Domain: openagenda
 * Domain Path: /languages
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP: 7.4.1
 * Requires at least: 5.0
 * Tested up to: 6.9.4
 *
 * @package OpenAgenda
 * @version 3.0.2
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

defined( 'ABSPATH' ) || die();

define( 'OPENAGENDA_PATH', plugin_dir_path( __FILE__ ) );
define( 'OPENAGENDA_URL', plugin_dir_url( __FILE__ ) );
define( 'OPENAGENDA_VERSION', '3.0.2' );


add_action( 'init', 'openagenda_load_textdomain' );
/**
 * Load translations
 */
function openagenda_load_textdomain() {
	load_plugin_textdomain( 'openagenda', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}


/**
 * Returns the name of the post type holding agendas.
 *
 * Sites that installed the plugin when the post type was named "oa-calendar"
 * keep that name, so their content and customizations are untouched.
 * New installations use "oa-agenda". The choice is made once and stored.
 *
 * @return  string  "oa-agenda" or "oa-calendar".
 */
function openagenda_get_post_type() {
	$post_type = get_option( 'openagenda_post_type' );
	if ( ! in_array( $post_type, array( 'oa-agenda', 'oa-calendar' ), true ) ) {
		$post_type = openagenda_detect_post_type();
		update_option( 'openagenda_post_type', $post_type );
		if ( 'oa-agenda' === $post_type ) {
			// Stored rules may still target the former post type: have WordPress rebuild them.
			delete_option( 'rewrite_rules' );
		}
	}
	return $post_type;
}


/**
 * Tells which post type name this site should use.
 *
 * Existing "oa-agenda" posts settle it. Otherwise any trace of an earlier
 * installation means the site keeps "oa-calendar".
 *
 * Must be called before openagenda_update_version() stores the version.
 *
 * @return  string  "oa-agenda" or "oa-calendar".
 */
function openagenda_detect_post_type() {
	if ( openagenda_has_posts( 'oa-agenda' ) ) {
		return 'oa-agenda';
	}
	return openagenda_is_existing_install() ? 'oa-calendar' : 'oa-agenda';
}


/**
 * Tells whether this site holds posts of the given type, in any status but auto-draft.
 *
 * Queries the database directly: the post type may not be registered.
 *
 * @param   string $post_type  Post type name.
 * @return  bool
 */
function openagenda_has_posts( $post_type ) {
	global $wpdb;
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
	return (bool) $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type = %s AND post_status <> 'auto-draft' LIMIT 1", $post_type ) );
}


/**
 * Tells whether the plugin was already in use on this site before the current request.
 *
 * Agendas are proof of it. Without any, both the stored version and the settings
 * are required: versions up to 3.0.2 left the version behind on uninstall, and
 * settings may be written by a setup script before the first activation.
 *
 * Must be called before openagenda_update_version() stores the version.
 *
 * @return  bool
 */
function openagenda_is_existing_install() {
	if ( openagenda_has_posts( 'oa-calendar' ) ) {
		return true;
	}
	return get_option( 'openagenda_version' ) && get_option( 'openagenda_general_settings' );
}


/**
 * Flags a new installation, which uses the default URL prefix.
 *
 * Sites left unflagged are existing ones: Content_Manager::maybe_keep_former_rewrite_base()
 * stores the prefix they were using.
 */
function openagenda_flag_new_install() {
	if ( ! get_option( 'openagenda_rewrite_base_checked' ) && ! openagenda_is_existing_install() ) {
		update_option( 'openagenda_rewrite_base_checked', 'new' );
		// The site may have rules built for the former default prefix: have WordPress rebuild them.
		delete_option( 'rewrite_rules' );
	}
}


register_activation_hook( __FILE__, 'openagenda_activation' );
/**
 * Activation procedure
 */
function openagenda_activation() {
	require_once OPENAGENDA_PATH . 'inc/interface-hookable.php';
	require_once OPENAGENDA_PATH . 'inc/class-content-manager.php';
	openagenda_get_post_type();
	$manager = new OpenAgenda\Content_Manager();
	openagenda_flag_new_install();
	$manager->maybe_keep_former_rewrite_base();
	$manager->register_post_types();
	$manager->register_rewrite_rules();
	flush_rewrite_rules();
}


register_deactivation_hook( __FILE__, 'openagenda_deactivation' );
/**
 * Deactivation procedure
 */
function openagenda_deactivation() {
	flush_rewrite_rules();
}


register_uninstall_hook( __FILE__, 'openagenda_uninstallation' );
/**
 * Uninstall procedure
 */
function openagenda_uninstallation() {
	$settings              = get_option( 'openagenda_general_settings' );
	$should_delete_content = ! empty( $settings ) && ! empty( $settings['openagenda_delete_content_on_uninstall'] ) ? (bool) $settings['openagenda_delete_content_on_uninstall'] : false;
	$should_delete_options = ! empty( $settings ) && ! empty( $settings['openagenda_delete_options_on_uninstall'] ) ? (bool) $settings['openagenda_delete_options_on_uninstall'] : false;

	if ( $should_delete_content ) {
		$calendar_ids = get_posts(
			array(
				// Both names: content left under the other one would make a reinstall look like an existing site.
				'post_type'   => array( 'oa-agenda', 'oa-calendar' ),
				'post_status' => array_values( get_post_stati() ),
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
		delete_option( 'openagenda_rewrite_base_checked' );
		delete_option( 'openagenda_former_rewrite_bases' );
		delete_option( 'openagenda_post_type' );
		delete_option( 'openagenda_customizer' );
		delete_expired_transients();
		// Without its options, a later reinstall must count as a new installation.
		delete_option( 'openagenda_version' );
	}
}

add_action( 'plugins_loaded', 'openagenda_update_version' );
/**
 * Maybe update version in database.
 */
function openagenda_update_version() {

	// Must run before the version is stored: a stored version marks an existing installation.
	openagenda_get_post_type();
	openagenda_flag_new_install();

	$db_version = get_option( 'openagenda_version' );
	if ( ! $db_version ) {
		$settings = get_option( 'openagenda_general_settings' );
		if ( ! empty( $settings ) ) {
			if ( ! isset( $settings['openagenda_use_legacy_templates'] ) ) {
				$settings['openagenda_use_legacy_templates'] = true;
				update_option( 'openagenda_general_settings', $settings );
			}
		}
	}

	// Maybe update version.
	if ( ! $db_version || version_compare( $db_version, OPENAGENDA_VERSION, '!=' ) ) {
		update_option( 'openagenda_version', OPENAGENDA_VERSION );
	}
}


add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'openagenda_plugin_action_links', 10, 4 );
/**
 * Adds plugin action links
 *
 * @param   array $actions  Available actions.
 * @return  array   $actions Actions.
 */
function openagenda_plugin_action_links( $actions ) {
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
 */
function openagenda_init() {
	require_once OPENAGENDA_PATH . 'inc/class-main.php';
	$oa_main = new OpenAgenda\Main();
	$oa_main->init();
}
