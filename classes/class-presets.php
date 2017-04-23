<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * @about Update Network Robots.txt File With Preset Robots.txt File
 * @location classes/class-process.php
 * @call MsRobotstxtManager_Presets::instance();
 * 
 * @method init()                   Update Network Robots.txt, Status & Preset Options
 * @method robotstxt()              Preset Robots.txt File
 * @method defaultRobotstxt()       Default Robots.txt File
 * @method defaultAltRobotstxt()    Default-Alt Robots.txt File
 * @method wordpressRobotstxt()     Wordpress Only Robots.txt File
 * @method openRobotstxt()          Open Robots.txt File
 * @method bloggerRobotstxt()       Blogger Robots.txt File
 * @method blockedRobotstxt()       Disallow Website Robots.txt File
 * @method googleRobotstxt()        Google Friendly Robots.txt File
 * @method instance()               Create Instance
 */
if ( ! class_exists( 'MsRobotstxtManager_Presets' ) )
{
    class MsRobotstxtManager_Presets extends MsRobotstxtManager_Extended
    {
        // Holds Instance Object
        protected static $instance = NULL;


        /**
         * @about Update Network Robots.txt, Status & Preset Options
         */
        final public function init()
        {
            // Get Post Data
            $post = filter_input( INPUT_POST, 'preset', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );

            // Allowed Presets
            $allowed = array( 'default', 'default-alt', 'wordpress', 'open', 'blogger', 'block', 'google' );

            // Clear Preset Type
            $type = '';

            // Validate Preset Type
            foreach ( $allowed as $value ) {
                if ( strpos( $post, $value ) !== false ) {
                    $type = $value;
                }
            }

            // If Preset Set
            if ( ! empty( $type ) ) {
                // Change To Root Website
                switch_to_blog( '1' );

                // Update Robots.txt File
                update_option( $this->option_name . 'network_robotstxt', array( 'robotstxt' => $this->robotstxt( $type ) ), 'no' );

                // Define Preset Being Used
                update_option( $this->option_name . 'network_preset', $type, 'no' );

                // Return To Previous Website
                restore_current_blog();

                // Display Message
                parent::message( 'presetupdated', 'updated' );

            } else {
                // Error Display Message
                parent::message( 'presetfailed', 'error' );
            }
        }


        /**
         * @about Get Preset Robots.txt File
         */
        final private function robotstxt( $type )
        {
            // Default Robots.txt Preset
            if ( $type == "default" ) {
                $robotstxt = $this->defaultRobotstxt();

            // Default Alt Robots.txt Preset
            } elseif ( $type == "default-alt" ) {
                $robotstxt = $this->defaultAltRobotstxt();
 
            // Wordpress Limited Robots.txt Preset
            } elseif ( $type == "wordpress" ) {
                $robotstxt = $this->wordpressRobotstxt();

            // Open Robots.txt Preset
            } elseif ( $type == "open" ) {
                $robotstxt = $this->openRobotstxt();

            // Blogger Style Robots.txt Preset
            } elseif ( $type == "blogger" ) {
                $robotstxt = $this->bloggerRobotstxt();

            // Blocked Robots.txt Preset
            } elseif ( $type == "block" ) {
                $robotstxt = $this->blockedRobotstxt();

            // Google Robots.txt Preset
            } elseif ( $type == "google" ) {
                $robotstxt = $this->googleRobotstxt();
            }

            return $robotstxt;
        }


        /**
         * @about Default Robots.txt File
         */
        final private function defaultRobotstxt()
        {
            $txt = "# robots.txt\n";
            $txt .= "User-agent: *\n";
            $txt .= "Disallow: /feed\n";
            $txt .= "Disallow: /feed/\n";
            $txt .= "Disallow: /cgi-bin/\n";
            $txt .= "Disallow: /comment\n";
            $txt .= "Disallow: /comments\n";
            $txt .= "Disallow: /trackback\n";
            $txt .= "Disallow: /comment/\n";
            $txt .= "Disallow: /comments/\n";
            $txt .= "Disallow: /trackback/\n";
            $txt .= "Disallow: /wp-admin/\n";
            $txt .= "Disallow: /wp-content/\n";
            $txt .= "Disallow: /wp-includes/\n";
            $txt .= "Disallow: /wp-login.php\n";
            $txt .= "Allow: /wp-admin/admin-ajax.php\n";
            $txt .= "{APPEND_WEBSITE_ROBOTSTXT}";

            return $txt;
        }


        /**
         * @about Default-Alt Robots.txt File
         */
        final private function defaultAltRobotstxt()
        {
            $txt = "# robots.txt\n";
            $txt .= "User-agent: *\n";
            $txt .= "Disallow: */feed\n";
            $txt .= "Disallow: */feed/\n";
            $txt .= "Disallow: */comment/\n";
            $txt .= "Disallow: */comments/\n";
            $txt .= "Disallow: */trackback/\n";
            $txt .= "Disallow: */comment\n";
            $txt .= "Disallow: */comments\n";
            $txt .= "Disallow: */trackback\n";
            $txt .= "Disallow: /feed\n";
            $txt .= "Disallow: /feed/\n";
            $txt .= "Disallow: /cgi-bin/\n";
            $txt .= "Disallow: /comment\n";
            $txt .= "Disallow: /comment/\n";
            $txt .= "Disallow: /comments\n";
            $txt .= "Disallow: /comments/\n";
            $txt .= "Disallow: /trackback\n";
            $txt .= "Disallow: /trackback/\n";
            $txt .= "Disallow: /wp-admin/\n";
            $txt .= "Disallow: /wp-content/\n";
            $txt .= "Disallow: /wp-includes/\n";
            $txt .= "Disallow: /wp-login.php\n";
            $txt .= "Allow: /wp-admin/admin-ajax.php\n";
            $txt .= "{APPEND_WEBSITE_ROBOTSTXT}";

            return $txt;
        }


        /**
         * @about Wordpress Only Robots.txt File
         */
        final private function wordpressRobotstxt()
        {
            $txt = "# robots.txt\n";
            $txt .= "User-agent: *\n";
            $txt .= "Disallow: /wp-admin/\n";
            $txt .= "Disallow: /wp-includes/\n";
            $txt .= "Allow: /wp-admin/admin-ajax.php\n";
            $txt .= "{APPEND_WEBSITE_ROBOTSTXT}";

            return $txt;
        }


        /**
         * @about Open Robots.txt File
         */
        final private function openRobotstxt()
        {
            $txt = "# robots.txt\n";
            $txt .= "User-agent: *\n";
            $txt .= "Disallow:";

            return $txt;
        }


        /**
         * @about Blogger Robots.txt File
         */
        final private function bloggerRobotstxt()
        {
            $txt = "# robots.txt\n";
            $txt .= "User-agent: *\n";
            $txt .= "Disallow: *?\n";
            $txt .= "Disallow: *.inc$\n";
            $txt .= "Disallow: *.php$\n";
            $txt .= "Disallow: */feed\n";
            $txt .= "Disallow: */feed/\n";
            $txt .= "Disallow: */author\n";
            $txt .= "Disallow: */comment/\n";
            $txt .= "Disallow: */comments/\n";
            $txt .= "Disallow: */trackback/\n";
            $txt .= "Disallow: */comment\n";
            $txt .= "Disallow: */comments\n";
            $txt .= "Disallow: */trackback\n";
            $txt .= "Disallow: /wp-\n";
            $txt .= "Disallow: /wp-*\n";
            $txt .= "Disallow: /feed\n";
            $txt .= "Disallow: /feed/\n";
            $txt .= "Disallow: /author\n";
            $txt .= "Disallow: /cgi-bin/\n";
            $txt .= "Disallow: /wp-admin/\n";
            $txt .= "Disallow: /comment/\n";
            $txt .= "Disallow: /comments/\n";
            $txt .= "Disallow: /trackback/\n";
            $txt .= "Disallow: /comment\n";
            $txt .= "Disallow: /comments\n";
            $txt .= "Disallow: /trackback\n";
            $txt .= "Disallow: /wp-admin/\n";
            $txt .= "Disallow: /wp-content/\n";
            $txt .= "Disallow: /wp-includes/\n";
            $txt .= "Disallow: /wp-login.php\n";
            $txt .= "Disallow: /wp-content/cache/\n";
            $txt .= "Disallow: /wp-content/themes/\n";
            $txt .= "Disallow: /wp-content/plugins/\n";
            $txt .= "Allow: /wp-admin/admin-ajax.php\n";
            $txt .= "{APPEND_WEBSITE_ROBOTSTXT}";

            return $txt;
        }


        /**
         * @about Disallow Website Robots.txt File
         */
        final private function blockedRobotstxt()
        {
            $txt = "# robots.txt\n";
            $txt .= "User-agent: *\n";
            $txt .= "Disallow: /";

            return $txt;
        }


        /**
         * @about Google Friendly Robots.txt File
         */
        final private function googleRobotstxt()
        {
            $txt = "# robots.txt\n";
            $txt .= "User-agent: *\n";
            $txt .= "Disallow: /wp-\n";
            $txt .= "Disallow: /feed\n";
            $txt .= "Disallow: /feed/\n";
            $txt .= "Disallow: /author\n";
            $txt .= "Disallow: /cgi-bin/\n";
            $txt .= "Disallow: /wp-admin/\n";
            $txt .= "Disallow: /comment/\n";
            $txt .= "Disallow: /comments/\n";
            $txt .= "Disallow: /trackback/\n";
            $txt .= "Disallow: /comment\n";
            $txt .= "Disallow: /comments\n";
            $txt .= "Disallow: /trackback\n";
            $txt .= "Disallow: /wp-content/\n";
            $txt .= "Disallow: /wp-includes/\n";
            $txt .= "Disallow: /wp-login.php\n";
            $txt .= "Disallow: /wp-content/cache/\n";
            $txt .= "Disallow: /wp-content/themes/\n";
            $txt .= "Disallow: /wp-content/plugins/\n";
            $txt .= "Allow: /wp-admin/admin-ajax.php\n";
            $txt .= "{APPEND_WEBSITE_ROBOTSTXT}";
            $txt .= "\n";
            $txt .= "# google bot\n";
            $txt .= "User-agent: Googlebot\n";
            $txt .= "Disallow: /wp-*\n";
            $txt .= "Disallow: *?\n";
            $txt .= "Disallow: *.inc$\n";
            $txt .= "Disallow: *.php$\n";
            $txt .= "Disallow: */feed\n";
            $txt .= "Disallow: */feed/\n";
            $txt .= "Disallow: */author\n";
            $txt .= "Disallow: */comment/\n";
            $txt .= "Disallow: */comments/\n";
            $txt .= "Disallow: */trackback/\n";
            $txt .= "Disallow: */comment\n";
            $txt .= "Disallow: */comments\n";
            $txt .= "Disallow: */trackback\n";
            $txt .= "\n";
            $txt .= "# google image bot\n";
            $txt .= "User-agent: Googlebot-Image\n";
            $txt .= "Allow: /*\n";

            return $txt;
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
