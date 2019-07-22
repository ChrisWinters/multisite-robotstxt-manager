<?php
/**
 * Feature Class
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

/**
 * Loads Translated Strings
 */
final class Translate {
	/**
	 * Init Class
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'textdomain' ] );
	}


	/**
	 * Load Plugin Textdomain
	 */
	public function textdomain() {
		$domain = MS_ROBOTSTXT_MANAGER_PLUGIN_NAME;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, basename( dirname( __FILE__ ) ) . '/lang/' );
	}
}//end class
