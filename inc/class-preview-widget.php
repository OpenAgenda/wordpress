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
class Preview_Widget extends OpenAgenda_Widget {

	/**
	 * Constructor
	 * Uses parent constructor.
	 *
	 * @param  array $args  Additional arguments.
	 */
	public function __construct( $args = array() ) {
		$args['additional_settings'] = array(
			'size'    => array(
				'name'    => 'size',
				'type'    => 'number',
				'label'   => __( 'Number of events to display&nbsp;:', 'openagenda' ),
				'class'   => 'widefat',
				'default' => 3,
			),
			'view'    => array(
				'name'    => 'view',
				'type'    => 'radio',
				'label'   => __( 'Display setting', 'openagenda' ),
				'default' => 'list',
				'class'   => 'widefat',
				'options' => array(
					'list' => array(
						'label' => __( 'Display as list', 'openagenda' ),
						'value' => 'list',
					),
					'grid' => array(
						'label' => __( 'Display as grid', 'openagenda' ),
						'value' => 'grid',
					),
				),
			),
			'sort'    => array(
				'name'    => 'sort',
				'type'    => 'select',
				'label'   => __( 'Default event sort', 'openagenda' ),
				'default' => 'lastTimingWithFeatured.asc',
				'class'   => 'widefat',
				'options' => array(
					'lastTimingWithFeatured.asc' => __( 'Featured first, followed by ascending last occurrence (default)', 'openagenda' ),
					'timingsWithFeatured.asc'    => __( 'Featured first, followed by ascending upcoming occurrence', 'openagenda' ),
					'lastTiming.asc'             => __( 'Ascending last occurrence', 'openagenda' ),
					'timings.asc'                => __( 'Ascending upcoming occurrence', 'openagenda' ),
					'updatedAt.desc'             => __( 'Descending update date', 'openagenda' ),
					'updatedAt.asc'              => __( 'Ascending update date', 'openagenda' ),
				),
			),
			'filters' => array(
				'name'        => 'filters',
				'type'        => 'text',
				'label'       => __( 'Default filters (advanced)', 'openagenda' ),
				'class'       => 'widefat',
				'placeholder' => '?relative[]=upcoming',
				'default'     => '',
				'description' => __( 'Use a query string representing a filtered query. Only events corresponding to these filters will be displayed.', 'openagenda' ),
			),
			'links'   => array(
				'name'        => 'links',
				'type'        => 'checkbox',
				'label'       => __( 'Use external links', 'openagenda' ),
				'class'       => 'widefat',
				'default'     => false,
				'description' => __( 'Check to make event permalinks point to event pages on https://openagenda.com instead of local pages.', 'openagenda' ),
			),
		);
		parent::__construct(
			'openagenda-preview-widget',
			__( 'OpenAgenda Preview', 'openagenda' ),
			array(
				'description'                 => __( 'Displays a calendar preview widget.', 'openagenda' ),
				'customize_selective_refresh' => true,
			),
			array(),
			$args
		);
	}


	/**
	 * Outputs the widget on the front end
	 *
	 * @param array $args      Display arguments including 'before_title', 'after_title',
	 *                         'before_widget', and 'after_widget'.
	 * @param array $instance  The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];
		}

		// Encode filters to avoid brackets issues with do_shortcode().
		$instance['filters'] = ! empty( $instance['filters'] ) ? rawurlencode( $instance['filters'] ) : '';
		$instance['links']   = ! empty( $instance['links'] ) ? 'oa' : '';

		$shortcode = 'openagenda_filter_preview';
		$atts      = openagenda_get_shortcode_attributes( $instance );
		echo do_shortcode( sprintf( '[%s %s]', $shortcode, $atts ) );

		echo $args['after_widget'];
	}


	/**
	 * Outputs the settings form in the Widgets administration screen
	 *
	 * @param array $instance  Current settings.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$uid   = ! empty( $instance['uid'] ) ? $instance['uid'] : '';
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title :', 'openagenda' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'uid' ) ); ?>"><?php esc_html_e( 'Agenda UID :', 'openagenda' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'uid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'uid' ) ); ?>" value="<?php echo esc_attr( $uid ); ?>">
			</p>  
		<?php

		$additional_settings = $this->get_additional_settings();
		if ( ! empty( $additional_settings ) ) {
			foreach ( $additional_settings as $field_id => $field ) {
				$field = wp_parse_args(
					$field,
					array(
						'description' => '',
						'type'        => 'text',
						'class'       => '',
						'default'     => '',
					)
				);
				echo $this->additional_setting_field( $field, $instance );
			}
		}
	}


	/**
	 * Saves our options
	 *
	 * @param   array $new_instance  New settings for this instance.
	 * @param   array $old_instance  Old settings for this instance.
	 * @return  array                 Settings to save or bool false to cancel saving
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array(
			'title'   => ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '',
			'uid'     => ! empty( $new_instance['uid'] ) ? sanitize_text_field( $new_instance['uid'] ) : '',
			'size'    => ! empty( $new_instance['size'] ) ? (int) $new_instance['size'] : 3,
			'view'    => ! empty( $new_instance['view'] ) ? sanitize_title( $new_instance['view'] ) : 'list',
			'sort'    => ! empty( $new_instance['sort'] ) ? sanitize_text_field( $new_instance['sort'] ) : 'timingsWithFeatured.asc',
			'filters' => ! empty( $new_instance['filters'] ) ? urldecode( $new_instance['filters'] ) : '',
			'links'   => ! empty( $new_instance['links'] ),
		);
		return $instance;
	}
}