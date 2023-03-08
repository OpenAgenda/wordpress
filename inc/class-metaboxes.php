<?php
namespace Openagenda;
/**
 * Class for handling individual calendar settings on calendar edit page.
 */
class Metaboxes implements Hookable {
    /**
     * Main metabox to register
     */
    protected $metaboxes = array();
    
    /**
     * Fields to display
     */
    protected $fields = array();

    /**
     * Constructor
     */
    public function __construct(){
        $this->metaboxes = array(
            'oa-calendar-settings' => array(
                'id'            => 'oa-calendar-settings',
                'title'         => __( 'Calendar settings', 'openagenda' ),
                'callback'      => array( $this, 'calendar_settings_markup' ),
                'screen'        => 'oa-calendar',
                'context'       => 'side',
                'priority'      => 'default',
                'callback_args' => array(),
            ), 
        );
        $this->fields = array(
            'oa-calendar-uid' => array(
                'metabox'     => 'oa-calendar-settings',
                'type'        => 'text',
                'label'       => __( 'Calendar UID', 'openagenda' ),
                'default'     => '',
                'description' => sprintf( 
                    '<a href="%s" class="components-external-link" target="_blank" rel="external noopener noreferrer">%s</a>',
                    'https://github.com/OpenAgenda/wordpress#howtogetagendauid',
                    __( 'How to find my calendar UID ?', 'openagenda' )
                ),
            ),
            'oa-calendar-per-page' => array(
                'metabox' => 'oa-calendar-settings',
                'type'    => 'number',
                'label'   => __( 'Events per page', 'openagenda' ),
                'default' => (int) get_option( 'posts_per_page' ),
            ),
            'oa-calendar-view' => array(
                'metabox' => 'oa-calendar-settings',
                'type'    => 'radio',
                'label'   => __( 'Display setting', 'openagenda' ),
                'default' => 'list',
                'choices' => array(
                    'list' => array(
                        'label' => __( 'Display as list', 'openagenda' ),
                        'value' => 'list'
                    ),
                    'grid' => array(
                        'label' => __( 'Display as grid', 'openagenda' ),
                        'value' => 'grid'
                    ),
                ),
            ),
            'oa-calendar-content-on-archive' => array(
                'metabox'     => 'oa-calendar-settings',
                'type'        => 'checkbox',
                'label'       => __( 'Display editor content on list view.', 'openagenda' ),
                'default'     => 'yes',
            ),
            'oa-calendar-content-on-single' => array(
                'metabox'     => 'oa-calendar-settings',
                'type'        => 'checkbox',
                'label'       => __( 'Display editor content on single event views.', 'openagenda' ),
                'default'     => 'no',
            ),
            'oa-calendar-exclude' => array(
                'metabox'     => 'oa-calendar-settings',
                'type'        => 'checkbox',
                'label'       => __( 'Only display current and upcoming events. Past events can be displayed using the calendar widget.', 'openagenda' ),
                'default'     => 'no',
            ),
            'oa-calendar-filters' => array(
                'metabox'     => 'oa-calendar-settings',
                'type'        => 'text',
                'label'       => __( 'Default filters (advanced)', 'openagenda' ),
                'default'     => '',
                'description' => __( 'Paste a url to a pre-filtered calendar page. Only events corresponding to these filters will be displayed.', 'openagenda' ),
            ),
        );
    }


    /**
     * Registers hooks
     */
    public function register_hooks(){
        add_action( 'add_meta_boxes', array( $this, 'register_metaboxes' ), 10, 2 );
        add_action( 'save_post_oa-calendar', array( $this, 'calendar_settings_save' ), 10, 3 );
    }


    /**
     * Returns the parent admin page to register
     * 
     * @return  array  Main page arguments 
     */
    public function get_metaboxes(){
        return apply_filters( 'openagenda_metaboxes', $this->metaboxes );
    }


    /**
     * Returns the list of fields
     * 
     * @return  array  Fields array : 'name' => $args 
     */
    public function get_fields(){
        return apply_filters( 'openagenda_fields', $this->fields );
    }

    /**
     * Register the metaboxes
     * 
     * @param  string   $post_type  The post type for the current page.
     * @param  WP_Post  $post       The post object.
     */
    public function register_metaboxes( $post_type, $post ){
        foreach ( $this->get_metaboxes() as $id => $args ) {
            add_meta_box( 
                $args['id'],
                $args['title'],
                $args['callback'],
                $args['screen'],
                $args['context'],
                $args['priority'],
                $args['callback_args']
            );
        }
    }

    
    /**
     * Settings metabox markup
     * 
     * @param  WP_Post  $post  Current post
     * @param  array    $args  Additional callback arguments, passed via add_meta_box() function call
     */
    public function calendar_settings_markup( $post, $args ){
        wp_nonce_field( 'oa_calendar_settings_metabox_save_' . (int) $post->ID, 'oa_calendar_settings_nonce' );
        echo '<style>#oa-calendar-settings .components-base-control{margin-bottom: 1rem;}#oa-calendar-settings .is-warning{margin: 5px 0;}</style>';

        // If no API key is provided, display an error message
        $general_settings = get_option('openagenda_general_settings');
        if( ! $general_settings || empty( $general_settings['openagenda_api_key'] ) ){
            $settings_page_url = menu_page_url( 'openagenda', false );
            /* translators: %s: settings page url */ 
            $message = sprintf( __( 'Please provide your account API key in <a href="%s">the plugin settings</a>.', 'openagenda' ), esc_url( $settings_page_url ) );
            $html = sprintf('<div class="components-notice is-warning"><div class="components-notice__content">%s</div></div>', wp_kses_post( $message ) );
            echo $html;
        }

        foreach ( $this->get_fields() as $name => $args ) {
            $this->render_field( $name, $args );
        }
    }


