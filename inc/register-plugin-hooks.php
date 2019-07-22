<?php
/**
 * WordPress Plugin Hooks
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
 * Set the activation hook for a plugin.
 * https://developer.wordpress.org/reference/functions/register_activation_hook/
 */
register_activation_hook(
	MS_ROBOTSTXT_MANAGER_FILE,
	[
		'MsRobotstxtManager\Plugin_Activate',
		'init',
	]
);

msrtm_fs()->add_action(
	'after_uninstall',
	'msrtm_fs_uninstall_cleanup'
);
