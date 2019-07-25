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
 * Plugin Admin Area Notices
 */
final class Plugin_Admin_Notices {
	/**
	 * Notice Messages.
	 *
	 * @var array
	 */
	public $message = [];


	/**
	 * Set Class Params
	 *
	 * @return void
	 */
	public function __construct() {
		$this->notice = '';
	}//end __construct()


	/**
	 * Return Message Based On Key.
	 *
	 * @param string $message Message Key To Return.
	 */
	private function messages( $message = '' ) {
		$messages = [
			'update_success'       => __(
				'Rules Updated.',
				'includes'
			),
			'robotstxt_success'    => __(
				'Robots.txt File Generated.',
				'includes'
			),
			'network_updated'      => __(
				'Network Websites Updated.',
				'includes'
			),
			'member_updated'       => __(
				'Network Member Websites Updated.',
				'includes'
			),
			'update_error'         => __(
				'Settings Update Failed.',
				'includes'
			),
			'save_success'         => __(
				'Network Robots.txt File Saved.',
				'includes'
			),
			'append_success'       => __(
				'Append Rules Saved.',
				'includes'
			),
			'input_error'          => __(
				'A Selection Is Required.',
				'includes'
			),
			'delete_success'       => __(
				'All Plugin Settings Deleted.',
				'includes'
			),
			'checkdata_notice'     => __(
				'Old robots.txt file data found! Click the "remove old data" button to remove the old data.',
				'includes'
			),
			'checkdata_done'       => __(
				'No old robots.txt file data found.',
				'includes'
			),
			'checkphysical_notice' => __(
				'A real robots.txt file was found within the websites root directory. Click the "delete physical file" to delete the robots.txt file.',
				'includes'
			),
			'checkphysical_done'   => __(
				'A physical robots.txt file was not found.',
				'includes'
			),
			'checkphysical_error'  => __(
				'The plugin was unable to delete the robots.txt file due to file permissions. Manual deletion required.',
				'includes'
			),
			'checkrewrite_notice'  => __(
				'This website is missing the robots.txt Rewrite Rule. Click the "correct missing rules" button to add the missing rule.',
				'includes'
			),
			'checkrewrite_done'    => __(
				'Proper Rewrite Rule found.',
				'includes'
			),
			'disable_success'      => __(
				'Default WordPress robots.txt file restored.',
				'includes'
			),
			'upgraded_already'     => __(
				'Plugin has already been upgraded.',
				'includes'
			),
			'upgrade_success'      => __(
				'Plugin upgraded. Please check the saved rules to ensure everything is correct.',
				'includes'
			),
		];

		if ( true !== empty( $messages[ $message ] ) ) {
			return $messages[ $message ];
		}
	}//end messages()


	/**
	 * Display Admin Notice
	 *
	 * @param string $type    Message Type (success|error).
	 * @param string $message Message Key To Get.
	 * @param string $network Set to network to use network_admin_notices.
	 */
	public function add_notice( $type = '', $message = '', $network = '' ) {
		if ( false === method_exists( $this, $type ) ) {
			return;
		}

		if ( true === empty( $message ) ) {
			return;
		}

		if ( true === empty( $this->messages( $message ) ) ) {
			return;
		}

		$admin_notice_type = 'admin_notices';

		if ( true !== empty( $network ) && 'network' === $network ) {
			$admin_notice_type = 'network_admin_notices';
		}

		// Set Notice Message.
		$this->notice = $this->messages( $message );

		/*
		 * Prints admin screen notices.
		 * https://developer.wordpress.org/reference/hooks/admin_notices/
		 */
		add_action(
			$admin_notice_type,
			[
				$this,
				$type,
			]
		);
	}//end add_notice()


	/**
	 * Success Message HTML
	 */
	public function success() {
		if ( true === empty( $this->notice ) ) {
			return;
		}

		/*
		 * Sanitizes content for allowed HTML tags for post content.
		 * https://developer.wordpress.org/reference/functions/wp_kses_post/
		 */
		echo wp_kses_post( '<div class="notice notice-success is-dismissible"><p>' . $this->notice . '</p></div>' );
	}//end success()


	/**
	 * Error Message HTML
	 */
	public function error() {
		if ( true === empty( $this->notice ) ) {
			return;
		}

		/*
		 * Sanitizes content for allowed HTML tags for post content.
		 * https://developer.wordpress.org/reference/functions/wp_kses_post/
		 */
		echo wp_kses_post( '<div class="notice notice-error is-dismissible"><p>' . $this->notice . '</p></div>' );
	}//end error()
}//end class
