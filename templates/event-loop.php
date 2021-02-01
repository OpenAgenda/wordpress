<?php
/**
 * Template part containing the main event loop.
 * Acts as a wrapper around actual event templates
 * 
 * @var string  $class     CSS class added to the wrapper
 * @var string  $template  Event template to load
 * @see openagenda_get_events_html()
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Open_Agenda
 */
if( $openagenda->have_events() ) : ?>
    <div class="<?php echo esc_attr( $class ); ?>">
        <?php
            if( $openagenda->is_archive() ) openagenda_exports();
            if( $openagenda->is_archive() ) openagenda_pagination();
            if( $openagenda->is_single() ) open_agenda_navigation();
            while( $openagenda->have_events() ) : $openagenda->the_event();
                include openagenda_get_template( $template );
            endwhile; 
            if( $openagenda->is_archive() ) openagenda_pagination();
        ?>
    </div>
<?php else: ?>
    <div class="<?php echo esc_attr( $class ); ?>">
        <p><?php esc_html_e( 'Sorry, we could not find any event.', 'openagenda' ); ?></p>
    </div>
<?php endif;