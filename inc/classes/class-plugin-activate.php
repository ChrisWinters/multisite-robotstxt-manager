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

		// Maybe Upgade Robots.txt Manager Plugin.
		self::upgrade_plugin();

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

		if ( true !== empty( $website_robotstxt['response']['code'] ) && '200' === $website_robotstxt['response']['code'] && true !== empty( $website_robotstxt['body'] ) ) {
			$robotstxt  = $website_robotstxt['body'] . "\n";
			$robotstxt .= '{APPEND_WEBSITE_ROBOTSTXT}';
		}

		return $robotstxt;
	}//end get_website_robotstxt()


	/**
	 * Maybe Upgade Robots.txt Manager Plugin
	 */
	public static function upgrade_plugin() {
		$network_robotstxt = get_option( 'ms_robotstxt_manager_network_robotstxt' );

		if ( true !== empty( $network_robotstxt['robotstxt'] ) ) {
			update_site_option(
				MS_ROBOTSTXT_MANAGER_PLUGIN_NAME,
				[
					'robotstxt' => $network_robotstxt['robotstxt'],
				]
			);

			delete_option( 'ms_robotstxt_manager_network_robotstxt' );
			delete_option( 'ms_robotstxt_manager_network_preset' );
			delete_option( 'ms_robotstxt_manager_network_status' );
			delete_option( 'ms_robotstxt_manager_settings' );
			delete_option( 'ms_robotstxt_manager_cleaner_old_data' );
			delete_option( 'ms_robotstxt_manager_cleaner_physical' );
			delete_option( 'ms_robotstxt_manager_cleaner_rewrite' );
			delete_option( 'msrtm_settings' );

			$option_array = [];

			/*
			 * Retrieves a list of sites matching requested arguments.
			 * https://developer.wordpress.org/reference/functions/get_sites/
			 */
			foreach ( get_sites() as $website ) {
				/*
				 * Switch the current blog.
				 * https://developer.wordpress.org/reference/functions/switch_to_blog/
				 */
				switch_to_blog( $website->blog_id );

				$website_robotstxt    = get_option( 'ms_robotstxt_manager_robotstxt' );
				$website_append_rules = get_option( 'ms_robotstxt_manager_append' );

				if ( true !== empty( $website_robotstxt['robotstxt'] ) ) {
					$option_array['robotstxt'] = $website_robotstxt['robotstxt'];
				}

				if ( true !== empty( $website_append_rules['robotstxt'] ) ) {
					$option_array['append'] = $website_append_rules['robotstxt'];
				}

				if ( true === get_option( 'ms_robotstxt_manager_status' ) ) {
					$option_array['disable'] = true;
				}

				if ( true !== empty( $option_array ) ) {
					update_option(
						MS_ROBOTSTXT_MANAGER_PLUGIN_NAME,
						$option_array
					);
				}

				delete_option( 'ms_robotstxt_manager_robotstxt' );
				delete_option( 'ms_robotstxt_manager_status' );
				delete_option( 'ms_robotstxt_manager_append' );
				delete_option( 'ms_robotstxt_manager_default' );

				/*
				 * Restore the current blog, after calling switch_to_blog.
				 * https://developer.wordpress.org/reference/functions/restore_current_blog/
				 */
				restore_current_blog();
			}
		}
	}//end upgrade_plugin()
}//end class
