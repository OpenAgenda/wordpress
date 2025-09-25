<?php
/**
 * Template part for displaying a single event content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OpenAgenda
 * @version 2.14.0
 */

$timing               = openagenda_event_timing( 'date', false, false );
$date_range           = openagenda_get_field( 'dateRange' );
$access_link          = openagenda_get_field( 'onlineAccessLink' );
$registration_methods = openagenda_get_field( 'registration' );

?>
<article id="event-<?php openagenda_field( 'uid' ); ?>" class="oa-event oa-single-event">
	<div class="oa-event-wrapper">
		<header class="oa-event-header">
			<h2 class="oa-event-title">
				<?php
					openagenda_field( 'title' );
					openagenda_favorite_badge();
				?>
			</h2>
			<div class="oa-metas">
				<?php if ( $timing ) : ?>
					<p class="oa-meta oa-event-timing">
						<?php
						openagenda_icon( 'time' );
						echo wp_kses_post( $timing );
						?>
					</p>
				<?php endif; ?>
				<?php if ( $date_range ) : ?>
					<p class="oa-meta oa-event-range">
						<?php
						openagenda_icon( 'month' );
						echo wp_kses_post( $date_range );
						?>
					</p>
				<?php endif; ?>
				<div class="oa-event-share"><?php openagenda_event_share_buttons(); ?></div>
			</div>
			<p class="oa-entry-description"><?php openagenda_field( 'description' ); ?></p>
			<div class="oa-event-thumbnail"><?php openagenda_event_image(); ?></div>
		</header>
		<div class="oa-event-timings"><?php openagenda_event_timings(); ?></div>
		<div class="oa-event-details"><?php openagenda_field( 'longDescription' ); ?></div>

		<?php if ( ! empty( $access_link ) ) : ?>
			<div class="oa-event-access-link">
				<?php printf( '<strong class="oa-access-link-label">%1$s</strong><p><a href="%2$s">%2$s</a></p>', esc_html__( 'Access the online event: ', 'openagenda' ), esc_url( $access_link ) ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $registration_methods ) ) : ?>
			<div class="oa-event-registration">
				<?php
					printf( '<span class="oa-registration-label"><strong>%s</strong></span>', esc_html__( 'Registration: ', 'openagenda' ) );
					openagenda_event_registration_methods();
				?>
			</div>
		<?php endif; ?>
		
		<?php require openagenda_get_template( 'event-additional-fields' ); ?>
		<?php require openagenda_get_template( 'event-location' ); ?>
	</div>
</article>