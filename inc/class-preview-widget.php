<?php
namespace Openagenda;
/**
 * Class for our filter widget.
 */
class Preview_Widget extends \WP_Widget {

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
	public function __construct() {
        parent::__construct( 
            'openagenda-preview-widget', 
            __( 'Openagenda Preview', 'openagenda' ),
            array( 
                'description'                 => __( 'Displays a calendar preview widget.', 'openagenda' ),
                'customize_selective_refresh' => true,
            )
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
        $label  = isset( $instance['preview_label'] ) ? $instance['preview_label'] : __( 'Preview', 'openagenda' );
        $help   = __( 'This corresponds to the text for the link to the calendar.', 'openagenda' );
        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title :', 'openagenda' ); ?></label>
                <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'uid' ) ); ?>"><?php esc_html_e( 'Agenda UID :', 'openagenda' ); ?></label>
                <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'uid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'uid' ) ); ?>" value="<?php echo esc_attr( $uid ); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'preview_label' ) ); ?>"><?php esc_html_e( 'Preview label :', 'openagenda' ); ?></label>
                <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'preview_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'preview_label' ) ); ?>" value="<?php echo esc_attr( $label ); ?>">
                <span class="description"><?php echo wp_kses_post( $help ); ?></span>
            </p>
        <?php
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
            'title'         => ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '',
            'preview_label' => ! empty( $new_instance['preview_label'] ) ? sanitize_text_field( $new_instance['preview_label'] ) : '',
            'uid'           => ! empty( $new_instance['uid'] ) ? sanitize_text_field( $new_instance['uid'] ) : '',
        );
        return $instance;
    }
}