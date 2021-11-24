<?php
namespace Openagenda;
/**
 * Class for our filter widget.
 */
class Filter_Widget extends Openagenda_Widget {

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
        $settings            = get_option( 'openagenda_integrations_settings' );
        $default_tiles       = ! empty( $settings['openagenda_map_tiles_link'] ) ? $settings['openagenda_map_tiles_link'] : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        $default_attribution = ! empty( $settings['openagenda_map_tiles_attribution_link'] ) ? $settings['openagenda_map_tiles_attribution_link'] : sprintf( '<a href="%s">%s</a>', 'https://www.openstreetmap.org/copyright', __( 'OpenStreetMap contributors', 'openagenda' ) );

        $args['additional_settings'] = array(
            'openagenda_filter_map' => array(
                'map_tiles_link' => array(
                    'name'        => 'map_tiles_link',
                    'label'       => __( 'Map tiles link:', 'openagenda' ),
                    'class'       => 'widefat',
                    'default'     => $default_tiles,
                    'description' => __( 'The default map tile link can be found in your Integrations settings.', 'openagenda' )
                ),
                'map_auto' => array(
                    'name'        => 'map_auto',
                    'label'       => __( 'Automatically update map on scroll ?', 'openagenda' ),
                    'type'        => 'checkbox',
                    'default'     => false
                ),
                'map_longitude' => array(
                    'name'        => 'map_longitude',
                    'label'       => __( 'Default longitude:', 'openagenda' ),
                    'class'       => 'widefat',
                ),
                'map_latitude' => array(
                    'name'        => 'map_latitude',
                    'label'       => __( 'Default latitude:', 'openagenda' ),
                    'class'       => 'widefat',
                ),
                'map_zoom' => array(
                    'name'        => 'map_zoom',
                    'label'       => __( 'Map default zoom:', 'openagenda' ),
                    'type'        => 'number',
                    'class'       => 'tiny-text',
                    'default'     => 12
                ),
            ),
            'openagenda_filter_search' => array(
                'placeholder'     => array(
                    'name'        => 'placeholder',
                    'label'       => __( 'Placeholder text:', 'openagenda' ),
                    'class'       => 'widefat',
                    'default'     => __( 'Search events', 'openagenda' )
                ),
            ),
            'openagenda_filter_tags' => array(
                'tag_group' => array(
                    'name'        => 'tag_group',
                    'label'       => __( 'Tag group:', 'openagenda' ),
                    'class'       => 'widefat',
                ),
                'tags' => array(
                    'name'        => 'tags',
                    'label'       => __( 'Tags to display:', 'openagenda' ),
                    'description' => __( 'Enter tags separated by a comma.', 'openagenda' ),
                    'type'        => 'textarea',
                    'class'       => 'large-text',
                ),
            ), 
        );

        parent::__construct( 
            'openagenda-filter-widget', 
            __( 'Openagenda Filter', 'openagenda' ),
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
     * @param array $args      Display arguments including 'before_title', 'after_title',
     *                         'before_widget', and 'after_widget'.
     * @param array $instance  The settings for the particular instance of the widget.
     */
	public function widget( $args, $instance ) {
        $available_filters = $this->get_available_filters();

        if( ! is_singular( 'oa-calendar' ) ) return;
        if( empty( $instance['filter'] ) || ! array_key_exists( $instance['filter'], $available_filters ) ) return;
       
        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];
        }

        $filter    = $available_filters[$instance['filter']];
        $shortcode = ! empty( $filter['shortcode'] ) ? sanitize_key( $filter['shortcode'] ) : false;

        if( $shortcode ){
            $atts = openagenda_get_shortcode_attributes( $instance );
            echo do_shortcode( sprintf( '[%s %s]', $shortcode, $atts ) );
        }
        
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
        $filter = ! empty( $instance['filter'] ) ? $instance['filter'] : '';
        $available_filters = $this->get_available_filters();
        ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title :', 'openagenda' ); ?></label>
                <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>"><?php esc_html_e( 'Filter to display :', 'openagenda' ); ?></label>
                <select id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ); ?>" class="widefat">
                    <option value=""><?php esc_html_e( 'Choose filter', 'openagenda' ); ?></option>
                    <?php foreach ( $available_filters as $key => $filter_data ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $filter, $key ); ?>><?php echo esc_html( $filter_data['label'] ); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
        <?php

        $additional_settings = $this->get_additional_settings();
        if( ! empty( $additional_settings ) && array_key_exists( $filter, $additional_settings ) ){
            foreach ( $additional_settings[$instance['filter']] as $field_id => $field ) {
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
            'title'  => ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '',
            'filter' => array_key_exists( $new_instance['filter'], $this->get_available_filters() ) ? $new_instance['filter'] : '',
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
            case 'openagenda_filter_tags':
                $tags_string = '';
                if( ! empty( $new_instance['tags'] ) ){
                    $tags_array  = array_map( function( $tag ){ return sanitize_title( trim( $tag ) ); }, explode( ',', sanitize_textarea_field( $new_instance['tags'] ) ) );
                    $tags_string = join( ',', $tags_array );
                }
                $additional_settings = array( 
                    'tags'      => ! empty( $tags_string ) ? $tags_string : '',
                    'tag_group' => ! empty( $new_instance['tag_group'] ) ? sanitize_text_field( $new_instance['tag_group'] ) : '',
                );
                break;
            default:
                $additional_settings = array();
                break;
        }

        $instance = array_merge( $instance, $additional_settings  );
        return $instance;
    }
}