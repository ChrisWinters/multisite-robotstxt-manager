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
 * Update Website Append Rules
 */
final class Do_Save_Append_Rules {
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
	 * Do_Build_Robotstx Object.
	 *
	 * @var object
	 */
	public $build_robotstxt = [];


	/**
	 * Setup Class
	 *
	 * @param array $post_object Cleaned Post Object.
	 */
	public function __construct( $post_object = [] ) {
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

		// Website Append Rules.
		if ( 'append' === $this->post_action ) {
			$this->save_append_rules();
		}
	}//end update()


	/**
	 * Website Append Rules
	 */
	private function save_append_rules() {
		$message = false;

		if ( true !== empty( $this->post_object['append'] ) ) {
			$this->option_manager->update_setting( 'append', $this->post_object['append'] );
			$message = true;
		}

		if ( true === empty( $this->post_object['append'] ) ) {
			$this->option_manager->delete_setting( 'append' );
			$message = true;
		}

		if ( true !== empty( $this->post_object['override'] ) ) {
			$this->option_manager->update_setting( 'override', 1 );
		} else {
			$this->option_manager->delete_setting( 'override' );
		}

		// Remove Disable Marker.
		$this->option_manager->delete_setting( 'disable' );

		if ( true === $message ) {
			// Build Robots.txt Files.
			$this->build_robotstxt->init();

			$this->admin_notices->add_notice( 'success', 'append_success' );
		}
	}//end save_append_rules()
}//end class
