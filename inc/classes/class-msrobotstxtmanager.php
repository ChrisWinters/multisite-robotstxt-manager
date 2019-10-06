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
 * Plugin Core
 */
final class MsRobotstxtManager {
	/**
	 * Init Plugin
	 */
	public static function init() {
		require_once MS_ROBOTSTXT_MANAGER_PLUGIN_DIR . '/inc/instantiate-public-classes.php';
		require_once MS_ROBOTSTXT_MANAGER_PLUGIN_DIR . '/inc/instantiate-admin-classes.php';
		require_once MS_ROBOTSTXT_MANAGER_PLUGIN_DIR . '/inc/instantiate-network-classes.php';

		/*
		 * Determines whether the current request is for an administrative interface page.
		 * https://developer.wordpress.org/reference/functions/is_admin/
		 */
		if ( true === is_admin() ) {
			msrtm_fs()->add_filter(
				'show_admin_notice',
				[
					'MsRobotstxtManager\MsRobotstxtManager',
					'freemius_notices',
				],
				10,
				2
			);

			msrtm_fs()->add_filter(
				'show_delegation_option',
				[
					'MsRobotstxtManager\MsRobotstxtManager',
					'freemius_delegation',
				]
			);
		}
	}//end init()


	/**
	 * Remove Update Nag Notice
	 *
	 * @param bool  $show  Default notice to show.
	 * @param array $array Content data array.
	 * @return bool
	 */
	public static function freemius_notices( $show, $array ) {
		if ( 'update-nag' == $array['type'] ) {
			return false;
		}

		return $show;
	}


	/**
	 * Remove Delegation Text
	 */
	public static function freemius_delegation() {
		return '';
	}
}//end class
