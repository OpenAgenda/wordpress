<?php
/**
 * Class for our filter widget.
 *
 * @package Openagenda
 */

namespace OpenAgenda;

/**
 * Class for our filter widget.
 */
class OpenAgenda_Widget extends \WP_Widget {

	/**
	 * Array of additional settings
	 */
	protected $additional_settings = array();

	/**
	 * Array of available filters
	 */
	protected $available_filters = array();

	/**
	 * Constructor
	 *
	 * @param  string $id_base         Optional Base ID for the widget, lowercase and unique. If left empty,
	 *                                 a portion of the widget's class name will be used Has to be unique.
	 * @param  string $name            Name for the widget displayed on the admin page.
	 * @param  array  $widget_options  Optional. Widget options. See wp_register_sidebar_widget() for information
	 *                                 on accepted arguments. Default empty array.
	 * @param  array  $control_options Optional. Widget control options. See wp_register_widget_control() for
	 *                                 information on accepted arguments. Default empty array.
	 * @param  array  $args            Optional. Additional arguments
	 */
	public function __construct( $id_base, $name, $widget_options = array(), $control_options = array(), $args = array() ) {
		$this->available_filters   = ! empty( $args['available_filters'] ) ? $args['available_filters'] : array();
		$this->additional_settings = ! empty( $args['additional_settings'] ) ? $args['additional_settings'] : array();
		parent::__construct( $id_base, $name, $widget_options, $control_options );
	}

	/**
	 * Outputs the widget on the front end
	 *
	 * @param array $args      Display arguments including 'before_title', 'after_title',
	 *                         'before_widget', and 'after_widget'.
	 * @param array $instance  The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {}

	/**
	 * Outputs the settings form in the Widgets administration screen
	 *
	 * @param array $instance  Current settings.
	 * @return string          Default return is 'noform'.
	 */
	public function form( $instance ) {}

	/**
	 * Saves our options
	 *
	 * @param   array $new_instance  New settings for this instance.
	 * @param   array $old_instance  Old settings for this instance.
	 * @return  array                 Settings to save or bool false to cancel saving
	 */
	public function update( $new_instance, $old_instance ) {}

	/**
	 * Returns array of available settings
	 */
	public function get_additional_settings() {
		return apply_filters( "{$this->id_base}_additional_settings", $this->additional_settings );
	}

	/**
	 * Returns array of available filters
	 */
	public function get_available_filters() {
		return apply_filters( "{$this->id_base}_available_filters", $this->available_filters );
	}

