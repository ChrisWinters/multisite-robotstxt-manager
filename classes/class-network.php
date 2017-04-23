<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * @about Update Network Robots.txt File With Preset Robots.txt File
 * @location classes/class-process.php
 * @call MsRobotstxtManager_Network::instance();
 * 
 * @method init()               Update Network Robots.txt, Status & Preset Options
 * @method saveRobotstxt()      Save Network Robots.txt File
 * @method memberRobotstxt()    Update Websites User Is A Member Of
 * @method networkRobotstxt()   Update All Network Websites
 * @method updateWebsite()      Update Websites Robotst.txt File
 * @method instance()           Create Instance
 */
if ( ! class_exists( 'MsRobotstxtManager_Network' ) )
{
    class MsRobotstxtManager_Network extends MsRobotstxtManager_Extended
    {
        // Holds Instance Object
        protected static $instance = NULL;

        // Posted Network Robots.txt File
        private $network_robotstxt;


        /**
         * @about Update Network Robots.txt, Status & Preset Options
         */
        final public function init()
        {
            // Get Post Data
            $this->network_robotstxt = filter_input( INPUT_POST, 'robotstxt_file', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

            // Change To Root Website
            switch_to_blog( '1' );

            // Save Network Robots.txt File
            if ( filter_input( INPUT_POST, 'update' ) == 'save' ) {
                $this->saveRobotstxt();
            }

            // Update Websites User Is A Member Of
            if ( filter_input( INPUT_POST, 'update' ) == 'member' ) {
                $this->memberRobotstxt();
            }

            // Update All Network Websites
            if ( filter_input( INPUT_POST, 'update' ) == 'network' ) {
                $this->networkRobotstxt();
            }

            // Return To Previous
            restore_current_blog();

            // Error: Display Message
            if ( ! filter_input( INPUT_POST, 'update' ) ) {
                parent::message( 'networkfailed', 'error' );
            }
        }


        /**
         * @about Save Network Robots.txt File
         */
        final private function saveRobotstxt()
        {
            // Update Robots.txt File
            update_option( $this->option_name . 'network_robotstxt', array( 'robotstxt' => $this->network_robotstxt ), 'no' );

            // Delete Preset Setting
            delete_option( $this->option_name . 'network_preset' );

            // Display Message
            parent::message( 'networkrobotstxtsaved', 'updated' );
        }


        /**
         * @about Update Websites Admin Is A Member Of
         */
        final private function memberRobotstxt()
        {
            global $current_user;

            // Update Robots.txt File
            update_option( $this->option_name . 'network_robotstxt', array( 'robotstxt' => $this->network_robotstxt ), 'no' );

            // Enable Network
            update_option( $this->option_name . 'network_status', true, 'no' );

            // Delete Preset Setting
            delete_option( $this->option_name . 'network_preset' );

            // Current Admin User
            $current_user = wp_get_current_user();
            $this_admin_user = $current_user->ID;

            // Blog IDs For This User
            $users_blogs = get_blogs_of_user( $this_admin_user );

            // Update Allowed Blogs
            foreach ( $users_blogs as $users_blog_id ) {
                // Switch To Each Website
                switch_to_blog( $users_blog_id->userblog_id );

                // Update Websites
                $this->updateWebsite();

                // Return To Root Site
                restore_current_blog();
            }

            // Display Message
            parent::message( 'networkmemberupdated', 'updated' );
        }


        /**
         * @about Update All Network Websites
         */
        final private function networkRobotstxt()
        {
            global $wpdb;

            // Update Robots.txt File
            update_option( $this->option_name . 'network_robotstxt', array( 'robotstxt' => $this->network_robotstxt ), 'no' );

            // Enable Network
            update_option( $this->option_name . 'network_status', true, 'no' );

            // Delete Preset Setting
            delete_option( $this->option_name . 'network_preset' );

            // Get blog ID's
            $site_list = $wpdb->get_results( "SELECT blog_id FROM $wpdb->blogs WHERE public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' ORDER BY blog_id" );

            // Update Network
            foreach ( $site_list as $site ) {
                // Ignore If Site Empty
                if ( empty( $site ) ) { continue; }

                // Switch To Each Website
                switch_to_blog( $site->blog_id );

                // Update Websites
                $this->updateWebsite();

                // Return To Root Site
                restore_current_blog();
            }

            // Display Message
            parent::message( 'networkglobalupdated', 'updated' );
        }


        /**
         * @about Update Websites Robotst.txt File
         * @location memberRobotstxt() & networkRobotstxt()
         */
        final private function updateWebsite()
        {
            // Network Robots.txt File Disabled On Website, User Modified Robots.txt File
            if ( get_option( $this->option_name . 'default' ) ) { return; }

            // Get Website Robots.txt File To Append
            $append_option = get_option( $this->option_name . 'append' );
            $append_rules = ( $append_option ) ? $append_option['robotstxt'] : '';

            // Enable For Website
            update_option( $this->option_name . 'status', true, 'yes' );

            // Get Domain URL Base
            $sitemap_url_base = get_option( 'site_url' ) ? get_option( 'site_url' ) : MS_ROBOTSTXT_MANAGER_BASE_URL;

            // MSRM PRO: Parse Sitemap Marker
            // @version 4.0.1
            $network_robotstxt = apply_filters( 'msrtm_parse_sitemap_marker', $this->network_robotstxt, site_url() );

            // Append Website Rules to Network Robots.txt File
            if ( isset( $robotstxt_append_rules ) ) {
                // Return Replaced String
                $new_robotstxt = str_replace( '{APPEND_WEBSITE_ROBOTSTXT}', $append_rules, $network_robotstxt );

                // Update Website Robots.txt File
                update_option( $this->option_name . 'robotstxt', array( 'robotstxt' => $new_robotstxt ), 'yes' );

            // No Append Rules, Network Robots.txt File Only
            } else {
                // Return Replaced String
                $new_robotstxt = str_replace( '{APPEND_WEBSITE_ROBOTSTXT}', '', $network_robotstxt );

                // Update Website Robots.txt File
                update_option( $this->option_name . 'robotstxt', array( 'robotstxt' => $new_robotstxt ), 'yes' );
            }
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
