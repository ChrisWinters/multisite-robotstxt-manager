<?php
/**
 * Manager Class
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

use MsRobotstxtManager\Trait_Query_String as TraitQueryString;


/**
 * Save/Update Plugin Settings
 */
class Plugin_Admin_Post {
	use TraitQueryString;

	/**
	 * Plugin Admin Post Object.
	 *
	 * @var array
	 */
	public $post_object = [];


	/**
	 * Set Class Params
	 */
	public function __construct() {
		if ( $this->query_string( 'page' ) !== MS_ROBOTSTXT_MANAGER_PLUGIN_NAME ) {
			return;
		}

		$post_object_array = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
		$post_object       = $this->unset_post_items( $post_object_array );

		if ( true === empty( $post_object ) ) {
			return;
		}

		$this->post_object = $post_object;
	}//end __construct()


	/**
	 * Get Cleaned Post Object
	 */
	public function get_post_object() {
		return $this->post_object;
	}//end get_post_object()


	/**
	 * Unset Post Objects
	 *
	 * @param array $post_array Form Post Object.
	 *
	 * @return array|void
	 */
	final public function unset_post_items( $post_array ) {
		unset( $post_array['submit'] );
		unset( $post_array[ MS_ROBOTSTXT_MANAGER_SETTING_PREFIX . 'nonce' ] );
		unset( $post_array['_wp_http_referer'] );

		if ( true !== empty( $post_array ) ) {
			unset( $post_array['section'] );

			return $post_array;
		}
	}//end unset_post_items()
}//end class