    /**
     * Renders our metabox fields
     * 
     * @param  string  $name  Name of the field. Used in id and name attributes 
     * @param  array   $args  Array of arguments for the field 
     */
    public function render_field( $name, $args = array() ){
        global $post;

        $args = wp_parse_args( $args, array(
            'metabox'     => 'calendar-settings',
            'type'        => 'text',
            'label'       => __( 'New field', 'openagenda' ),
            'default'     => '',
            'description' => '',
        ) );
        
        if( 'oa-calendar-exclude' === $name && empty( get_post_meta( $post->ID, 'oa-calendar-uid', true ) ) ) $args['default'] = 'yes';
        $field_value = get_post_meta( $post->ID, $name, true ) ? get_post_meta( $post->ID, $name, true ) : $args['default'];  

        if( 'oa-calendar-uid' == $name ){
            $openagenda = new Openagenda( $field_value, array( 'size' => 1 ), false, false );
            $response   = $openagenda->get_raw_response();
            $message    = '';
            if( ! is_wp_error( $response ) ){
                $response_code = $response['response']['code'];
                switch ( $response_code ) {
                    case 404:
                        $message = __( 'Agenda could not be found. Please double check your agenda UID.', 'openagenda' );
                        break;
                    case 403:
                        /* translators: %s: settings page url */ 
                        $message = sprintf( __( 'The request could not be authenticated. Please double check API key in <a href="%s">your general settings.</a>', 'openagenda' ), esc_url( menu_page_url( 'openagenda', false ) ) );
                        break;
                }
            }
            if( ! empty( $message ) ) $args['message'] = $message;
        }

        switch ( $args['type'] ) {
            case 'checkbox':
                $checked         = 'yes' === $field_value;
                $container_class = use_block_editor_for_post( $post ) ? 'components-checkbox-control__input-container' : '';
                $input_class     = use_block_editor_for_post( $post ) ? 'components-checkbox-control__input' : '';
                ?>
                    <div class="components-base-control">
                        <div class="components-base-control__field">
                            <span class="<?php echo $container_class; ?>">
                                <?php 
                                    if( use_block_editor_for_post( $post ) ){
                                        printf( '<style>#%s:checked { background-color:var(--wp-admin-theme-color); border-color: var(--wp-admin-theme-color); }</style>', esc_attr( $name ));
                                    }
                                ?>
                                <input id="<?php echo esc_attr( $name ); ?>" 
                                       name="<?php echo esc_attr( $name ); ?>" 
                                       class="<?php echo $input_class; ?>" 
                                       type="checkbox"
                                       value="yes"
                                       <?php checked( $checked ); ?> 
                                />
                                <?php if( use_block_editor_for_post( $post ) ) : ?>
                                    <svg aria-hidden="true" role="img" focusable="false" class="dashicon dashicons-yes components-checkbox-control__checked" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                        <path d="M14.83 4.89l1.34.94-5.81 8.38H9.02L5.78 9.67l1.34-1.25 2.57 2.4z"></path>
                                    </svg>
                                <?php endif; ?>
                            </span>
                            <label for="<?php echo esc_attr( $name ); ?>" class="components-checkbox-control__label"><?php echo esc_html( $args['label'] ); ?></label>
                        </div>
                        <?php 
                            if( ! empty( $args['description'] ) ) {
                                printf( '<p class="description">%s</p>', wp_kses_post( $args['description'] ) );
                            }
                        ?>
                    </div>
                <?php
                break;
            case 'radio':
                $container_class = use_block_editor_for_post( $post ) ? 'components-radio-control__input-container' : '';
                $input_class     = use_block_editor_for_post( $post ) ? 'components-radio-control__input' : '';
                ?>
                    <div class="components-base-control">
                        <div class="components-base-control__field">
                            <fieldset class="components-radio-control__inputs">
                                <legend class="components-radio-control__legend"><?php echo esc_html( $args['label'] );?></legend>
                                <?php 
                                    if( ! empty( $args['description'] ) ) {
                                        printf( '<p>%s</p>', wp_kses_post( $args['description'] ) );
                                    }
                                ?>
                                <?php foreach ( $args['choices'] as $key => $choice ) : $field_id = sprintf( '%s-%s', $name, $choice['value'] ); ?>
                                    <div class="<?php echo $container_class; ?>">
                                        <input  id="<?php echo esc_attr( $field_id ); ?>" 
                                                name="<?php echo esc_attr( $name ); ?>" 
                                                class="<?php echo $input_class; ?>" 
                                                type="radio"
                                                value="<?php echo esc_attr( $choice['value'] ) ?>"
                                                <?php checked( $field_value, $choice['value']  ); ?> 
                                        />
                                        <label for="<?php echo esc_attr( $field_id ); ?>" class="components-radio-control__label"><?php echo esc_html( $choice['label'] ); ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </fieldset>
                        </div>
                    </div>
                <?php
                break;          
            default:
                ?>
                    <div class="components-base-control">
                        <div class="components-base-control__field">
                            <label for="<?php echo esc_attr( $name ); ?>" class="components-base-control__label" style="display: block; margin-bottom: 8px"><?php echo esc_html( $args['label'] ); ?></label>
                            <input id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" type="<?php echo esc_attr( $args['type'] ); ?>" class="components-text-control__input" value="<?php echo esc_attr( $field_value ); ?>" />
                        </div>
                        <?php 
                            if( ! empty( $args['message'] ) ) printf( '<p class="description" style="color:red;">%s</p>', wp_kses_post( $message ) );
                            if( ! empty( $args['description'] ) ) printf( '<p class="description">%s</p>', wp_kses_post( $args['description'] ) );
                        ?>
                    </div>
                <?php
                break;
        }
    }

