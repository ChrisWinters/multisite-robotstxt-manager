<?php
/**
 * Public Facing Class Instances
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

/*
 * Whether the current request is for the network administrative interface.
 * https://developer.wordpress.org/reference/functions/is_network_admin/
 */
if ( true === is_network_admin() ) {
	// SDK: Save Dismiss Status.
	$ms_robotstxt_manager_sdk = new \MsRobotstxtManager\Do_Save_Sdk( $ms_robotstxt_manager_post_object );
	$ms_robotstxt_manager_sdk->init();

	if ( ( msrtm_fs()->is__premium_only() ) ) {
		// Pro: Save Plugin Admin Data.
		$ms_robotstxt_manager_pro_plugin_admin_save = new \MsRobotstxtManager\Pro_Plugin_Admin_Save( $ms_robotstxt_manager_post_object );
		$ms_robotstxt_manager_pro_plugin_admin_save->init();
	}
}
