<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * @about Check & Clean Previous Robots.txt Data
 * @location classes/class-process.php
 * @call MsRobotstxtManager_Cleaner::instance();
 * 
 * @method init()           Call Check / Clean Methods
 * @method checkData()      Check For Old Plugin Data
 * @method cleanData()      Remove Old Plugin Data
 * @method checkPhysical()  Check For Phsyical Robots.txt File
 * @method cleanPhysical()  Remove Physical Robots.txt File
 * @method checkRewrite()   Check For Missing Rewrite Rules
 * @method AddRewrite()     Add Missing Rewrite Rule
 * @method instance()       Create Instance
 */
if ( ! class_exists( 'MsRobotstxtManager_Cleaner' ) )
{
    class MsRobotstxtManager_Cleaner extends MsRobotstxtManager_Extended
    {
        // Holds Instance Object
        protected static $instance = NULL;


        /**
         * @about Call Check / Clean Methods
         */
        final public function init()
        {
            // Check For Old Plugin Data
            if ( filter_input( INPUT_POST, 'cleaner' ) == "check-data" ) {
                $this->checkData();
            }

            // Remove Old Plugin Data
            if ( filter_input( INPUT_POST, 'cleaner' ) == "clean-data" ) {
                $this->cleanData();
            }

            // Check For Physical Robots.txt File
            if ( filter_input( INPUT_POST, 'cleaner' ) == "check-physical" ) {
                $this->checkPhysical();
            }

            // Remove Physical Robots.txt File
            if ( filter_input( INPUT_POST, 'cleaner' ) == "clean-physical" ) {
                $this->cleanPhysical();
            }

            // Check For Missing Rewrite Rules
            if ( filter_input( INPUT_POST, 'cleaner' ) == "check-rewrite" ) {
                $this->checkRewrite();
            }

            // Add Missing Rewrite Rule
            if ( filter_input( INPUT_POST, 'cleaner' ) == "add-rewrite" ) {
                $this->AddRewrite();
            }
        }


        /**
         * @about Check For Old Plugin Data
         */
        final private function checkData()
        {
            // Clear Warning
            $warning = false;

            global $wpdb;

            // Get blog ID's
            $site_list = $wpdb->get_results( "SELECT blog_id FROM $wpdb->blogs ORDER BY blog_id" );

            // Check Network
            foreach ( $site_list as $site ) {
                // Ignore If Site Empty
                if ( empty( $site ) ) { continue; }

                // Switch To Each Website
                switch_to_blog( $site->blog_id );

                // Check For Options
                if( get_option( 'pc_robotstxt' ) || get_option( 'kb_robotstxt' ) || get_option( 'cd_rdte_content' ) ) { $warning = true; }

                // Return Home
                restore_current_blog();
            }

            if ( $warning == true ) {
                // Set Old Data Found Marker
                update_option( $this->option_name . 'cleaner_old_data', true, 'no' );

                // Display Message
                parent::message( 'yesolddata', 'error' );

            } else {
                // Remove Old Data Marker
                delete_option( $this->option_name . 'cleaner_old_data' );

                // Display Message
                parent::message( 'noolddata', 'updated' );
            }

            return $warning;
        }


        /**
         * @about Remove Old Plugin Data
         */
        final private function cleanData()
        {
            global $wpdb;

            // Get blog ID's
            $site_list = $wpdb->get_results( "SELECT blog_id FROM $wpdb->blogs ORDER BY blog_id" );

            // Check Network
            foreach ( $site_list as $site ) {
                // Ignore If Site Empty
                if ( empty( $site ) ) { continue; }

                // Switch To Each Website
                switch_to_blog( $site->blog_id );

                // Remove Options
                if( get_option( 'pc_robotstxt' ) ) { delete_option( 'pc_robotstxt' ); }
                if( get_option( 'kb_robotstxt' ) ) { delete_option( 'kb_robotstxt' ); }
                if( get_option( 'cd_rdte_content' ) ) {
                    delete_option( 'cd_rdte_content' );
                    remove_filter( 'robots_txt', 'cd_rdte_filter_robots' );
                }

                // Remove Other Plugin Filters
                remove_filter( 'robots_txt', 'ljpl_filter_robots_txt' );
                remove_filter( 'robots_txt', 'robots_txt_filter' );

                // Return Home
                restore_current_blog();
            }

            // Run Full Check Again
            $this->checkData();
        }


        /**
         * @about Check For Phsyical Robots.txt File
         */
        final private function checkPhysical()
        {
            // Clear Warning
            $warning = false;

            // Check For Real Robots.txt File
            if ( file_exists ( get_home_path() . 'robots.txt' ) ) {
                $warning = true;
            }

            if ( $warning == true ) {
                // Set Old Data Found Marker
                update_option( $this->option_name . 'cleaner_physical', true, 'no' );

                // Display Message
                parent::message( 'yesphysical', 'error' );

            } else {
                // Remove Old Data Marker
                delete_option( $this->option_name . 'cleaner_physical' );

                // Display Message
                parent::message( 'nophysical', 'updated' );

            }

            return $warning;
        }


        /**
         * @about Remove Physical Robots.txt File
         */
        final private function cleanPhysical()
        {
            // Remove Real Robots.txt File
            if ( is_writable( get_home_path() . 'robots.txt' ) ) {
                unlink( get_home_path() . 'robots.txt' );
            }
            
            // Check Again
            if ( file_exists ( get_home_path() . 'robots.txt' ) ) {
                // Display Message
                parent::message( 'badphysical', 'error' );
            } else {
                // Display Message
                parent::message( 'nophysical', 'updated' );

                // Remove Old Data Marker
                delete_option( $this->option_name . 'cleaner_physical' );
            }
        }


        /**
         * @about Check For Missing Rewrite Rules
         */
        final private function checkRewrite()
        {
            // Clear Warning
            $warning = false;

            global $wpdb;

            // Get blog ID's
            $site_list = $wpdb->get_results( "SELECT blog_id FROM $wpdb->blogs ORDER BY blog_id" );

            // Update Network
            foreach ( $site_list as $site ) {
                // Ignore If Site Empty
                if ( empty( $site ) ) { continue; }

                // Switch To Each Website
                switch_to_blog( $site->blog_id );

                // Get Rewrite Rules
                $rules = get_option( 'rewrite_rules' );

                // Flush Rules If Needed
                if( empty( $rules ) ) { flush_rewrite_rules(); }

                // Check If Rule Within Rewrite Rules Array
                if( ! in_array( "index.php?robots=1", (array) $rules ) ) { $warning = true; }

                // Return Home
                restore_current_blog();
            }

            // Switch To Network
            switch_to_blog( '1' );

            // Bad Rewrite Rules
            if( $warning == true ) {
                update_option( $this->option_name . 'cleaner_rewrite', true, 'no' );

                // Display Message
                parent::message( 'norewrite', 'error' );
            }

            // Good Rule Found
            if( $warning == false ) {
                delete_option( $this->option_name . 'cleaner_rewrite' );

                // Display Message
                parent::message( 'yesrewrite', 'updated' );
            }
        }


        /**
         * @about Add Missing Rewrite Rule
         */
        final private function addRewrite()
        {
            global $wpdb;

            // Get blog ID's
            $site_list = $wpdb->get_results( "SELECT blog_id FROM $wpdb->blogs ORDER BY blog_id" );

            // Update Network
            foreach ( $site_list as $site ) {
                // Ignore If Site Empty
                if ( empty( $site ) ) { continue; }

                // Switch To Each Website
                switch_to_blog( $site->blog_id );

                // Get Rewrite Rules
                $rewrite_rules = get_option( 'rewrite_rules' );

                // Force Update of Missing Rule
                if( ! in_array( "index.php?robots=1", (array) $rewrite_rules ) ) {
                    $rules = array_merge( $rewrite_rules, array( 'robots\.txt$' => 'index.php?robots=1' ) );
                    delete_option( 'rewrite_rules' );
                    update_option( 'rewrite_rules', $rules );

                    // Flush Rules
                    flush_rewrite_rules();
                }

                // Return Home
                restore_current_blog();
            }

            // Recheck Rewrite Rules
            $this->checkRewrite();
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
