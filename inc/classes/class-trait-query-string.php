<?php
/**
 * Class Trait
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
 * Process Plugin Admin Query String
 */
trait Trait_Query_String {
	/**
	 * Get Query String Item & Sanitize
	 *
	 * @param string $get Query String Get Item.
	 *
	 * @return string Query String Item Sanitized
	 */
	final public function query_string( $get ) {
		$string = filter_input(
			INPUT_GET,
			$get,
			FILTER_SANITIZE_STRING,
			( FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK )
		);

		if ( true !== isset( $string ) ) {
			return false;
		};

		$string = strtolower( $string );

		$string = preg_replace( '/\s/', '', $string );

		/*
		 * Sanitizes a string from user input or from the database.
		 * https://developer.wordpress.org/reference/functions/sanitize_text_field/
		 */
		return sanitize_text_field( $string );
	}//end query_string()
}//end trait
