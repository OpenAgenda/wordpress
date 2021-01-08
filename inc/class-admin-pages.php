<?php
namespace Openagenda;
/**
 * Class for handling admin settings page.
 */
class Admin_Pages implements Hookable {

    /**
     * Main page to register
     */
    protected $main_page = array();

    /**
     * Tabs to register
     */
    protected $tabs = array();

    /**
     * Constructor
     */
    public function __construct(){
        $this->main_page = array(
            'parent_slug' => 'edit.php?post_type=oa-calendar',
            'page_title'  => __( 'Open Agenda Settings', 'openagenda' ),
            'menu_title'  => __( 'Settings', 'openagenda' ),
            'capability'  => 'manage_options',
            'menu_slug'   => 'openagenda',
            'position'    => 100,
            'callback'    => array( $this, 'settings_page_markup' ),
        );
        $this->tabs = array(
            'general' => __( 'General', 'openagenda' ),
            // 'display' => __( 'Display', 'openagenda' ),
        ); 
    }

    /**
     * Registers hooks
     */
    public function register_hooks(){
        add_action( 'admin_menu', array( $this, 'register_admin_page') );
        add_action( 'openagenda_admin_page_general_tab_content', array( $this, 'general_tab_content' ) );
        // add_action( 'openagenda_admin_page_display_tab_content', array( $this, 'display_tab_content' ) );
    }


    /**
     * Registers the admin pages
     */
    public function register_admin_page(){
        $main_page = $this->get_main_page();

        $hook = add_submenu_page(
            $main_page['parent_slug'],
            $main_page['page_title'],
            $main_page['menu_title'],
            $main_page['capability'],
            $main_page['menu_slug'],
            $main_page['callback'],
            $main_page['position']
        );

        // add_action( 'load-' . $hook, array( $this, "setup_${hook}_screen" ) );
    }


    /**
     * Returns the parent admin page to register
     * 
     * @return  array  Main page arguments 
     */
    public function get_main_page(){
        return apply_filters( 'openagenda_main_admin_page', $this->main_page );
    }
    

    /**
     * Returns the registered tabs on the admin page.
     * 
     * @return  array  Main page arguments 
     */
    public function get_tabs(){
        return apply_filters( 'openagenda_admin_page_tabs', $this->tabs );
    }
    

    /**
     * Settings page display callback
     */
    public function settings_page_markup(){

        $tabs        = $this->get_tabs();
        $current_tab = isset( $_GET['tab'] ) && array_key_exists( $_GET['tab'], $tabs  ) ? $_GET['tab'] : 'general';
        $base_url    = menu_page_url( 'openagenda', false );

        ?>
            <div class="wrap">
                <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

                <?php if( count( $tabs ) > 1 ) : ?>
                    <nav class="nav-tab-wrapper">
                        <?php foreach ( $tabs as $slug => $label ) : 
                            $url   = add_query_arg( 'tab', urlencode( $slug ), $base_url );
                            $class = $current_tab === $slug ? 'nav-tab nav-tab-active' : 'nav-tab';
                        ?>
                            <a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $class ); ?>"><?php echo esc_html( $label );?></a>
                        <?php endforeach; ?>
                    </nav>
                <?php endif; ?>

                <div class="tab-content">
                    <?php do_action( "openagenda_admin_page_${current_tab}_tab_content" ); ?>
                </div>
            </div>
        <?php
    }


    /**
     * Content for the 'general' settings tab
     */
    public function general_tab_content(){
        ?>
        <h2><?php esc_html_e( 'General settings', 'openagenda' );?></h2>
            <form action="options.php" method="POST">
                <?php settings_fields( 'openagenda_general_settings' ); ?>
                <table class="form-table" role="presentation">
                    <?php do_settings_fields( 'openagenda', 'openagenda_general_settings' ); ?>   
                </table>  
                <?php submit_button(); ?>
            </form>
        <?php
    }

    /**
     * Content for the 'display' settings tab
     */
    public function display_tab_content(){
        ?>
        <h2><?php esc_html_e( 'Display settings', 'openagenda' );?></h2>
            <form action="options.php" method="POST">
                <?php
                    // settings_fields( 'delalande_ftp_settings' );
                    // do_settings_sections( 'delalande_settings' );
                    // submit_button();
                ?>     
            </form>
        <?php
    }
}