<?php
/**
 * Plugin Name: Multisite Robots.txt Manager | MS Robots.txt
 * Plugin URI: http://technerdia.com/msrtm/
 * Description: A Multisite Network Robots.txt Manager. Quickly manage your Network Websites robots.txt files from a single administration area.
 * Tags: robotstxt, robots.txt, robots, robot, spiders, virtual, search, google, seo, plugin, network, wpmu, multisite, technerdia, tribalnerd
 * Version: 1.0.6
 * License: GPL
 * Copyright (c) 2016, techNerdia LLC.
 * Author: tribalNerd, Chris Winters
 * Author URI: http://techNerdia.com/
 * Text Domain: multisite-robotstxt-manager
 * Domain Path: /languages/
 */

// Wordpress check
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * Define Constants
 * 
 * @return array
 */
if( function_exists( 'MsRobotstxtManagerConstants' ) )
{
    MsRobotstxtManagerConstants( Array(
        'MS_ROBOTSTXT_MANAGER_BASE_URL'         => get_bloginfo( 'url' ),
        'MS_ROBOTSTXT_MANAGER_VERSION'          => '1.0.6',
        'MS_ROBOTSTXT_MANAGER_WP_MIN_VERSION'   => '3.8',

        'MS_ROBOTSTXT_MANAGER_PLUGIN_FILE'      => __FILE__,
        'MS_ROBOTSTXT_MANAGER_PLUGIN_DIR'       => dirname( __FILE__ ),
        'MS_ROBOTSTXT_MANAGER_PLUGIN_BASE'      => plugin_basename( __FILE__ ),

        'MS_ROBOTSTXT_MANAGER_MENU_NAME'        => __( 'MS Robots.txt', 'multisite-robotstxt-manager' ),
        'MS_ROBOTSTXT_MANAGER_PAGE_NAME'        => __( 'Multisite Robots.txt Manager for Wordpress', 'multisite-robotstxt-manager' ),
        'MS_ROBOTSTXT_MANAGER_PAGE_ABOUT'       => __( 'A Multisite Robots.txt Manager Plugin For Wordpress.', 'multisite-robotstxt-manager' ),
        'MS_ROBOTSTXT_MANAGER_PLUGIN_NAME'      => 'ms_robotstxt_manager' ,

        'MS_ROBOTSTXT_MANAGER_INCLUDES'         => dirname( __FILE__ ) .'/includes',
        'MS_ROBOTSTXT_MANAGER_TEMPLATES'        => dirname( __FILE__ ) .'/templates'
    ) );
}


/**
 * Loop Through Constants
 * 
 * @param $constants_array array
 * @return void
 */
function MsRobotstxtManagerConstants( $constants_array )
{
    // Define Constants
    foreach( $constants_array as $name => $value ) {
        define( $name, $value, true );
    }
}


/**
 * Register Classes & Include
 * 
 * @param $class string Class Name
 * @return void
 */
spl_autoload_register( function ( $class )
{
    if( strpos( $class, 'MsRobotstxtManager_' ) !== false ) {
        $class_name = str_replace( 'MsRobotstxtManager_', "", $class );

        // If The Class Exists
        if( file_exists( MS_ROBOTSTXT_MANAGER_INCLUDES .'/class_'. strtolower( $class_name ) .'.php' ) ) {
            // Include Classes
            include_once( MS_ROBOTSTXT_MANAGER_INCLUDES .'/class_'. strtolower( $class_name ) .'.php' );
        }
    }

    // Plugin Extension
    if ( class_exists( 'MSRTM_Api' ) ) { require_once( WP_PLUGIN_DIR . '/' . MSRTM ); }
} );


/**
 * Load Plugin
 */
