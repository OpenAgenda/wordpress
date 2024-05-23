<?php
namespace OpenAgenda;
/**
 * Settings Manager class
 * 
 * Responsible for registering settings.
 */
class Settings implements Hookable {

    /**
     * Settings groups to register.
     * Basically one for each settings tab.
     */
    protected $settings = array();

    /**
     * Settings sections to register.
     */
    protected $sections = array();

    /**
     * Settings fields to register.
     */
    protected $fields = array();


    /**
     * Constructor
     */
    public function __construct(){
        $this->settings = array(
            'general' => array(
                'option_group'      => 'openagenda_general_settings',
                'option_name'       => 'openagenda_general_settings',
                'sanitize_callback' => array( $this, 'sanitize_general_settings' ),
            ),
            'integrations' => array(
                'option_group'      => 'openagenda_integrations_settings',
                'option_name'       => 'openagenda_integrations_settings',
                'sanitize_callback' => array( $this, 'sanitize_integrations_settings' ),
            ),
            'permalinks' => array(
                'option_group'      => 'permalink',
                'option_name'       => 'openagenda_permalinks_settings',
                'sanitize_callback' => array( $this, 'sanitize_permalinks_settings' ),
            ),
        );
        $this->sections = array(
            'general' => array(
                'id'       => 'openagenda_general_settings',
                'title'    => __( 'General settings', 'openagenda' ),
                'callback' => '',
                'page'     => 'openagenda',
            ),
            'openstreetmap' => array(
                'id'       => 'openagenda_openstreetmap_settings',
                'title'    => __( 'OpenStreetMap', 'openagenda' ),
                'callback' => '',
                'page'     => 'openagenda',
            ),
            'cloudimage' => array(
                'id'       => 'openagenda_cloudimage_settings',
                'title'    => __( 'CloudImage', 'openagenda' ),
                'callback' => '',
                'page'     => 'openagenda',
            ),
        );
        $this->fields = array(
            'api-key' => array(
                'id'       => 'openagenda_api_key',
                'title'    => __( 'OpenAgenda API key', 'openagenda' ),
                'callback' => array( $this, 'input_field_markup' ),
                'page'     => 'openagenda',
                'section'  => 'openagenda_general_settings',
                'args'     => array( 
                    'id'          => 'openagenda_api_key',
                    'option_name' => 'openagenda_general_settings',
                    'label_for'   => 'openagenda_api_key',
                    'type'        => 'password',
                    'description' => sprintf(
                        /* translators: %s: openagenda site url */ 
                        __( 'Your API key can be found in your <a href="%s">OpenAgenda account</a>.', 'openagenda' ),
                         'https://openagenda.com' 
                    ),
                ),
            ),
            'include-embeds' => array(
                'id'       => 'openagenda_include_embeds',
                'title'    => __( 'Allow embedded content.', 'openagenda' ),
                'callback' => array( $this, 'checkbox_field_markup' ),
                'page'     => 'openagenda',
                'section'  => 'openagenda_general_settings',
                'args'     => array( 
                    'id'          => 'openagenda_include_embeds',
                    'option_name' => 'openagenda_general_settings',
                    'label_for'   => 'openagenda_include_embeds',
                    'type'        => 'checkbox',
                    'default'     => true,
                    'description' => sprintf( __( 'Allow for embedded content in the event\'s content.', 'openagenda' ), 'https://openagenda.com' ),
                    'help-text'   => sprintf( __( 'By default, embedded content like Youtube players will be filtered, and will not appear on the frontend. Checking this option will disable filtering.', 'openagenda' ) ),
                ),
            ),
            'include-styles' => array(
                'id'       => 'openagenda_include_styles',
                'title'    => __( 'Load default stylesheets.', 'openagenda' ),
                'callback' => array( $this, 'checkbox_field_markup' ),
                'page'     => 'openagenda',
                'section'  => 'openagenda_general_settings',
                'args'     => array( 
                    'id'          => 'openagenda_include_styles',
                    'option_name' => 'openagenda_general_settings',
                    'label_for'   => 'openagenda_include_styles',
                    'type'        => 'checkbox',
                    'default'     => true,
                    'description' => __( 'Load default styling.', 'openagenda' ),
                ),
            ),
            'cache-duration' => array(
                'id'       => 'openagenda_cache_duration',
                'title'    => __( 'Cache duration', 'openagenda' ),
                'callback' => array( $this, 'input_field_markup' ),
                'page'     => 'openagenda',
                'section'  => 'openagenda_general_settings',
                'args'     => array( 
                    'id'          => 'openagenda_cache_duration',
                    'option_name' => 'openagenda_general_settings',
                    'label_for'   => 'openagenda_cache_duration',
                    'type'        => 'number',
                    'default'     => (int) ( HOUR_IN_SECONDS / 2 ),
                    'description' => __( 'Requests responses are temporarily stored for performance reasons. This setting controls the number of seconds basic requests responses are stored', 'openagenda' ),
                ),
            ),
            'default-event-image' => array(
                'id'       => 'openagenda_default_event_image',
                'title'    => __( 'Default event image', 'openagenda' ),
                'callback' => array( $this, 'media_upload_field_markup' ),
                'page'     => 'openagenda',
                'section'  => 'openagenda_general_settings',
                'args'     => array( 
                    'id'           => 'openagenda_default_event_image',
                    'option_name'  => 'openagenda_general_settings',
                    'label_for'    => 'openagenda_default_event_image',
                    'add_label'    => __( 'Add default image', 'openagenda' ),
                    'update_label' => __( 'Update default image', 'openagenda' ),
                    'remove_label' => __( 'Remove default image', 'openagenda' ),
                    'type'         => 'button',
                    'default'      => 0,
                ),
            ),
            'delete-calendars-on-uninstall' => array(
                'id'       => 'openagenda_delete_content_on_uninstall',
                'title'    => __( 'Delete all calendar content on uninstall ?', 'openagenda' ),
                'callback' => array( $this, 'checkbox_field_markup' ),
                'page'     => 'openagenda',
                'section'  => 'openagenda_general_settings',
                'args'     => array( 
                    'id'          => 'openagenda_delete_content_on_uninstall',
                    'option_name' => 'openagenda_general_settings',
                    'label_for'   => 'openagenda_delete_content_on_uninstall',
                    'type'        => 'checkbox',
                    'default'     => false,
                    'description' => __( 'Delete all posts of type "Calendar" permanently when I uninstall the plugin. Content will NOT be deleted when deactivating the plugin.', 'openagenda' ),
                ),
            ),
            'delete-options-on-uninstall' => array(
                'id'       => 'openagenda_delete_options_on_uninstall',
                'title'    => __( 'Delete all options on uninstall ?', 'openagenda' ),
                'callback' => array( $this, 'checkbox_field_markup' ),
                'page'     => 'openagenda',
                'section'  => 'openagenda_general_settings',
                'args'     => array( 
                    'id'          => 'openagenda_delete_options_on_uninstall',
                    'option_name' => 'openagenda_general_settings',
                    'label_for'   => 'openagenda_delete_options_on_uninstall',
                    'type'        => 'checkbox',
                    'default'     => false,
                    'description' => __( 'Delete all of this plugin\'s settings permanently when I uninstall the plugin.', 'openagenda' ),
                ),
            ),
            'allow-usage-stats-collection' => array(
                'id'       => 'openagenda_allow_usage_stats_collection',
                'title'    => __( 'Allow OpenAgenda to collect usage stats ?', 'openagenda' ),
                'callback' => array( $this, 'checkbox_field_markup' ),
                'page'     => 'openagenda',
                'section'  => 'openagenda_general_settings',
                'args'     => array( 
                    'id'          => 'openagenda_allow_usage_stats_collection',
                    'option_name' => 'openagenda_general_settings',
                    'label_for'   => 'openagenda_allow_usage_stats_collection',
                    'type'        => 'checkbox',
                    'default'     => true,
                    'description' => __( 'Allow OpenAgenda to collect plugin usage information for statistics purposes. The following information is collected : CMS used, site URL and whether site editor is used or not.', 'openagenda' ),
                ),
            ),
            'calendar-prefix' => array(
                'id'       => 'openagenda_calendar_base',
                'title'    => __( 'Calendar base', 'openagenda' ),
                'callback' => array( $this, 'input_field_markup' ),
                'page'     => 'permalink',
                'section'  => 'optional',
                'args'     => array( 
                    'id'          => 'openagenda_calendar_base',
                    'option_name' => 'openagenda_permalinks_settings',
                    'label_for'   => 'openagenda_calendar_base',
                    'type'        => 'text',
                    'default'     => 'calendar',
                    'description' => sprintf( 
                        /* translators: %s : home url */
                        __( 'You can modify the URL prefix for the calendars. For example, the default prefix is <code>calendar</code>, so URLs will look like <code>%s/calendar/calendar-name</code>.', 'openagenda' ), 
                        esc_url( get_home_url() )
                    ),
                ),
            ),
            'map-tiles-link' => array(
                'id'       => 'openagenda_map_tiles_link',
                'title'    => __( 'Default map tiles link', 'openagenda' ),
                'callback' => array( $this, 'input_field_markup' ),
                'page'     => 'openagenda',
                'section'  => 'openagenda_openstreetmap_settings',
                'args'     => array( 
                    'id'          => 'openagenda_map_tiles_link',
                    'option_name' => 'openagenda_integrations_settings',
                    'label_for'   => 'openagenda_map_tiles_link',
                    'default'     => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                ),
            ),
            'map-tiles-attribution-link' => array(
                'id'       => 'openagenda_map_tiles_attribution_link',
                'title'    => __( 'Default map tiles attribution link', 'openagenda' ),
                'callback' => array( $this, 'input_field_markup' ),
                'page'     => 'openagenda',
                'section'  => 'openagenda_openstreetmap_settings',
                'args'     => array( 
                    'id'          => 'openagenda_map_tiles_attribution_link',
                    'option_name' => 'openagenda_integrations_settings',
                    'label_for'   => 'openagenda_map_tiles_attribution_link',
                    'default'     => sprintf( '<a href="%s">%s</a>', 'https://www.openstreetmap.org/copyright', __( 'OpenStreetMap contributors', 'openagenda' ) ),
                ),
            ),
            'cloudimage-api-key' => array(
                'id'       => 'openagenda_cloudimage_api_key',
                'title'    => __( 'CloudImage API key', 'openagenda' ),
                'callback' => array( $this, 'input_field_markup' ),
                'page'     => 'openagenda',
                'section'  => 'openagenda_cloudimage_settings',
                'args'     => array( 
                    'id'          => 'openagenda_cloudimage_api_key',
                    'option_name' => 'openagenda_integrations_settings',
                    'label_for'   => 'openagenda_cloudimage_api_key',
                    'type'        => 'password',
                    'description' => sprintf(
                        /* translators: %s: openagenda site url */ 
                        __( 'Your API key can be found in your <a href="%s">CloudImage account</a>.', 'openagenda' ),
                         'https://www.cloudimage.io/' 
                    ),
                ),
            ),
        );
    }

