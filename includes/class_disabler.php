<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * Disable Plugin / Delete Plugin Settings
 */
if ( ! class_exists( 'MsRobotstxtManager_Disabler' ) )
{
    class MsRobotstxtManager_Disabler
    {
        /**
         * Display Messages To User
         * 
         * @return void
         */
        final public function throwMessage( $slug, $notice_type = false ) {
            // Set Message Type, Default Error
            $type = ( $notice_type == "updated" ) ? "updated" : "error";

            // Clear Message
            $message = '';

            // Switch Between Tabs
            switch ( $slug ) {
                case 'websitedisabled':
                    $message = __( '<u>Website Disabled</u>: The Multisite Robots.txt Manager Plugin is no longer managing the robots.txt file on this website. Click the "update update" button to reenable the website.' );
                break;
                case 'networkdisabled':
                    $message = __( '<u>Network Disabled</u>: The Multisite Robots.txt Manager Plugin is no longer managing robots.txt files across network websites. Click the "update network" button to reenable the plugin.' );
                break;
                case 'settingsdeleted':
                    $message = __( '<u>Settings Deleted</u>: All Multisite Robots.txt Manager Plugin settings have been removed across the network. To re-enable: Save a preset robots.txt file or create your own robots.txt file, then click the "update network" button to update .' );
                break;
            }

            // Throw Message
            if ( ! empty( $message ) ) {
                add_settings_error( $slug, $slug, $message, $type );
            }
        }


        /**
         * Detect Disable Post
         * Disable Plugin On Single Website
         * 
         * @return void
         */
        final public function disableWebsite()
        {
            // If MSRTM Status Change
            if ( is_admin() && ! is_network_admin() && filter_input( INPUT_POST, 'disable' ) == "website" ) {
                // Form Security Check
                do_action( 'msrtm_validate_action' );

                // Clear Option
                delete_option( "ms_robotstxt_manager_status" );

                // Display Message
                $this->throwMessage( 'websitedisabled', 'updated' );
            }
        }


        /**
         * Disable Plugin Across Network
         * Restore Default Robots.txt File
         * 
         * @return void
         */
        final public function disableNetwork()
        {
            // If MSRTM Status Change
            if ( is_network_admin() && filter_input( INPUT_POST, 'disable' ) == "network" ) {
                // Form Security Check
                do_action( 'msrtm_validate_action' );

                // Switch to root website
                switch_to_blog( '1' );

                // Clear Option
                delete_option( "ms_robotstxt_manager_network_status" );

                global $wpdb;

                // Get blog ID's
                $site_list = $wpdb->get_results( "SELECT blog_id FROM $wpdb->blogs WHERE public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' ORDER BY blog_id" );

                // Update Network
                foreach ( $site_list as $site ) {
                    // Ignore If Site Empty
                    if ( empty( $site ) ) { continue; }

                    // Switch To Each Website
                    switch_to_blog( $site->blog_id );

                    // Clear Active Status
                    delete_option( 'ms_robotstxt_manager_status' );

                    // Return To Root Site
                    restore_current_blog();
                }

                // Display Message
                $this->throwMessage( 'networkdisabled', 'updated' );
            }
        }


        /**
         * Delete All Plugin Data Across Network
         * 
         * @return void
         */
        final public function deleteNetwork()
        {
            // If MSRTM Status Change
            if ( is_network_admin() && filter_input( INPUT_POST, 'disable' ) == "all" ) {
                // Form Security Check
                do_action( 'msrtm_validate_action' );

                // Switch to root website
                switch_to_blog( '1' );

                delete_option( 'ms_robotstxt_manager_network_robotstxt' );
                delete_option( 'ms_robotstxt_manager_network_preset' );
                delete_option( 'ms_robotstxt_manager_network_status' );
                delete_option( 'ms_robotstxt_manager_settings' );

                // Return To Previous Website
                restore_current_blog();

                // Connect to Database
                global $wpdb;

                // Get All Blog ID's
                $blog_ids = $wpdb->get_results( 'SELECT blog_id FROM '. $wpdb->blogs .' ORDER BY blog_id' );

                // Remove Option From Each Blog
                foreach ( $blog_ids as $value ) {
                    // Switch to website
                    $id = $value->blog_id;

                    // Change to each Website
                    switch_to_blog($id);

                    // Remove Option
                    delete_option( 'ms_robotstxt_manager_robotstxt' );
                    delete_option( 'ms_robotstxt_manager_status' );
                    delete_option( 'ms_robotstxt_manager_append' );
                    delete_option( 'ms_robotstxt_manager_post' );
                    delete_option( 'msrtm_pro_settings' );
                }

                // Return To Previous Website
                restore_current_blog();

                // Display Message
                $this->throwMessage( 'settingsdeleted', 'updated' );
            }
        }
    }
}
