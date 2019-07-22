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

use MsRobotstxtManager\Do_Build_Robotstxt as DoBuildRobotstxt;
use MsRobotstxtManager\Plugin_Admin_Notices as PluginAdminNotices;
use MsRobotstxtManager\Pro_Build_Append_Rules as ProBuildAppendRules;
use MsRobotstxtManager\Option_Manager as OptionManager;

/**
 * Automatically Build & Save Robots.txt File When Robots.txt Is Called
 */
final class Pro_Generate_Robotstxt {
	/**
	 * Pro_Build_Append_Rules Class
	 *
	 * @var object
	 */
	public $append_rules = [];

	/**
	 * Plugin_Admin_Notices Class
	 *
	 * @var object
	 */
	public $admin_notices = [];

	/**
	 * Option_Manager Class.
	 *
	 * @var object
	 */
	public $option_manager = [];

	/**
	 * Do_Build_Robotstxt Class
	 *
	 * @var object
	 */
	public $build_robotstxt = [];

	/**
	 * Request URI Check.
	 *
	 * @var bool
	 */
	public $check_robotstxt;

	/**
	 * Request URI Check.
	 *
	 * @var bool
	 */
	public $check_new_site;


	/**
	 * Check File Being Called
	 */
	public function __construct() {
		$this->append_rules    = new ProBuildAppendRules();
		$this->admin_notices   = new PluginAdminNotices();
		$this->option_manager  = new OptionManager();
		$this->build_robotstxt = new DoBuildRobotstxt( $this->option_manager );
		$this->check_robotstxt = strpos( filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL ), 'robots.txt' );
		$this->check_new_site  = strpos( filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL ), 'site-new.php' );

		// Robots.txt File.
		if ( false !== $this->check_robotstxt ) {
			if ( true !== function_exists( 'get_site_option' ) ) {
				return;
			}

			$pro_site_option = $this->option_manager->get_site_option( '-pro' );

			if ( true !== empty( $pro_site_option['network_create'] ) ) {
				$this->init();
			}
		}

		// New Network Website.
		if ( false !== $this->check_new_site ) {
			if ( true !== function_exists( 'get_site_option' ) ) {
				return;
			}

			// Network & Valid Numeric ID Required.
			if ( false === is_int( filter_input( INPUT_GET, 'id', FILTER_UNSAFE_RAW ) ) ) {
				return;
			}

			$pro_site_option = $this->option_manager->get_site_option( '-pro' );

			if ( true !== empty( $pro_site_option['network_sites'] ) ) {
				$site_id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT );
				$this->init( $site_id );
			}
		}
	}


	/**
	 * Build & Save Robots.txt File
	 *
	 * @param int $site_id Network Site ID.
	 */
	private function init( $site_id = '' ) {
		$this->append_rules->init( $site_id );
		$this->build_robotstxt->init( $site_id );

		if ( true !== empty( $site_id ) && false !== $this->check_new_site ) {
			$this->admin_notices->add_notice( 'success', 'robotstxt_success', 'network' );
		}
	}//end init()
}//end class