    /**
     * Registers hooks
     */
    public function register_hooks(){
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_init', array( $this, 'save_permalinks_settings' ) );
    }

    /**
     * Returns the array of settings to register
     */
    public function get_settings(){
        return apply_filters( 'openagenda_settings', $this->settings );
    }

    /**
     * Returns the array of settings sections to register
     */
    public function get_sections(){
        return apply_filters( 'openagenda_settings_sections', $this->sections );
    }

    /**
     * Returns the array of settings fields to register
     */
    public function get_fields(){
        return apply_filters( 'openagenda_settings_fields', $this->fields );
    }

    /**
     * Registers all our settings.
     */
    public function register_settings(){
        foreach ( $this->get_settings() as $slug => $setting ) {
            register_setting( $setting['option_group'], $setting['option_name'], $setting['sanitize_callback'] ) ;
        }

        foreach ( $this->get_sections() as $slug => $section ) {
            add_settings_section( $section['id'], $section['title'], $section['callback'], $section['page'] ) ;
        }

        foreach ( $this->get_fields() as $slug => $field ) {
            add_settings_field( $field['id'], $field['title'], $field['callback'], $field['page'], $field['section'], $field['args'] ) ;
        }
    }
    
    /**
     * Displays a <input> field
     * 
     * @param  array  $args  Arguments passed to corresponding add_settings_field() call
     */
    public function input_field_markup( $args ){

        $args = wp_parse_args( $args, array(
            'type'        => 'text',
            'placeholder' => '',
            'default'     => '',
            'description' => '',
        ) );
        
        $option_name = sanitize_title( $args['option_name'] );
        $field_id    = sanitize_title( $args['id'] );
        $field_name  = "{$option_name}[{$field_id}]";
        $settings    = get_option( $args['option_name'] );
        $default     = ! empty( $args['default'] ) ? $args['default'] : '';
        $value       = ! empty( $settings ) && isset( $settings[$field_id] ) ? $settings[$field_id] : $default;
        ?>
            <input 
                type="<?php echo esc_attr( $args['type'] ); ?>" 
                id="<?php echo esc_attr( $field_id ); ?>" 
                name="<?php echo esc_attr( $field_name ); ?>" 
                class="regular-text"
                placeholder="<?php echo esc_attr( $args['placeholder']); ?>"
                value="<?php echo esc_attr( $value );?>"
            >
            <?php if( ! empty( $args['description'] ) ) printf( '<p class="description">%s</p>', wp_kses_post( $args['description'] ) ); ?>
        <?php
    }

