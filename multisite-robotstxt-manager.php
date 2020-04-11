<?php
/**
 * Plugin Name: Multisite Robots.txt Manager | MS Robots.txt
 * Plugin URI: https://github.com/ChrisWinters/multisite-robotstxt-manager
 * Description: A Multisite Network Robots.txt Manager. Quickly manage your Network Websites robots.txt files from a single administration area.
 * Tags: robotstxt, robots.txt, robots, robot, spiders, virtual, search, google, seo, plugin, network, wpmu, multisite, technerdia, tribalnerd
 * Version: 3.0.0
 * License: GNU GPLv3
 * Copyright (c) 2017-2019 Chris Winters
 * Author: tribalNerd, Chris Winters
 * Author URI: https://github.com/ChrisWinters
 * Text Domain: multisite-robotstxt-manager
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

define( 'MS_ROBOTSTXT_MANAGER_DIR', __DIR__ );
define( 'MS_ROBOTSTXT_MANAGER_FILE', __FILE__ );
define( 'MS_ROBOTSTXT_MANAGER_VERSION', '3.0.0' );
define( 'MS_ROBOTSTXT_MANAGER_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'MS_ROBOTSTXT_MANAGER_PLUGIN_NAME', 'multisite-robotstxt-manager' );
define( 'MS_ROBOTSTXT_MANAGER_SETTING_PREFIX', 'multisite-robotstxt_manager_' );

require_once dirname( __FILE__ ) . '/sdk/msrtm-fs.php';
require_once dirname( __FILE__ ) . '/inc/autoload-classes.php';

/*
 * Hooks a function on to a specific action.
 * https://developer.wordpress.org/reference/functions/add_action/
 *
 * Hooks a function on to a specific action.
 * https://developer.wordpress.org/reference/functions/add_action/
 */
add_action(
	'plugins_loaded',
	array(
		'MsRobotstxtManager\Translate',
		'init',
	)
);

add_action(
	'plugins_loaded',
	array(
		'MsRobotstxtManager\MsRobotstxtManager',
		'init',
	)
);

/*
 * Set the activation hook for a plugin.
 * https://developer.wordpress.org/reference/functions/register_activation_hook/
 */
register_activation_hook(
	__FILE__,
	array(
		'MsRobotstxtManager\Plugin_Activate',
		'init',
	)
);
