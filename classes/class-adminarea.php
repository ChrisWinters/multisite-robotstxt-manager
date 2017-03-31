<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * @about Admin Area Display
 * @location multisite-robotstxt-manager.php
 * @call MsRobotstxtManager_AdminArea::instance();
 * 
 * @method init()       Init Admin Actions
 * @method redirect()   Redirect if Network Tab is Opened
 * @method menu()       Load Admin Area Menu
 * @method enqueue()    Enqueue Stylesheet and jQuery
 * @method website()    Display Website Admin Templates
 * @method network()    Display Network Admin Templates
 * @method tabs()       Load Admin Area Tabs
 * @method instance()   Class Instance
 */
if ( ! class_exists( 'MsRobotstxtManager_AdminArea' ) )
{
    class MsRobotstxtManager_AdminArea extends MsRobotstxtManager_Extended
    {
        // Holds Instance Object
        protected static $instance = NULL;

        // Tab Names
        private $tabs;


        /**
         * @about Init Admin Actions
         */
        final public function init()
        {
            // Website Menu Link
            add_action( 'admin_menu', array( $this, 'menu' ) );

            // Network Menu Link
            add_action( 'network_admin_menu', array( $this, 'menu' ) );

            // Unqueue Scripts Within Plugin Admin Area
            if ( parent::qString( 'page' ) == $this->plugin_name ) {
                add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
            }

            // Website Tabs Names: &tab=home
            if ( ! is_network_admin() ) {
                $this->tabs = array(
                    'website' => __( 'Website', 'multisite-robotstxt-manager' ),
                    'msrobotstxt' => __( 'Network', 'multisite-robotstxt-manager' ),
                );

                // Redirect if Network Tab is Opened
                if ( $this->qString( 'tab' ) == 'msrobotstxt' ) {
                    $this->redirect();
                }
            }

            // Network Tabs Names: &tab=home
            if ( is_network_admin() ) {
                $this->tabs = array(
                    'network' => __( 'Network', 'multisite-robotstxt-manager' ),
                    'cleaner' => __( 'Cleaner', 'multisite-robotstxt-manager' ),
                );
            }
        }


        /**
         * @about Redirect if Network Tab is Opened
         */
        final private function redirect()
        {
            wp_safe_redirect( network_admin_url( '/settings.php?page=' . $this->plugin_name ) );
            exit;
        }


        /**
         * @about Plugin Menus
         */
        final public function menu()
        {
            // Website Menu
            add_submenu_page(
                'options-general.php',
                $this->plugin_title,
                $this->menu_name,
                'manage_options',
                $this->plugin_name,
                array( $this, 'website' )
            );

            // Network Menu
            add_submenu_page(
                'settings.php',
                $this->plugin_title,
                $this->menu_name,
                'manage_options',
                $this->plugin_name,
                array( $this, 'network' )
            );
        }


        /**
         * @about Enqueue Stylesheet and jQuery
         */
        final public function enqueue()
        {
            wp_enqueue_style( $this->plugin_name, plugins_url( '/assets/style.css', $this->plugin_file ), '', date( 'YmdHis', time() ), 'all' );
        }


        /**
         * @about Display Website Admin Templates
         */
        final public function website()
        {
            // Admin Header
            require_once( $this->templates .'/header.php' );

            // Switch Between Tabs
            switch ( parent::qString( 'tab' ) ) {
                case 'website':
                default:
                    require_once( $this->templates .'/website.php' );
                break;
            }

            // Admin Footer
            require_once( $this->templates .'/footer.php' );
        }


        /**
         * @about Display Network Admin Templates
         */
        final public function network()
        {
            // Admin Header
            require_once( $this->templates .'/header.php' );

            // Switch Between Tabs
            switch ( parent::qString( 'tab' ) ) {
                case 'network':
                default:
                    require_once( $this->templates .'/network.php' );
                break;

                case 'cleaner':
                    require_once( $this->templates .'/cleaner.php' );
                break;
            }

            // Admin Footer
            require_once( $this->templates .'/footer.php' );
        }


        /**
         * @about Admin Area Tabs
         * @return string $html Tab Display
         */
        final public function tabs()
        {
            $html = '<h2 class="nav-tab-wrapper">';

            // Set Current Tab
            $current = ( parent::qString( 'tab' ) ) ? parent::qString( 'tab' ) : key( $this->tabs );

            foreach( $this->tabs as $tab => $name ) {
                // Current Tab Class
                $class = ( $tab == $current ) ? ' nav-tab-active' : '';

                // Tab Links
                $html .= '<a href="?page='. parent::qString( 'page' ) .'&tab='. $tab .'" class="nav-tab'. $class .'">'. $name .'</a>';
            }

            $html .= '</h2><br />';

            return $html;
        }


        /**
         * @about Create Instance
         */
        public static function instance()
        {
            if ( ! self::$instance ) {
                self::$instance = new self();
                self::$instance->init();
            }

            return self::$instance;
        }
    }
}
