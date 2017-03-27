<?php
if( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }

// Wordpress Uninstall Check
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { exit; }


/**
 * Uninstall Pluing Features
 */
if ( ! class_exists( 'MsRobotstxtManager_Uninstall' ) )
{
    class MsRobotstxtManager_Uninstall
    {
        /**
         * Run Uninstall
         */
        public function __construct()
        {
            // Valid Users Only
            if( ! is_user_logged_in() && ! current_user_can( 'manage_options' ) ) { wp_die( __( 'Unauthorized Access.', 'multisite-robotstxt-manager' ) ); }

            // Do Uninstall
            $this->uninstall();
        }


        /**
         * Remove Features
         */
        final public function uninstall()
        {
            // Remove Options
            delete_option( 'ms_robotstxt_manager_network_robotstxt' );
            delete_option( 'ms_robotstxt_manager_network_status' );
            delete_option( 'ms_robotstxt_manager_network_preset' );
            delete_option( 'ms_robotstxt_manager_settings' );
            delete_option( 'ms_robotstxt_manager_status' );
            delete_option( 'ms_robotstxt_manager_append' );
            delete_option( 'ms_robotstxt_manager_robotstxt' );
            delete_option( 'ms_robotstxt_manager_upgraded' );
            delete_option( 'ms_robotstxt_manager_rewrite' );
            delete_option( 'ms_robotstxt_manager_old_data' );

            global $wpdb;

            // Get blog ID's
            $site_list = $wpdb->get_results( "SELECT blog_id FROM $wpdb->blogs ORDER BY blog_id" );

            // Update Network
            foreach ( $site_list as $site ) {
                // Ignore If Site Empty
                if ( empty( $site ) ) { continue; }

                // Switch To Each Website
                switch_to_blog( $site->blog_id );

                // Remove Website Options
                delete_option( 'ms_robotstxt_manager_status' );
                delete_option( 'ms_robotstxt_manager_append' );
                delete_option( 'ms_robotstxt_manager_robotstxt' );
                delete_option( 'ms_robotstxt_manager_default' );

                // Return To Root Site
                restore_current_blog();
            }

            return;
        }
    }
}

// Run Class
$MsRobotstxtManager_Uninstall = new MsRobotstxtManager_Uninstall();
