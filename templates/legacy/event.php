<?php
/**
 * Template part for displaying a single events list item
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OpenAgenda
 * @version 2.14.0
 */

$date_range            = openagenda_get_field( 'dateRange' );
$location              = openagenda_get_field( 'location' );
$attendance_field      = openagenda_get_field( 'attendanceMode' );
$attendance_mode       = is_array( $attendance_field ) && isset( $attendance_field['id'] ) ? (int) $attendance_field['id'] : (int) $attendance_field;
$external              = isset( $atts ) ? isset( $atts['links'] ) && 'oa' === $atts['links'] : false;
$permalink             = openagenda_event_permalink( false, false, true, $external );
$additional_attributes = $external ? 'target="_blank" rel="noopener noreferer"' : '';

switch ( $attendance_mode ) {
	case '2': // Online.
		$location_label = openagenda_get_attendance_mode_label();
		break;
	case '3': // Mixed.
		$location_label = ! empty( $location ) ? sprintf( '%s | %s, %s', __( 'Online', 'openagenda' ), esc_html( $location['name'] ?? '' ), esc_html( $location['city'] ?? '' ) ) : '';
		break;
	default: // 1 - On site.
		$location_label = ! empty( $location ) ? sprintf( '%s, %s', esc_html( $location['name'] ?? '' ), esc_html( $location['city'] ?? '' ) ) : '';
		break;
}

?>
<article id="event-<?php openagenda_field( 'uid' ); ?>" class="oa-event oa-list-item">
	<div class="oa-event-wrapper">
		<div class="oa-event-thumbnail">
			<a class="oa-event-permalink" href="<?php echo esc_url( $permalink ); ?>" <?php echo $additional_attributes; ?>>
				<?php openagenda_event_image(); ?>
			</a>
		</div>

		<h2 class="oa-event-title">
			<a class="oa-event-permalink" href="<?php echo esc_url( $permalink ); ?>" <?php echo $additional_attributes; ?>>
				<?php openagenda_field( 'title' ); ?>
			</a>
			<?php openagenda_favorite_badge(); ?>
		</h2>

		<?php
		if ( $date_range ) :
			?>
			<p class="oa-event-range">
				<strong><?php echo wp_kses_post( $date_range ); ?></strong>
			</p>
		<?php endif; ?>
		
		<p class="oa-event-short-description">
			<?php openagenda_field( 'description' ); ?>
		</p>
			
		<?php if ( $location_label ) : ?>
			<p class="oa-event-location">
				<small><?php echo wp_kses_post( $location_label ); ?></small>
			</p>
		<?php endif; ?>
		
		<?php openagenda_event_schema(); ?>
	</div>
</article>