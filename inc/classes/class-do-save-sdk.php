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
use MsRobotstxtManager\Option_Manager as OptionManager;

/**
 * Save Freemius SDK Rules.
 */
final class Do_Save_Sdk {
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

		if ( 'reconnect' === $this->post_action ) {
			$this->reconnect_action();
		}

		if ( 'sdk' === $this->post_action ) {
			if ( true !== empty( $this->post_object['optin'] ) && '1' === $this->post_object['optin'] ) {
				$this->optin_action();
			}

			if ( true !== empty( $this->post_object['dismiss'] ) && '1' === $this->post_object['dismiss'] ) {
				$this->dismiss_action();
			}
		}
	}//end update()


	/**
	 * SDK Reconnect Again
	 */
	private function reconnect_action() {
		$this->option_manager->update_site_setting( 'sdk_action', 'optin' );
		msrtm_fs()->connect_again();
	}//end reconnect_action()


	/**
	 * SDK Opt In
	 */
	private function optin_action() {
		$this->option_manager->update_site_setting( 'sdk_action', 'optin' );
		msrtm_fs()->opt_in();
	}//end optin_action()


	/**
	 * SDK Opt Out
	 */
	private function dismiss_action() {
		$this->option_manager->update_site_setting( 'sdk_action', 'skip' );
	}//end dismiss_action()

}//end class
