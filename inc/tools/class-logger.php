<?php
/**
 * Logs OpenAgenda debugging information.
 *
 * @package Openagenda
 */

namespace OpenAgenda;

/**
 * Logs OpenAgenda debugging information.
 */
class Logger {

	/**
	 * Logs a message to the OpenAgenda debug log and Query Monitor.
	 *
	 * @param string $message Message to log.
	 * @param string $type    Type of log entry.
	 * @return void
	 */
	public static function log( $message, $type = 'log' ) {
		global $wp_filesystem;
		$upload_dir = wp_upload_dir();

		if ( ! $wp_filesystem || ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$contents = false;
		if ( ! empty( $upload_dir['basedir'] ) ) {
			$log_dir = sprintf( '%s/openagenda', untrailingslashit( $upload_dir['basedir'] ) );
			if ( ! $wp_filesystem->is_dir( $log_dir ) ) {
				$wp_filesystem->mkdir( $log_dir );
			}

			$destination = sprintf( '%s/openagenda-%s.log', untrailingslashit( $log_dir ), current_time( 'Y-m-d' ) );
			$contents    = $wp_filesystem->exists( $destination ) ? $wp_filesystem->get_contents( $destination ) : '';
		}

		switch ( $type ) {
			case 'error':
				// Query Monitor's public hook uses a slash in its name.
		        // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores,WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
				do_action( 'qm/error', $message );

				error_log( $message ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log

				if ( false !== $contents ) {
					$contents .= sprintf( "\n%s :: %s :: %s", gmdate( 'Y-m-d H:i:s' ), $type, $message );
					$wp_filesystem->put_contents( $destination, $contents, FS_CHMOD_FILE );
				}
				break;
			default:
				// Query Monitor's public hook uses a slash in its name.
		        // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores,WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
				do_action( 'qm/info', $message );

				if ( false !== $contents ) {
					$contents .= sprintf( "\n%s :: %s :: %s", gmdate( 'Y-m-d H:i:s' ), $type, $message );
					$wp_filesystem->put_contents( $destination, $contents, FS_CHMOD_FILE );
				}

				break;
		}
	}
}