    /**
     * Displays a media button uploader field
     * 
     * @param  array  $args  Arguments passed to corresponding add_settings_field() call
     */
    public function media_upload_field_markup( $args ){

        $args = wp_parse_args( $args, array(
            'type'        => 'hidden',
            'placeholder' => '',
            'default'     => '',
            'description' => '',
        ) );
        
        $option_name = sanitize_title( $args['option_name'] );
        $field_id    = sanitize_title( $args['id'] );
        $field_name  = "{$option_name}[{$field_id}]";
        $settings    = get_option( $args['option_name'] );
        $default     = ! empty( $args['default'] ) ? $args['default'] : '';
        $value       = ! empty( $settings ) && isset( $settings[$field_id] ) ? (int) $settings[$field_id] : (int) $default;
        $label       = empty( $value ) ? $args['add_label'] : $args['update_label'];

        wp_enqueue_media();
	    wp_enqueue_script( 'openagenda-media-uploader' );
        
        ?>
            <div class="media-upload-field">
                <div class="media-field-preview">
                    <?php if( ! empty( $value ) ) echo wp_get_attachment_image( $value, 'thumbnail' ); ?>
                </div>

                <button
                    type="button"
                    class="button media-upload-button"
                    data-update="<?php echo esc_attr( $args['update_label'] ); ?>"
                    data-value="<?php echo esc_attr( $value ); ?>"
                >
                    <?php echo esc_html( $label ); ?>
                </button>

                <button
                    type="button"
                    class="<?php printf( 'button media-remove-button %s', $value ? '' : 'hidden' ) ?>"
                >
                    <?php echo esc_html( $args['remove_label'] ); ?>
                </button>

                <input 
                    type="hidden" 
                    id="<?php echo esc_attr( $field_id ); ?>" 
                    name="<?php echo esc_attr( $field_name ); ?>" 
                    class="media-input-field"
                    value="<?php echo esc_attr( $value );?>"
                >
                <?php if( ! empty( $args['description'] ) ) printf( '<p class="description">%s</p>', wp_kses_post( $args['description'] ) ); ?>
            </div>
        <?php
    }


