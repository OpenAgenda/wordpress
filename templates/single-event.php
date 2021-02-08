<?php
/**
 * Template part for displaying a single event content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Openagenda
 */
?>
<article id="event-<?php openagenda_field( 'uid' ); ?>" class="oa-event oa-single-event">
    <div class="oa-event-wrapper">
        <header class="oa-event-header">
            <h2 class="oa-event-title"><?php openagenda_field( 'title' ); ?></h2>
            <div class="oa-meta">
                <p class="oa-event-timing">
                    <?php 
                        openagenda_icon( 'time' );
                        openagenda_event_timing(); 
                    ?>
                </p>
                <p class="oa-event-range">
                    <?php
                        openagenda_icon( 'month' );
                        openagenda_field( 'range' );
                    ?>
                </p>
                <div class="oa-event-share"><?php openagenda_event_share_buttons(); ?></div>
            </div>
            <p class="oa-entry-description"><?php openagenda_field( 'description' ); ?></p>
            <div class="oa-event-thumbnail"><?php openagenda_event_image( 'image' ); ?></div>
        </header>
        <div class="oa-event-timings"><?php openagenda_event_timings(); ?></div>
        <div class="oa-event-details"><?php openagenda_field( 'html' ); ?></div>
        
        <?php include openagenda_get_template( 'event-location' ); ?>
    </div>
</article>