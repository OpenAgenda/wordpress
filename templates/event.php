<?php
/**
 * Template part for displaying a single events list item
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OpenAgenda
 * @version 3.0.0
 */
$location              = openagenda_get_field( 'location' );
$attendance_field      = openagenda_get_field( 'attendanceMode' );
$attendance_mode       = is_array( $attendance_field ) && isset( $attendance_field['id'] ) ? (int) $attendance_field['id'] : (int) $attendance_field;
$external              = isset( $atts ) ? isset( $atts['links'] ) && $atts['links'] === 'oa' : false;
$permalink             = openagenda_event_permalink( false, false, true, $external );
$additional_attributes = $external ? 'target="_blank" rel="noopener noreferer"' : '';

switch ( $attendance_mode ) {
	case '2': // Online
		$location_label = openagenda_get_attendance_mode_label();
		break;
	case '3': // Mixed
		$location_label = ! empty( $location ) ? sprintf( '%s | %s, %s', __( 'Online', 'openagenda' ), esc_html( $location['name'] ?? '' ), esc_html( $location['city'] ?? '' ) ) : '';
		break;
	default: // 1 - On site
		$location_label = ! empty( $location ) ? sprintf( '%s, %s', esc_html( $location['name'] ?? '' ), esc_html( $location['city'] ?? '' ) ) : '';
		break;
}
?>
<article id="event-<?php openagenda_field( 'uid' ); ?>" class="oa-event oa-list-item">
	<a class="oa-event-wrapper" href="<?php echo esc_url( $permalink ); ?>" <?php echo $additional_attributes; ?>>
		<?php openagenda_featured_badge(); ?>

		<div class="oa-event-thumbnail">
			<?php openagenda_event_image(); ?>
		</div>

		<div class="oa-event-details">
			<?php if ( $dateRange = openagenda_get_field( 'dateRange' ) ) : ?>
				<p class="oa-event-range">
					<strong><?php echo wp_kses_post( $dateRange ); ?></strong>
				</p>
			<?php endif; ?>

			<h2 class="oa-event-title">
				<?php openagenda_field( 'title' ); ?>
			</h2>
			
			<p class="oa-event-description"><?php openagenda_field( 'description' ); ?></p>
				
			<?php if ( $location_label ) : ?>
				<p class="oa-event-location-label">
					<?php echo wp_kses_post( $location_label ); ?>
				</p>
			<?php endif; ?>
		</div>
		
		<?php openagenda_event_schema(); ?>
	</a>
</article>