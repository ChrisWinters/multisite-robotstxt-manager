<?php
/**
 * Manager Class
 *
 * @package    WordPress
 * @subpackage Plugin
 * @author     Chris W. <chrisw@null.net>
 * @license    GNU GPLv3
 * @link       /LICENSE
 */

namespace MsRobotstxtManager;

if ( false === defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build Robots.txt Rule Statements
 */
final class Get_Robotstxt_Rules {
	/**
	 * Get the Upload Path Rule
	 *
	 * @return string
	 */
	public function get_uploadpath() {
		// Get Upload Dir For This Website.
		$upload_dir = wp_upload_dir( null, false, true );

		if ( true === empty( $upload_dir['basedir'] ) ) {
			return esc_html__( 'Upload Path Not Set', 'multisite-robotstxt-manager' );
		}

		// Split The Path.
		$contents = explode( 'uploads', $upload_dir['basedir'] );

		// Return The Path.
		return 'Allow: /wp-content/uploads' . end( $contents ) . '/';
	}


	/**
	 * Get Theme Path Rule
	 *
	 * @return string
	 */
	public function get_themepath() {
		// Build Path For Theme.
		$path_to_themes = get_stylesheet_directory();
		$theme_path     = 'Allow: ' . strstr( $path_to_themes, '/wp-content/themes' ) . '/';

		return $theme_path;
	}


	/**
	 * Get Website Sitemap URL Rule
	 *
	 * @return string
	 */
	public function get_sitemapurl() {
		// Get Site URL.
		$sitemap_url_base = get_option( 'siteurl' ) ? get_option( 'siteurl' ) : MS_ROBOTSTXT_MANAGER_BASE_URL;

		if ( true === file_exists( $sitemap_url_base . '/sitemap.xml' ) ) {
			$root_xml_file_location = get_headers( $sitemap_url_base . '/sitemap.xml' );
		}

		if ( true === file_exists( $sitemap_url_base . '/sitemaps/sitemap.xml' ) ) {
			$alt_xml_file_location = get_headers( $sitemap_url_base . '/sitemaps/sitemap.xml' );
		}

		// Check if xml sitemap exists.
		if ( true === isset( $root_xml_file_location[0] ) && 'HTTP/1.1 200 OK' === $root_xml_file_location[0] ) {
			// http://domain.com/sitemap.xml.
			$url = $sitemap_url_base . '/sitemap.xml';
		} elseif ( true === isset( $alt_xml_file_location[0] ) && 'HTTP/1.1 200 OK' === $alt_xml_file_location[0] ) {
			// http://domain.com/sitemaps/sitemap.xml.
			$url = $sitemap_url_base . '/sitemaps/sitemap.xml';
		} else {
			$url = '';
		}

		// Return the url or empty if no sitemap.
		return ( ! empty( $url ) ) ? 'Sitemap: ' . $url : '';
	}
}//end class
