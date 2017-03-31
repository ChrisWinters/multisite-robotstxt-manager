<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * @about Disable or Delete Network/Website Robots.txt File Settings
 * @location classes/class-process.php
 * @call MsRobotstxtManager_Disable::instance();
 * 
 * @method init()           Manage Disable Post Inputs
 * @method disableNetwork() Disable All Network Robots.txt Files
 * @method deleteNetwork()  Delete All Settings, Network Wide
 * @method disableWebsite() Disable Robots.txt File On A Unique Website
 * @method disableDefault() Disable Network Robots.txt File On A Unique Website
 * @method enableDefault()  Enable Network Robots.txt File On A Unique Website
 * @method instance()       Create Instance
 */
if ( ! class_exists( 'MsRobotstxtManager_Disable' ) )
{
    class MsRobotstxtManager_Disable extends MsRobotstxtManager_Extended
    {
        // Holds Instance Object
        protected static $instance = NULL;


        /**
         * @about Manage Disable Post Inputs
         */
        final public function init()
        {
            // Disable All Network Robots.txt Files
            if ( filter_input( INPUT_POST, 'disable' ) == 'network' ) {
                $this->disableNetwork();
            }

            // Delete All Settings, Network Wide
            if ( filter_input( INPUT_POST, 'disable' ) == 'all' ) {
                $this->deleteNetwork();
            }

            // Disable Robots.txt File On A Unique Website
            if ( filter_input( INPUT_POST, 'disable' ) == 'website' ) {
                $this->disableWebsite();
            }

            // Disable Network Robots.txt File On A Unique Website
            if ( filter_input( INPUT_POST, 'disable' ) == 'default-disable' ) {
                $this->disableDefault();
            }

            // Enable Network Robots.txt File On A Unique Website
            if ( filter_input( INPUT_POST, 'disable' ) == 'default-enable' ) {
                $this->enableDefault();
            }

            // Error: Display Message
            if ( ! filter_input( INPUT_POST, 'disable' ) ) {
                parent::message( 'disablefailed', 'error' );
            }
        }


        /**
         * @about Disable All Network Robots.txt Files
         */
        final private function disableNetwork()
        {
            // Switch to root website
            switch_to_blog( '1' );

            // Clear Option
            delete_option( $this->option_name . 'network_status' );

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
                delete_option( $this->option_name . 'status' );

                // Return To Root Site
                restore_current_blog();
            }
 
            // Display Message
            parent::message( 'disablenetwork', 'updated' );
        }


        /**
         * @about Delete All Settings, Network Wide
         */
        final private function deleteNetwork()
        {
            // Switch to root website
            switch_to_blog( '1' );

            delete_option( $this->option_name . 'network_robotstxt' );
            delete_option( $this->option_name . 'network_preset' );
            delete_option( $this->option_name . 'network_status' );
            delete_option( $this->option_name . 'settings' );
            delete_option( $this->option_name . 'cleaner_old_data' );
            delete_option( $this->option_name . 'cleaner_physical' );
            delete_option( $this->option_name . 'cleaner_rewrite' );
            delete_option( 'msrtm_settings' );

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
                delete_option( $this->option_name . 'robotstxt' );
                delete_option( $this->option_name . 'status' );
                delete_option( $this->option_name . 'append' );
                delete_option( $this->option_name . 'default' );
            }

            // Return To Previous Website
            restore_current_blog();

            // Display Message
            parent::message( 'deletenetwork', 'updated' );
        }


        /**
         * @about Disable Robots.txt File On A Unique Website
         */
        final private function disableWebsite()
        {
            // Clear Status Option
            delete_option( $this->option_name . 'status' );

            // Display Message
            parent::message( 'disablewebsite', 'updated' );
        }


        /**
         * @about Disable Network Robots.txt File On A Unique Website
         */
        final private function disableDefault()
        {
            // Set Disable
            update_option( $this->option_name . 'default', true, 'no' );

            // Display Message
            parent::message( 'disabledefault', 'updated' );
        }


        /**
         * @about Disable Network Robots.txt File On A Unique Website
         */
        final private function enableDefault()
        {
            // Set Disable
            delete_option( $this->option_name . 'default' );

            // Display Message
            parent::message( 'enabledefault', 'updated' );
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
