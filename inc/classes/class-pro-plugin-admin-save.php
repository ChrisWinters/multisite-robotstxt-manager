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
 * Save/Update Plugin Settings
 */
final class Pro_Plugin_Admin_Save {
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

		// Delete Pro Settings.
		if ( 'delete' === $this->post_action ) {
			$this->delete_settings();
		}

		// Update Settings.
		if ( 'automate' === $this->post_action ) {
			$this->automation_rules();
		}
	}//end update()


	/**
	 * Delete Pro Settings
	 */
	private function delete_settings() {
		$this->option_manager->delete_site_option( '-pro' );
	}//end delete_settings()


	/**
	 * Update Robots.txt Append Rules
	 */
	private function automation_rules() {
		$message = false;

		$site_option = $this->option_manager->get_site_option( '-pro' );

		// Clear Setting.
		if ( true === empty( $this->post_object['network_sites'] ) && true !== empty( $site_option['network_sites'] ) ) {
			unset( $site_option['network_sites'] );
		}

		// Clear Setting.
		if ( true === empty( $this->post_object['network_create'] ) && true !== empty( $site_option['network_create'] ) ) {
			unset( $site_option['network_create'] );
		}

		// Clear Setting.
		if ( true === empty( $this->post_object['network_upload_path'] ) && true !== empty( $site_option['network_upload_path'] ) ) {
			unset( $site_option['network_upload_path'] );
		}

		// Clear Setting.
		if ( true === empty( $this->post_object['network_theme_path'] ) && true !== empty( $site_option['network_theme_path'] ) ) {
			unset( $site_option['network_theme_path'] );
		}

		// Clear Setting.
		if ( true === empty( $this->post_object['network_sitemap_url'] ) && true !== empty( $site_option['network_sitemap_url'] ) ) {
			unset( $site_option['network_sitemap_url'] );
		}

		// Add Setting.
		if ( true !== empty( $this->post_object['network_sites'] ) ) {
			$site_option['network_sites'] = '1';
		}

		// Add Setting.
		if ( true !== empty( $this->post_object['network_create'] ) ) {
			$site_option['network_create'] = '1';
		}

		// Add Setting.
		if ( true !== empty( $this->post_object['network_upload_path'] ) ) {
			$site_option['network_upload_path'] = '1';
		}

		// Add Setting.
		if ( true !== empty( $this->post_object['network_theme_path'] ) ) {
			$site_option['network_theme_path'] = '1';
		}

		// Add Setting.
		if ( true !== empty( $this->post_object['network_sitemap_url'] ) ) {
			$site_option['network_sitemap_url'] = '1';
		}

		if ( true === empty( $site_option ) ) {
			$this->option_manager->delete_site_option( '-pro' );
		} else {
			$this->option_manager->update_site_option( $site_option, '-pro' );
		}

		$this->admin_notices->add_notice( 'success', 'update_success', 'network' );
	}//end automation_rules()
}//end class
