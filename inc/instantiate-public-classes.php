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

if ( ( msrtm_fs()->is__premium_only() ) ) {
	// Pro: Automatically Generate Robot.txt Files.
	$ms_robotstxt_manager_pro_generate_robotstxt = new \MsRobotstxtManager\Pro_Generate_Robotstxt();
}

// Display Robots.txt File.
$ms_robotstxt_manager_robotstxt = new \MsRobotstxtManager\Robotstxt();
