<?php
/**
 * Template part for displaying a single events list item
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OpenAgenda
 * @version 3.0.0
 */

$openagenda_date_range            = openagenda_get_field( 'dateRange' );
$openagenda_location              = openagenda_get_field( 'location' );
$openagenda_attendance_field      = openagenda_get_field( 'attendanceMode' );
$openagenda_attendance_mode       = is_array( $openagenda_attendance_field ) && isset( $openagenda_attendance_field['id'] ) ? (int) $openagenda_attendance_field['id'] : (int) $openagenda_attendance_field;
$openagenda_external              = isset( $atts ) ? isset( $atts['links'] ) && 'oa' === $atts['links'] : false;
$openagenda_permalink             = openagenda_event_permalink( false, false, true, $openagenda_external );
$openagenda_additional_attributes = $openagenda_external ? 'target="blank" rel="noopener noreferer"' : '';

switch ( $openagenda_attendance_mode ) {
	case '2': // Online.
		$openagenda_location_label = openagenda_get_attendance_mode_label();
		break;
	case '3': // Mixed.
		$openagenda_location_label = ! empty( $openagenda_location ) ? sprintf( '%s | %s, %s', __( 'Online', 'openagenda' ), esc_html( $openagenda_location['name'] ?? '' ), esc_html( $openagenda_location['city'] ?? '' ) ) : '';
		break;
	default: // 1 - On site.
		$openagenda_location_label = ! empty( $openagenda_location ) ? sprintf( '%s, %s', esc_html( $openagenda_location['name'] ?? '' ), esc_html( $openagenda_location['city'] ?? '' ) ) : '';
		break;
}
?>
<article id="event-<?php openagenda_field( 'uid' ); ?>" class="oa-event oa-list-item">
	<a class="oa-event-wrapper" href="<?php echo esc_url( $openagenda_permalink ); ?>" <?php echo esc_attr( $openagenda_additional_attributes ); ?>>
		<?php openagenda_featured_badge(); ?>

		<div class="oa-event-thumbnail">
			<?php openagenda_event_image(); ?>
		</div>

		<div class="oa-event-details">
			<?php if ( $openagenda_date_range ) : ?>
				<p class="oa-event-range">
					<strong><?php echo wp_kses_post( $openagenda_date_range ); ?></strong>
				</p>
			<?php endif; ?>

			<h2 class="oa-event-title">
				<?php
					openagenda_status_badge();
					openagenda_field( 'title' );
				?>
			</h2>
			
			<p class="oa-event-description">
				<?php openagenda_field( 'description' ); ?>
			</p>
				
			<?php if ( $openagenda_location_label ) : ?>
				<p class="oa-event-location-label">
					<?php echo wp_kses_post( $openagenda_location_label ); ?>
				</p>
			<?php endif; ?>
		</div>
		
		<?php openagenda_event_schema(); ?>
	</a>
</article>