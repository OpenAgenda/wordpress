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

$openagenda_view     = $atts['view'] ?? 'list';
$openagenda_class    = sprintf( 'oa-event-%s', sanitize_title( $openagenda_view ) );
$openagenda_template = ! empty( openagenda_get_template( 'preview' ) ) ? openagenda_get_template( 'preview' ) : openagenda_get_template( 'event' );

if ( $openagenda->have_events() ) :
	$openagenda->reset_index(); ?>
	<div class="oa-preview">
		<div class="oa-preview-events <?php echo esc_attr( $openagenda_class ); ?>">
			<?php
			while ( $openagenda->have_events() ) :
				$openagenda->the_event();
				include $openagenda_template;
				endwhile;
			?>
		</div>
	</div>
	<?php
endif;