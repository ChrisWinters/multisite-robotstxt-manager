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
	// Loads Translated Strings.
	$ms_robotstxt_manager_translate = new \MsRobotstxtManager\Translate();

	// Display Plugin Admin.
	$ms_robotstxt_manager_plugin_admin = new \MsRobotstxtManager\Plugin_Admin();

	// Manage Admin Updates.
	$ms_robotstxt_manager_plugin_admin_post = new \MsRobotstxtManager\Plugin_Admin_Post();
	$ms_robotstxt_manager_post_object       = $ms_robotstxt_manager_plugin_admin_post->get_post_object();

	// Website: Save Append Rules.
	$ms_robotstxt_manager_save_append_rules = new \MsRobotstxtManager\Do_Save_Append_Rules( $ms_robotstxt_manager_post_object );
	$ms_robotstxt_manager_save_append_rules->init();

	// Website: Disable Website.
	$ms_robotstxt_manager_disable_website = new \MsRobotstxtManager\Do_Disable_Website( $ms_robotstxt_manager_post_object );
	$ms_robotstxt_manager_disable_website->init();

	// Network: Save SDK Options.
	$ms_robotstxt_manager_save_sdk = new \MsRobotstxtManager\Do_Save_Sdk( $ms_robotstxt_manager_post_object );
	$ms_robotstxt_manager_save_sdk->init();

	// Network: Save Network Robots.txt File.
	$ms_robotstxt_manager_save_network_robotstxt = new \MsRobotstxtManager\Do_Save_Network_Robotstxt( $ms_robotstxt_manager_post_object );
	$ms_robotstxt_manager_save_network_robotstxt->init();

	// Network: Save Preset As Network Robots.txt File.
	$ms_robotstxt_manager_save_preset_robotstxt = new \MsRobotstxtManager\Do_Save_Preset_As_Robotstxt( $ms_robotstxt_manager_post_object );
	$ms_robotstxt_manager_save_preset_robotstxt->init();

	// Network: Build Robots.txt File For All Network Websites.
	$ms_robotstxt_manager_network_robotstxt_build = new \MsRobotstxtManager\Do_Network_Robotstxt_Build( $ms_robotstxt_manager_post_object );
	$ms_robotstxt_manager_network_robotstxt_build->init();

	// Network: Build Robots.txt File For All Member Websites.
	$ms_robotstxt_manager_member_robotstxt_build = new \MsRobotstxtManager\Do_Member_Robotstxt_Build( $ms_robotstxt_manager_post_object );
	$ms_robotstxt_manager_member_robotstxt_build->init();

	// Network: Delete All Plugin Settings Across Network.
	$ms_robotstxt_manager_delete_settings = new \MsRobotstxtManager\Do_Delete_Settings( $ms_robotstxt_manager_post_object );
	$ms_robotstxt_manager_delete_settings->init();

	// Network: Run Cleaner Tool.
	$ms_robotstxt_manager_robotstxt_cleaner = new \MsRobotstxtManager\Do_Robotstxt_Cleaner( $ms_robotstxt_manager_post_object );
	$ms_robotstxt_manager_robotstxt_cleaner->init();
}
