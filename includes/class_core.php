<?php
if( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * Plugin Core
 */
if ( ! class_exists( 'MsRobotstxtManager_Core' ) )
{
    class MsRobotstxtManager_Core
    {
        // Plugin Base Name: plugin_basename( __FILE__ )
        private $plugin_base = MS_ROBOTSTXT_MANAGER_PLUGIN_BASE;

        // The plugin_root_name
        private $plugin_name = MS_ROBOTSTXT_MANAGER_PLUGIN_NAME;
        
        // Plugin filename.php
        private $plugin_file = MS_ROBOTSTXT_MANAGER_PLUGIN_FILE;

        // Minimum Wordpress Version
        private $wp_min_version = MS_ROBOTSTXT_MANAGER_WP_MIN_VERSION;

        // Current URL
        private $request_uri;


        /**
         * Run Plugin
         * 
         * @return void
         */
        public function __construct()
        {
            // Localize
            load_plugin_textdomain( 'multisite-robotstxt-manager', false, dirname( plugin_basename( $this->plugin_file ) ) . '/languages' );

            // Set Validation Filter: do_action( 'msrtm_validate_action' );
            add_filter( 'msrtm_validate_action', array( &$this, 'validateActions' ) );

            // Plugin Upgrade Check
            add_action( 'wp_loaded', array( &$this, 'upgradeCheck' ) );

            // Get Current URI
            $this->request_uri = filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL );

            // Inject Links Into Plugin Admins
            if ( strpos( $this->request_uri, "plugins.php" ) !== false ){
                add_filter( 'plugin_row_meta', array( &$this, 'links' ), 10, 2 );
            }

            // Activate Plugin
            register_activation_hook( $this->plugin_file, array( 'MsRobotstxtManager_Core', 'activate' ) );
        }


        /**
         * Validate Form Access
         * 
         * @return void
         */
        public final function validateActions()
        {
            // Plugin Admin Area Only
            if ( filter_input( INPUT_GET, 'page', FILTER_UNSAFE_RAW ) != $this->plugin_name ) {
                wp_die( __( 'You are not authorized to perform this action.', 'multisite-robotstxt-manager' ) );
            }

            // Validate Nonce Action
            if( ! check_admin_referer( $this->plugin_name . '_action', $this->plugin_name . '_nonce' ) ) {
                wp_die( __( 'You are not authorized to perform this action.', 'multisite-robotstxt-manager' ) );
            }
        }


        /**
         * Activate Plugin: Validate Plugin & Install Default Features
         * 
         * @return void
         */
        final public static function activate()
        {
            // Wordpress Version Check
            global $wp_version;

            // Multisite Networks Only
            if( ! function_exists( 'switch_to_blog' ) ) {
                wp_die( __( 'Activation Failed: The "Multisite Robots.txt Manager" Plugin can only be activated on Network Enabled Wordpress installs. Download and install the plugin, "Robots.txt Manager" for standalone Wordpress installs.', 'multisite-robotstxt-manager' ) );
            }

            // Network Activate Only
            if( ! is_network_admin() ) {
                wp_die( __( 'Activation Failed: The "Multisite Robots.txt Manager" Plugin can only be activated within the Network Admin.', 'multisite-robotstxt-manager' ) );
            }

            // Version Check
            if( version_compare( $wp_version, MS_ROBOTSTXT_MANAGER_WP_MIN_VERSION, "<" ) ) {
                wp_die( __( 'This plugin requires WordPress ' . MS_ROBOTSTXT_MANAGER_WP_MIN_VERSION . ' or higher. Please Upgrade Wordpress, then try activating this plugin again.', 'multisite-robotstxt-manager' ) );
            }
        }


        /**
         * Inject Plugin Links
         * 
         * @return array
         */
        public final function links( $links, $file )
        {
            if( $file == $this->plugin_base ) {
                if( is_network_admin() ) {
                    $links[] = '<a href="settings.php?page=' . $this->plugin_name . '">'. __( 'Network Settings', 'multisite-robotstxt-manager' ) .'</a>';
                } else {
                    $links[] = '<a href="options-general.php?page=' . $this->plugin_name . '">'. __( 'Website Settings', 'multisite-robotstxt-manager' ) .'</a>';
                }
                $links[] = '<a href="http://technerdia.com/msrtm/#faq" target="_blank">'. __( 'F.A.Q.', 'multisite-robotstxt-manager' ) .'</a>';
                $links[] = '<a href="http://technerdia.com/help/" target="_blank">'. __( 'Support', 'multisite-robotstxt-manager' ) .'</a>';
                $links[] = '<a href="http://technerdia.com/feedback/" target="_blank">'. __( 'Feedback', 'multisite-robotstxt-manager' ) .'</a>';
                $links[] = '<a href="http://technerdia.com/donate/" target="_blank">'. __( 'Donations', 'multisite-robotstxt-manager' ) .'</a>';
                $links[] = '<a href="http://technerdia.com/msrtm/" target="_blank">'. __( 'PRO Details', 'multisite-robotstxt-manager' ) .'</a>';
            }

            return $links;
        }


        /**
         * Plugin Upgrade Check
         * 
         * @return void
         */
        public final function upgradeCheck()
        {
            if ( get_option( 'msrtm' ) ) {
                add_action( 'admin_notices', array( &$this, 'upgradeNotice' ) );
                add_action( 'network_admin_notices', array( &$this, 'upgradeNotice' ) );
            }
        }


        /**
         * Admin Area Upgrade Notice
         * 
         * @return html
         */
        public final function upgradeNotice()
        {
            echo '<div id="message" class="updated notice is-dismissible"><p><b>' . __( 'Upgrade Notice' ) . '</b>: ' . __( 'MSRTM PRO failed to automatically upgrade - a new version is ready! Please contact us for download instructions.', 'multisite-robotstxt-manager' ) . '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
        }
    }
}