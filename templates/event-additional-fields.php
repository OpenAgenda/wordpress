<?php
/**
 * Template part for displaying all event additional fields on single event pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OpenAgenda
 * @version 3.0.0
 */

$oa_additional_fields = openagenda_get_additional_fields_template_fields();
?>
<div class="oa-event-additional-fields">
		<?php
		foreach ( $oa_additional_fields as $oa_field ) {
			$oa_value = openagenda_get_additional_field( $oa_field );
			if ( $oa_value ) {
				$oa_label = openagenda_get_field_label( $oa_field );
				?>
						<div class="oa-event-additional-field oa-event-<?php echo esc_attr( $oa_field ); ?>">
							<strong class="oa-label oa-event-<?php echo esc_attr( $oa_field ); ?>-label">
							<?php echo esc_html( $oa_label ); ?>
							</strong>
							<div class="oa-event-<?php echo esc_attr( $oa_field ); ?>-value">
							<?php echo wp_kses_post( $oa_value ); ?>
							</div>
						</div>
					<?php
			}
		}
		?>
</div>