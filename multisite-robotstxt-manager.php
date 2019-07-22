<?php
/**
 * Plugin Name: Multisite Robots.txt Manager | MS Robots.txt
 * Plugin URI: https://github.com/ChrisWinters/multisite-robotstxt-manager
 * Description: A Multisite Network Robots.txt Manager. Quickly manage your Network Websites robots.txt files from a single administration area.
 * Tags: robotstxt, robots.txt, robots, robot, spiders, virtual, search, google, seo, plugin, network, wpmu, multisite, technerdia, tribalnerd
 * Version: 2.0.0
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
 *
 * @fs_premium_only /inc/classes/class-pro-build-append-rules.php, /inc/classes/class-pro-generate-robotstxt, /inc/classes/class-pro-plugin-admin-save.php, /inc/templates/automate.php
 */

namespace MsRobotstxtManager;

if ( false === defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MS_ROBOTSTXT_MANAGER_DIR', __DIR__ );
define( 'MS_ROBOTSTXT_MANAGER_FILE', __FILE__ );
define( 'MS_ROBOTSTXT_MANAGER_VERSION', '2.0.0' );
define( 'MS_ROBOTSTXT_MANAGER_PLUGIN_NAME', 'multisite-robotstxt-manager' );
define( 'MS_ROBOTSTXT_MANAGER_SETTING_PREFIX', 'multisite-robotstxt_manager_' );

require_once dirname( __FILE__ ) . '/sdk/msrtm-fs.php';
require_once dirname( __FILE__ ) . '/inc/autoload-classes.php';
require_once dirname( __FILE__ ) . '/inc/instantiate-public-classes.php';
require_once dirname( __FILE__ ) . '/inc/instantiate-admin-classes.php';
require_once dirname( __FILE__ ) . '/inc/instantiate-network-classes.php';
require_once dirname( __FILE__ ) . '/inc/register-plugin-hooks.php';
