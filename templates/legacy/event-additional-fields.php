<?php
/**
 * Template part for displaying all event additional fields on single event pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OpenAgenda
 * @version 2.14.0
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
						<p class="oa-event-<?php echo esc_attr( $field ); ?>">
							<strong class="oa-event-<?php echo esc_attr( $field ); ?>-label block">
							<?php echo esc_html( $label ); ?>
							</strong>
							<span class="oa-event-<?php echo esc_attr( $field ); ?>-value block">
							<?php echo wp_kses_post( $value ); ?>
							</span>
						</p>
					<?php
			}
		}
		?>
</div>