<?php
/**
 * Admin class
 *
 * @author Yithemes
 * @package YITH WooCommerce Social Login
 * @version 1.0.0
 */

if ( ! defined( 'YITH_YWSL_INIT' ) ) {
    exit;
} // Exit if accessed directly

if( ! class_exists( 'YITH_WC_Social_Login_Admin' ) ){
    /**
     * YITH WooCommerce Social Login Admin class
     *
     * @since 1.0.0
     */
    class YITH_WC_Social_Login_Admin {
        /**
         * Single instance of the class
         *
         * @var \YITH_WC_Social_Login_Admin
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * @var $_panel Panel Object
         */
        protected $_panel;

        /**
         * @var $_premium string Premium tab template file name
         */
        protected $_premium = 'premium.php';

        /**
         * @var string Premium version landing link
         */
        protected $_premium_landing = 'https://yithemes.com/themes/plugins/yith-woocommerce-social-login/';

        /**
         * @var string Panel page
         */
        protected $_panel_page = 'yith_woocommerce_social_login';

        /**
         * @var string Doc Url
         */
        public $doc_url = 'https://docs.yithemes.com/yith-woocommerce-social-login/';


        /**
         * Returns single instance of the class
         *
         * @return \YITH_WC_Social_Login_Admin
         * @since 1.0.0
         */
        public static function get_instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self;
            }

            return self::$instance;
        }

	    /**
	     * Constructor.
	     *
	     * @since 1.0.0
	     */
        public function __construct() {

            $this->create_menu_items();

            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename( YITH_YWSL_DIR . '/' . basename( YITH_YWSL_FILE ) ), array( $this, 'action_links' ) );
            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

	        if ( ywsl_check_wpengine() ) {
		        add_filter('ywsl_callback_url_list', array( $this, 'get_only_callback_url') );
	        }

            //custom styles and javascripts
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );
        
        }

        /**
         * Enqueue styles and scripts
         *
         * @access public
         * @return void
         * @since 1.0.0
         */
        public function enqueue_styles_scripts() {

	        if ( isset( $_GET['page'] ) && $_GET['page'] != $this->_panel_page ) {
		        return;
	        }

            $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
            wp_enqueue_script( 'yith_ywsl_admin', YITH_YWSL_ASSETS_URL . '/js/backend' . $suffix . '.js', array( 'jquery' ), YITH_YWSL_VERSION, true );
            wp_enqueue_style( 'yith_ywsl_backend', YITH_YWSL_ASSETS_URL . '/css/backend.css' );

        }

        /**
         * Create Menu Items
         *
         * Print admin menu items
         *
         * @since  1.0
         * @author Emanuela Castorina
         */
        private function create_menu_items() {
            // Add a panel under YITH Plugins tab
            add_action( 'admin_menu', array( $this, 'register_panel' ), 5 );
            add_action( 'ywsl_premium_tab', array( $this, 'premium_tab' ) );
        }

        /**
         * Add a panel under YITH Plugins tab
         *
         * @return   void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use      /Yit_Plugin_Panel class
         * @see      plugin-fw/lib/yit-plugin-panel.php
         */
        public function register_panel() {

            if ( !empty( $this->_panel ) ) {
                return;
            }

            $admin_tabs = apply_filters('ywsl_admin_tabs', array(
                'settings' => __( 'Settings', 'yith-woocommerce-social-login' )
            ));

            if ( defined( 'YITH_YWSL_FREE_INIT' ) ) {
                $admin_tabs['premium'] = __( 'Premium Version', 'yith-woocommerce-social-login' );
            }


            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => __( 'Social Login', 'yith-woocommerce-social-login' ),
                'menu_title'       => __( 'Social Login', 'yith-woocommerce-social-login' ),
                'capability'       => 'manage_options',
                'parent'           => '',
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'admin-tabs'       => $admin_tabs,
                'options-path'     => YITH_YWSL_DIR . '/plugin-options'
            );

            /* === Fixed: not updated theme  === */
            if ( !class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {
                require_once( YITH_YWSL_DIR.'/plugin-fw/lib/yit-plugin-panel-wc.php' );
            }

            $this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );

            add_action( 'woocommerce_admin_field_ywsl_upload', array( $this->_panel, 'yit_upload' ), 10, 1 );
            //add_action( 'woocommerce_update_option_ywsl_upload', array( $this->_panel, 'yit_upload_update' ), 10, 1 );

			do_action('ywsl_register_panel', $this->_panel);


        }

        /**
         * Premium Tab Template
         *
         * Load the premium tab template on admin page
         *
         * @return   void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function premium_tab() {
            $premium_tab_template = YITH_YWSL_TEMPLATE_PATH . '/admin/' . $this->_premium;
            if ( file_exists( $premium_tab_template ) ) {
                include_once( $premium_tab_template );
            }
        }

        /**
         * Action Links
         *
         * add the action links to plugin admin page
         *
         * @param $links | links plugin array
         *
         * @return   mixed Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @return mixed
         * @use      plugin_action_links_{$plugin_file_name}
         */
        public function action_links( $links ) {

            $links[] = '<a href="' . admin_url( "admin.php?page={$this->_panel_page}" ) . '">' . __( 'Settings', 'yith-woocommerce-social-login' ) . '</a>';
            if ( defined( 'YITH_YWSL_FREE_INIT' ) ) {
                $links[] = '<a href="' . $this->get_premium_landing_uri() . '" target="_blank">' . __( 'Premium Version', 'yith-woocommerce-social-login' ) . '</a>';
            }

            return $links;
        }

        /**
         * plugin_row_meta
         *
         * add the action links to plugin admin page
         *
         * @param $plugin_meta
         * @param $plugin_file
         * @param $plugin_data
         * @param $status
         *
         * @return   Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use      plugin_row_meta
         */
        public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {

            if ( defined( 'YITH_YWSL_INIT' ) && YITH_YWSL_INIT == $plugin_file ) {
                $plugin_meta[] = '<a href="' . $this->doc_url . '" target="_blank">' . __( 'Plugin Documentation', 'yith-woocommerce-social-login' ) . '</a>';
            }
            return $plugin_meta;
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri(){
            return defined( 'YITH_REFER_ID' ) ? $this->get_premium_landing_uri() . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing;
        }


	    /**
	     * @param $callback_list
	     *
	     * @since 1.3.0
	     * @return mixed
	     * @author Emanuela Castorina <emanuela.castorina@yithemes.com>
	     */
	    public function get_only_callback_url( $callback_list ) {
		    if ( isset( $callback_list['hybrid'] ) ) {
			    unset( $callback_list['hybrid'] );
		    }
		    return $callback_list;
        }

    }

    /**
     * Unique access to instance of YITH_WC_Social_Login_Admin class
     *
     * @return \YITH_WC_Social_Login_Admin
     */
    function YITH_WC_Social_Login_Admin() {
        return YITH_WC_Social_Login_Admin::get_instance();
    }

}

