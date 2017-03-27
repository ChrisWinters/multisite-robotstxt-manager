<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * @about Process Plugin Updates/Changes
 * @location multisite-robotstxt-manager.php
 * @call MsRobotstxtManager_Process::instance();
 * 
 * @method init()       Init Admin Actions
 * @method update()     Call Update Classes
 * @method instance()   Class Instance
 */
if ( ! class_exists( 'MsRobotstxtManager_Process' ) )
{
    class MsRobotstxtManager_Process extends MsRobotstxtManager_Extended
    {
        // Holds Instance Object
        protected static $instance = NULL;


        /**
         * @about Update Settings
         */
        final public function init()
        {
            // Plugin Admin Only
            if ( filter_input( INPUT_POST, 'type' ) && parent::qString( 'page' ) == $this->plugin_name ) {
                add_action( 'admin_init', array( $this, 'update') );
            }
        }


        /**
         * @about Call Update Classes
         */
        final public function update()
        {
            // Form Security Check
            parent::validate();

            // Update Website Robots.txt File
            if ( filter_input( INPUT_POST, 'type' ) == "website" ) {
                MsRobotstxtManager_Website::instance();
            }

            // Update Network Robots.txt File
            if ( filter_input( INPUT_POST, 'type' ) == "network" ) {
                MsRobotstxtManager_Network::instance();
            }

            // Update Network Presets
            if ( filter_input( INPUT_POST, 'type' ) == "presets" ) {
                MsRobotstxtManager_Presets::instance();
            }

            // Disable / Delete Settings
            if ( filter_input( INPUT_POST, 'type' ) == "status" ) {
                MsRobotstxtManager_Disable::instance();
            }

            // Check/Clean Old Plugin Data / Rewrite Data
            if ( filter_input( INPUT_POST, 'type' ) == "cleaner" ) {
                MsRobotstxtManager_Cleaner::instance();
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
