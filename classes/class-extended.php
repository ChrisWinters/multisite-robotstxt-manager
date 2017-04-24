<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }

/**
 * @about Core Manager Class
 * 
 * @method __construct()            Set Parent Variables
 * @method message()                Display Messages To User
 * @method status()                 Get The Current Status Of The Plugin
 * @method getNetworkRobotstxt()    Get Root/Network Robots.txt File
 * @method getWebsiteRobotstxt()    Get A Websites Unique Robots.txt File
 * @method getAppendRules()         Get A Websites Append Rules For Robots.txt File
 * @method getUploadPath()          Get the Upload Path
 * @method getThemePath()           Get the Theme Path Within Allow Statement
 * @method getSitemapUrl()          Get the Sitemap URL
 * @method getSettings()            Extend Setting Options
 * @method qString()                Get Query String Item
 * @method validate()               Form Validation
 */
if( ! class_exists( 'MsRobotstxtManager_Extended' ) )
{
    class MsRobotstxtManager_Extended
    {
        // Website URL
        public $base_url;

        // The plugin-slug-name
        public $plugin_name;
        
        // Plugin Page Title
        public $plugin_title;
        
        // Plugin filename.php
        public $plugin_file;
        
        // Current Plugin Version
        public $plugin_version;
        
        // Plugin Menu Name
        public $menu_name;
        
        // Path To Plugin Templates
        public $templates;

        // Base Option Name
        public $option_name;


        /**
         * @about Set Class Vars
         */
        function __construct()
        {
            // Set Vars
            $this->base_url         = MS_ROBOTSTXT_MANAGER_BASE_URL;
            $this->plugin_name      = MS_ROBOTSTXT_MANAGER_PLUGIN_NAME;
            $this->plugin_title     = MS_ROBOTSTXT_MANAGER_PAGE_NAME;
            $this->plugin_file      = MS_ROBOTSTXT_MANAGER_PLUGIN_FILE;
            $this->plugin_version   = MS_ROBOTSTXT_MANAGER_VERSION;
            $this->menu_name        = MS_ROBOTSTXT_MANAGER_MENU_NAME;
            $this->templates        = MS_ROBOTSTXT_MANAGER_TEMPLATES;
            $this->option_name      = MS_ROBOTSTXT_MANAGER_OPTION_NAME;

            // Plugin Extension: Version 3.0.0
            if ( ! defined( 'MSRTM_TEMPLATES' ) && defined( 'MSRTM' ) ) { $this->msrtm = new MSRTM_Extension(); }
        }


        /**
         * @about Display Messages To User
         * @param string $slug Which switch to load
         * @param string $notice_type Either updated/error
         */
        final public function message( $slug, $notice_type = false )
        {
            // Clear Message
            $message = '';

            // Message Switch
            switch ( $slug ) {
                case 'presetupdated':
                    $message = __( '<u>Preset Updated</u>: The preset robots.txt has been saved as the network robots.txt file. You need to publish your changes for network websites to use the newly saved network robots.txt file.', 'multisite-robotstxt-manager' );
                break;

                case 'presetfailed':
                    $message = __( '<u>Error</u>: Preset robots.txt file failed to update.', 'multisite-robotstxt-manager' );
                break;

                case 'networkrobotstxtsaved':
                    $message = __( '<u>Saved</u>: The network robots.txt file has been saved.', 'multisite-robotstxt-manager' );
                break;

                case 'networkmemberupdated':
                    $message = __( '<u>Success</u>: The saved network robots.txt file has been published to allowed websites.', 'multisite-robotstxt-manager' );
                break;

                case 'networkglobalupdated':
                    $message = __( '<u>Success</u>: The saved network robots.txt file has been published to all network websites.', 'multisite-robotstxt-manager' );
                break;

                case 'networkfailed':
                    $message = __( '<u>Error</u>: Network settings failed to update.', 'multisite-robotstxt-manager' );
                break;

                case 'disablenetwork':
                    $message = __( '<u>Network Disabled</u>: The Multisite Robots.txt Manager plugin is no longer managing robots.txt files across network websites.', 'multisite-robotstxt-manager' );
                break;

                case 'deletenetwork':
                    $message = __( '<u>Settings Deleted</u>: All Multisite Robots.txt Manager plugin settings have been removed across the network.', 'multisite-robotstxt-manager' );
                break;

                case 'disablewebsite':
                    $message = __( '<u>Website Disabled</u>: The Multisite Robots.txt Manager Plugin is no longer managing the robots.txt file on this website.', 'multisite-robotstxt-manager' );
                break;

                case 'disablefailed':
                    $message = __( '<u>Notice</u>: No settings disabled or deleted!', 'multisite-robotstxt-manager' );
                break;

                case 'websiteupdated':
                    $message = __( '<u>Success</u>: The robots.txt file has been updated.', 'multisite-robotstxt-manager' );
                break;

                case 'noappendrules':
                    $message = __( '<u>Notice</u>: No robots.txt rules or append rules found!', 'multisite-robotstxt-manager' );
                break;

                case 'noolddata':
                    $message = __( '<u>Network Is Clean</u>: No old data found.', 'multisite-robotstxt-manager' );
                break;

                case 'yesolddata':
                    $message = __( '<u>Warning</u>: Old robots.txt file data found! Scroll down and click the "remove old data" button to remove the old data.', 'multisite-robotstxt-manager' );
                break;

                case 'norewrite':
                    $message = __( '<u>Warning</u>: Missing robots.txt rewrite rule! Scroll down and click the "correct missing rules" button to add the missing rule.', 'multisite-robotstxt-manager' );
                break;

                case 'yesrewrite':
                    $message = __( '<u>Network Is Clean</u>: All network websites have the proper rewrite rule.', 'multisite-robotstxt-manager' );
                break;

                case 'nophysical':
                    $message = __( '<u>Network Is Clean</u>: A physical robots.txt file was not found.', 'multisite-robotstxt-manager' );
                break;

                case 'yesphysical':
                    $message = __( '<u>Warning</u>: A real robots.txt file was found at the websites root directory. Scroll down and click the "delete physical file" to delete the real robots.txt file.', 'multisite-robotstxt-manager' );
                break;

                case 'badphysical':
                    $message = __( '<u>Warning</u>: The plugin was unable to delete the robots.txt file due to file permissions. You will need to manually delete the real robots.txt file.', 'multisite-robotstxt-manager' );
                break;
            
                case 'disabledefault':
                    $message = __( '<u>Success</u>: The network robots.txt file disabled on this website, you can now fully customize the robots.txt file. No changes to the robots.txt file has been made. You need to create your robots.txt file below, the click the "update website rules" button to change the robots.txt file.', 'multisite-robotstxt-manager' );
                break;
            
                case 'enabledefault':
                    $message = __( '<u>Success</u>: The network robots.txt file on this website has been enabled, restoring the default behavior. No changes to the robots.txt file has been made. You need to modify the append rules below, the click the "update website rules" button to change the robots.txt file.', 'multisite-robotstxt-manager' );
                break;
            }

            // Throw Message
            if ( ! empty( $message ) ) {
                // Set Message Type, Default Error
                $type = ( $notice_type == "updated" ) ? "updated" : "error";

                // Return Message
                add_settings_error( $slug, $slug, $message, $type );
            }
        }


        /**
         * @about Get The Current Status Of The Plugin
         * 
         * @return bool
         */
        final public function status()
        {
            // Default Status
            $status = false;

            // Network Admin Status
            if ( is_network_admin() ) {

                // Change To Network
                switch_to_blog( '1' );

                // Get Plugin Status
                $status = get_option( $this->option_name . 'network_status' ) ? true : false;

                // Return To Previous Website
                restore_current_blog();
            }

            // Website Status
            if ( is_admin() && ! is_network_admin() ) {
                global $blog_id;

                // Switch Through Websites
                switch_to_blog( $blog_id );

                // Get Plugin Status
                $status = get_option( $this->option_name . 'status' ) ? true : false;

                // Return To Previous Website
                restore_current_blog();
            }

            return $status;
        }


        /**
         * @about Get Root/Network Robots.txt File
         * @return string $robotstxt Network Robots.txt File
         */
        final public function getNetworkRobotstxt()
        {
            // Switch to Network
            switch_to_blog( '1' );

            // Get Websites Robots.txt File
            if ( get_option( $this->option_name . 'network_robotstxt' ) ) {
                $option = get_option( $this->option_name . 'network_robotstxt' );
            }

            // Return To Previous Website
            restore_current_blog();

            // Return Robots.txt or Return Empty
            return $robotstxt = isset( $option[ 'robotstxt' ] ) ? $option[ 'robotstxt' ] : '';
        }


        /**
         * @about Get A Websites Unique Robots.txt File
         * @return string $robotstxt Websites Robots.txt File
         */
        final public function getWebsiteRobotstxt()
        {
            // Switch to Current Website
            switch_to_blog( get_current_blog_id() );

            // Get Websites Robots.txt File
            if ( get_option( $this->option_name . 'robotstxt' ) ) {
                $option = get_option( $this->option_name . 'robotstxt' );
            }

            // Return To Previous Website
            restore_current_blog();

            // Return Robots.txt or Return Empty
            return $robotstxt = isset( $option[ 'robotstxt' ] ) ? $option[ 'robotstxt' ] : '';
        }


        /**
         * @about Get A Websites Append Rules For Robots.txt File
         * @return string $rules The Append Rules
         */
        final public function getAppendRules()
        {
            // Switch to Current Website
            switch_to_blog( get_current_blog_id() );

            // Get Websites Robots.txt File
            if ( get_option( $this->option_name . 'append' ) ) {
                $option = get_option( $this->option_name . 'append' );
            }

            // Return To Previous Website
            restore_current_blog();

            // Return Robots.txt or Return Empty
            return $rules = isset( $option[ 'robotstxt' ] ) ? $option[ 'robotstxt' ] : '';
        }


        /**
         * @about Build Upload Path Rule
         * @param int $blogid Website ID
         * @return string $upload_path Robots.txt Rule
         */
        final public function getUploadPath( $blogid = false )
        {
            $blog_id = ( ! $blogid ) ? get_current_blog_id() : $blogid;

            // Switch to Current Website
            switch_to_blog( $blog_id );

            // Get Upload Dir For This Website
            $upload_dir = wp_upload_dir( null, false, true );

            // Split The Path
            $contents = explode( 'uploads', $upload_dir['basedir'] );

            // Return To Previous Website
            restore_current_blog();

            // Return The Path
            $allow = 'Allow: /wp-content/uploads' . end( $contents ) . '/';
            return $upload_path = ( ! empty( $upload_dir['basedir'] ) ) ? $allow : 'Upload Path Not Set';
        }


        /**
         * @about Build Theme Path Rule
         * @param int $blogid Website ID
         * @return string $theme_path Robots.txt Rule
         */
        final public function getThemePath( $blogid = false )
        {
            $blog_id = ( ! $blogid ) ? get_current_blog_id() : $blogid;

            // Switch to Current Website
            switch_to_blog( $blog_id );

            // Build Path For Theme
            $path_to_themes = get_stylesheet_directory();
            $theme_path = 'Allow: ' . strstr( $path_to_themes, '/wp-content/themes' ) . '/';

            // Return To Previous Website
            restore_current_blog();

            // Return The Path
            return $theme_path;
        }


        /**
         * @about Build Sitemap Rule
         * @param int $blogid Website ID
         * @return string $sitemap_url Robots.txt Rule
         */
        final public function getSitemapUrl( $blogid = false )
        {
            // Clear URL
            $url = '';

            // Switch to Current Website
            switch_to_blog( $blogid );

            // Set Blog ID
            $blog_id = ( ! $blogid ) ? get_current_blog_id() : $blogid;

            // Set Site URL
            $site_url = get_site_url( $blog_id );

            // No fopen, Check Rewrite Rules
            if ( ! ini_get( 'allow_url_fopen' ) ) {
                // Get Rewrite Rules
                $rules = get_option( 'rewrite_rules' );

                // Check Sitemap Rule Within Rewrite Rules Array
                if( array_key_exists( "sitemap\.xml$", (array) $rules ) || array_key_exists( "sitemap(-+([a-zA-Z0-9_-]+))?\.xml$", (array) $rules ) ) {
                    $url = $site_url . '/sitemap.xml';
                }
            }

            // No fopen, URL Not Set, Check For Physical File
            if ( empty( $url ) && ! ini_get( 'allow_url_fopen' ) ) {
                if ( file_exists( get_home_path() . 'sitemap.xml' ) ) {
                    $url = $site_url . '/sitemap.xml';

                } elseif ( file_exists( get_home_path() . 'wp-content/plugins/xml-sitemap-generator/sitemap.xml' ) ) {
                    $url = $site_url . '/wp-content/plugins/xml-sitemap-generator/sitemap.xml';

                } elseif ( file_exists( get_home_path() . 'wp-content/uploads/ap-sitemap/sitemap-ap-monthly-index.xml' ) ) {
                    $url = $site_url . '/wp-content/uploads/ap-sitemap/sitemap-ap-monthly-index.xml';

                } elseif ( file_exists( get_home_path() . 'sitemap_' . str_replace( '.', '_', preg_replace( '(^https?://)', '', $site_url ) ) . '.xml' ) ) {
                    $url = $site_url . '/sitemap_' . str_replace( '.', '_', preg_replace( '(^https?://)', '', $site_url ) ) . '.xml';
                }
            }

            // URL Not Set & fopen Allowed
            if ( empty( $url ) && ini_get( 'allow_url_fopen' ) ) {
                // Sitemap Files To Check
                $sitemaps = array(
                    'sitemap.xml',
                    'sitemaps.xml',
                    'xmlsitemap.xml',
                    'sitemap_index.xml',
                    'sitemap/sitemap.xml',
                    'sitemap/sitemaps.xml',
                    'sitemaps/sitemap.xml',
                    'sitemaps/sitemaps.xml',
                    'sitemap_' . str_replace( '.', '_', preg_replace( '(^https?://)', '', $site_url ) ) . '.xml',
                    'wpms-sitemap_' . str_replace( '.', '_', preg_replace( '(^https?://)', '', $site_url ) ) . '.xml',
                );

                // Loop Through Sitemap Names
                foreach ( $sitemaps as $sitemap ) {
                    $get_headers = get_headers( $site_url . '/' . $sitemap );

                    if ( isset( $get_headers[0] ) && strpos( $get_headers[0], '200 OK' ) !== false ) {
                        $url = $site_url . '/' . $sitemap;
                    }
                }
            }

            // Return To Previous Website
            restore_current_blog();

            // Return the url or empty if no sitemap
            return $sitemap_url = ( ! empty( $url ) ) ? 'Sitemap: ' . $url : '';
        }


        /**
         * @about Extend Setting Options
         */
        final public function getSettings()
        {
            // Version 4.0.0
            if ( defined( 'MSRTM_TEMPLATES' ) && is_plugin_active( 'msrtm-pro/msrtm-pro.php' ) && file_exists( MSRTM_TEMPLATES . '/settings.php' ) ) {
                $plugincheck = ( ! get_option( 'msrtm_api_form' ) && get_option( 'msrtm_key' ) ) ? true : false;
                include_once( MSRTM_TEMPLATES . '/settings.php' );
            }

            // Plugin Extension: Version 3.0.0
            if ( ! defined( 'MSRTM_TEMPLATES' ) && defined( 'MSRTM_PRO' ) && is_plugin_active( 'msrtm-pro/msrtm-pro.php' ) ) {
                return $this->msrtm->extendSettings();
            }
        }


        /**
         * @about Get Query String Item
         * @param string $get Query String Get Item
         * @return string Query String Item Sanitized
         */
        final public function qString( $get )
        {
            // Lowercase & Sanitize String
            $filter = strtolower( filter_input( INPUT_GET, $get, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK ) );

            // Return No Spaces/Tabs, Stripped/Cleaned String
            return sanitize_text_field( preg_replace( '/\s/', '', $filter ) );
        }


        /**
         * @about Form Validation
         */
        final public function validate()
        {
            // Plugin Admin Area Only
            if ( filter_input( INPUT_GET, 'page', FILTER_UNSAFE_RAW ) != $this->plugin_name ) {
                wp_die( __( 'You are not authorized to perform this action.', 'multisite-robotstxt-manager' ) );
            }

            // Validate Nonce Action
            if( ! check_admin_referer( $this->option_name . 'action', $this->option_name . 'nonce' ) ) {
                wp_die( __( 'You are not authorized to perform this action.', 'multisite-robotstxt-manager' ) );
            }
        }
    }
}
