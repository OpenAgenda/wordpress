<?php
/**
 * Template part for displaying a event location on single event pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Openagenda
 */

if( empty( openagenda_get_field( 'location' ) ) || empty( openagenda_get_field( 'location.uid' ) ) ) return;
?>
<div class="oa-event-location">
    <h3 class="oa-event-location-name"><?php openagenda_field( 'location.name' ); ?></h3>
    <address class="oa-event-location-address">
        <?php
            $latitude  = openagenda_get_field( 'location.latitude' ); 
            $longitude = openagenda_get_field( 'location.longitude' ); 
            $url       = add_query_arg( 'destination', urlencode( $latitude . ',' . $longitude ), 'https://www.google.com/maps/dir/?api=1' );
            printf( '<a href="%s" target="_blank" rel="noopener noreferer">%s</a>', esc_url( $url ), openagenda_get_field( 'location.address' ) ); 
        ?>
    </address>
    <p class="oa-event-location-phone">
        <?php printf( '<a href="tel:%1$s">%1$s</a>', openagenda_get_field( 'location.phone' ) );?>
    </p>
    <p class="oa-event-location-description"><?php openagenda_field( 'location.description' ); ?></p>
    <figure class="oa-event-location-map"><?php openagenda_event_map(); ?></figure>
    <p class="oa-event-location-access"><?php openagenda_field( 'location.access' ); ?></p>
</div>