<?php
/**
 * Plugin Name: Multisite Robots.txt Manager | MS Robots.txt
 * Plugin URI: https://github.com/tribalNerd/multisite-robotstxt-manager
 * Description: A Multisite Network Robots.txt Manager. Quickly manage your Network Websites robots.txt files from a single administration area.
 * Tags: robotstxt, robots.txt, robots, robot, spiders, virtual, search, google, seo, plugin, network, wpmu, multisite, technerdia, tribalnerd
 * Version: 1.0.11
 * License: GNU GPLv3
 * Copyright (c) 2017 Chris Winters
 * Author: tribalNerd, Chris Winters
 * Author URI: http://techNerdia.com/
 * Text Domain: multisite-robotstxt-manager
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * @about Define Constants
 */
if( function_exists( 'MsRobotstxtManagerConstants' ) )
{
    MsRobotstxtManagerConstants( Array(
        'MS_ROBOTSTXT_MANAGER'                  => true,
        'MS_ROBOTSTXT_MANAGER_BASE_URL'         => get_bloginfo( 'url' ),
        'MS_ROBOTSTXT_MANAGER_VERSION'          => '1.0.11',
        'MS_ROBOTSTXT_MANAGER_WP_MIN_VERSION'   => '3.8',

        'MS_ROBOTSTXT_MANAGER_PLUGIN_FILE'      => __FILE__,
        'MS_ROBOTSTXT_MANAGER_PLUGIN_DIR'       => dirname( __FILE__ ),
        'MS_ROBOTSTXT_MANAGER_PLUGIN_BASE'      => plugin_basename( __FILE__ ),

        'MS_ROBOTSTXT_MANAGER_MENU_NAME'        => __( 'MS Robots.txt', 'multisite-robotstxt-manager' ),
        'MS_ROBOTSTXT_MANAGER_PAGE_NAME'        => __( 'Multisite Robots.txt Manager for WordPress', 'multisite-robotstxt-manager' ),
        'MS_ROBOTSTXT_MANAGER_PAGE_ABOUT'       => __( 'A Multisite Robots.txt Manager Plugin For WordPress.', 'multisite-robotstxt-manager' ),
        'MS_ROBOTSTXT_MANAGER_OPTION_NAME'      => 'ms_robotstxt_manager_',
        'MS_ROBOTSTXT_MANAGER_PLUGIN_NAME'      => 'multisite-robotstxt-manager',

        'MS_ROBOTSTXT_MANAGER_CLASSES'          => dirname( __FILE__ ) .'/classes',
        'MS_ROBOTSTXT_MANAGER_TEMPLATES'        => dirname( __FILE__ ) .'/templates'
    ) );
}


/**
 * @about Loop Through Constants
 */
function MsRobotstxtManagerConstants( $constants_array )
{
    foreach( $constants_array as $name => $value ) {
        define( $name, $value, true );
    }
}


/**
 * @about Register Classes & Include
 */
spl_autoload_register( function ( $class )
{
    if( strpos( $class, 'MsRobotstxtManager_' ) !== false ) {
        $class_name = str_replace( 'MsRobotstxtManager_', "", $class );

        // If the Class Exists, Include the Class
        if( file_exists( MS_ROBOTSTXT_MANAGER_CLASSES .'/class-'. strtolower( $class_name ) .'.php' ) ) {
            include_once( MS_ROBOTSTXT_MANAGER_CLASSES .'/class-'. strtolower( $class_name ) .'.php' );
        }
    }

    // Plugin Extension: Version 3.0.0
    // Found in:
    // classes/class-extended.php __construct() & getSettings()
    // templates/network.php Upgrade Notice
    // multisite-robotstxt-manager.php Upgrade Notice
    if ( class_exists( 'MSRTM_Api' ) && ! defined( 'MSRTM_TEMPLATES' ) ) { require_once( WP_PLUGIN_DIR . '/' . MSRTM ); }
} );


/**
 * @about Pro Upgrade Notices
 */
function msrtmnotices() {
    echo '<div class="notice update-nag is-dismissible"><strong><u>UPDATE NOTICE</u>!</strong> A new version of the MSRTM PRO plugin is available. An email has been sent to you. <a href="https://technerdia.com/account/" target="_blank">Login</a> to your techNerdia account to download version 4.0.0. If you need your login details or are having problems then please <a href="https://technerdia.com/help/" target="_blank">contact</a> us for further assistance.</div>';
}

if ( defined( 'MSRTM_PRO' ) && ! defined( 'MSRTM_TEMPLATES' ) ) {
    add_action( 'network_admin_notices',  'msrtmnotices' );
    add_action( 'admin_notices', 'msrtmnotices' );
}


