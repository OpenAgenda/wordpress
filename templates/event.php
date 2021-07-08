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
                <a class="oa-event-permalink" href="<?php openagenda_event_permalink( false, true, true ); ?>">
                    <?php openagenda_event_image( 'image' ); ?>
                </a>
            </div>
            <h2 class="oa-event-title">
                <a class="oa-event-permalink" href="<?php openagenda_event_permalink( false, true, true ); ?>">
                    <?php openagenda_field( 'title' ); ?>
                </a>
            </h2>
            <div class="oa-metas">
                <p class="oa-meta oa-event-timing">
                    <?php 
                        openagenda_icon( 'time' );
                        openagenda_event_timing( 'relative' ); 
                    ?>
                </p>
                <p class="oa-meta oa-event-range">
                    <?php
                        openagenda_icon( 'month' );
                        openagenda_field( 'range' );
                    ?>
                </p>
                <p class="oa-meta oa-event-attendance">
                    <?php
                        openagenda_icon( 'location' );
                        openagenda_event_attendance_mode();
                    ?>
                </p>
            </div>
        </header>
        <p class="oa-event-short-description"><?php openagenda_field( 'description' ); ?></p>
    </div>
</article>