	/**
	 * Generates a settings field
	 *
	 * @param  array $field     Array of field arguments
	 * @param  array $instance  Instance settings
	 */
	public function additional_setting_field( $field, $instance ) {
		$value = isset( $instance[ $field['name'] ] ) ? $instance[ $field['name'] ] : $field['default'];
		$html  = '';
		switch ( $field['type'] ) {
			case 'textarea':
				$description = ! empty( $field['description'] ) ? sprintf( '<em>%s</em>', wp_kses_post( $field['description'] ) ) : '';
				$html        = sprintf(
					'<p>
                        <label for="%1$s">%3$s</label>
                        <textarea id="%1$s" name="%2$s" rows=5 class="%4$s">%5$s</textarea>
                        %6$s
                    </p>',
					esc_attr( $this->get_field_id( $field['name'] ) ),
					esc_attr( $this->get_field_name( $field['name'] ) ),
					esc_html( $field['label'] ),
					esc_attr( $field['class'] ),
					esc_textarea( $value ),
					$description
				);
				break;
			case 'checkbox':
				$description = ! empty( $field['description'] ) ? sprintf( '<span class="description"><em>(%s)</em></span>', wp_kses_post( $field['description'] ) ) : '';
				$html        = sprintf(
					'<p>
                        <input type="checkbox" id="%1$s" name="%2$s" class="%4$s" %5$s>
                        <label for="%1$s">%3$s</label>
                        %6$s
                    </p>',
					esc_attr( $this->get_field_id( $field['name'] ) ),
					esc_attr( $this->get_field_name( $field['name'] ) ),
					esc_html( $field['label'] ),
					esc_attr( $field['class'] ),
					checked( $value, true, false ),
					$description
				);
				break;
			case 'multi-checkbox':
				$description = ! empty( $field['description'] ) ? sprintf( '<label class="">%s</label>', wp_kses_post( $field['description'] ) ) : '';
				$options     = '';
				if ( ! empty( $field['options'] ) ) {
					foreach ( $field['options'] as $option_value => $option_label ) {
						$checked  = in_array( $option_value, $value ) ? 'checked=checked' : '';
						$options .= sprintf(
							'<span>
                                <input type="checkbox" id="%1$s" name="%2$s[]" class="%4$s" value="%5$s" %6$s>
                                <label for="%1$s">%3$s</label>
                            </span>',
							esc_attr( sprintf( '%s-%s', $this->get_field_id( $field['name'] ), $option_value ) ),
							esc_attr( $this->get_field_name( $field['name'] ) ),
							esc_html( $option_label ),
							esc_attr( $field['class'] ),
							esc_attr( $option_value ),
							$checked,
						);
					}
				}
				$html = sprintf(
					'<p>%s<div style="display:flex; align-items:center; flex-wrap:wrap; gap:12px;">%s</div></p>',
					$description,
					$options
				);
				break;
			case 'select';
				$options = '';
				if ( ! empty( $field['options'] ) ) {
					if ( ! empty( $field['option_none'] ) ) {
						$options .= sprintf( '<option value="">%s</option>', esc_html( $field['option_none'] ) );
					}
					foreach ( $field['options'] as $option_value => $option_label ) {
						$options .= sprintf(
							'<option value="%1$s"%3$s>%2$s</option>',
							esc_attr( $option_value ),
							esc_html( $option_label ),
							selected( $value, $option_value, false )
						);
					}
				}

				$html = sprintf(
					'<p><label for="%1$s">%3$s</label>
                    <select id="%1$s" name="%2$s" class="%4$s">
					%5$s
					</select></p>',
					esc_attr( $this->get_field_id( $field['name'] ) ),
					esc_attr( $this->get_field_name( $field['name'] ) ),
					esc_html( $field['label'] ),
					esc_attr( $field['class'] ),
					$options
				);
			break;
			case 'radio';
				$options = '';
				if ( ! empty( $field['options'] ) ) {
					foreach ( $field['options'] as $option => $data ) {
						$option_value = $data['value'] ?? '';
						$option_label = $data['label'] ?? '';
						$id           = sprintf( '%s-%s', $this->get_field_id( $field['name'] ), $option_value );
						$options     .= sprintf(
							'<span><input type="radio" id="%1$s" name="%2$s" value="%3$s"%5$s><label for="%1$s">%4$s</label></span><br />',
							esc_attr( $id ),
							esc_attr( $this->get_field_name( $field['name'] ) ),
							esc_attr( $option_value ),
							esc_html( $option_label ),
							checked( $value, $option_value, false )
						);
					}
				}

				$html = sprintf(
					'<fieldset>
						<legend>%1$s</legend>
						%2$s
					</fieldset>',
					esc_html( $field['label'] ),
					$options
				);
				break;
			default:
				$description = ! empty( $field['description'] ) ? sprintf( '<em><span class="description">%s</span></em>', wp_kses_post( $field['description'] ) ) : '';
				$placeholder = ! empty( $field['placeholder'] ) ? sprintf( 'placeholder="%s"', esc_attr( $field['placeholder'] ) ) : '';
				$html        = sprintf(
					'<p>
                        <label for="%1$s">%3$s</label>
                        <input type="%4$s" id="%1$s" class="%5$s" name="%2$s" %6$s value="%7$s">
                        %8$s
                    </p>',
					esc_attr( $this->get_field_id( $field['name'] ) ),
					esc_attr( $this->get_field_name( $field['name'] ) ),
					esc_html( $field['label'] ),
					esc_attr( $field['type'] ),
					esc_attr( $field['class'] ),
					$placeholder,
					esc_attr( $value ),
					$description
				);
				break;
		}
		return $html;
	}
}
