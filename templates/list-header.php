<?php
/**
 * Template part for displaying the list header information
 * 
 * @var string  $class     CSS class added to the wrapper
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Openagenda
 */
?>
<header class="<?php echo esc_attr( $class );?>">
    <!-- <div data-container-id="oa-events-total"><?php // \openagenda_get_events_total_html(); ?></div> -->
    <?php echo do_shortcode( '[openagenda_filter_total]' )?>
    <?php echo do_shortcode( '[openagenda_filter_active]' )?>
</header>