<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * Admin Area Display & Functionality
 */
if ( ! class_exists( 'MsRobotstxtManager_Admin' ) )
{
    class MsRobotstxtManager_Admin extends MsRobotstxtManager_Helper
    {
        // Website URL: get_bloginfo( 'url' )
        private $base_url;

        // The plugin_root_name
        private $plugin_name;
        
        // Plugin filename.php
        private $plugin_file;
        
        // Current Plugin Version
        private $plugin_version;
        
        // Plugin Menu name
        private $menu_name;
        
        // Path To Plugin Templates
        private $templates;

        // Plugin Extension
        public $msrtm;

        // Disable Plugin Features
        private $disabler;


        /**
         * Set Class Vars
         */
        function __construct( array $args = null )
        {
            // Require Array
            if( ! is_array( $args ) ) { return; }

            // Set Vars
            $this->base_url         = $args['base_url'];
            $this->plugin_name      = $args['plugin_name'];
            $this->plugin_file      = $args['plugin_file'];
            $this->plugin_version   = $args['plugin_version'];
            $this->menu_name        = $args['menu_name'];
            $this->templates        = $args['templates'];
        }


        /**
         * Init Admin Functions & Filters
         * 
         * @return void
         */
        final public function initAdmin()
        {
            // Website Menu Link
            add_action( 'admin_menu', array( &$this, 'displayMenu' ) );

            // Network Menu Link
            add_action( 'network_admin_menu', array( &$this, 'displayMenu' ) );

            // Append Website Rules To Robots.txt File
            add_filter( 'msrtm_append_rules', array( &$this, 'appendRobotstxt') );

            // Update Website
            add_filter( 'msrtm_update_website', array( &$this, 'updateWebsite') );

            // Update Network
            add_filter( 'msrtm_update_network', array( &$this, 'updateNetwork') );

            // Update Network Robots.txt With Preset Robots.txt File
            add_filter( 'msrtm_preset_network', array( &$this, 'presetNetwork') );

            // Extended Class: Ge Network Robots.txt File
            add_filter( 'msrtm_network_robotstxt', array( &$this, 'getNetworkRobotstxt') );

            // Extended Class: Get Website Robots.txt File
            add_filter( 'msrtm_website_robotstxt', array( &$this, 'getWebsiteRobotstxt') );

            // Extended Class: Get Website Append Data
            add_filter( 'msrtm_website_append', array( &$this, 'getWebsiteAppend') );

            // Extended Class: Current Plugin Status
            add_filter( 'msrtm_plugin_status', array( &$this, 'getPluginStatus') );

            // Extended Class: Website Uplaod Path
            add_filter( 'msrtm_upload_path', array( &$this, 'getUploadPath') );

            // Extended Class: Active Theme Path
            add_filter( 'msrtm_theme_path', array( &$this, 'getThemePath') );

            // Extended Class: Website Sitemap URL
            add_filter( 'msrtm_sitemap_url', array( &$this, 'getSitemapUrl') );

            // Plugin Extension
            if ( defined( 'MSRTM' ) ) { $this->msrtm = new MSRTM_Extension(); }

            // Only If Page Is Plugin Admin Area
            if ( filter_input( INPUT_GET, 'page', FILTER_UNSAFE_RAW ) == $this->plugin_name ) {
                // Admin Area Protection
                add_action( 'admin_init', array( &$this, 'protectAdmin' ) );

                // Disable / Delete Features
                add_action( 'admin_init', array( &$this, 'initDisabler' ) );

                // Add CSS
                add_action( 'admin_enqueue_scripts', array( &$this, 'loadScripts' ) );

                // Set Post Action Redirect
                if ( filter_input( INPUT_POST, 'ms_robotstxt_manager' ) ) {
                    //add_action( 'wp_loaded', array( &$this, 'pluginRedirect' ) );
                }
            }
        }


        /**
         * Init Disabler Class & Filters
         * 
         * @return void
         */
        final public function initDisabler()
        {
            // Disable Plugin / Delete Plugin Settings
            $this->disabler = new MsRobotstxtManager_Disabler();

            // Disable Network Action
            add_filter( 'msrtm_disable_network', array( $this->disabler, 'disableNetwork') );

            // Disable Website Action
            add_filter( 'msrtm_disable_website', array( $this->disabler, 'disableWebsite') );

            // Delete Network Action
            add_filter( 'msrtm_delete_network', array( $this->disabler, 'deleteNetwork') );
        }


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
                case 'presetupdated':
                    $message = __( '<u>Preset Option Updated</u>: The preset has been saved as the network robots.txt file. Click the "update network" button to publish the robots.txt file across the network.' );
                break;
                case 'websiteupdated':
                    $message = __( '<u>Website Settings Updated</u>: ' );
                break;
                case 'networkuserupdated':
                    $message = __( '<u>Blogs You Are Member Of Have Been Updated</u>: The saved network robots.txt file has been published to allowed websites.' );
                break;
                case 'networkglobalupdated':
                    $message = __( '<u>All Network Websites Have Been Updated</u>: The saved network robots.txt file has been published to all websites.' );
                break;
            }

            // Throw Message
            if ( ! empty( $message ) ) {
                add_settings_error( $slug, $slug, $message, $type );
            }
        }


        /**
         * Redirect To Plugin Admin
         * 
         * @return void
         */
        final public function pluginRedirect()
        {
            // Network Redirect
            if ( is_network_admin() ) {
                $url = $this->base_url . '/wp-admin/network/settings.php?page=' . $this->plugin_name;

            }

            // Website Redirect
            if ( is_admin() && ! is_network_admin() ) {
                $url = $this->base_url . '/wp-admin/options-general.php?page=' . $this->plugin_name;
            }

            // Return JS
            echo '<script type="text/javascript">';
            echo 'document.location.href="' . $url . '";';
            echo '</script>';
        }


        /**
         * Display Admin Templates
         * 
         * @return html
         */
        final public function displayAdmin()
        {
            global $blog_id;

            //
            // Update Plugin
            //

            // Update Network Robots.txt File
            apply_filters( 'msrtm_update_network', $blog_id );

            // Update Website Robots.txt File
            apply_filters( 'msrtm_update_website', false );

            // Save Preset For Network Robots.txt File
            apply_filters( 'msrtm_preset_network', false );

            // Network: Disable / Delete Across Network
            do_action( 'msrtm_disable_network' );
            do_action( 'msrtm_delete_network' );

            // Website: Disable Plugin
            do_action( 'msrtm_disable_website' );

            // Update Network Settings
            if ( defined( 'MSRTM' ) ) { apply_filters( 'msrtm_network_settings', false ); }


            //
            // Template Variables
            //

            // Network Textarea Display: Get Network Robots.txt File
            $get_network_robotstxt = apply_filters( 'msrtm_network_robotstxt', false );

            // Website Textarea: Get A Websites Append Data For Robots.txt File
            $get_website_append_data = apply_filters( 'msrtm_website_append', $blog_id );

            // Website Textarea: Get A Websites Unique Robots.txt File
            $get_website_robotstxt = apply_filters( 'msrtm_website_robotstxt', $blog_id );

            // Website Input Field: Get Upload Path/Dir For This Website
            $get_upload_path = apply_filters( 'msrtm_upload_path', $blog_id );

            // Website Input Field: Get Active Theme Path
            $get_theme_path = apply_filters( 'msrtm_theme_path', $blog_id );

            // Website Input Field: Get Sitemap URL
            $get_sitemap_url = apply_filters( 'msrtm_sitemap_url', $blog_id );

            // Admin Header
            require_once( $this->templates .'/header.php' );

            // Switch Between Tabs
            switch ( filter_input( INPUT_GET, 'tab', FILTER_UNSAFE_RAW ) ) {
                case 'home':
                default:
                    // Home Tab Template
                    require_once( $this->templates .'/home.php' );
                break;
            }

            // Admin Footer
            require_once( $this->templates .'/footer.php' );
        }


        /**
         * Display Textarea With Robots.txt File
         * 
         * @param string $robotstxt_file robots.txt file
         * @param int $textarea_cols number of columns in textarea
         * @param int $textarea_rows nubmer of rows in textarea
         * @param bool $readonly true to endable
         * @return html
         */
        final private function echoTextarea( $robotstxt_file, $textarea_cols, $textarea_rows, $readonly = false )
        {
            // Define Textarea Settings
            $cols = is_numeric( $textarea_cols ) ? $textarea_cols : '65';
            $rows = is_numeric( $textarea_rows ) ? $textarea_rows : '25';

            // If Set, Display Robots.txt File
            $file = ( ! empty( $robotstxt_file ) ) ? htmlspecialchars( $robotstxt_file ) : '';

            // Readonly Marker
            $readonly_html = $readonly === true ? ' readonly' : '';
            $readonly_name = $readonly === true ? '_readonly' : '';

            // Return Textarea
            echo '<textarea name="robotstxt_file' . $readonly_name . '" cols="' . $cols . '" rows="' . $rows . '" class="textarea"' .  $readonly_html . '>' . $file . '</textarea>';
        }


        /**
         * Display Preset Radios
         * 
         * @return html
         */
        final private function echoPresets()
        {
            // Switch to Current Website
            switch_to_blog( '1' );

            // Selected Preset, If Any
            $selected_preset = get_option( 'ms_robotstxt_manager_network_preset' ) ? get_option( 'ms_robotstxt_manager_network_preset' ) : false;

            // Return To Previous Website
            restore_current_blog();

            // Input Radio Data
            $inputs = array(
                'default'       => __( 'Default Robots.txt File: The plugins default installed robots.txt file.', 'multisite-robotstxt-manager' ),
                'default-alt'   => __( 'Alternative Robots.txt File: Simular to the plugins default robots.txt file, with more disallows.', 'multisite-robotstxt-manager' ),
                'wordpress'     => __( 'Wordpress Limited Robots.txt File: Only disallows wp-includes and wp-admin.', 'multisite-robotstxt-manager' ),
                'open'          => __( 'Open Robots.txt File: Fully open robots.txt file, no disallows.', 'multisite-robotstxt-manager' ),
                'blogger'       => __( 'A Bloggers Robots.txt File: Optimized for blog focused Wordpress websites.', 'multisite-robotstxt-manager' ),
                'google'        => __( 'Google Robots.txt File: A Google friendly robots.txt file.', 'multisite-robotstxt-manager' ),
                'block'         => __( 'Lockdown Robots.txt File: Disallow everything, prevent spiders from indexing the website.', 'multisite-robotstxt-manager' )
            );

            // Start HTML
            $html = '<h3>' . __( 'Robots.txt File Presets', 'multisite-robotstxt-manager' ) . '</h3>';

            // Create Radios
            foreach( $inputs as $input => $desc ) {
                // Preset Input
                $html .= '<p><input type="radio" name="preset" value="' . $input . '" id="' . $input . '" />';

                // Set Active Preset
                if ( $selected_preset == $input ) {
                    $html .= '<span class="showing">' . __( 'Showing!', 'multisite-robotstxt-manager' ) . '</span>';
                }

                // Label For Input
                $html .= ' <label for="' . $input . '">' . $desc . '</label></p>';
            }

            // Submit Button / Close Form
            $html .= '<p><input type="submit" name="submit" value=" save as network default " style="margin-top:15px;" /></p>';
            $html .= '</form>';

            // Return The HTML
            echo $html;
        }


        /**
         * Display Disable / Delete Checkboxes
         * 
         * @return string
         */
        final private function echoRemoves()
        {
            // Get The Plugins Status Based On The Admin Area
            $status = $this->getPluginStatus();

            // Website Disable
            if ( is_admin() && ! is_network_admin() && $status ) {
                echo '<p class="textright"><label>' . __( 'Disable the saved robots.txt file on this website, restoring the default Wordpress robots.txt file.', 'multisite-robotstxt-manager' ) . '</label> <input type="checkbox" name="disable" value="website" /></p>';
                echo '<p class="textright"><input type="submit" name="submit" value=" submit " style="margin-top:15px;" onclick="return confirm(\'' . __( "Are You Sure You Want To Submit This?", "multisite-robotstxt-manager" ) . '\');" /></p>';
            }

            // Network Disable
            if ( is_network_admin() && $status ) {
                echo '<p class="textright"><label>' . __( 'Disable saved robots.txt files across all network websites, restoring the default Wordpress robots.txt file.', 'multisite-robotstxt-manager' ) . '</label> <input type="checkbox" name="disable" value="network" /></p>';
            }

            // Network Delete
            if ( is_network_admin() ) {
                echo '<p class="textright"><label>' . __( 'WARNING: Delete all settings related to the Multisite Robots.txt Manager Plugin across the entire network.', 'multisite-robotstxt-manager' ) . '</label> <input type="checkbox" name="disable" value="all" /></p>';
            echo '<p class="textright"><input type="submit" name="submit" value=" submit " style="margin-top:15px;" onclick="return confirm(\'' . __( "Are You Sure You Want To Submit This?", "multisite-robotstxt-manager" ) . '\');" /></p>';
            }

            // Submit Button / Close Form
            echo '</form>';
        }


        /**
         * Extend Setting Options
         * 
         * @return html
         */
        final private function echoSettings()
        {
            if ( defined( 'MSRTM_PRO' ) && is_plugin_active( MSRTM_PRO ) ) {
                return $this->msrtm->extendSettings();
            }
        }


        /**
         * Display Plugin Status Messages
         * 
         * @return html
         */
        final private function statusMessages()
        {
            // Get The Plugins Status Based On The Admin Area
            $status = $this->getPluginStatus();

            // Network : Plugin Active
            if ( is_network_admin() && $status ) {
                $html = '<p><span class="active">' . __( 'Multisite Robots.txt Manager is Active', 'multisite-robotstxt-manager' ) . '</span>: ' . __( "The robots.txt file template below is currently being used across all active network websites. The saved robots.txt file rules for each website will replace the {APPEND_WEBSITE_ROBOTSTXT} marker.", 'multisite-robotstxt-manager' ) . '</p>';
            }

            // Network : Plugin Inactive
            if ( is_network_admin() && ! $status ) {
                $html = '<p><span class="inactive">' . __( 'Multisite Robots.txt Manager is Disabled', 'multisite-robotstxt-manager' ) . '</span>: ' . __( "All network websites are currently displaying the default Wordpress robots.txt file. To enable, click the 'update network' button below.", 'multisite-robotstxt-manager' ) . '</p>';
            }

            // Website : Plugin Active
            if ( is_admin() && ! is_network_admin() && $status ) {
                $html = '<p><span class="active">' . __( 'Multisite Robots.txt Manager is Active', 'multisite-robotstxt-manager' ) . '</span>: ' . sprintf( __( '<a href="%1$s/robots.txt" target="_blank">Click here</a> to view this websites customized robots.txt file.', 'multisite-robotstxt-manager' ), $this->base_url ) . '</p>';
            }

            // Website : Plugin Inactive
            if ( is_admin() && ! is_network_admin() && ! $status ) {
                $html = '<p><span class="inactive">' . __( 'Multisite Robots.txt Manager is Disabled', 'multisite-robotstxt-manager' ) . '</span>: ' . sprintf( __( '<a href="%1$s/robots.txt" target="_blank">Click here</a> to view this websites default Wordpress robots.txt file.', 'multisite-robotstxt-manager' ), $this->base_url ) . '</p>';
            }

            // Return HTML
            return $html = isset( $html ) ? $html : '';
        }


        /**
         * Saves A Preset As The Network Robots.txt File
         * 
         * @return void
         */
        final public function presetNetwork()
        {
            if ( filter_input( INPUT_POST, 'ms_robotstxt_manager' ) == "presets" ) {
                // Form Security Check
                do_action( 'msrtm_validate_action' );

                // Define Preset Var
                $preset = filter_input( INPUT_POST, 'preset', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

                // Change To Root Website
                switch_to_blog( '1' );

                // Clear Settings
                delete_option( 'ms_robotstxt_manager_network' );
                delete_option( 'ms_robotstxt_manager_network_robotstxt' );
                delete_option( "ms_robotstxt_manager_network_preset" );
                delete_option( "ms_robotstxt_manager_network_status" );

                // Enable Network
                add_option( "ms_robotstxt_manager_network_status", '1', '', "no" );

                // Get Preset Robots.txt Files Class
                $preset_robotstxt_file = new MsRobotstxtManager_Presets();

                // Default Robots.txt Preset
                if ( $preset == "default" ) {
                    // Update Robots.txt File
                    add_option( 'ms_robotstxt_manager_network_robotstxt', array( 'robotstxt' => $preset_robotstxt_file->defaultRobotstxt() ), '', "no" );

                    // Define Preset Being Used
                    add_option( 'ms_robotstxt_manager_network_preset', 'default', '', "no" );
                }

                // Default Alt Robots.txt Preset
                if ( $preset == "default-alt" ) {
                    // Update Robots.txt File
                    add_option( 'ms_robotstxt_manager_network_robotstxt', array( 'robotstxt' => $preset_robotstxt_file->defaultAltRobotstxt() ), '', "no" );

                    // Define Preset Being Used
                    add_option( 'ms_robotstxt_manager_network_preset', 'default-alt', '', "no" );
                }

                // Wordpress Limited Robots.txt Preset
                if ( $preset == "wordpress" ) {
                    // Update Robots.txt File
                    add_option( 'ms_robotstxt_manager_network_robotstxt', array( 'robotstxt' => $preset_robotstxt_file->wordpressRobotstxt() ), '', "no" );

                    // Define Preset Being Used
                    add_option( 'ms_robotstxt_manager_network_preset', 'wordpress', '', "no" );
                }

                // Open Robots.txt Preset
                if ( $preset == "open" ) {
                    // Update Robots.txt File
                    add_option( 'ms_robotstxt_manager_network_robotstxt', array( 'robotstxt' => $preset_robotstxt_file->openRobotstxt() ), '', "no" );

                    // Define Preset Being Used
                    add_option( 'ms_robotstxt_manager_network_preset', 'open', '', "no" );
                }

                // Blogger Style Robots.txt Preset
                if ( $preset == "blogger" ) {
                    // Update Robots.txt File
                    add_option( 'ms_robotstxt_manager_network_robotstxt', array( 'robotstxt' => $preset_robotstxt_file->bloggerRobotstxt() ), '', "no" );

                    // Define Preset Being Used
                    add_option( 'ms_robotstxt_manager_network_preset', 'blogger', '', "no" );
                }

                // Blocked Robots.txt Preset
                if ( $preset == "block" ) {
                    // Update Robots.txt File
                    add_option( 'ms_robotstxt_manager_network_robotstxt', array( 'robotstxt' => $preset_robotstxt_file->blockedRobotstxt() ), '', "no" );

                    // Define Preset Being Used
                    add_option( 'ms_robotstxt_manager_network_preset', 'block', '', "no" );
                }

                // Google Robots.txt Preset
                if ( $preset == "google" ) {
                    // Update Robots.txt File
                    add_option( 'ms_robotstxt_manager_network_robotstxt', array( 'robotstxt' => $preset_robotstxt_file->googleRobotstxt() ), '', "no" );

                    // Define Preset Being Used
                    add_option( 'ms_robotstxt_manager_network_preset', 'google', '', "no" );
                }

                // Return To Previous Website
                restore_current_blog();

                // Display Message
                $this->throwMessage( 'presetupdated', 'updated' );
            }
        }


        /**
         * Update a Websites Robots.txt File
         * 
         * @param int $blog_id current websites id
         * @return void
         */
        final public function updateWebsite( $blog_id )
        {
            // Post: Update Network Robots.txt File
            if ( filter_input( INPUT_POST, 'ms_robotstxt_manager' ) == "website" ) {
                // Form Security Check
                do_action( 'msrtm_validate_action' );

                // Filter Robots.txt File
                $append_rules_post = filter_input( INPUT_POST, 'robotstxt_file', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
                $website_append_rules = ( ! empty( $append_rules_post ) ) ? $append_rules_post : '';

                switch_to_blog( $blog_id );

                // Clear Saved Options
                delete_option( 'ms_robotstxt_manager_append' );
                delete_option( 'ms_robotstxt_manager_robotstxt' );
                delete_option( 'ms_robotstxt_manager_status' );

                // Enable Plugin For Website
                add_option( "ms_robotstxt_manager_status", '1', '', "no" );

                // Update Append Data For Robots.txt File
                add_option( 'ms_robotstxt_manager_append', array( 'robotstxt' => $website_append_rules ), '', "no" );

                // Update Robots.txt File
                add_option( 'ms_robotstxt_manager_robotstxt', array( 'robotstxt' => apply_filters( 'msrtm_append_rules', $website_append_rules ) ), '', "no" );

                // Return To Current Website
                restore_current_blog();

                // Display Message
                $this->throwMessage( 'websiteupdated', 'updated' );
            }
        }


        /**
         * Update Network Robots.txt File / Network Wide
         * 
         * @return void
         */
        final public function updateNetwork()
        {
            // Post: Update Network Robots.txt File
            if ( filter_input( INPUT_POST, 'ms_robotstxt_manager' ) == "network" ) {
                // Form Security Check
                do_action( 'msrtm_validate_action' );

                // Filter Robots.txt File
                $robotstxt_file_post = filter_input( INPUT_POST, 'robotstxt_file', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
                $robotstxt_file = ( ! empty( $robotstxt_file_post ) ) ? $robotstxt_file_post : '';

                // Switch to root website
                switch_to_blog( '1' );

                // Clear Saved Settings
                delete_option( 'ms_robotstxt_manager_network_robotstxt' );
                delete_option( 'ms_robotstxt_manager_network_status' );
                delete_option( "ms_robotstxt_manager_network_preset" );

                // Update Robots.txt File
                add_option( 'ms_robotstxt_manager_network_robotstxt', array( 'robotstxt' => $robotstxt_file ), '', "no" );

                // Enable Network
                add_option( "ms_robotstxt_manager_network_status", '1', '', "no" );

                global $wpdb, $current_user;

                // Update Blogs This Admin Is A Member Of Only
                if ( filter_input( INPUT_POST, 'update_method' ) == "user" || filter_input( INPUT_POST, 'update_method' ) === null ) {

                    // Current Admin User
                    $current_user = wp_get_current_user();
                    $this_admin_user = $current_user->ID;

                    // Blog IDs For This User
                    $users_blogs = get_blogs_of_user( $this_admin_user );

                    // Update Allowed Blogs
                    foreach ( $users_blogs as $users_blog_id ) {
                        // Switch To Each Website
                        switch_to_blog( $users_blog_id->userblog_id );

                        // Update Website
                        $this->updateNetworkWebsites();
                    }

                    // Display Message
                    $this->throwMessage( 'networkuserupdated', 'updated' );
                }

                // Update All Network Websites
                if ( filter_input( INPUT_POST, 'update_method' ) == "network" ) {
                    // Get blog ID's
                    $site_list = $wpdb->get_results( "SELECT blog_id FROM $wpdb->blogs WHERE public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' ORDER BY blog_id" );

                    // Update Network
                    foreach ( $site_list as $site ) {
                        // Ignore If Site Empty
                        if ( empty( $site ) ) { continue; }

                        // Switch To Each Website
                        switch_to_blog( $site->blog_id );

                        // Update Website
                        $this->updateNetworkWebsites();
                    }

                    // Display Message
                    $this->throwMessage( 'networkglobalupdated', 'updated' );
                }
            }
        }


        /**
         * Network Wide Website Settings
         * 
         * @return void
         */
        final private function updateNetworkWebsites()
        {
            // Get Robots.txt File Data To Append
            $get_website_append = get_option( 'ms_robotstxt_manager_append' );
            $website_append_rules = $get_website_append['robotstxt'];

            // Clear Previous Data
            delete_option( 'ms_robotstxt_manager_robotstxt' );
            delete_option( 'ms_robotstxt_manager_status' );

            // Enable Plugin For Website
            add_option( "ms_robotstxt_manager_status", '1', '', "no" );

            // Update Robots.txt File
            add_option( 'ms_robotstxt_manager_robotstxt', array( 'robotstxt' => apply_filters( 'msrtm_append_rules', $website_append_rules ) ), '', "no" );

            // Return To Root Site
            restore_current_blog();
        }


        /**
         * Protect Admin Area From Lower Users
         * 
         * @return void
         */
	final public function protectAdmin()
        {
            // Nobody Can Access
            $user_can_access = false;

            // Authorized Users Can Access
            if ( current_user_can( 'edit_posts' ) ) {
                $user_can_access = true;
            }

            // Redirect Invalid Users
            if ( ! $user_can_access ) {
                wp_safe_redirect( admin_url( 'index.php' ) );
                exit;
            }
	}


        /**
         * Include CSS
         * 
         * @return void
         */
        function loadScripts()
        {
            // Register the CSS File
            wp_register_style(
                $this->plugin_name . '-default',
                plugins_url( '/templates/style.css', $this->plugin_file ),
                '',
                $this->plugin_version,
                'all'
            );

            // Add CSS To Header
            wp_enqueue_style( $this->plugin_name . '-default' );
        }


        /**
         * Valid Users and Settings Menu
         * 
         * @return void
         */
        final public function displayMenu()
        {
            // Logged in users only
            if( !is_user_logged_in() ) { return; }

            // Website Admin Menu
            if( is_user_member_of_blog() && is_admin() ) {
                add_options_page(
                        $this->menu_name,
                        $this->menu_name,
                        'manage_options',
                        $this->plugin_name,
                        array( &$this, 'displayAdmin' )
                );
            }

            // Website Admin Menu
            if( is_super_admin() && is_network_admin() ) {
                add_submenu_page(
                        'settings.php',
                        $this->menu_name,
                        $this->menu_name,
                        'manage_options',
                        $this->plugin_name,
                        array( &$this, 'displayAdmin' )
                );
            }
        }
    }
}
