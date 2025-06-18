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

$oa_display_default_filters = 'yes' === get_post_meta( get_the_ID(), 'oa-calendar-display-default-filters', true );
?>
<header class="<?php echo esc_attr( $class ); ?>">
	<?php if ( $oa_display_default_filters ) : ?>
		<div class="oa-filters oa-default-filters">
			<?php
				echo do_shortcode( '[openagenda_filter_calendar dropdown="true"]' );
				echo do_shortcode( '[openagenda_filter_search]' );
			?>
		</div>
	<?php endif; ?>
	<?php
		echo do_shortcode( '[openagenda_filter_active]' );
		echo do_shortcode( '[openagenda_filter_total]' );
	?>
</header>