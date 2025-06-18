<?php
/**
 * Template part for displaying the preview loop wrapper
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @var     $atts        Shortcode attributes
 * @package OpenAgenda
 * @version 3.0.0
 */

$oa_view     = $atts['view'] ?? 'list';
$oa_template = ! empty( openagenda_get_template( 'preview' ) ) ? openagenda_get_template( 'preview' ) : openagenda_get_template( 'event' );

if ( $openagenda->have_events() ) :
	$openagenda->reset_index(); ?>
	<div class="oa-preview <?php echo esc_attr( $oa_view ); ?>">
		<div class="oa-preview-events">
			<?php
			while ( $openagenda->have_events() ) :
				$openagenda->the_event();
				include $oa_template;
				endwhile;
			?>
		</div>
	</div>
	<?php
endif;