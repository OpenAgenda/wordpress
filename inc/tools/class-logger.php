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

		$contents = null;
		if ( ! empty( $upload_dir['basedir'] ) ) {
			$log_dir = self::setup_log_folder( $upload_dir['basedir'] );

			if ( false !== $log_dir ) {
				$destination = sprintf( '%s/openagenda-%s.log', untrailingslashit( $log_dir ), current_time( 'Y-m-d' ) );
				$contents    = $wp_filesystem->exists( $destination ) ? $wp_filesystem->get_contents( $destination ) : '';
			}
		}

		switch ( $type ) {
			case 'error':
				// Query Monitor's public hook uses a slash in its name.
		        // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores,WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
				do_action( 'qm/error', $message );

				error_log( $message ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log

				if ( null !== $contents ) {
					$contents .= sprintf( "\n%s :: %s :: %s", gmdate( 'Y-m-d H:i:s' ), $type, $message );
					$wp_filesystem->put_contents( $destination, $contents, FS_CHMOD_FILE );
				}
				break;
			default:
				// Query Monitor's public hook uses a slash in its name.
		        // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores,WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
				do_action( 'qm/info', $message );

				if ( null !== $contents ) {
					$contents .= sprintf( "\n%s :: %s :: %s", gmdate( 'Y-m-d H:i:s' ), $type, $message );
					$wp_filesystem->put_contents( $destination, $contents, FS_CHMOD_FILE );
				}
				break;
		}
	}

	/**
	 * Create the log directory and protect it from direct access.
	 *
	 * @param string $base_dir Upload directory path.
	 * @return string|false Log directory path, or false if setup failed.
	 */
	private static function setup_log_folder( $base_dir ) {
		global $wp_filesystem;

		$log_dir = sprintf( '%s/openagenda', untrailingslashit( $base_dir ) );
		if ( ! $wp_filesystem->is_dir( $log_dir ) && ! $wp_filesystem->mkdir( $log_dir ) ) {
			return false;
		}

		$index_file = sprintf( '%s/index.php', untrailingslashit( $log_dir ) );
		if ( ! $wp_filesystem->exists( $index_file ) ) {
			$wp_filesystem->put_contents( $index_file, '', FS_CHMOD_FILE );
		}

		$htaccess_file = sprintf( '%s/.htaccess', untrailingslashit( $log_dir ) );
		if ( ! $wp_filesystem->exists( $htaccess_file ) ) {
			$htaccess = "<IfModule mod_authz_core.c>\n\tRequire all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n\tOrder deny,allow\n\tDeny from all\n</IfModule>\n";
			$wp_filesystem->put_contents( $htaccess_file, $htaccess, FS_CHMOD_FILE );
		}

		return $log_dir;
	}
}
