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
 * Robots.txt Cleaner Rules & Actions
 */
final class Do_Robotstxt_Cleaner {
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

		// Init Cleaner.
		if ( 'cleaner' === $this->post_action ) {
			$this->cleaner();
		}
	}//end update()


	/**
	 * Init Cleaner
	 */
	private function cleaner() {
		if ( true === empty( $this->post_object ) || true === empty( $this->admin_notices ) ) {
			return;
		}

		if ( true !== empty( $this->post_object['check-data'] ) ) {
			$this->checkdata();
		}

		if ( true !== empty( $this->post_object['clean-data'] ) ) {
			$this->cleandata();
		}

		if ( true !== empty( $this->post_object['check-physical'] ) ) {
			$this->checkphysical();
		}

		if ( true !== empty( $this->post_object['clean-physical'] ) ) {
			$this->cleanphysical();
		}

		if ( true !== empty( $this->post_object['check-rewrite'] ) ) {
			$this->checkrewrite();
		}

		if ( true !== empty( $this->post_object['add-rewrite'] ) ) {
			$this->addrewrite();
		}
	}//end cleaner()


	/**
	 * Check For Old Plugin Data
	 */
	private function checkdata() {
		$message = false;

		// Old Data Found, Set Marker.
		if ( get_option( 'pc_robotstxt' ) || get_option( 'kb_robotstxt' ) || get_option( 'cd_rdte_content' ) ) {
			$this->option_manager->update_option( [ 'checkdata' => 'error' ] );
			$message = true;
		} else {
			$this->option_manager->delete_setting( 'checkdata' );
		}

		if ( true === $message ) {
			$this->admin_notices->add_notice( 'success', 'checkdata_notice', 'network' );
		} else {
			$this->admin_notices->add_notice( 'error', 'checkdata_done', 'network' );
		}
	}


	/**
	 * Remove Old Plugin Data
	 */
	private function cleandata() {
		// Remove Options.
		delete_option( 'pc_robotstxt' );
		delete_option( 'kb_robotstxt' );
		delete_option( 'cd_rdte_content' );

		// Remove Filters.
		remove_filter( 'robots_txt', 'cd_rdte_filter_robots' );
		remove_filter( 'robots_txt', 'ljpl_filter_robots_txt' );
		remove_filter( 'robots_txt', 'robots_txt_filter' );

		// Run Check Again.
		$this->checkData();
	}


	/**
	 * Check For Phsyical Robots.txt File
	 */
	private function checkphysical() {
		$message = false;

		// Robots.txt File Found.
		if ( true === file_exists( get_home_path() . 'robots.txt' ) ) {
			$this->option_manager->update_option( [ 'checkphysical' => 'error' ] );
			$message = true;
		} else {
			$this->option_manager->delete_setting( 'checkphysical' );
		}

		if ( true === $message ) {
			$this->admin_notices->add_notice( 'success', 'checkphysical_notice', 'network' );
		} else {
			$this->admin_notices->add_notice( 'error', 'checkphysical_done', 'network' );
		}
	}


	/**
	 * Remove Physical Robots.txt File
	 */
	private function cleanphysical() {
		// Remove Robots.txt File.
		if ( true === file_exists( get_home_path() . 'robots.txt' ) && true === is_writable( get_home_path() . 'robots.txt' ) ) {
			unlink( realpath( get_home_path() . 'robots.txt' ) );
		}

		// Robots.txt File Found.
		if ( true === file_exists( get_home_path() . 'robots.txt' ) ) {
			$this->option_manager->delete_setting( 'checkphysical' );
			$this->admin_notices->add_notice( 'error', 'checkphysical_error', 'network' );
		} else {
			$this->checkphysical();
		}
	}


	/**
	 * Check For Missing Rewrite Rules
	 */
	private function checkrewrite() {
		$message = false;

		// Get Rewrite Rules.
		$rules = get_option( 'rewrite_rules' );

		// Flush Rules If Needed.
		if ( empty( $rules ) ) {
			flush_rewrite_rules();
		}

		// Error No Rewrite Rule Found, Set Marker.
		if ( true !== in_array( 'index.php?robots=1', (array) $rules, true ) ) {
			$this->option_manager->update_option( [ 'checkrewrite' => 'error' ] );
			$message = true;
		} else {
			$this->option_manager->delete_setting( 'checkrewrite' );
		}

		if ( true === $message ) {
			$this->admin_notices->add_notice( 'success', 'checkrewrite_notice', 'network' );
		} else {
			$this->admin_notices->add_notice( 'success', 'checkrewrite_done', 'network' );
		}
	}


	/**
	 * Add Missing Rewrite Rule
	 */
	private function addrewrite() {
		// Get Rewrite Rules.
		$rules = get_option( 'rewrite_rules' );

		// Add Missing Rule.
		if ( true !== in_array( 'index.php?robots=1', (array) $rules, true ) ) {
			// Set Proper Keys.
			$rule_key           = 'robots\.txt$';
			$rules[ $rule_key ] = 'index.php?robots=1';

			// Update Rules.
			update_option( 'rewrite_rules', $rules );

			// Flush Rules.
			flush_rewrite_rules();
		}

		// Recheck Rewrite Rules.
		$this->checkRewrite();
	}
}//end class
