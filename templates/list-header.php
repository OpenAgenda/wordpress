<?php
/**
 * Template part for displaying the list header information
 * 
 * @var string  $class     CSS class added to the wrapper
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package OpenAgenda
 */
?>
<header class="<?php echo esc_attr( $class );?>">
    <?php echo do_shortcode( '[openagenda_filter_total]' )?>
    <?php echo do_shortcode( '[openagenda_filter_active]' )?>
</header>