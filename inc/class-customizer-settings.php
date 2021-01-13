<?php
namespace Openagenda;
/**
 * Customizer Settings Manager class
 * 
 * Responsible for registering customizer settings.
 */
class Customizer_Settings implements Hookable {
  
    /**
     * Array of panels to register
     */
    protected $panels = array();
    
    /**
     * Array of sections to register
     */
    protected $sections = array();

     /**
     * Array of settings to register
     */
    protected $settings = array();


    /** 
     * Class constructor 
     */
    public function __construct() {
        $this->panels = array(
            'oa_customizer' => array(
                'title'       => __( 'Calendars', 'openagenda' ),
                'description' => __( 'Manage calendars display settings here.', 'openagenda' ),
            ),
        );
        $this->sections = array(
            'oa_colors' => array(
                'title' => __( 'Colors', 'openagenda' ),
            ),
        );
        $this->settings = array(
            'openagenda_customizer[main_color]' => array(
                'default'           => '#41acdd',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'         => 'postMessage',
                'control'           => array(
                    'type'    => 'color',
                    'label'   => __( 'OpenAgenda main color', 'openagenda' ),
                    'section' => 'oa_colors',
                ),
            ),
        );
    }

    /**
     * Register all the hooks
     */
    public function register_hooks(){
        add_action( 'customize_register', array( $this, 'customize_register' ), 10, 1 );
        add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );
    }


    /**
     * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
     */
    function customize_preview_js() {
        wp_enqueue_script( 'oa-customizer', OPENAGENDA_URL . 'assets/js/customizer.js', array( 'customize-preview' ), OPENAGENDA_VERSION, true );
    }


    /**
     * Returns all customizer panels
     */
    public function get_panels(){
        return apply_filters( 'openagenda_customizer_panels', $this->panels );
    }


    /**
     * Returns all customizer sections
     */
    public function get_sections(){
        return apply_filters( 'openagenda_customizer_sections', $this->sections );
    }


    /**
     * Returns all customizer settings
     */
    public function get_settings(){
        return apply_filters( 'openagenda_customizer_settings', $this->settings );
    }


    /**
     * Register all the customizer settings
     */
    public function customize_register( $wp_customize ){

        // Register all panels
        $panels = $this->get_panels();
        foreach ( $panels as $id => $args ) {
            $args = wp_parse_args( $args, array(
                'capability' => 'manage_options',
            ) );
            $wp_customize->add_panel( $id, $args );
        }
            
            
        // Register all sections
        $sections = $this->get_sections();
        foreach ( $sections as $id => $args ) {
            $args = wp_parse_args( $args, array(
                'panel'      => 'oa_customizer',
                'capability' => 'manage_options',
            ) );
            $wp_customize->add_section( $id, $args );
        }


        // Register settings and controls
        $settings = $this->get_settings();
        foreach ( $settings as $id => $args ) {
            $args = wp_parse_args( $args, array(
                'type'              => 'option',
                'capability'        => 'manage_options',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_setting( $id, $args );

            // By default, for standard controls pass in the setting id to add_control() method
            $id_or_control = $id;

            // For custom controls, check the type and pass in the relevant WP Customize Custom Control if needed
            if( ! empty( $args['control']['type'] ) ){
                switch ( $args['control']['type'] ) {
                    case 'color':
                        $id_or_control = new \WP_Customize_Color_Control( $wp_customize, $id, $args['control'] );
                        break;
                }
            }

            $wp_customize->add_control( $id_or_control, $args['control'] );
        }
    }
}