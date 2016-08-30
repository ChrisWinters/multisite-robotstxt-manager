<?php
/**
 * Plugin Name: Multisite Robots.txt Manager | MS Robots.txt
 * Plugin URI: http://technerdia.com/msrtm/
 * Description: A Multisite Network Robots.txt Manager. Quickly manage your Network Websites robots.txt files from a single administration area.
 * Tags: robotstxt, robots.txt, robots, robot, spiders, virtual, search, google, seo, plugin, network, wpmu, multisite, technerdia, tribalnerd
 * Version: 1.0.0
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
        'MS_ROBOTSTXT_MANAGER_VERSION'          => '1.0.0',
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
 * Register Auto Loaded Classes
 * 
 * @param $class string
 * @return void
 */
spl_autoload_register( function ( $class )
{
    if( strpos( $class, 'MsRobotstxtManager_' ) !== false ) {
        $class_name = str_replace( 'MsRobotstxtManager_', "", $class );

        // If The Class Exists
        if( file_exists( MS_ROBOTSTXT_MANAGER_INCLUDES .'/class_'. strtolower( $class_name ) .'.php' ) ) {
            // Include Classes
            include( MS_ROBOTSTXT_MANAGER_INCLUDES .'/class_'. strtolower( $class_name ) .'.php' );
        }

        // Plugin Extension
        if( defined( 'MSRTM' ) ) { require_once( WP_PLUGIN_DIR . '/' . MSRTM ); }
    }
} );

// Backend Facing
if( is_admin() || is_network_admin() ) {
    // Plugin Core
    $MsRobotstxtManager_Core = new MsRobotstxtManager_Core();

    // Admin Area Display & Functionality
    $MsRobotstxtManager_Admin = new MsRobotstxtManager_Admin();

// Frontend Facing
} else {
    // Display Robots.txt File
    $MsRobotstxtManager_Public = new MsRobotstxtManager_Public();
}