<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }


/**
 * Admin Area Helper Functions
 */
if ( ! class_exists( 'MsRobotstxtManager_Helper' ) )
{
    class MsRobotstxtManager_Helper
    {
        /**
         * Inject Website Robots.txt File Rules Into Network Robots.txt File
         * 
         * @param string $append_robotstxt_rules a websites robots.txt append rules
         * @return string
         */
        final public function appendRobotstxt( $append_robotstxt_rules )
        {
            $find_replace = array(
                '{APPEND_WEBSITE_ROBOTSTXT}' => ( $append_robotstxt_rules = empty( $append_robotstxt_rules ) ? '' : $append_robotstxt_rules )
            );

            // Return Replaced String
            return str_replace( array_keys( $find_replace ), array_values( $find_replace ), $this->getNetworkRobotstxt() );
        }


        /**
         * Get Root/Network Robots.txt File
         * 
         * @return string
         */
        final public function getNetworkRobotstxt()
        {
            // Switch to Network
            switch_to_blog( '1' );

            // Get Websites Robots.txt File
            if ( get_option( 'ms_robotstxt_manager_network_robotstxt' ) ) {
                $robotstxt_array = get_option( 'ms_robotstxt_manager_network_robotstxt' );
                $robotstxt = $robotstxt_array[ 'robotstxt' ];
            }

            // Return To Previous Website
            restore_current_blog();

            // Return Robots.txt or Return Empty
            return $robotstxt = isset( $robotstxt ) ? $robotstxt : '';
        }


        /**
         * Get A Websites Unique Robots.txt File
         * 
         * @param int $blog_id current website id
         * @return string
         */
        final public function getWebsiteRobotstxt( $blog_id )
        {
            // Switch to Current Website
            switch_to_blog( $blog_id );

            // Get Websites Robots.txt File
            if ( get_option( 'ms_robotstxt_manager_robotstxt' ) ) {
                $array = get_option( 'ms_robotstxt_manager_robotstxt' );
                $robotstxt = $array[ 'robotstxt' ];
            }

            // Return To Previous Website
            restore_current_blog();

            // Return Robots.txt or Return Empty
            return $robotstxt = isset( $robotstxt ) ? $robotstxt : '';
        }


        /**
         * Get A Websites Append Data For Robots.txt File
         * 
         * @param int $blog_id current website id
         * @return string
         */
        final public function getWebsiteAppend( $blog_id )
        {
            // Switch to Current Website
            switch_to_blog( $blog_id );

            // Get Websites Robots.txt File
            if ( get_option( 'ms_robotstxt_manager_append' ) ) {
                $array = get_option( 'ms_robotstxt_manager_append' );
                $robotstxt = $array[ 'robotstxt' ];
            }

            // Return To Previous Website
            restore_current_blog();

            // Return Robots.txt or Return Empty
            return $robotstxt = isset( $robotstxt ) ? $robotstxt : '';
        }


        /**
         * Get The Current Status Of The Plugin
         * 
         * @return bool
         */
        final public function getPluginStatus()
        {
            // Default Status
            $status = false;

            // Network Admin Status
            if ( is_network_admin() ) {

                // Change To Network
                switch_to_blog( '1' );

                // Get Plugin Status
                $status = get_option( 'ms_robotstxt_manager_network_status' ) ? true : false;

                // Return To Previous Website
                restore_current_blog();
            }

            // Website Status
            if ( is_admin() && ! is_network_admin() ) {
                global $blog_id;

                // Switch Through Websites
                switch_to_blog( $blog_id );

                // Get Plugin Status
                $status = get_option( 'ms_robotstxt_manager_status' ) ? true : false;

                // Return To Previous Website
                restore_current_blog();
            }

            return $status;
        }


        /**
         * Get and Retrn the Theme Path Within Allow Statement
         * 
         * @param int $blog_id current website id
         * @return html
         */
        final public function getThemePath( $blog_id )
        {
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
         * Get and Retrn the Upload Path
         * 
         * @param int $blog_id current website id
         * @return html
         */
        final public function getUploadPath( $blog_id )
        {
            // Switch to Current Website
            switch_to_blog( $blog_id );

            // Get Upload Dir For This Website
            $upload_dir = wp_upload_dir();

            // Split The Path
            $contents = explode( 'uploads', $upload_dir['basedir'] );

            // Return To Previous Website
            restore_current_blog();

            // Return The Path
            $allow = 'Allow: /wp-content/uploads' . end( $contents ) . '/';
            return $upload_path = ( ! empty( $upload_dir['basedir'] ) ) ? $allow : 'Upload Path Not Set';
        }


        /**
         * Get and Retrn the Sitemap URL
         * 
         * @param int $blog_id current website id
         * @return html
         */
        final public function getSitemapUrl( $blog_id )
        {
            // Switch to Current Website
            switch_to_blog( $blog_id );

            // Get Site URL
            $sitemap_url_base = get_option( 'siteurl' ) ? get_option( 'siteurl' ) : MS_ROBOTSTXT_MANAGER_BASE_URL;

            // Base XML File Locations To check
            $root_xml_file_location = get_headers( $sitemap_url_base . '/sitemap.xml' );
            $alt_xml_file_location = get_headers( $sitemap_url_base . '/sitemaps/sitemap.xml' );

            // Check if xml sitemap exists
            if ( $root_xml_file_location && $root_xml_file_location[0] == 'HTTP/1.1 200 OK' ) {
                // http://domain.com/sitemap.xml
                $url = $sitemap_url_base . '/sitemap.xml';

            } elseif ( $alt_xml_file_location && $alt_xml_file_location[0] == 'HTTP/1.1 200 OK' ) {
                // http://domain.com/sitemaps/sitemap.xml
                $url = $sitemap_url_base . '/sitemaps/sitemap.xml';
 
            } else {
                $url = '';
            }

            // Return To Previous Website
            restore_current_blog();

            // Return the url or empty if no sitemap
            return $sitemap_url = ( ! empty( $url ) ) ? 'Sitemap: ' . $url : '';
        }


        /**
         * Display Input Submit Button
         * 
         * @param string $text submit button value
         * @return html
         */
        final public function echoSubmit( $text )
        {
            // Define Button Text
            $button_text = ( ! empty( $text ) ) ? $text : 'submit';

            return '<input type="submit" name="submit" value=" ' . $button_text . ' " />';
        }


        /**
         * Display Form
         * 
         * @param string $location input post value
         * @param bool $close form close tag
         * @return html
         */
        final public function echoForm( $location, $close = false )
        {
            if ( $close === true ) {
                echo '</form>';
            } else {
                echo '<form enctype="multipart/form-data" method="post" action="">';
                echo '<input type="hidden" name="ms_robotstxt_manager" value="' . $location . '" />';
                wp_nonce_field( 'ms_robotstxt_manager_action', 'ms_robotstxt_manager_nonce' );
            }
        }
    }
}