    /**
     * Saves settings metabox fields
     *
     * @param  int      $post_ID  Post ID.
     * @param  WP_Post  $post     Post object.
     * @param  bool     $update   Whether this is an existing post being updated or not.
     */
    public function calendar_settings_save( $post_ID, $post, $update ){
        
        // Check nonce
        if ( ! isset( $_POST['oa_calendar_settings_nonce'] ) || ! wp_verify_nonce( $_POST['oa_calendar_settings_nonce'], 'oa_calendar_settings_metabox_save_' . (int) $post->ID ) ) {
            return;
        }

        // Check user has permissions
        if ( ! current_user_can( 'edit_post', (int) $post_ID ) ) {
            return;
        }

        // If autosaving, do nothing
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if( isset( $_POST['oa-calendar-uid'] ) ){
            $agenda_uid = sanitize_text_field( $_POST['oa-calendar-uid'] );
            update_post_meta( $post_ID, 'oa-calendar-uid', $agenda_uid );
            $this->save_agenda_settings( $agenda_uid, $post_ID );
        }

        if( ! empty( $_POST['oa-calendar-per-page'] ) ){
            update_post_meta( $post_ID, 'oa-calendar-per-page', (int) $_POST['oa-calendar-per-page'] );
        }

        if( ! empty( $_POST['oa-calendar-view'] ) && in_array( $_POST['oa-calendar-view'], array( 'list', 'grid' ) ) ){
            update_post_meta( $post_ID, 'oa-calendar-view', sanitize_title( $_POST['oa-calendar-view'] ) );
        }

        if( isset( $_POST['oa-calendar-filters'] ) ){
            update_post_meta( $post_ID, 'oa-calendar-filters', esc_url_raw( $_POST['oa-calendar-filters'] ) );
        }

        $content_on_archive  = isset( $_POST['oa-calendar-content-on-archive'] ) ? 'yes' : 'no';
        $content_on_single   = isset( $_POST['oa-calendar-content-on-single'] ) ? 'yes' : 'no';
        $exclude_past_events = isset( $_POST['oa-calendar-exclude'] ) ? 'yes' : 'no';
        update_post_meta( $post_ID, 'oa-calendar-content-on-archive', $content_on_archive );
        update_post_meta( $post_ID, 'oa-calendar-content-on-single', $content_on_single );
        update_post_meta( $post_ID, 'oa-calendar-exclude', $exclude_past_events );

        if( $update ) openagenda_clear_transient();
    }


    /**
     * Gets an agenda schema
     * 
     * @param  string  $agenda_uid  Agenda to fetch settings for
     * 
     */
    public function save_agenda_settings( $agenda_uid, $post_id ){
        $settings = get_option( 'openagenda_general_settings' );
        $api_key  = ! empty( $settings['openagenda_api_key'] ) ? $settings['openagenda_api_key'] : '';
        $base_url = 'https://api.openagenda.com/v2/agendas/';
    
        $agenda_settings = array();
        $url      = add_query_arg( 'key', $api_key, sprintf( $base_url . '%s', $agenda_uid ) );
        $response = wp_safe_remote_get( $url );
        if( ! is_wp_error( $response ) ){
            $body    = wp_remote_retrieve_body( $response );
            $decoded = json_decode( $body, true );
            if( null !== $decoded ){
                $agenda_settings = $decoded;
            }
        }    

        // Save agenda settings
        if( ! empty( $agenda_settings ) ){
            $all_languages = isset( $agenda_settings['summary']['languages'] ) ? array_keys( $agenda_settings['summary']['languages'] ) : array();
            update_post_meta( $post_id, 'oa-calendar-languages', $all_languages );
            update_post_meta( $post_id, 'oa-calendar-settings', $agenda_settings );
        }

        return $agenda_settings;
    }
}