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
	}//end init()
}//end class
