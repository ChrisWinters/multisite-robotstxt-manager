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

/**
 * WordPress Options Manager
 */
class Option_Manager {
	/**
	 * Get Option Data
	 *
	 * @param string $str Option Name.
	 *
	 * @return array
	 */
	public function get_option( $str = '' ) {
		/*
		 * Retrieves an option value based on an option name.
		 * https://developer.wordpress.org/reference/functions/get_option/
		 */
		$get_option = get_option( MS_ROBOTSTXT_MANAGER_PLUGIN_NAME . $str );

		if ( true !== empty( $get_option ) ) {
			return $get_option;
		}

		return '';
	}//end get_option()


	/**
	 * Get Option Setting
	 *
	 * @param mixed  $setting_name Name Of Option To Get.
	 * @param string $str          Option Name.
	 *
	 * @return string
	 */
	public function get_setting( $setting_name, $str = '' ) {
		$get_option = $this->get_option( $str );

		if ( true === isset( $get_option[ $setting_name ] ) ) {
			return $get_option[ $setting_name ];
		}

		return '';
	}//end get_setting()


	/**
	 * Get Network Site Option
	 *
	 * @param string $str Option Name.
	 *
	 * @return array
	 */
	public function get_site_option( $str = '' ) {
		/*
		 * Retrieve an option value for the current network based on name of option.
		 * https://developer.wordpress.org/reference/functions/get_site_option/
		 */
		$get_option = get_site_option( MS_ROBOTSTXT_MANAGER_PLUGIN_NAME . $str );

		if ( true !== empty( $get_option ) ) {
			return $get_option;
		}

		return '';
	}//end get_site_option()


	/**
	 * Get Network Option Setting
	 *
	 * @param mixed  $setting_name Name Of Option To Get.
	 * @param string $str          Option Name.
	 *
	 * @return string
	 */
	public function get_site_setting( $setting_name, $str = '' ) {
		$get_option = $this->get_site_option( $str );

		if ( true === isset( $get_option[ $setting_name ] ) ) {
			return $get_option[ $setting_name ];
		}

		return '';
	}//end get_site_setting()


	/**
	 * Update Option Array
	 *
	 * @param mixed  $option_array Prepared Option Array.
	 * @param string $str          Option Name.
	 */
	public function update_option( $option_array = [], $str = '' ) {
		if ( true === empty( $option_array ) ) {
			return;
		}

		/*
		 * Update the value of an option that was already added.
		 * https://developer.wordpress.org/reference/functions/update_option/
		 */
		update_option(
			MS_ROBOTSTXT_MANAGER_PLUGIN_NAME . $str,
			$option_array
		);
	}//end update_option()


	/**
	 * Update Option Array
	 *
	 * @param array  $option_value Data To Save.
	 * @param string $str          Option Name.
	 */
	public function update_site_option( $option_value = [], $str = '' ) {
		if ( true === empty( $option_value ) ) {
			return;
		}

		/*
		 * Update the value of an option that was already added for the current network.
		 * https://developer.wordpress.org/reference/functions/update_site_option/
		 */
		update_site_option(
			MS_ROBOTSTXT_MANAGER_PLUGIN_NAME . $str,
			$option_value
		);
	}//end update_site_option()


	/**
	 * Update Setting Within Option
	 *
	 * @param mixed  $setting_name  Name Of Option To Save.
	 * @param mixed  $setting_value The Value To Save.
	 * @param string $str           Option Name.
	 */
	public function update_setting( $setting_name, $setting_value, $str = '' ) {
		$get_option = $this->get_option( $str );

		if ( true === empty( $get_option ) ) {
			$get_option = [];
		}

		if ( true === is_array( $get_option ) && true === array_key_exists( $setting_name, $get_option ) ) {
			unset( $get_option[ $setting_name ] );
		}

		$this->update_option( array_merge( $get_option, [ $setting_name => $setting_value ] ), $str );
	}//end update_setting()


	/**
	 * Update Setting Within Network Option
	 *
	 * @param mixed  $setting_name  Name Of Option To Save.
	 * @param mixed  $setting_value The Value To Save.
	 * @param string $str           Option Name.
	 */
	public function update_site_setting( $setting_name, $setting_value, $str = '' ) {
		$get_option = $this->get_site_option( $str );

		if ( true === empty( $get_option ) ) {
			$get_option = [];
		}

		if ( true === is_array( $get_option ) && true === array_key_exists( $setting_name, $get_option ) ) {
			unset( $get_option[ $setting_name ] );
		}

		$this->update_site_option( array_merge( $get_option, [ $setting_name => $setting_value ] ), $str );
	}//end update_site_setting()


	/**
	 * Delete Option
	 *
	 * @param string $str Option Name.
	 *
	 * @return void
	 */
	public function delete_option( $str = '' ) {
		$get_option = $this->get_option( $str );

		if ( true === isset( $get_option ) ) {
			/*
			 * Removes a option by name.
			 * https://developer.wordpress.org/reference/functions/delete_option/
			 */
			delete_option( MS_ROBOTSTXT_MANAGER_PLUGIN_NAME . $str );
		}
	}//end delete_option()


	/**
	 * Delete Network Site Option
	 *
	 * @param string $str Option Name.
	 *
	 * @return void
	 */
	public function delete_site_option( $str = '' ) {
		$get_option = $this->get_site_option( $str );

		if ( true === isset( $get_option ) ) {
			/*
			 * Removes a option by name for the current network.
			 * https://developer.wordpress.org/reference/functions/delete_site_option/
			 */
			delete_site_option( MS_ROBOTSTXT_MANAGER_PLUGIN_NAME . $str );
		}
	}//end delete_site_option()


	/**
	 * Delete Option Setting
	 *
	 * @param mixed  $setting_name Name Of Option To Delete.
	 * @param string $str          Option Name.
	 *
	 * @return void
	 */
	public function delete_setting( $setting_name = '', $str = '' ) {
		if ( true === empty( $setting_name ) ) {
			return;
		}

		$get_option = $this->get_option( $str );

		if ( true === is_array( $get_option ) && true === array_key_exists( $setting_name, $get_option ) ) {
			unset( $get_option[ $setting_name ] );

			if ( true !== empty( $get_option ) ) {
				/*
				 * Update the value of an option that was already added.
				 * https://developer.wordpress.org/reference/functions/update_option/
				 */
				update_option(
					MS_ROBOTSTXT_MANAGER_PLUGIN_NAME . $str,
					$get_option
				);
			}
		}

		if ( true === empty( $get_option ) ) {
			$this->delete_option( $str );
		}
	}//end delete_setting()
}//end class
