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
 * Delete All Plugin Settings
 */
final class Do_Delete_Settings {
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

		$this->post_object    = $post_object;
		$this->post_action    = $post_object['action'];
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

		// Set Disable Marker For Website.
		if ( 'delete' === $this->post_action ) {
			$this->do_delete();
		}
	}//end update()


	/**
	 * Init Delete
	 */
	private function do_delete() {
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

			$this->option_manager->delete_option();

			/*
			 * Restore the current blog, after calling switch_to_blog.
			 * https://developer.wordpress.org/reference/functions/restore_current_blog/
			 */
			restore_current_blog();
		}

		$this->option_manager->delete_site_option();

		if ( true === empty( $this->option_manager->get_option() ) && true === empty( $this->option_manager->get_site_option() ) ) {
			$this->admin_notices->add_notice( 'success', 'delete_success', 'network' );
		}
	}//end do_delete()
}//end class
