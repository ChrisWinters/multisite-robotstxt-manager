<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * @about Display Robots.txt File
 * @location multisite-robotstxt-manager.php
 * @call new MsRobotstxtManager_Robotstxt();
 * 
 * @method __construct()    Check File Being Called
 * @method robotstxt()      Display Robots.txt File
 */
if ( ! class_exists( 'MsRobotstxtManager_Robotstxt' ) )
{
    class MsRobotstxtManager_Robotstxt
    {
        /**
         * @about Check File Being Called
         */
        final public function __construct()
        {
            // Request URI: robots.txt
            if ( strpos( filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL ), "robots.txt" ) !== false ) {
                $this->robotstxt();
            }
        }


        /**
         * @about Display Robots.txt File
         */
        final private function robotstxt()
        {
            // If Active, Display Robots.txt File
            if( get_option( 'ms_robotstxt_manager_status' ) ) {
                // Return Proper Headers
                header( 'Status: 200 OK', true, 200 );
                header( 'Content-type: text/plain; charset=' . get_bloginfo( 'charset' ) );

                // Wordpress Action
                do_action( 'do_robotstxt' );

                // Get Website Unique Robots.txt File
                $website_robotstxt = get_option( 'ms_robotstxt_manager_robotstxt' );

                // Return Robots.txt File
                echo $website_robotstxt[ 'robotstxt' ];

                // Stop WP
                exit;
            }
        }
    }
}
