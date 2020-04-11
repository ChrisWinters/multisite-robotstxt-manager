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

use MsRobotstxtManager\Trait_Security_Check as TraitSecurityCheck;
use MsRobotstxtManager\Plugin_Admin_Notices as PluginAdminNotices;
use MsRobotstxtManager\Do_Build_Robotstxt as DoBuildRobotstxt;
use MsRobotstxtManager\Option_Manager as OptionManager;

/**
 * Build Robots.txt File Across All Network Sites.
 */
final class Do_Network_Robotstxt_Build {
	use  TraitSecurityCheck;

	/**
	 * Plugin Admin Post Object.
	 *
	 * @var array
	 */
	public $post_object = array();

	/**
	 * Post Action To Take.
	 *
	 * @var string
	 */
	public $post_action = array();

	/**
	 * Option_Manager Class.
	 *
	 * @var object
	 */
	public $option_manager = array();

	/**
	 * Plugin_Admin_Notices Class
	 *
	 * @var object
	 */
	public $admin_notices = array();

	/**
	 * Do_Build_Robotstxt Class
	 *
	 * @var object
	 */
	public $build_robotstxt = array();


	/**
	 * Setup Class
	 *
	 * @param array $post_object Cleaned Post Object.
	 */
	public function __construct( $post_object = array() ) {
		if ( true === empty( $post_object ) || true === empty( $post_object['action'] ) ) {
			return;
		}

		$this->post_object     = $post_object;
		$this->post_action     = $post_object['action'];
		$this->option_manager  = new OptionManager();
		$this->admin_notices   = new PluginAdminNotices();
		$this->build_robotstxt = new DoBuildRobotstxt( $this->option_manager );
	}//end __construct()


	/**
	 * Init Update Action
	 */
	public function init() {
		if ( true === empty( $this->post_object ) ) {
			return;
		}

		/*
		 * Fires as an admin screen or script is being initialized.
		 * https://developer.wordpress.org/reference/hooks/admin_init/
		 */
		add_action( 'admin_init', array( $this, 'update' ) );
	}//end init()


	/**
	 * Security Check & Update On Action
	 */
	public function update() {
		$this->security_check();

		// All Network Sites Robots.txt Builds.
		if ( 'network' === $this->post_action ) {
			$this->network_robosttxt_build();
		}
	}//end update()


	/**
	 * All Network Sites Robots.txt Builds
	 */
	private function network_robosttxt_build() {
		if ( true === empty( $this->post_object ) || true === empty( $this->admin_notices ) ) {
			return;
		}

		$message = false;

		if ( true !== empty( $this->post_object ) && true !== empty( $this->post_object['robotstxt'] ) ) {
			$this->option_manager->update_site_option( 'robotstxt', $this->post_object['robotstxt'] );
			$message = true;
		}

		if ( true !== empty( $this->post_object ) && true === empty( $this->post_object['robotstxt'] ) ) {
			$this->option_manager->delete_site_option();
			$message = true;
		}

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

			// Build Robots.txt Files.
			$this->build_robotstxt->init( $website->blog_id );

			/*
			 * Restore the current blog, after calling switch_to_blog.
			 * https://developer.wordpress.org/reference/functions/restore_current_blog/
			 */
			restore_current_blog();
		}

		if ( true === $message ) {
			$this->admin_notices->add_notice( 'success', 'network_updated', 'network' );
		}
	}
}//end class
