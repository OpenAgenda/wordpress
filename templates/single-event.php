<?php
/**
 * Template part for displaying a single event content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OpenAgenda
 * @version 3.0.0
 */

$oa_date_range           = openagenda_get_field( 'dateRange' );
$oa_registration_methods = openagenda_get_field( 'registration' );
$oa_conditions           = openagenda_get_field( 'conditions' );
$oa_keywords             = openagenda_get_field( 'keywords' );
$oa_access_link          = openagenda_get_field( 'onlineAccessLink' );
$oa_credits              = openagenda_get_field( 'imageCredits' );
?>
<article id="event-<?php openagenda_field( 'uid' ); ?>" class="oa-event oa-single-event">
	<div class="oa-event-wrapper">
		<h2 class="oa-event-title">
			<?php openagenda_field( 'title' ); ?>
		</h2>
		
		<p class="oa-event-description">
			<?php openagenda_field( 'description' ); ?>
		</p>
		
		<div class="oa-event-details">
			<div class="oa-event-share-button">
				<?php
					openagenda_icon( 'share' );
					openagenda_event_share_button();
				?>
			</div>
			
			<?php if ( ! empty( $oa_date_range ) ) : ?>
				<div class="oa-event-range">
					<?php
					openagenda_icon( 'clock' );
					echo wp_kses_post( $oa_date_range );
					?>
				</div>
			<?php endif; ?>
	
			<?php if ( ! empty( $oa_conditions ) ) : ?>
				<div class="oa-event-conditions">
					<?php
						openagenda_icon( 'ticket' );
						printf( '<strong class="oa-label oa-conditions-label">%s</strong>', esc_html__( 'Conditions', 'openagenda' ) );
						printf( '<div class="oa-conditions-value">%s</div>', esc_html( $oa_conditions ) );
					?>
				</div>
			<?php endif; ?>
	
			<?php if ( ! empty( $oa_registration_methods ) ) : ?>
				<div class="oa-event-registration">
					<?php
						openagenda_icon( 'check' );
						printf( '<strong class="oa-label oa-registration-label">%s</strong>', esc_html__( 'Registration', 'openagenda' ) );
						openagenda_event_registration_methods();
					?>
				</div>
			<?php endif; ?>
		</div>

		<figure class="oa-event-thumbnail">
			<?php
				openagenda_event_image();
			if ( ! empty( $oa_credits ) ) {
				printf( '<figcaption class="oa-image-credits">%s</figcaption>', esc_html( $oa_credits ) );
			}
			?>
		</figure>
		
		<div class="oa-event-longDescription">
			<?php openagenda_field( 'longDescription' ); ?>
		</div>
			
		<?php if ( ! empty( $oa_keywords ) ) : ?>
			<div class="oa-event-keywords">
				<?php openagenda_field( 'keywords-list' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $oa_access_link ) ) : ?>
			<div class="oa-event-access-link">
				<?php printf( '<strong class="oa-label oa-access-link-label">%1$s</strong><p><a href="%2$s">%2$s</a></p>', esc_html__( 'Access the online event: ', 'openagenda' ), esc_url( $oa_access_link ) ); ?>
			</div>
		<?php endif; ?>
		
		<?php require openagenda_get_template( 'event-additional-fields' ); ?>

		<div class="oa-event-timings">
			<?php openagenda_event_timings(); ?>
		</div>

		<?php require openagenda_get_template( 'event-location' ); ?>
	</div>
</article>