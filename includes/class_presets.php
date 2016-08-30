<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * Preset Robots.txt Files
 */
if ( ! class_exists( 'MsRobotstxtManager_Presets' ) )
{
    class MsRobotstxtManager_Presets
    {
        /**
         * Default Robots.txt File
         * 
         * @return string
         */
        public function defaultRobotstxt()
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
         * Default-Alt Robots.txt File
         * 
         * @return string
         */
	public function defaultAltRobotstxt()
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
         * Wordpress Only Robots.txt File
         * 
         * @return string
         */
	public function wordpressRobotstxt()
        {
            $txt = "# robots.txt\n";
            $txt .= "User-agent: *\n";
            $txt .= "Disallow: /wp-admin/\n";
            $txt .= "Disallow: /wp-includes/";
            $txt .= "Allow: /wp-admin/admin-ajax.php\n";
            $txt .= "{APPEND_WEBSITE_ROBOTSTXT}";

            return $txt;
	}


        /**
         * Open Robots.txt File
         * 
         * @return string
         */
	public function openRobotstxt()
        {
            $txt = "# robots.txt\n";
            $txt .= "User-agent: *\n";
            $txt .= "Disallow:";

            return $txt;
	}


        /**
         * Blogger Robots.txt File
         * 
         * @return string
         */
	public function bloggerRobotstxt()
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
         * Disallow Website Robots.txt File
         * 
         * @return string
         */
	public function blockedRobotstxt()
        {
            $txt = "# robots.txt\n";
            $txt .= "User-agent: *\n";
            $txt .= "Disallow: /";

            return $txt;
	}


        /**
         * Google Friendly Robots.txt File
         * 
         * @return string
         */
	public function googleRobotstxt()
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
            $txt .= "Allow: /wp-content/uploads\n";
            $txt .= "Allow: /wp-content/uploads/\n";
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
    }
}