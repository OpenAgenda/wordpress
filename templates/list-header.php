<?php
/**
 * Template part for displaying the list header information
 *
 * @var string  $class     CSS class added to the wrapper
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package OpenAgenda
 * @version 3.0.0
 */
?>
<header class="<?php echo esc_attr( $class ); ?>">
	<?php
		openagenda_filters();
		echo do_shortcode( '[openagenda_filter_total]' );
		echo do_shortcode( '[openagenda_filter_active]' );
	?>
</header>