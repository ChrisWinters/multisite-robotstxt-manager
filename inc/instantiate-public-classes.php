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

// Loads Translated Strings.
$translate = new \MsRobotstxtManager\Translate();

// Display Robots.txt File.
$robotstxt = new \MsRobotstxtManager\Robotstxt();
