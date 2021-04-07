<?php
/**
 * Template part containing the main event loop.
 * Acts as a wrapper around actual event templates
 * 
 * @var string  $class     CSS class added to the wrapper
 * @var string  $view      View setting
 * @var string  $template  Event template to load
 * @see openagenda_get_events_html()
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Openagenda
 */
if( $openagenda->have_events() ) : ?>
    <div class="oa-controls oa-controls-top">
        <?php
            if( $openagenda->is_archive() ) {
                openagenda_exports(); 
                openagenda_pagination();
            } else {
                openagenda_navigation();
            }
        ?>
    </div>
    <div class="<?php echo esc_attr( $class ); ?>">
        <?php
            while( $openagenda->have_events() ) : $openagenda->the_event();
                include openagenda_get_template( $template );
            endwhile; 
        ?>
    </div>
    <?php if( $openagenda->is_archive() ) : ?>
        <div class="oa-controls oa-controls-bottom">
            <?php openagenda_pagination(); ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="<?php echo esc_attr( $class ); ?>">
        <p><?php esc_html_e( 'Sorry, we could not find any event.', 'openagenda' ); ?></p>
    </div>
<?php endif;