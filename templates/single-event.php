<?php
/**
 * Template part for displaying a single event content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OpenAgenda
 * @version 3.0.0
 */
$dateRange = openagenda_get_field( 'dateRange' );
$registration_methods = openagenda_get_field( 'registration' );
$conditions = openagenda_get_field( 'conditions' );
?>
<article id="event-<?php openagenda_field( 'uid' ); ?>" class="oa-event oa-single-event">
	<div class="oa-event-wrapper">
		<h2 class="oa-event-title">
			<?php openagenda_field( 'title' ); ?>
		</h2>
		
		<p class="oa-event-description"><?php openagenda_field( 'description' ); ?></p>
		
		<div class="oa-meta oa-event-share-button">
			<?php
				openagenda_icon( 'xpost' );
				openagenda_event_share_button();
			?>
		</div>
		
		<?php if ( ! empty( $dateRange ) ) : ?>
			<div class="oa-meta oa-event-range">
				<?php
				openagenda_icon( 'time' );
				echo wp_kses_post( $dateRange );
				?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $conditions ) ) : ?>
			<div class="oa-meta oa-event-conditions">
				<?php
					openagenda_icon( 'info' );
					printf( '<strong class="oa-meta-label oa-conditions-label">%s</strong>', esc_html__( 'Conditions: ', 'openagenda' ) );
					printf( '<div class="oa-conditions-value">%s</div>', esc_html( $conditions ) );
				?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $registration_methods ) ) : ?>
			<div class="oa-meta oa-event-registration">
				<?php
					openagenda_icon( 'document' );
					printf( '<strong class="oa-meta-label oa-registration-label">%s</strong>', esc_html__( 'Registration: ', 'openagenda' ) );
					openagenda_event_registration_methods();
				?>
			</div>
		<?php endif; ?>

		<div class="oa-event-thumbnail"><?php openagenda_event_image(); ?></div>
		<div class="oa-event-timings"><?php openagenda_event_timings(); ?></div>
		<div class="oa-event-details"><?php openagenda_field( 'longDescription' ); ?></div>

		<?php if ( ! empty( $access_link = openagenda_get_field( 'onlineAccessLink' ) ) ) : ?>
			<div class="oa-event-access-link">
				<?php printf( '<strong class="oa-access-link-label">%1$s</strong><p><a href="%2$s">%2$s</a></p>', esc_html__( 'Access the online event: ', 'openagenda' ), esc_url( $access_link ) ); ?>
			</div>
		<?php endif; ?>
		
		<?php require openagenda_get_template( 'event-additional-fields' ); ?>
		<?php require openagenda_get_template( 'event-location' ); ?>
	</div>
</article>