/**
 * @about Run Plugin
 */
if( ! class_exists( 'multisite_robotstxt_manager' ) )
{
    class multisite_robotstxt_manager
    {
        // Holds Instance Object
        protected static $instance = NULL;


        /**
         * @about Initiate Plugin
         */
        final public function init()
        {
            // Activate Plugin
            register_activation_hook( __FILE__, array( $this, 'activate' ) );

            // Inject Plugin Links
            add_filter( 'plugin_row_meta', array( $this, 'links' ), 10, 2 );

            // Display Robots.txt File
            add_action( 'init', array( $this, 'robotstxt' ), 0 );

            // Load Admin Area
            MsRobotstxtManager_AdminArea::instance();

            // Update Settings
            MsRobotstxtManager_Process::instance();
        }


        /**
         * @about Activate Plugin
         */
        final public function activate()
        {
            // Wordpress Version Check
            global $wp_version;

            // Version Check
            if( version_compare( $wp_version, MS_ROBOTSTXT_MANAGER_WP_MIN_VERSION, "<" ) ) {
                wp_die( __( '<b>Activation Failed</b>: The ' . MS_ROBOTSTXT_MANAGER_PAGE_NAME . ' plugin requires WordPress version ' . MS_ROBOTSTXT_MANAGER_WP_MIN_VERSION . ' or higher. Please Upgrade Wordpress, then try activating this plugin again.', 'multisite-robotstxt-manager' ) );
            }

            // Multisite Networks Only
            if( ! function_exists( 'switch_to_blog' ) ) {
                wp_die( __( '<b>Activation Failed</b>: The ' . MS_ROBOTSTXT_MANAGER_PAGE_NAME . ' Plugin can only be activated on Network Enabled Wordpress installs. Download and install the plugin, "Robots.txt Manager" for standalone Wordpress installs.', 'multisite-robotstxt-manager' ) );
            }

            // Network Activate Only
            if( ! is_network_admin() ) {
                wp_die( __( '<b>Activation Failed</b>: The ' . MS_ROBOTSTXT_MANAGER_PAGE_NAME . ' Plugin can only be activated within the Network Admin.', 'multisite-robotstxt-manager' ) );
            }
        }


        /**
         * @about Inject Links Into Plugin Admin
         * @param array $links Default links for this plugin
         * @param string $file The name of the plugin being displayed
         * @return array $links The links to inject
         */
        final public function links( $links, $file )
        {
            // Get Current URL
            $request_uri = filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL );

            // Links To Inject
            if ( $file == MS_ROBOTSTXT_MANAGER_PLUGIN_BASE && strpos( $request_uri, "plugins.php" ) !== false ) {
                if( is_network_admin() ) {
                    $links[] = '<a href="settings.php?page=' . MS_ROBOTSTXT_MANAGER_PLUGIN_NAME . '">'. __( 'Network Settings', 'multisite-robotstxt-manager' ) .'</a>';
                } else {
                    $links[] = '<a href="options-general.php?page=' . MS_ROBOTSTXT_MANAGER_PLUGIN_NAME . '">'. __( 'Website Settings', 'multisite-robotstxt-manager' ) .'</a>';
                }
                $links[] = '<a href="http://technerdia.com/msrtm/#faq" target="_blank">'. __( 'F.A.Q.', 'multisite-robotstxt-manager' ) .'</a>';
                $links[] = '<a href="http://technerdia.com/help/" target="_blank">'. __( 'Support', 'multisite-robotstxt-manager' ) .'</a>';
                $links[] = '<a href="http://technerdia.com/feedback/" target="_blank">'. __( 'Feedback', 'multisite-robotstxt-manager' ) .'</a>';
                $links[] = '<a href="http://technerdia.com/donate/" target="_blank">'. __( 'Donations', 'multisite-robotstxt-manager' ) .'</a>';
                $links[] = '<a href="http://technerdia.com/msrtm/" target="_blank">'. __( 'PRO Details', 'multisite-robotstxt-manager' ) .'</a>';
            }

            return $links;
        }


        /**
         * Display Robots.txt File
         */
        final public function robotstxt() {
            if( ! is_admin() && ! is_network_admin() ) {
                new MsRobotstxtManager_Robotstxt();
            }
        }


        /**
        * @about Create Instance
        */
        final public static function instance()
        {
            if ( ! self::$instance ) {
                self::$instance = new self();
                self::$instance->init();
            }

            return self::$instance;
        }
    }
}

add_action( 'after_setup_theme', array( 'multisite_robotstxt_manager', 'instance' ), 0 );
