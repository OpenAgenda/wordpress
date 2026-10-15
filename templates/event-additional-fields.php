<?php
/**
 * Template part for displaying all event additional fields on single event pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OpenAgenda
 * @version 3.0.0
 */

$openagenda_additional_fields = openagenda_get_additional_fields_template_fields();
?>
<div class="oa-event-additional-fields">
		<?php
		foreach ( $openagenda_additional_fields as $openagenda_field ) {
			$openagenda_value = openagenda_get_additional_field( $openagenda_field );
			if ( $openagenda_value ) {
				$openagenda_label = openagenda_get_field_label( $openagenda_field );
				?>
						<div class="oa-event-additional-field oa-event-<?php echo esc_attr( $openagenda_field ); ?>">
							<strong class="oa-label oa-event-<?php echo esc_attr( $openagenda_field ); ?>-label">
							<?php echo esc_html( $openagenda_label ); ?>
							</strong>
							<div class="oa-event-<?php echo esc_attr( $openagenda_field ); ?>-value">
							<?php echo wp_kses_post( $openagenda_value ); ?>
							</div>
						</div>
					<?php
			}
		}
		?>
</div>