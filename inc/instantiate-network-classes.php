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
	// Maybe Upgrade Plugin.
	$maybe_upgrade_plugin = new \MsRobotstxtManager\Plugin_Upgrade( $post_object );
	$maybe_upgrade_plugin->init();

	// SDK: Save Dismiss Status.
	$freemius = new \MsRobotstxtManager\Do_Save_Sdk( $post_object );
	$freemius->init();
}
