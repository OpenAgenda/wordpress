<?php
/**
 * Template part for displaying a event location on single event pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OpenAgenda
 * @version 3.0.0
 */

if ( empty( openagenda_get_field( 'location' ) ) || empty( openagenda_get_field( 'location.uid' ) ) ) {
	return;
}

$openagenda_latitude  = openagenda_get_field( 'location.latitude' );
$openagenda_longitude = openagenda_get_field( 'location.longitude' );
$openagenda_url       = add_query_arg( 'destination', rawurlencode( $openagenda_latitude . ',' . $openagenda_longitude ), 'https://www.google.com/maps/dir/?api=1' );

$openagenda_address = openagenda_get_field( 'location.address' );
$openagenda_city    = openagenda_get_field( 'location.city' );
$openagenda_region  = openagenda_get_field( 'location.region' );

$openagenda_credits = openagenda_get_field( 'location.imageCredits' );

$openagenda_website = openagenda_get_field( 'location.website' );
$openagenda_phone   = openagenda_get_field( 'location.phone' );
$openagenda_email   = openagenda_get_field( 'location.email' );

$openagenda_links = openagenda_get_field( 'location.links' );
?>
<div class="oa-event-location">
	<h2 class="oa-event-location-title">
		<?php esc_html_e( 'About the location', 'openagenda' ); ?>
	</h2>
	
	<address class="oa-event-location-address">
		<strong class="oa-event-location-name">
			<?php openagenda_field( 'location.name' ); ?>
		</strong>
		
		<?php
			printf( '<a class="oa-event-location-address-link" href="%s" target="_blank" rel="noopener noreferer">%s</a>', esc_url( $openagenda_url ), wp_kses_post( $openagenda_address ) );
		if ( ! empty( $openagenda_city ) ) {
			printf( '<span class="oa-event-location-city">%s</span>', esc_html( $openagenda_city ) );
		}
		if ( ! empty( $openagenda_region ) ) {
			printf( '<span class="oa-event-location-region">%s</span>', esc_html( $openagenda_region ) );
		}
		?>
	</address>

	<p class="oa-event-location-description">
		<?php openagenda_field( 'location.description' ); ?>
	</p>

	<p class="oa-event-location-access">
		<?php
		printf( '<strong class="oa-label oa-event-location-access-label">%s</strong>', esc_html__( 'Access', 'openagenda' ) );
		openagenda_field( 'location.access' );
		?>
	</p>

	<figure class="oa-event-location-image">
		<?php
			openagenda_event_location_image();
		if ( ! empty( $openagenda_credits ) ) {
			printf( '<figcaption class="oa-image-credits">%s</figcaption>', esc_html( $openagenda_credits ) );
		}
		?>

	</figure>

	<div class="oa-event-location-contact">
		<?php printf( '<strong class="oa-label oa-event-location-contact-label">%s</strong>', esc_html__( 'Contact information', 'openagenda' ) ); ?>
		<?php if ( ! empty( $openagenda_website ) ) : ?>
			<div class="oa-event-location-website">
				<?php
					openagenda_icon( 'website' );
					printf( '<a href="%1$s">%1$s</a>', esc_url( $openagenda_website ) );
				?>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $openagenda_phone ) ) : ?>
			<div class="oa-event-location-phone">
				<?php
					openagenda_icon( 'phone' );
					printf( '<a href="tel:%1$s">%1$s</a>', esc_attr( $openagenda_phone ) );
				?>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $openagenda_email ) ) : ?>
			<div class="oa-event-location-email">
				<?php
					openagenda_icon( 'email' );
					printf( '<a href="mailto:%1$s">%1$s</a>', esc_attr( $openagenda_email ) );
				?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $openagenda_links ) ) : ?>
		<div class="oa-event-location-links">
			<?php
				printf( '<strong class="oa-label oa-event-location-links-label">%s</strong>', esc_html__( 'Additionnal links', 'openagenda' ) );
				echo '<ul>';
			foreach ( $openagenda_links as $openagenda_location_link ) {
				printf( '<li><a class="oa-event-location-link" href="%s">%s</a></li>', esc_url( $openagenda_location_link ), esc_html( $openagenda_location_link ) );
			}
				echo '</ul>';
			?>

		</div>
	<?php endif; ?>

	<figure class="oa-event-location-map">
		<?php openagenda_event_map(); ?>
	</figure>
</div>