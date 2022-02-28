<?php
/**
 * Template part for displaying the preview loop wrapper
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @var     $atts        Shortcode attributes
 * @package Openagenda
 */
if( $openagenda->have_events()) : $openagenda->reset_index(); ?>
    <div class="oa-preview">
        <div class="oa-preview-events">
            <?php
                while( $openagenda->have_events() ) : $openagenda->the_event();
                    include openagenda_get_template( 'preview' );
                endwhile;
            ?>
        </div>
    </div>
<?php endif;