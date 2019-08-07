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
 * Load Plugin Translation Strings & .mo File
 */
final class Translate {
	/**
	 * Maybe Init Translate
	 */
	public static function init() {
		/*
		 * Call the functions added to a filter hook.
		 * https://developer.wordpress.org/reference/functions/apply_filters/
		 *
		 * Retrieves the current locale.
		 * https://developer.wordpress.org/reference/functions/get_locale/
		 */
		$get_locale = apply_filters(
			'plugin_locale',
			get_locale(),
			MS_ROBOTSTXT_MANAGER_PLUGIN_NAME
		);

		$load_mo_file = MS_ROBOTSTXT_MANAGER_PLUGIN_DIR . '/lang/' . $get_locale . '.mo';

		if ( true === file_exists( $load_mo_file ) ) {
			/*
			 * Load a .mo file into the text domain $textdomain.
			 * https://developer.wordpress.org/reference/functions/load_textdomain/
			 */
			load_textdomain(
				MS_ROBOTSTXT_MANAGER_PLUGIN_NAME,
				$load_mo_file
			);
		}

		/*
		 * Loads a plugin’s translated strings.
		 * https://developer.wordpress.org/reference/functions/load_plugin_textdomain/
		 */
		load_plugin_textdomain(
			MS_ROBOTSTXT_MANAGER_PLUGIN_NAME,
			false,
			MS_ROBOTSTXT_MANAGER_FILE . '/lang/'
		);
	}
}//end class
