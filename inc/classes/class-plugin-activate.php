<?php
/**
 * WordPress Class
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
 * Activation Rules
 */
final class Plugin_Activate {

	/**
	 * Init Plugin Activation
	 */
	public static function init() {
		/*
		 * Retrieves the current WordPress version
		 * https://developer.wordpress.org/reference/functions/get_bloginfo/
		 */
		$wp_version = get_bloginfo( 'version' );

		if ( true === version_compare( $wp_version, 3.8, '<' ) ) {
			/*
			 * Kill WordPress execution and display HTML message with error message.
			 * https://developer.wordpress.org/reference/functions/wp_die/
			 *
			 * Escaping for HTML blocks.
			 * https://developer.wordpress.org/reference/functions/esc_html/
			 */
			wp_die( esc_html__( 'WordPress 3.8 is required. Please upgrade WordPress and try again.', 'multisite-robotstxt-manager' ) );
		}

		// Maybe Save Robots.txt As Plugin Robots.txt.
		self::set_robotstxt();

		// Skip Freemius Connection.
		msrtm_fs()->skip_connection( null, true );
	}//end init()


	/**
	 * Maybe Set Plugin Robots.txt
	 */
	public static function set_robotstxt() {
		/*
		 * Retrieve an option value for the current network based on name of option.
		 * https://developer.wordpress.org/reference/functions/get_site_option/
		 */
		$plugin_option = get_site_option( MS_ROBOTSTXT_MANAGER_PLUGIN_NAME );

		// Set Plugin Robots.txt From Website Robots.txt.
		if ( true === empty( $plugin_option ) && true !== empty( self::get_website_robotstxt() ) ) {
			/*
			 * Update the value of an option that was already added for the current network.
			 * https://developer.wordpress.org/reference/functions/update_site_option/
			 */
			update_site_option( MS_ROBOTSTXT_MANAGER_PLUGIN_NAME, self::get_website_robotstxt() );
		}

		// Set Plugin Robots.txt Based On Default WordPress robots.txt - Unable To Read Robots.txt.
		if ( true === empty( $plugin_option ) && true === empty( self::get_website_robotstxt() ) ) {
			$preset_robotstxt['robotstxt']  = "User-agent: *\n";
			$preset_robotstxt['robotstxt'] .= "Disallow: /wp-admin/\n";
			$preset_robotstxt['robotstxt'] .= "Allow: /wp-admin/admin-ajax.php\n";
			$preset_robotstxt['robotstxt'] .= '{APPEND_WEBSITE_ROBOTSTXT}';

			/*
			 * Update the value of an option that was already added for the current network.
			 * https://developer.wordpress.org/reference/functions/update_site_option/
			 */
			update_site_option( MS_ROBOTSTXT_MANAGER_PLUGIN_NAME, $preset_robotstxt );
		}
	}//end set_robotstxt()


	/**
	 * Get Local Website Robots.txt File Body
	 */
	public static function get_website_robotstxt() {
		$robotstxt = '';

		/*
		 * Retrieve the raw response from the HTTP request using the GET method.
		 * https://developer.wordpress.org/reference/functions/wp_remote_get/
		 */
		$website_robotstxt = wp_remote_get( get_home_url() . '/robots.txt' );

		/*
		 * Check whether variable is a WordPress Error.
		 * https://developer.wordpress.org/reference/functions/is_wp_error/
		 *
		 * Issue: https://github.com/ChrisWinters/multisite-robotstxt-manager/issues/8
		 */
		if ( true === is_wp_error( $website_robotstxt ) ) {
			return $robotstxt;
		}

		if ( true !== empty( $website_robotstxt['response']['code'] ) && '200' === $website_robotstxt['response']['code'] && true !== empty( $website_robotstxt['body'] ) ) {
			$robotstxt  = $website_robotstxt['body'] . "\n";
			$robotstxt .= '{APPEND_WEBSITE_ROBOTSTXT}';
		}

		return $robotstxt;
	}//end get_website_robotstxt()
}//end class
