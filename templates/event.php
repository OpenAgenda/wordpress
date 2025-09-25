<?php
/**
 * Template part for displaying a single events list item
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OpenAgenda
 * @version 3.0.0
 */

$oa_date_range            = openagenda_get_field( 'dateRange' );
$oa_location              = openagenda_get_field( 'location' );
$oa_attendance_field      = openagenda_get_field( 'attendanceMode' );
$oa_attendance_mode       = is_array( $oa_attendance_field ) && isset( $oa_attendance_field['id'] ) ? (int) $oa_attendance_field['id'] : (int) $oa_attendance_field;
$oa_external              = isset( $atts ) ? isset( $atts['links'] ) && 'oa' === $atts['links'] : false;
$oa_permalink             = openagenda_event_permalink( false, false, true, $oa_external );
$oa_additional_attributes = $oa_external ? 'target="_blank" rel="noopener noreferer"' : '';

switch ( $oa_attendance_mode ) {
	case '2': // Online.
		$oa_location_label = openagenda_get_attendance_mode_label();
		break;
	case '3': // Mixed.
		$oa_location_label = ! empty( $oa_location ) ? sprintf( '%s | %s, %s', __( 'Online', 'openagenda' ), esc_html( $oa_location['name'] ?? '' ), esc_html( $oa_location['city'] ?? '' ) ) : '';
		break;
	default: // 1 - On site.
		$oa_location_label = ! empty( $oa_location ) ? sprintf( '%s, %s', esc_html( $oa_location['name'] ?? '' ), esc_html( $oa_location['city'] ?? '' ) ) : '';
		break;
}
?>
<article id="event-<?php openagenda_field( 'uid' ); ?>" class="oa-event oa-list-item">
	<a class="oa-event-wrapper" href="<?php echo esc_url( $oa_permalink ); ?>" <?php echo $oa_additional_attributes; ?>>
		<?php openagenda_featured_badge(); ?>

		<div class="oa-event-thumbnail">
			<?php openagenda_event_image(); ?>
		</div>

		<div class="oa-event-details">
			<?php if ( $oa_date_range ) : ?>
				<p class="oa-event-range">
					<strong><?php echo wp_kses_post( $oa_date_range ); ?></strong>
				</p>
			<?php endif; ?>

			<h2 class="oa-event-title">
				<?php openagenda_field( 'title' ); ?>
			</h2>
			
			<p class="oa-event-description">
				<?php openagenda_field( 'description' ); ?>
			</p>
				
			<?php if ( $oa_location_label ) : ?>
				<p class="oa-event-location-label">
					<?php echo wp_kses_post( $oa_location_label ); ?>
				</p>
			<?php endif; ?>
		</div>
		
		<?php openagenda_event_schema(); ?>
	</a>
</article>