    /**
     * Displays a <input type="checkbox"> field
     * 
     * @param  array  $args  Arguments passed to corresponding add_settings_field() call
     */
    public function checkbox_field_markup( $args ){

        $args = wp_parse_args( $args, array(
            'type'        => 'checkbox',
            'default'     => '',
            'description' => '',
        ) );
        
        $option_name = sanitize_title( $args['option_name'] );
        $field_id    = sanitize_title( $args['id'] );
        $field_name  = "{$option_name}[{$field_id}]";
        $settings    = get_option( $args['option_name'] );
        $default     = ! empty( $args['default'] ) ? $args['default'] : '';
        $value       = ! empty( $settings ) && isset( $settings[$field_id] ) ? $settings[$field_id] : $default;
        ?>
            <label for="<?php echo esc_attr( $field_id ); ?>">
                <input 
                    type="<?php echo esc_attr( $args['type'] ); ?>" 
                    id="<?php echo esc_attr( $field_id ); ?>" 
                    name="<?php echo esc_attr( $field_name ); ?>" 
                    class="regular-text"
                    <?php checked( $value ) ?>
                >
                <?php if( ! empty( $args['description'] ) ) printf( '<span>%s</span>', wp_kses_post( $args['description'] ) ); ?>
            </label>
            <?php if( ! empty( $args['help-text']) ) printf( '<p class="description">%s</p>', wp_kses_post( $args['help-text'] ) ); ?>
        <?php
    }


