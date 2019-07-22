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
// Display Robots.txt File.
$ms_robotstxt_manager_robotstxt = new \MsRobotstxtManager\Robotstxt();