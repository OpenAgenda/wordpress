<?php
/**
 * Template part for displaying all event additional fields on single event pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OpenAgenda
 * @version 3.0.0
 */

$additional_fields = openagenda_get_additional_fields_template_fields();
?>
<div class="oa-event-additional-fields">
		<?php
		foreach ( $additional_fields as $field ) {
			$value = openagenda_get_additional_field( $field );
			if ( $value ) {
				$label = openagenda_get_field_label( $field );
				?>
						<div class="oa-event-additional-field oa-event-<?php echo esc_attr( $field ); ?>">
							<strong class="oa-label oa-event-<?php echo esc_attr( $field ); ?>-label">
							<?php echo esc_html( $label ); ?>
							</strong>
							<div class="oa-event-<?php echo esc_attr( $field ); ?>-value">
							<?php echo wp_kses_post( $value ); ?>
							</div>
						</div>
					<?php
			}
		}
		?>
</div>