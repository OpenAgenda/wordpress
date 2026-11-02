<?php
/**
 * Class handling simple scheduled tasks.
 *
 * @package Openagenda
 */

namespace OpenAgenda;

/**
 * Class handling simple background tasks.
 */
class Tasks implements Hookable {

	/**
	 * Cron hook used to clean up old log files.
	 *
	 * @var string
	 */
	const LOG_CLEANUP_HOOK = 'openagenda_cleanup_logs';

	/**
	 * Register all the hooks
	 */
	public function register_hooks() {
		add_action( 'init', array( $this, 'schedule_log_cleanup' ) );
		add_action( self::LOG_CLEANUP_HOOK, array( $this, 'cleanup_log_files' ) );
	}


	/**
	 * Schedule the daily log cleanup event if it is not already scheduled.
	 *
	 * @return void
	 */
	public function schedule_log_cleanup() {
		if ( ! wp_next_scheduled( self::LOG_CLEANUP_HOOK ) ) {
			wp_schedule_event( time(), 'daily', self::LOG_CLEANUP_HOOK );
		}
	}

	/**
	 * Delete OpenAgenda log files more than one month old.
	 *
	 * @return void
	 */
	public function cleanup_log_files() {
		global $wp_filesystem;

		$upload_dir = wp_upload_dir();
		if ( ! empty( $upload_dir['error'] ) || empty( $upload_dir['basedir'] ) ) {
			return;
		}

		$log_dir = sprintf( '%s/openagenda', untrailingslashit( $upload_dir['basedir'] ) );

		if ( ! $wp_filesystem || ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$files = $wp_filesystem->dirlist( $log_dir, false, false );
		if ( ! is_array( $files ) ) {
			return;
		}

		$cutoff_time = strtotime( '-1 month', time() );

		foreach ( $files as $file ) {
			if ( empty( $file['name'] ) || 'log' !== pathinfo( $file['name'], PATHINFO_EXTENSION ) ) {
				continue;
			}

			$path     = sprintf( '%s/%s', untrailingslashit( $log_dir ), $file['name'] );
			$modified = $file['lastmodunix'] ?? filemtime( $path );

			if ( $modified && $modified < $cutoff_time ) {
				$wp_filesystem->delete( sprintf( '%s/%s', untrailingslashit( $log_dir ), $file['name'] ) );
			}
		}
	}
}
