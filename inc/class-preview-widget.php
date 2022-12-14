<?php
namespace Openagenda;
/**
 * Class for our filter widget.
 */
class Preview_Widget extends Openagenda_Widget {

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
     */
	public function __construct( $args = array() ) {
        $args['additional_settings'] = array(
            'size' => array(
                'name'        => 'size',
                'type'        => 'number',
                'label'       => __( 'Number of events to display&nbsp;:', 'openagenda' ),
                'class'       => 'widefat',
                'default'     => 3
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
        );
        parent::__construct( 
            'openagenda-preview-widget', 
            __( 'Openagenda Preview', 'openagenda' ),
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

        // Encode filters to avoid brackets issues with do_shortcode()
        $instance['filters'] = ! empty( $instance['filters'] ) ? urlencode( $instance['filters'] ) : '';

        $shortcode = 'openagenda_filter_preview';
        $atts      = openagenda_get_shortcode_attributes( $instance );
        echo do_shortcode( sprintf( '[%s %s]', $shortcode, $atts ) );
        
        echo $args['after_widget'];
    }


    /**
     * Outputs the settings form in the Widgets administration screen
     * 
     * @param array $instance  Current settings.
     * @return string          Default return is 'noform'.
     */
	public function form( $instance ) {
        $title  = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $uid    = ! empty( $instance['uid'] ) ? $instance['uid'] : '';
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
        if( ! empty( $additional_settings ) ){
            foreach ( $additional_settings as $field_id => $field ) {
                $field = wp_parse_args( $field, array(
                    'description' => '',
                    'type'        => 'text',
                    'class'       => '',
                    'default'     => ''
                ) );
                echo $this->additional_setting_field( $field, $instance );
            }
        }
    }

    
	/**
     * Saves our options
     * 
     * @param   array  $new_instance  New settings for this instance.
     * @param   array  $old_instance  Old settings for this instance.
     * @return  array                 Settings to save or bool false to cancel saving
     */
	public function update( $new_instance, $old_instance ) {
        $instance = array(
            'title'   => ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '',
            'uid'     => ! empty( $new_instance['uid'] ) ? sanitize_text_field( $new_instance['uid'] ) : '',
            'size'    => ! empty( $new_instance['size'] ) ? (int) $new_instance['size'] : 3,
            'filters' => ! empty( $new_instance['filters'] ) ? urldecode( $new_instance['filters'] ) : '',
        );
        return $instance;
    }
}