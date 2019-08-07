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
 * Determines whether the current request is for an administrative interface page.
 * https://developer.wordpress.org/reference/functions/is_admin/
 */
if ( true === is_admin() ) {
	// Display Plugin Admin.
	$plugin_admin = new \MsRobotstxtManager\Plugin_Admin();

	// Manage Admin Updates.
	$plugin_admin_post = new \MsRobotstxtManager\Plugin_Admin_Post();
	$post_object       = $plugin_admin_post->get_post_object();

	// Website: Save Append Rules.
	$save_append_rules = new \MsRobotstxtManager\Do_Save_Append_Rules( $post_object );
	$save_append_rules->init();

	// Website: Disable Website.
	$disable_website = new \MsRobotstxtManager\Do_Disable_Website( $post_object );
	$disable_website->init();

	// Network: Save SDK Options.
	$save_sdk = new \MsRobotstxtManager\Do_Save_Sdk( $post_object );
	$save_sdk->init();

	// Network: Save Network Robots.txt File.
	$save_network_robotstxt = new \MsRobotstxtManager\Do_Save_Network_Robotstxt( $post_object );
	$save_network_robotstxt->init();

	// Network: Save Preset As Network Robots.txt File.
	$save_preset_robotstxt = new \MsRobotstxtManager\Do_Save_Preset_As_Robotstxt( $post_object );
	$save_preset_robotstxt->init();

	// Network: Build Robots.txt File For All Network Websites.
	$network_robotstxt_build = new \MsRobotstxtManager\Do_Network_Robotstxt_Build( $post_object );
	$network_robotstxt_build->init();

	// Network: Build Robots.txt File For All Member Websites.
	$member_robotstxt_build = new \MsRobotstxtManager\Do_Member_Robotstxt_Build( $post_object );
	$member_robotstxt_build->init();

	// Network: Delete All Plugin Settings Across Network.
	$delete_settings = new \MsRobotstxtManager\Do_Delete_Settings( $post_object );
	$delete_settings->init();

	// Network: Run Cleaner Tool.
	$cleaner = new \MsRobotstxtManager\Do_Robotstxt_Cleaner( $post_object );
	$cleaner->init();
}
