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

$latitude  = openagenda_get_field( 'location.latitude' );
$longitude = openagenda_get_field( 'location.longitude' );
$url       = add_query_arg( 'destination', urlencode( $latitude . ',' . $longitude ), 'https://www.google.com/maps/dir/?api=1' );

$address = openagenda_get_field( 'location.address' );
$city    = openagenda_get_field( 'location.city' );
$region  = openagenda_get_field( 'location.region' );

$website = openagenda_get_field( 'location.website' );
$phone   = openagenda_get_field( 'location.phone' );
$email   = openagenda_get_field( 'location.email' );

$links   = openagenda_get_field( 'location.links' );
$credits = openagenda_get_field( 'location.imageCredits' );
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
			printf( '<a class="oa-event-location-address-link" href="%s" target="_blank" rel="noopener noreferer">%s</a>', esc_url( $url ), $address );
		if ( ! empty( $city ) ) {
			printf( '<span class="oa-event-location-city">%s</span>', esc_html( $city ) );
		}
		if ( ! empty( $region ) ) {
			printf( '<span class="oa-event-location-region">%s</span>', esc_html( $region ) );
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
		if ( ! empty( $credits ) ) {
			printf( '<figcaption class="oa-image-credits">%s</figcaption>', esc_html( $credits ) );
		}
		?>

	</figure>

	<div class="oa-event-location-contact">
		<?php printf( '<strong class="oa-label oa-event-location-contact-label">%s</strong>', esc_html__( 'Contact information', 'openagenda' ) ); ?>
		<?php if ( ! empty( $website ) ) : ?>
			<div class="oa-event-location-website">
				<?php
					openagenda_icon( 'website' );
					printf( '<a href="tel:%1$s">%1$s</a>', $website );
				?>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $phone ) ) : ?>
			<div class="oa-event-location-phone">
				<?php
					openagenda_icon( 'phone' );
					printf( '<a href="tel:%1$s">%1$s</a>', $phone );
				?>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $email ) ) : ?>
			<div class="oa-event-location-email">
				<?php
					openagenda_icon( 'email' );
					printf( '<a href="tel:%1$s">%1$s</a>', $email );
				?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $links ) ) : ?>
		<div class="oa-event-location-links">
			<?php
				printf( '<strong class="oa-label oa-event-location-links-label">%s</strong>', esc_html__( 'Additionnal links', 'openagenda' ) );
				echo '<ul>';
			foreach ( $links as $link ) {
				printf( '<li><a class="oa-event-location-link" href="%s">%s</a></li>', esc_url( $link ), esc_html( $link ) );
			}
				echo '</ul>';
			?>

		</div>
	<?php endif; ?>

	<figure class="oa-event-location-map">
		<?php openagenda_event_map(); ?>
	</figure>
</div>