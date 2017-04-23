<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * @about Update Website Robots.txt File
 * @location classes/class-process.php
 * @call MsRobotstxtManager_Website::instance();
 * 
 * @method init()       Get Append Rules For Save
 * @method saveRules()  Save Website Robots.txt File
 * @method instance()   Create Instance
 */
if ( ! class_exists( 'MsRobotstxtManager_Website' ) )
{
    class MsRobotstxtManager_Website extends MsRobotstxtManager_Extended
    {
        // Holds Instance Object
        protected static $instance = NULL;


        /**
         * @about Get Append Rules For Save
         */
        final public function init()
        {
            // Get Post Data
            $append_rules = filter_input( INPUT_POST, 'append_rules', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

            // Save Website Append Rules
            if ( ! empty( $append_rules ) ) {
                $this->saveRules( $append_rules );
            }

            // Error: Display Message
            if ( empty( $append_rules ) ) {
                parent::message( 'noappendrules', 'error' );
            }
        }


        /**
         * @about Save Website Robots.txt File
         * @param string $network_robotstxt Network Robots.txt File
         */
        final private function saveRules( $append_rules )
        {
            switch_to_blog( get_current_blog_id() );

            // Enable Plugin For Website
            update_option( $this->option_name . 'status', true, 'yes' );

            // Update Append Data For Robots.txt File
            update_option( $this->option_name . 'append', array( 'robotstxt' => $append_rules ), 'no' );

            // Disabled Network Robots.txt File On Local Website
            if ( get_option( $this->option_name . 'default' ) ) {
                $robotstxt = $append_rules;

            } else {
                // Get Network Robots.txt File And Append Rules
                $robotstxt = ( parent::getNetworkRobotstxt() ) ? str_replace( '{APPEND_WEBSITE_ROBOTSTXT}', $append_rules, parent::getNetworkRobotstxt() ) : $append_rules;
            }

            // Update Robots.txt File
            update_option( $this->option_name . 'robotstxt', array( 'robotstxt' => $robotstxt ), 'yes' );

            // Return To Current Website
            restore_current_blog();

            // Display Message
            parent::message( 'websiteupdated', 'updated' );
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
