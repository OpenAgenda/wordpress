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
class Filter_Widget extends OpenAgenda_Widget {

	/**
	 * Constructor
	 *
	 * @param  array<string, mixed> $args Optional. Additional arguments.
	 */
	public function __construct( $args = array() ) {
		$args['additional_settings'] = array();
		if ( ! empty( $args['available_filters'] ) ) {
			foreach ( $args['available_filters'] as $filter => $filter_data ) {
				$args['additional_settings'][ $filter ] = ! empty( $filter_data['settings'] ) ? $filter_data['settings'] : array();
			}
		}

		parent::__construct(
			'openagenda-filter-widget',
			__( 'OpenAgenda Filter', 'openagenda' ),
			array(
				'description'                 => __( 'Displays a filter widget.', 'openagenda' ),
				'customize_selective_refresh' => true,
			),
			array(),
			$args
		);
	}


	/**
	 * Outputs the widget on the front end
	 *
	 * @param array<string, mixed> $args Display arguments including 'before_title', 'after_title',
	 *                         'before_widget', and 'after_widget'.
	 * @param array<string, mixed> $instance The settings for the particular instance of the widget.
	 * @return void
	 */
	public function widget( $args, $instance ): void {
		$available_filters = $this->get_available_filters();

		if ( ! is_singular( OPENAGENDA_POST_TYPE_SLUG ) ) {
			return;
		}
		if ( empty( $instance['filter'] ) || ! array_key_exists( $instance['filter'], $available_filters ) ) {
			return;
		}

		$display_on_single = ! isset( $instance['display_on_single'] ) || ! in_array( $instance['display_on_single'], array( 'false', '0', '', 0, false ), true );
		if ( openagenda_is_single() && ! $display_on_single ) {
			return;
		}

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		$filter    = $available_filters[ $instance['filter'] ];
		$shortcode = ! empty( $filter['shortcode'] ) ? sanitize_key( $filter['shortcode'] ) : false;

		if ( $shortcode ) {
			$atts = openagenda_get_shortcode_attributes( $instance, $args['widget_id'] );
			echo do_shortcode( sprintf( '[%s %s]', $shortcode, $atts ) );
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}


	/**
	 * Outputs the settings form in the Widgets administration screen
	 *
	 * @param array<string, mixed> $instance Current settings.
	 * @return string|null
	 */
	public function form( $instance ): ?string {
		$title             = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$filter            = ! empty( $instance['filter'] ) ? $instance['filter'] : '';
		$dropdown          = ! empty( $instance['dropdown'] ) ? $instance['dropdown'] : '';
		$display_on_single = ! empty( $instance['display_on_single'] ) ? $instance['display_on_single'] : true;
		$available_filters = $this->get_available_filters();
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title :', 'openagenda' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>"><?php esc_html_e( 'Filter to display :', 'openagenda' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ); ?>" class="openagenda-filter-field widefat">
					<option value=""><?php esc_html_e( 'Choose filter', 'openagenda' ); ?></option>
					<?php foreach ( $available_filters as $key => $filter_data ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $filter, $key ); ?>><?php echo esc_html( $filter_data['label'] ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<p>
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'display_on_single' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_on_single' ) ); ?>" <?php checked( $display_on_single ); ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( 'display_on_single' ) ); ?>"><?php esc_html_e( 'Display filter on single event views ?', 'openagenda' ); ?></label>
			</p>
			<p>
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'dropdown' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dropdown' ) ); ?>" <?php checked( $dropdown ); ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( 'dropdown' ) ); ?>"><?php esc_html_e( 'Display filter as a dropdown ?', 'openagenda' ); ?></label>
			</p>
		<?php

		$additional_settings = $this->get_additional_settings();
		if ( ! empty( $additional_settings ) ) {
			foreach ( $additional_settings as $filter => $fields ) {
				printf( '<div data-filter="%1$s" class="openagenda-additional-settings %1$s-additional-settings">', esc_attr( $filter ) );
				foreach ( $fields as $field ) {
					$field = wp_parse_args(
						$field,
						array(
							'description' => '',
							'type'        => 'text',
							'class'       => '',
							'default'     => '',
						)
					);
					echo $this->additional_setting_field( $field, $instance ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				echo '</div>';
			}
		}
		return null;
	}


	/**
	 * Saves our options
	 *
	 * @param   array<string, mixed> $new_instance New settings for this instance.
	 * @param   array<string, mixed> $old_instance Old settings for this instance.
	 * @return  array<string, mixed> Settings to save.
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance = array(
			'title'             => ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '',
			'filter'            => array_key_exists( $new_instance['filter'], $this->get_available_filters() ) ? $new_instance['filter'] : '',
			'dropdown'          => ! empty( $new_instance['dropdown'] ) ? (bool) $new_instance['dropdown'] : false,
			'display_on_single' => ! empty( $new_instance['display_on_single'] ) ? (bool) $new_instance['display_on_single'] : false,
		);

		switch ( $instance['filter'] ) {
			case 'openagenda_filter_map':
				$additional_settings = array(
					'map_tiles_link' => ! empty( $new_instance['map_tiles_link'] ) ? sanitize_text_field( $new_instance['map_tiles_link'] ) : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
					'map_zoom'       => ! empty( $new_instance['map_zoom'] ) ? (int) $new_instance['map_zoom'] : 12,
					'map_auto'       => isset( $new_instance['map_auto'] ) ? (bool) $new_instance['map_auto'] : false,
					'map_longitude'  => ! empty( $new_instance['map_longitude'] ) ? (float) $new_instance['map_longitude'] : '',
					'map_latitude'   => ! empty( $new_instance['map_latitude'] ) ? (float) $new_instance['map_latitude'] : '',
				);
				break;
			case 'openagenda_filter_search':
				$additional_settings = array(
					'placeholder' => ! empty( $new_instance['placeholder'] ) ? sanitize_text_field( $new_instance['placeholder'] ) : '',
				);
				break;
			case 'openagenda_filter_calendar':
				$additional_settings = array(
					'display_ranges' => isset( $new_instance['display_ranges'] ) ? (bool) $new_instance['display_ranges'] : false,
					'type'           => ! empty( $new_instance['type'] ) ? sanitize_text_field( $new_instance['type'] ) : 'dateRange',
					'ranges'         => ! empty( $new_instance['ranges'] ) ? array_unique(
						array_map(
							function ( $range ) {
								return sanitize_text_field( $range );
							},
							$new_instance['ranges']
						)
					) : array(),
				);
				break;
			case 'openagenda_filter_ranges':
				$additional_settings = array(
					'static_ranges' => ! empty( $new_instance['static_ranges'] ) ? array_unique(
						array_map(
							function ( $range ) {
								return sanitize_text_field( $range );
							},
							$new_instance['static_ranges']
						)
					) : array(),
				);
				break;
			case 'openagenda_filter_sort':
				$additional_settings = array(
					'options' => ! empty( $new_instance['options'] ) ? array_unique(
						array_map(
							function ( $value ) {
								return sanitize_text_field( $value );
							},
							$new_instance['options']
						)
					) : array(),
				);
				break;
			case 'openagenda_filter_choice':
				$additional_settings = array(
					'field'            => ! empty( $new_instance['field'] ) ? sanitize_text_field( $new_instance['field'] ) : '',
					'additional_field' => ! empty( $new_instance['additional_field'] ) ? sanitize_text_field( $new_instance['additional_field'] ) : '',
					'page_size'        => ! empty( $new_instance['page_size'] ) ? (int) $new_instance['page_size'] : 10,
					'sort'             => ! empty( $new_instance['sort'] ) ? sanitize_text_field( $new_instance['sort'] ) : '',
				);
				break;
			case 'openagenda_filter_submit':
				$additional_settings = array(
					'button_label' => ! empty( $new_instance['button_label'] ) ? sanitize_text_field( $new_instance['button_label'] ) : '',
				);
				break;
			default:
				$additional_settings = array();
				break;
		}

		$instance = array_merge( $instance, $additional_settings );
		return $instance;
	}
}