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

use MsRobotstxtManager\Get_Robotstxt_Rules as GetRobotstxtRules;
use MsRobotstxtManager\Option_Manager as OptionManager;

/**
 * Build Website Append Rules
 */
final class Pro_Build_Append_Rules {
	/**
	 * Option_Manager Class.
	 *
	 * @var object
	 */
	public $option_manager = [];

	/**
	 * WordPress Upload Path.
	 *
	 * @var string
	 */
	public $upload_path = [];

	/**
	 * Current Theme Path.
	 *
	 * @var string
	 */
	public $theme_path = [];

	/**
	 * Website Sitemap URL.
	 *
	 * @var string
	 */
	public $sitemap_url = [];


	/**
	 * Setup Class
	 */
	public function __construct() {
		$this->option_manager = new OptionManager();

		$robotstxt_rules   = new GetRobotstxtRules();
		$this->upload_path = $robotstxt_rules->get_uploadpath();
		$this->theme_path  = $robotstxt_rules->get_themepath();
		$this->sitemap_url = $robotstxt_rules->get_sitemapurl();
	}//end __construct()


	/**
	 * Build Append Rules
	 *
	 * @param int $site_id Network Site ID.
	 */
	public function init( $site_id = '' ) {
		/*
		 * Retrieve an option value for the current network based on name of option.
		 * https://developer.wordpress.org/reference/functions/get_site_option/
		 */
		$pro_site_option = $this->option_manager->get_site_option( '-pro' );

		// Not Enabled.
		if ( true === empty( $pro_site_option['network_upload_path'] ) && true === empty( $pro_site_option['network_theme_path'] ) && true === empty( $pro_site_option['network_sitemap_url'] ) ) {
			return;
		}

		// Maybe Switch Blogs.
		if ( true !== empty( $site_id ) ) {
			/*
			 * Switch the current blog.
			 * https://developer.wordpress.org/reference/functions/switch_to_blog/
			 */
			switch_to_blog( $site_id );
		}

		$website_option = $this->option_manager->get_option();

		// Ignore If Disabled or Append Rules Already Set.
		if ( true !== empty( $website_option['disable'] ) ) {
			return;
		}

		// Clear Rules.
		$website_option['append'] = '';

		if ( true !== empty( $pro_site_option['network_upload_path'] ) && true !== empty( $this->upload_path ) ) {
			$website_option['append'] .= $this->upload_path . "\n";
		}

		if ( true !== empty( $pro_site_option['network_theme_path'] ) && true !== empty( $this->theme_path ) ) {
			$website_option['append'] .= $this->theme_path . "\n";
		}

		if ( true !== empty( $pro_site_option['network_sitemap_url'] ) && true !== empty( $this->sitemap_url ) ) {
			$website_option['append'] .= $this->sitemap_url . "\n";
		}

		if ( true !== empty( $website_option['append'] ) ) {
			$this->option_manager->update_option( $website_option );
		}

		if ( true !== empty( $site_id ) ) {
			/*
			 * Restore the current blog, after calling switch_to_blog
			 * https://developer.wordpress.org/reference/functions/restore_current_blog/
			 */
			restore_current_blog();
		}
	}


	/**
	 * Build Sitemap Rule
	 *
	 * @param int $site_id Website ID.
	 *
	 * @return string $sitemap_url Robots.txt Rule
	 */
	public function get_sitemap_url( $site_id = '' ) {
		// Clear URL.
		$url = '';

		// Set Blog ID.
		$blog_id = ( true === empty( $site_id ) ) ? get_current_blog_id() : $site_id;

		/*
		 * Switch the current blog.
		 * https://developer.wordpress.org/reference/functions/switch_to_blog/
		 */
		switch_to_blog( $blog_id );

		// Set Site URL.
		$site_url = get_site_url( $blog_id );

		// No fopen, Check Rewrite Rules.
		if ( false === ini_get( 'allow_url_fopen' ) ) {
			/*
			 * Retrieves an option value based on an option name.
			 * https://developer.wordpress.org/reference/functions/get_option/
			 */
			$rules = get_option( 'rewrite_rules' );

			// Check Sitemap Rule Within Rewrite Rules Array.
			if ( true === array_key_exists( 'sitemap\.xml$', (array) $rules ) || true === array_key_exists( 'sitemap(-+([a-zA-Z0-9_-]+))?\.xml$', (array) $rules ) ) {
				$url = $site_url . '/sitemap.xml';
			}
		}

		// No fopen, URL Not Set, Check For Physical File.
		if ( true === empty( $url ) && false === ini_get( 'allow_url_fopen' ) ) {
			/*
			 * Get the absolute filesystem path to the root of the WordPress installation.
			 * https://developer.wordpress.org/reference/functions/get_home_path/
			 */
			if ( true === file_exists( get_home_path() . 'sitemap.xml' ) ) {
				$url = $site_url . '/sitemap.xml';
			} elseif ( true === file_exists( get_home_path() . 'wp-content/plugins/xml-sitemap-generator/sitemap.xml' ) ) {
				$url = $site_url . '/wp-content/plugins/xml-sitemap-generator/sitemap.xml';
			} elseif ( true === file_exists( get_home_path() . 'wp-content/uploads/ap-sitemap/sitemap-ap-monthly-index.xml' ) ) {
				$url = $site_url . '/wp-content/uploads/ap-sitemap/sitemap-ap-monthly-index.xml';
			} elseif ( true === file_exists( get_home_path() . 'sitemap_' . str_replace( '.', '_', preg_replace( '(^https?://)', '', $site_url ) ) . '.xml' ) ) {
				$url = $site_url . '/sitemap_' . str_replace( '.', '_', preg_replace( '(^https?://)', '', $site_url ) ) . '.xml';
			}
		}

		// URL Not Set & fopen Allowed.
		if ( true === empty( $url ) && false !== ini_get( 'allow_url_fopen' ) ) {
			// Sitemap Files To Check.
			$sitemaps = [
				'wpms-sitemap_' . str_replace( '.', '_', preg_replace( '(^https?://)', '', $site_url ) ) . '.xml',
				'sitemap_' . str_replace( '.', '_', preg_replace( '(^https?://)', '', $site_url ) ) . '.xml',
				'sitemaps/sitemaps.xml',
				'sitemaps/sitemap.xml',
				'sitemap/sitemaps.xml',
				'sitemap/sitemap.xml',
				'sitemap_index.xml',
				'xmlsitemap.xml',
				'sitemaps.xml',
				'sitemap.xml',
			];

			// Loop Through Sitemap Names.
			foreach ( $sitemaps as $sitemap ) {
				$get_headers = get_headers( $site_url . '/' . $sitemap );

				if ( isset( $get_headers[0] ) && strpos( $get_headers[0], '200 OK' ) !== false ) {
					$url = $site_url . '/' . $sitemap;
				}
			}
		}

		/*
		 * Restore the current blog, after calling switch_to_blog.
		 * https://developer.wordpress.org/reference/functions/restore_current_blog/
		 */
		restore_current_blog();

		// Return the url or empty if no sitemap.
		return ( ! empty( $url ) ) ? 'Sitemap: ' . $url : '';
	}
}//end class