class multisite_robotstxt_manager
{
    /**
     * Backend Facing
     */
    final public static function backend() {
        if( is_admin() || is_network_admin() ) {

            // Form Validation
            add_filter( 'msrtm_validate_action', array( 'multisite_robotstxt_manager', 'validateActions' ) );

            // Admin Area Display & Functionality
            $MsRobotstxtManager_Admin = new MsRobotstxtManager_Admin( array(
                'base_url' => MS_ROBOTSTXT_MANAGER_BASE_URL,
                'plugin_name' => MS_ROBOTSTXT_MANAGER_PLUGIN_NAME,
                'plugin_file' => MS_ROBOTSTXT_MANAGER_PLUGIN_FILE,
                'plugin_version' => MS_ROBOTSTXT_MANAGER_VERSION,
                'menu_name' => MS_ROBOTSTXT_MANAGER_MENU_NAME,
                'templates' => MS_ROBOTSTXT_MANAGER_TEMPLATES
            ) );

            // Init Admin Functions & Filters
            $MsRobotstxtManager_Admin->initAdmin();
        }

        if( is_network_admin() ) {
            // Upgrade Detection & Manager
            $MsRobotstxtManager_Upgrade = new MsRobotstxtManager_Upgrade( array(
                'plugin_name' => MS_ROBOTSTXT_MANAGER_PLUGIN_NAME
            ) );

            // Init Upgrade Actions & Filters
            $MsRobotstxtManager_Upgrade->initUpgrade();
        }
    }


        /**
         * Activate Plugin: Validate Plugin & Install Default Features
         * 
         * @return void
         */
        final public static function activate()
        {
            // Wordpress Version Check
            global $wp_version;

            // Multisite Networks Only
            if( ! function_exists( 'switch_to_blog' ) ) {
                wp_die( __( '<b>Activation Failed</b>: The ' . MS_ROBOTSTXT_MANAGER_PAGE_NAME . ' Plugin can only be activated on Network Enabled Wordpress installs. Download and install the plugin, "Robots.txt Manager" for standalone Wordpress installs.', 'multisite-robotstxt-manager' ) );
            }

            // Network Activate Only
            if( ! is_network_admin() ) {
                wp_die( __( '<b>Activation Failed</b>: The ' . MS_ROBOTSTXT_MANAGER_PAGE_NAME . ' Plugin can only be activated within the Network Admin.', 'multisite-robotstxt-manager' ) );
            }

            // Version Check
            if( version_compare( $wp_version, MS_ROBOTSTXT_MANAGER_WP_MIN_VERSION, "<" ) ) {
                wp_die( __( '<b>Activation Failed</b>: The ' . MS_ROBOTSTXT_MANAGER_PAGE_NAME . ' plugin requires WordPress ' . MS_ROBOTSTXT_MANAGER_WP_MIN_VERSION . ' or higher. Please Upgrade Wordpress, then try activating this plugin again.', 'multisite-robotstxt-manager' ) );
            }
        }


        /**
         * Inject Plugin Links
         * 
         * @return array
         */
        final public static function links( $links, $file )
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
         * Form / Plugin Validation
         * 
         * @return void
         */
        final public static function validateActions()
        {
            // Plugin Admin Area Only
            if ( filter_input( INPUT_GET, 'page', FILTER_UNSAFE_RAW ) != MS_ROBOTSTXT_MANAGER_PLUGIN_NAME ) {
                wp_die( __( 'You are not authorized to perform this action.', 'multisite-robotstxt-manager' ) );
            }

            // Validate Nonce Action
            if( ! check_admin_referer( MS_ROBOTSTXT_MANAGER_PLUGIN_NAME . '_action', MS_ROBOTSTXT_MANAGER_PLUGIN_NAME . '_nonce' ) ) {
                wp_die( __( 'You are not authorized to perform this action.', 'multisite-robotstxt-manager' ) );
            }
        }


        /**
         * Frontend Facing
         */
        final public static function frontend() {
            if( ! is_admin() & ! is_network_admin() ) {
                // Display Robots.txt File
                $MsRobotstxtManager_Public = new MsRobotstxtManager_Public();

                // Detect Robots.txt File & Set Display Action
                $MsRobotstxtManager_Public->initRobotstxt();
            }
        }
    }

// Activate Plugin
register_activation_hook( __FILE__, array( 'multisite_robotstxt_manager', 'activate' ) );

// Inject Links Into Plugin Admins
add_filter( 'plugin_row_meta', array( 'multisite_robotstxt_manager', 'links' ), 10, 2 );

// Init Frontend
add_action( 'plugins_loaded', array( 'multisite_robotstxt_manager', 'frontend' ), 0 );

// Init Backend
add_action( 'init', array( 'multisite_robotstxt_manager', 'backend' ), 0 );
