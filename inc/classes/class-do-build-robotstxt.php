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
 * Build Network Website Robots.txt File
 */
final class Do_Build_Robotstxt {
	/**
	 * Option_Manager Class.
	 *
	 * @var object
	 */
	public $option_manager = [];


	/**
	 * Setup Class
	 *
	 * @param object $option_manager Option_Manager.
	 */
	public function __construct( $option_manager = [] ) {
		if ( true === empty( $option_manager ) ) {
			return;
		}

		$this->option_manager = $option_manager;
	}//end __construct()


	/**
	 * Build & Save Robots.txt File
	 *
	 * @param int $site_id Network Site ID.
	 */
	public function init( $site_id = '' ) {
		if ( true === empty( $this->option_manager ) ) {
			return;
		}

		$site_id = $this->get_site_id( $site_id );

		if ( true !== empty( $site_id ) ) {
			/*
			 * Switch the current blog.
			 * https://developer.wordpress.org/reference/functions/switch_to_blog/
			 */
			switch_to_blog( $site_id );
		}

		$website_option = $this->option_manager->get_option();

		$network_robotstxt_file = $this->option_manager->get_site_option();

		// Return Default WordPress Robots.txt File.
		if ( true === empty( $network_robotstxt_file['robotstxt'] ) ) {
			return;
		}

		$append_rules   = ( true !== empty( $website_option['append'] ) ) ? $website_option['append'] : '';
		$robotstxt_file = $this->replace_append_rules( $append_rules, $network_robotstxt_file['robotstxt'] );

		$this->update_robotstxt( $website_option, $robotstxt_file );

		if ( true !== empty( $site_id ) ) {
			/*
			 * Restore the current blog, after calling switch_to_blog.
			 * https://developer.wordpress.org/reference/functions/restore_current_blog/
			 */
			restore_current_blog();
		}
	}//end init()


	/**
	 * Get Current Site ID
	 *
	 * @param int $site_id Network Site ID.
	 *
	 * @return int/empty
	 */
	private function get_site_id( $site_id = '' ) {
		/*
		 * Whether the current request is for the network administrative interface.
		 * https://developer.wordpress.org/reference/functions/is_network_admin/
		 */
		if ( true === empty( $site_id ) && true !== is_network_admin() ) {
			/*
			 * Retrieve the current site ID.
			 * https://developer.wordpress.org/reference/functions/get_current_blog_id/
			 */
			$site_id = get_current_blog_id();
		}

		return $site_id;
	}//end get_site_id()


	/**
	 * Maybe Replace Append Rules
	 *
	 * @param string $append_rules      Website Append Rules.
	 * @param string $network_robotstxt Network Robots.txt File.
	 *
	 * @return string
	 */
	private function replace_append_rules( $append_rules = '', $network_robotstxt ) {
		if ( true !== empty( $append_rules ) ) {
			// Append Rules Found.
			$robotstxt_file = str_replace( '{APPEND_WEBSITE_ROBOTSTXT}', $append_rules, $network_robotstxt );
		} else {
			// No Append Rules.
			$robotstxt_file = str_replace( '{APPEND_WEBSITE_ROBOTSTXT}', '', $network_robotstxt );
		}

		return $robotstxt_file;
	}//end replace_append_rules()


	/**
	 * Maybe Update Website Robots.txt File
	 *
	 * @param array  $website_option Current Plugin Option Data.
	 * @param string $robotstxt_file Robots.txt File To Save.
	 */
	private function update_robotstxt( $website_option = '', $robotstxt_file = '' ) {
		if ( true === empty( $website_option ) ) {
			$website_option = [];
		}

		if ( true === is_array( $website_option ) && true === array_key_exists( 'robotstxt', $website_option ) ) {
			unset( $website_option['robotstxt'] );
		}

		$this->option_manager->update_option( array_merge( [ 'robotstxt' => $robotstxt_file ], $website_option ) );
	}//end update_robotstxt()
}//end class
