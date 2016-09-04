<?php
if( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * Finds Old Plugin Data, Updates New Plugin Options
 */
if ( ! class_exists( 'MsRobotstxtManager_Upgrade' ) )
{
    class MsRobotstxtManager_Upgrade extends MsRobotstxtManager_Helper
    {
        // The plugin_root_name
        private $plugin_name;

        /**
         * Setup/Run Upgrade
         * 
         * @return void
         */
        public function __construct( array $args = null )
        {
            // Require Array
            if( ! is_array( $args ) ) { return; }

            // Set Vars
            $this->plugin_name = $args['plugin_name'];
        }


        /**
         * Start Upgrade Checks
         * 
         * @return void
         */
        final public function initUpgrade()
        {
            // Network Only
            if ( filter_input( INPUT_GET, 'page', FILTER_UNSAFE_RAW ) == $this->plugin_name ) {
                // Check If Plugin Needs To Be Upgraded
                if ( ! get_option( 'ms_robotstxt_manager_upgraded' ) ) {
                    // Check If Update Needed
                    add_action( 'admin_init', array( &$this, 'upgradeCheck' ) );

                    // Upgrade The Network
                    add_action( 'admin_init', array( &$this, 'upgradeNetwork' ) );

                    // Upgrade All Websites
                    add_filter( 'msrtm_upgrade_websites', array( &$this, 'upgradeWebsites') );

                    // Clear Out Old Network Data
                    add_filter( 'msrtm_clean_network', array( &$this, 'cleanNetwork') );

                    // Clear Out Old Website Data
                    add_filter( 'msrtm_clean_websites', array( &$this, 'cleanWebsites') );

                    // Make Sure No Old Robots.txt Option Exists
                    add_filter( 'msrtm_final_check', array( &$this, 'finalCheck') );
                }

                // Check/Clean Other Plugin Robots.txt Data
                if ( ! get_option( 'msrtm_plugins_check' ) || get_option( 'msrtm_plugins_check' ) == '1' ) {
                    add_action( 'admin_init', array( &$this, 'checkOtherPlugins' ) );

                    // Remove Other Plugin Data
                    add_action( 'admin_init', array( &$this, 'cleanOtherPlugins') );
                }

                // Check/Clean Bad Rewrite Ruels
                //if ( ! get_option( 'msrtm_bad_rules' ) || get_option( 'msrtm_bad_rules' ) == '1' ) {
                    // Check If rewrite_rules Option & Robots.txt Keys Are Set
                    //add_action( 'admin_init', array( &$this, 'checkBadRewrite' ) );

                    // Update Bad Rules
                    //add_action( 'admin_init', array( &$this, 'cleanBadRules') );
                //}

                // Extension Upgrade Check
                add_action( 'wp_loaded', array( &$this, 'checkExtension' ) );
            }
        }


        /**
         * Make Sure No Old Robots.txt Option Exists
         * 
         * @return void
         */
        final public function finalCheck()
        {
            // No Data Found
            $data = false;

            global $wpdb;

            // Get blog ID's
            $site_list = $wpdb->get_results( "SELECT blog_id FROM $wpdb->blogs ORDER BY blog_id" );

            // Update Network
            foreach ( $site_list as $site ) {
                // Ignore If Site Empty
                if ( empty( $site ) ) { continue; }

                // Switch To Each Website
                switch_to_blog( $site->blog_id );

                // Data Found
                if ( get_option( 'ms_robotstxt' ) ) {
                    $data = true;
                }

                // Return Home
                restore_current_blog();
            }

            // Switch To Network
            switch_to_blog( '1' );
 
            // If No Data Found, Mark Network As Upgraded
            if ( $data === false ) {
                // Network Upgraded
                add_option( 'ms_robotstxt_manager_upgraded', '1', '', 'no' );
            } else {
                // Clear Option If Set
                delete_option( 'ms_robotstxt_manager_upgraded' );
            }

            // Return Home
            restore_current_blog();
        }


        /**
         * Plugin Upgrade Check
         * 
         * @return void
         */
        final public function upgradeCheck()
        {
            // Switch To Network
            switch_to_blog( '1' );

            if ( get_option( 'ms_robotstxt_default' ) ) {
                add_action( 'admin_notices', array( &$this, 'noticeUpgrade' ) );
                add_action( 'network_admin_notices', array( &$this, 'noticeUpgrade' ) );
            }

            // Return Home
            restore_current_blog();
        }



        /**
         * Admin Area Upgrade Notice
         * 
         * @return html
         */
        final public function noticeUpgrade()
        {
            echo '<div id="message" class="updated notice is-dismissible">';
            $this->echoForm( 'upgrade', false );
            echo '<p><b>' . __( 'Old Plugin Data Found', 'multisite-robotstxt-manager' ) . '</b>: ' . __( 'Click the button to automatically copy old settings over, and then purge the old settings from the database', 'multisite-robotstxt-manager' ) . ': ';
            echo $this->echoSubmit( __( 'upgrade and purge network', 'multisite-robotstxt-manager' ) ) . '</p>';
            $this->echoForm( false, true );
            echo '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
        }


        /**
         * Copy Old Network Robots.txt File To New Option
         * 
         * @return void
         */
        final public function upgradeNetwork()
        {
            // If Not Upgraded And Upgrade Posted
            if ( filter_input( INPUT_POST, 'ms_robotstxt_manager' ) == "upgrade" ) {
                // Form Security Check
                do_action( 'msrtm_validate_action' );

                // Detect Previous Version Robots.txt File
                if ( $this->detectOldNetworkOption() === true ) {
                    // Get Old Robots.txt File
                    $default_option = maybe_unserialize( get_option( "ms_robotstxt_default" ) );
                    $robotstxt = $default_option['default_robotstxt'];

                    // Build Robots.txt File From Old File
                    add_option( 'ms_robotstxt_manager_network_robotstxt', array( 'robotstxt' => $robotstxt ), '', 'no' );

                    // Deactivate The Plugin
                    delete_option( 'ms_robotstxt_manager_network_status' );

                    // Define Which Preset Is Being used
                    delete_option( 'ms_robotstxt_manager_network_preset' );
                }

                // If Net Option Not Found, Build Preset Robotst.txt File
                if ( $this->detectNewNetworkOption() === false ) {

                    // Get Preset Robots.txt File
                    $preset_robotstxt_file = new MsRobotstxtManager_Presets();

                    // Build Robots.txt File From Preset
                    add_option( 'ms_robotstxt_manager_network_robotstxt', array( 'robotstxt' => $preset_robotstxt_file->defaultRobotstxt() ), '', 'no' );

                    // Deactivate The Plugin
                    delete_option( 'ms_robotstxt_manager_network_status' );

                    // Define Which Preset Is Being used
                    delete_option( 'ms_robotstxt_manager_network_preset' );
                    add_option( 'ms_robotstxt_manager_network_preset', 'default', '', 'no' );
                }

                // Switch To Network
                switch_to_blog( '1' );

                // Clear Out Old Network Data
                apply_filters( 'msrtm_upgrade_websites', false );

                // Return Home
                restore_current_blog();
            }
        }


        /**
         * Use Old Sitemap URLs For New Append Rules, If The Rules Do Not Already Exist
         * 
         * @return void
         */
        final public function upgradeWebsites()
        {
            // If Not Upgraded And Upgrade Posted
            if ( filter_input( INPUT_POST, 'ms_robotstxt_manager' ) == "upgrade" ) {
                // Form Security Check
                do_action( 'msrtm_validate_action' );

                global $wpdb;

                // Get blog ID's
                $site_list = $wpdb->get_results( "SELECT blog_id FROM $wpdb->blogs ORDER BY blog_id" );

                // Update Network
                foreach ( $site_list as $site ) {
                    // Ignore If Site Empty
                    if ( empty( $site ) ) { continue; }

                    // Switch To Each Website
                    switch_to_blog( $site->blog_id );

                    // Get Old Robots.txt File URL
                    if ( get_option( 'ms_robotstxt_sitemap' ) && ! get_option( 'ms_robotstxt_manager_robotstxt' ) ) {
                        // Get Sitemap URL
                        $sitemap_data = maybe_unserialize( get_option( 'ms_robotstxt_sitemap' ) );

                        // Build Append Rules From Old Robots.txt File
                        add_option( 'ms_robotstxt_manager_robotstxt', array( 'robotstxt' => apply_filters( 'msrtm_append_rules', $sitemap_data ) ), '', 'no' );
                    }

                    // Return Home
                    restore_current_blog();
                }

                // Switch To Network
                switch_to_blog( '1' );

                // Clear Out Old Network Data
                apply_filters( 'msrtm_clean_network', false );

                // Clear Out Old Website Data
                apply_filters( 'msrtm_clean_websites', false );

                // Return Home
                restore_current_blog();
            }
        }


        /**
         * Remove Old Plugin Network Options
         * 
         * @return void
         */
        final public function cleanNetwork()
        {
            // Switch To Network
            switch_to_blog( '1' );

            // Remove Options
            remove_filter( 'robots_txt', array( 'msrtm_robots_txt', 'msrtm_show_robots_txt' ) );
            delete_option( 'ms_robotstxt_default' );
            delete_option( 'ms_robotstxt_sitemap' );
            delete_option( 'msrtm_plugin_check' );
            delete_option( 'msrtm_rules_check' );
            delete_option( 'ms_robotstxt' );

            // Return Home
            restore_current_blog();
        }


        /**
         * Remove Old Plugin Options From All Websites
         * 
         * @return void
         */
        final public function cleanWebsites()
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

                // Remove Old Website Options
                remove_filter( 'robots_txt', array( 'msrtm_robots_txt', 'msrtm_show_robots_txt' ) );
                delete_option( 'ms_robotstxt_default' );
                delete_option( 'ms_robotstxt_sitemap' );
                delete_option( 'msrtm_plugin_check' );
                delete_option( 'msrtm_rules_check' );
                delete_option( 'ms_robotstxt' );

                // Return Home
                restore_current_blog();
            }

                // Switch To Network
                switch_to_blog( '1' );

                // Recheck To Make Sure Everything Is Clear
                apply_filters( 'msrtm_final_check', false );

                // Return Home
                restore_current_blog();
        }


        /**
         * Detect Old Network Option
         * 
         * @return void
         */
        final public function detectOldNetworkOption()
        {
            // Switch To Root
            switch_to_blog( '1' );

            $return = ( get_option( "ms_robotstxt_default" ) ) ? true : false;

            // Return Home
            restore_current_blog();
            
            return $return;
        }


        /**
         * Detect New Network Option
         * 
         * @return void
         */
        final public function detectNewNetworkOption()
        {
            // Switch To Network
            switch_to_blog( '1' );

            $return = ( get_option( "ms_robotstxt_manager_network_robotstxt" ) ) ? true : false;

            // Return Home
            restore_current_blog();
            
            return $return;
        }


        /**
         * Detect Other Plugin Settings
         * 
         * @return void
         */
	final public function checkOtherPlugins()
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

                // Check For Options
                if( get_option( 'pc_robotstxt' ) || get_option( 'kb_robotstxt' ) || get_option( 'cd_rdte_content' ) ) { $warning = true; }

                // Return Home
                restore_current_blog();
            }

            // Switch To Network
            switch_to_blog( '1' );

            // Warning Old Plugin Data Found
            if( $warning === true ) {
                delete_option( 'msrtm_plugins_check' );
                add_option( 'ms_robotstxt_manager_plugin_check', '1', '', 'no' );
                
                // Throw Notice
                add_action( 'admin_notices', array( &$this, 'noticePlugins' ) );
                add_action( 'network_admin_notices', array( &$this, 'noticePlugins' ) );
            }

            // No Old Plugin Data Found
            if( $warning === false ) {
                delete_option( 'ms_robotstxt_manager_plugin_check' );
                add_option( 'ms_robotstxt_manager_plugin_check', '0', '', 'no' );
            }
        }


        /**
         * 
         * 
         * @return html
         */
        final public function noticePlugins()
        {
            echo '<div id="message" class="updated notice is-dismissible">';
            $this->echoForm( 'clean_plugins', false );
            echo '<p><b>' . __( 'Left Over Robots.txt Files Found', 'multisite-robotstxt-manager' ) . '</b>: ' . __( 'Click the button to automatically remove robots.txt files left by other plugins.', 'multisite-robotstxt-manager' ) . ': ';
            echo $this->echoSubmit( __( 'remove old data', 'multisite-robotstxt-manager' ) ) . '</p>';
            $this->echoForm( false, true );
            echo '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
        }


        /**
         * Remove Other Plugin Settings
         * 
         * @return void
         */
        final public function cleanOtherPlugins()
        {
            // If Clean Plugins Button Post
            if ( filter_input( INPUT_POST, 'ms_robotstxt_manager' ) == "clean_plugins" ) {
                // Form Security Check
                do_action( 'msrtm_validate_action' );

                global $wpdb;

                // Get blog ID's
                $site_list = $wpdb->get_results( "SELECT blog_id FROM $wpdb->blogs ORDER BY blog_id" );

                // Update Network
                foreach ( $site_list as $site ) {
                    // Ignore If Site Empty
                    if ( empty( $site ) ) { continue; }

                    // Switch To Each Website
                    switch_to_blog( $site->blog_id );

                    // Remove Old Plugin Settings
                    delete_option( 'pc_robotstxt' );
                    delete_option( 'kb_robotstxt' );
                    delete_option( 'cd_rdte_content' );
                    remove_action( 'do_robots', 'do_robots' );
                    remove_filter( 'robots_txt', 'cd_rdte_filter_robots' );
                    remove_filter( 'robots_txt', 'ljpl_filter_robots_txt' );
                    remove_filter( 'robots_txt', 'robots_txt_filter' );

                    // Return Home
                    restore_current_blog();
                }
            }
        }


        /**
         * Check If rewrite_rules Option Is Valid
         * 
         * @return void
         */
	final public function checkBadRewrite() {
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

                // Check If Rule Within Rewrite Rules Array
                if( ! in_array( "index.php?robots=1", (array) $rules ) ) { $warning = true; }

                // Return Home
                restore_current_blog();
            }

            // Switch To Network
            switch_to_blog( '1' );

            // Bad Rewrite Rules
            if( $warning === true ) {
                delete_option( 'ms_robotstxt_manager_rewrite_check' );
                add_option( 'ms_robotstxt_manager_rewrite_check', '1', '', 'no' );
                
                // Throw Notice
                add_action( 'admin_notices', array( &$this, 'noticeRewrite' ) );
                add_action( 'network_admin_notices', array( &$this, 'noticeRewrite' ) );
            }

            // Good Rule Found
            if( $warning === false ) {
                delete_option( 'ms_robotstxt_manager_rewrite_check' );
                add_option( 'ms_robotstxt_manager_rewrite_check', '0', '', 'no' );
            }
        }


        /**
         * Missing Robost.txt File Rules Notice
         * 
         * @return html
         */
        final public function noticeRewrite()
        {
            echo '<div id="message" class="updated notice is-dismissible">';
            $this->echoForm( 'clean_rewrite', false );
            echo '<p><b>' . __( 'Missing Robots.txt Rewrite Rule', 'multisite-robotstxt-manager' ) . '</b>: ' . __( 'Click the button to automatically correct the missing robots.txt rewrite rule.', 'multisite-robotstxt-manager' ) . ': ';
            echo $this->echoSubmit( __( 'update rewrite rules', 'multisite-robotstxt-manager' ) ) . '</p>';
            $this->echoForm( false, true );
            echo '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
        }


        /**
         * Remove rewrite_rules Options & Robots.txt Keys
         * 
         * @return void
         */
        final public function cleanBadRules()
        {
            // If Clean Plugins Button Post
            if ( filter_input( INPUT_POST, 'ms_robotstxt_manager' ) == "clean_rewrite" ) {
                // Form Security Check
                do_action( 'msrtm_validate_action' );

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
                    $get_rules = get_option( 'rewrite_rules' );

                    // Flush Rules If Needed
                    if( empty( $get_rules ) ) { $wp_rewrite->flush_rules(); }

                    // Get Fresh Option Array
                    $rules = get_option( 'rewrite_rules' );

                    // If Rule In Array
                    if( ! in_array( "index.php?robots=1", (array) $rules ) ) {
                        // Set Proper Keys
                        $rule_key = "robots\.txt$";
                        $rules[ $rule_key ] = 'index.php?robots=1';

                        // Update Rules
                        update_option( 'rewrite_rules', $rules );
                    }

                    // Return Home
                    restore_current_blog();
                }
            }
        }


        /**
         * Extension Upgrade Check
         * 
         * @return void
         */
        final public function checkExtension()
        {
            if ( get_option( 'msrtm' ) ) {
                add_action( 'admin_notices', array( &$this, 'noticeExtension' ) );
                add_action( 'network_admin_notices', array( &$this, 'noticeExtension' ) );
            }
        }


        /**
         * Admin Area Upgrade Notice
         * 
         * @return html
         */
        final public function noticeExtension()
        {
            echo '<div id="message" class="updated notice is-dismissible"><p><b>' . __( 'Upgrade Notice' ) . '</b>: ' . __( 'MSRTM PRO failed to automatically upgrade - a new version is ready! Please contact us for download instructions.', 'multisite-robotstxt-manager' ) . '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
        }
    }
}