    /**
     * Sanitizes general settings
     * 
     * @param   array  $settings  Settings value to sanitize
     * @return  array  $settings
     */
    public function sanitize_general_settings( $settings ){
        $new_settings = array(
            'openagenda_api_key'        => ! empty( $settings['openagenda_api_key'] ) ? sanitize_text_field( $settings['openagenda_api_key'] ) : '',
            'openagenda_cache_duration' => ! empty( $settings['openagenda_cache_duration'] ) && (int) $settings['openagenda_cache_duration'] > 0 ? (int) $settings['openagenda_cache_duration'] : (int) ( HOUR_IN_SECONDS / 2 ),
            'openagenda_include_embeds' => isset( $settings['openagenda_include_embeds'] ) ? (bool) $settings['openagenda_include_embeds'] : false,
            'openagenda_include_styles' => isset( $settings['openagenda_include_styles'] ) ? (bool) $settings['openagenda_include_styles'] : false,
            'openagenda_default_event_image' => !empty( $settings['openagenda_default_event_image'] ) ? (int) $settings['openagenda_default_event_image'] : 0,
            'openagenda_delete_content_on_uninstall'  => isset( $settings['openagenda_delete_content_on_uninstall'] ) ? (bool) $settings['openagenda_delete_content_on_uninstall'] : false,
            'openagenda_delete_options_on_uninstall'  => isset( $settings['openagenda_delete_options_on_uninstall'] ) ? (bool) $settings['openagenda_delete_options_on_uninstall'] : false,
            'openagenda_allow_usage_stats_collection' => isset( $settings['openagenda_allow_usage_stats_collection'] ) ? (bool) $settings['openagenda_allow_usage_stats_collection'] : false,
        );
        openagenda_clear_transient();
        return $new_settings;
    }


    /**
     * Sanitizes integrations settings
     * 
     * @param   array  $settings  Settings value to sanitize
     * @return  array  $settings
     */
    public function sanitize_integrations_settings( $settings ){
        $new_settings = array(
            'openagenda_map_tiles_link'              => ! empty( $settings['openagenda_map_tiles_link'] ) ? sanitize_text_field( $settings['openagenda_map_tiles_link'] ) : '',
            'openagenda_cloudimage_api_key'          => ! empty( $settings['openagenda_cloudimage_api_key'] ) ? sanitize_text_field( $settings['openagenda_cloudimage_api_key'] ) : '',
            'openagenda_map_tiles_attribution_link'  => ! empty( $settings['openagenda_map_tiles_attribution_link'] ) ? wp_kses_post( $settings['openagenda_map_tiles_attribution_link'] ) : '',
        );
        return $new_settings;
    }

    
    /**
     * Sanitizes permalinks settings
     * 
     * @param   array  $settings  Settings value to sanitize
     * @return  array  $settings
     */
    public function sanitize_permalinks_settings( $settings ){
        return $settings;
    }


    /**
     * Sanitizes and saves permalinks settings
     */
    public function save_permalinks_settings( $settings ){
        if ( isset( $_POST['openagenda_permalinks_settings'] ) ) {
            check_admin_referer( 'update-permalink' );
            $settings = array(
                'openagenda_calendar_base' => ! empty( $_POST['openagenda_permalinks_settings']['openagenda_calendar_base'] ) ? sanitize_title( $_POST['openagenda_permalinks_settings']['openagenda_calendar_base'] ) : __( 'calendar', 'openagenda' ),
            );
            update_option( 'openagenda_permalinks_settings', $settings );
        }
    }
}