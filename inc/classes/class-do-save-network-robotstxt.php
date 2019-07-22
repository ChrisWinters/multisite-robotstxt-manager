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
use MsRobotstxtManager\Option_Manager as OptionManager;

/**
 * Save Network Robots.txt File.
 */
final class Do_Save_Network_Robotstxt {
	use TraitSecurityCheck;

	/**
	 * Plugin Admin Post Object.
	 *
	 * @var array
	 */
	public $post_object = [];

	/**
	 * Post Action To Take.
	 *
	 * @var string
	 */
	public $post_action = [];

	/**
	 * Option_Manager Class.
	 *
	 * @var object
	 */
	public $option_manager = [];

	/**
	 * Plugin_Admin_Notices Class
	 *
	 * @var object
	 */
	public $admin_notices = [];


	/**
	 * Setup Class
	 *
	 * @param array $post_object Cleaned Post Object.
	 */
	public function __construct( $post_object = [] ) {
		if ( true === empty( $post_object ) || true === empty( $post_object['action'] ) ) {
			return;
		}

		$this->post_action    = $post_object['action'];
		$this->post_object    = $post_object;
		$this->option_manager = new OptionManager();
		$this->admin_notices  = new PluginAdminNotices();
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
		add_action(
			'admin_init',
			[
				$this,
				'update',
			]
		);
	}//end init()


	/**
	 * Security Check & Update On Action
	 */
	public function update() {
		$this->security_check();

		// Save Network Robots.txt File.
		if ( 'save' === $this->post_action ) {
			$this->save_network_robotstxt();
		}
	}//end update()


	/**
	 * Save Network Robots.txt
	 */
	private function save_network_robotstxt() {
		$message = false;

		if ( true !== empty( $this->post_object ) && true !== empty( $this->post_object['robotstxt'] ) ) {
			$this->option_manager->update_site_setting( 'robotstxt', $this->post_object['robotstxt'] );
			$message = true;
		}

		if ( true !== empty( $this->post_object ) && true === empty( $this->post_object['robotstxt'] ) ) {
			$this->option_manager->delete_site_option();
			$message = true;
		}

		if ( true === $message ) {
			$this->admin_notices->add_notice( 'success', 'save_success', 'network' );
		}
	}//end save_network_robotstxt()
}//end class
