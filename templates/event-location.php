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

$oa_latitude  = openagenda_get_field( 'location.latitude' );
$oa_longitude = openagenda_get_field( 'location.longitude' );
$oa_url       = add_query_arg( 'destination', rawurlencode( $oa_latitude . ',' . $oa_longitude ), 'https://www.google.com/maps/dir/?api=1' );

$oa_address = openagenda_get_field( 'location.address' );
$oa_city    = openagenda_get_field( 'location.city' );
$oa_region  = openagenda_get_field( 'location.region' );

$oa_credits = openagenda_get_field( 'location.imageCredits' );

$oa_website = openagenda_get_field( 'location.website' );
$oa_phone   = openagenda_get_field( 'location.phone' );
$oa_email   = openagenda_get_field( 'location.email' );

$oa_links = openagenda_get_field( 'location.links' );
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
			printf( '<a class="oa-event-location-address-link" href="%s" target="_blank" rel="noopener noreferer">%s</a>', esc_url( $oa_url ), $oa_address );
		if ( ! empty( $oa_city ) ) {
			printf( '<span class="oa-event-location-city">%s</span>', esc_html( $oa_city ) );
		}
		if ( ! empty( $oa_region ) ) {
			printf( '<span class="oa-event-location-region">%s</span>', esc_html( $oa_region ) );
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
		if ( ! empty( $oa_credits ) ) {
			printf( '<figcaption class="oa-image-credits">%s</figcaption>', esc_html( $oa_credits ) );
		}
		?>

	</figure>

	<div class="oa-event-location-contact">
		<?php printf( '<strong class="oa-label oa-event-location-contact-label">%s</strong>', esc_html__( 'Contact information', 'openagenda' ) ); ?>
		<?php if ( ! empty( $oa_website ) ) : ?>
			<div class="oa-event-location-website">
				<?php
					openagenda_icon( 'website' );
					printf( '<a href="tel:%1$s">%1$s</a>', $oa_website );
				?>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $oa_phone ) ) : ?>
			<div class="oa-event-location-phone">
				<?php
					openagenda_icon( 'phone' );
					printf( '<a href="tel:%1$s">%1$s</a>', $oa_phone );
				?>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $oa_email ) ) : ?>
			<div class="oa-event-location-email">
				<?php
					openagenda_icon( 'email' );
					printf( '<a href="tel:%1$s">%1$s</a>', $oa_email );
				?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $oa_links ) ) : ?>
		<div class="oa-event-location-links">
			<?php
				printf( '<strong class="oa-label oa-event-location-links-label">%s</strong>', esc_html__( 'Additionnal links', 'openagenda' ) );
				echo '<ul>';
			foreach ( $oa_links as $oa_location_link ) {
				printf( '<li><a class="oa-event-location-link" href="%s">%s</a></li>', esc_url( $oa_location_link ), esc_html( $oa_location_link ) );
			}
				echo '</ul>';
			?>

		</div>
	<?php endif; ?>

	<figure class="oa-event-location-map">
		<?php openagenda_event_map(); ?>
	</figure>
</div>