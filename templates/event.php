<?php
/**
 * Template part for displaying a single events list item
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Openagenda
 */
?>
<article id="event-<?php openagenda_field( 'uid' ); ?>" class="oa-event oa-list-item">
    <div class="oa-event-wrapper">
        <header class="oa-event-header">
            <div class="oa-event-thumbnail">
                <a class="oa-event-permalink" href="<?php openagenda_event_permalink(); ?>">
                    <?php openagenda_event_image(); ?>
                </a>
            </div>
            <h2 class="oa-event-title">
                <a class="oa-event-permalink" href="<?php openagenda_event_permalink(); ?>">
                    <?php openagenda_field( 'title' ); ?>
                </a>
                <?php openagenda_favorite_badge(); ?>
            </h2>
            <div class="oa-metas">
                <?php if( $timing = openagenda_event_timing( 'relative', false, false ) ) : ?>
                    <p class="oa-meta oa-event-timing">
                        <?php openagenda_icon( 'time' ); echo wp_kses_post( $timing ) ?>
                    </p>
                <?php endif; ?>
                <?php if( $dateRange = openagenda_get_field( 'dateRange' ) ) : ?>
                    <p class="oa-meta oa-event-range">
                        <?php openagenda_icon( 'month' ); echo wp_kses_post( $dateRange ) ?>
                    </p>
                <?php endif; ?>
                <?php if( $attendance = openagenda_event_attendance_mode( false, false ) ) : ?>
                    <p class="oa-meta oa-event-attendance">
                        <?php openagenda_icon( 'link' ); echo wp_kses_post( $attendance ) ?>
                    </p>
                <?php endif; ?>
            </div>
        </header>
        <p class="oa-event-short-description"><?php openagenda_field( 'description' ); ?></p>
    </div>
</article>