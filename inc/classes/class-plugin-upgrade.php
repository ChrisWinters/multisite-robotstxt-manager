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

use MsRobotstxtManager\Trait_Security_Check as TraitSecurityCheck;
use MsRobotstxtManager\Plugin_Admin_Notices as PluginAdminNotices;
use MsRobotstxtManager\Option_Manager as OptionManager;

/**
 * Maybe Upgrade Plugin
 */
final class Plugin_Upgrade {
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

		// Init Upgrade.
		if ( 'upgrade' === $this->post_action ) {
			if ( true !== empty( $this->post_object['migrate'] ) && '1' === $this->post_object['migrate'] ) {
				$this->upgrade();
			}

			if ( true !== empty( $this->post_object['delete'] ) && '1' === $this->post_object['delete'] ) {
				$this->delete();
			}

			if ( true !== empty( $this->post_object['dismiss'] ) && '1' === $this->post_object['dismiss'] ) {
				$this->dismiss();
			}
		}
	}//end update()


	/**
	 * Dismiss Upgrade
	 */
	private function dismiss() {
		$this->option_manager->update_site_setting( 'upgraded', true );
	}//end dismiss()


	/**
	 * Maybe Upgrade Plugin
	 */
	private function upgrade() {
		$new_network_option = $this->option_manager->get_site_option();

		if ( true !== empty( $new_network_option['upgraded'] ) || true !== empty( $new_network_option['robotstxt'] ) ) {
			$this->option_manager->update_site_setting( 'upgraded', true );
			$this->admin_notices->add_notice( 'success', 'upgraded_already', 'network' );
			return;
		}

		$network_robotstxt = get_option( 'ms_robotstxt_manager_network_robotstxt' );

		if ( true !== empty( $network_robotstxt['robotstxt'] ) ) {
			$this->option_manager->update_site_setting( 'robotstxt', $network_robotstxt['robotstxt'] );

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
					$this->option_manager->update_option( $option_array );
				}

				/*
				 * Restore the current blog, after calling switch_to_blog.
				 * https://developer.wordpress.org/reference/functions/restore_current_blog/
				 */
				restore_current_blog();
			}

			// Set Upgrade Delte Marker & Send Notice.
			$this->option_manager->update_site_setting( 'upgraded', 'delete' );
			$this->admin_notices->add_notice( 'success', 'upgrade_success', 'network' );
			return;
		}

		if ( true === empty( $network_robotstxt['robotstxt'] ) ) {
			$this->option_manager->update_site_setting( 'upgraded', true );
			$this->admin_notices->add_notice( 'success', 'upgraded_already', 'network' );
			return;
		}
	}//end upgrade()


	/**
	 * Maybe Delete Old Plugin Settings
	 */
	private function delete() {
		$network_robotstxt = get_option( 'ms_robotstxt_manager_network_robotstxt' );

		if ( true !== empty( $network_robotstxt['robotstxt'] ) ) {
			delete_option( 'ms_robotstxt_manager_network_robotstxt' );
			delete_option( 'ms_robotstxt_manager_network_preset' );
			delete_option( 'ms_robotstxt_manager_network_status' );
			delete_option( 'ms_robotstxt_manager_settings' );
			delete_option( 'ms_robotstxt_manager_cleaner_old_data' );
			delete_option( 'ms_robotstxt_manager_cleaner_physical' );
			delete_option( 'ms_robotstxt_manager_cleaner_rewrite' );
			delete_option( 'msrtm_settings' );

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

			// Set Upgrade Delte Marker & Send Notice.
			$this->option_manager->update_site_setting( 'upgraded', true );
			$this->admin_notices->add_notice( 'success', 'upgrade_success', 'network' );
		}
	}//end delete()
}//end class
