<?php
/**
 * Freemius
 *
 * @package    WordPress
 * @subpackage Plugin
 * @author     Chris W. <chrisw@null.net>
 * @license    GNU GPLv3
 * @link       /LICENSE
 */

if ( false === file_exists( dirname( MS_ROBOTSTXT_MANAGER_FILE ) . '/sdk/freemius/start.php' ) ) {
	return;
}

if ( true === function_exists( 'msrtm_fs' ) ) {
	msrtm_fs()->set_basename( true, MS_ROBOTSTXT_MANAGER_FILE );
} elseif ( false === function_exists( 'msrtm_fs' ) ) {
	/**
	 * Freemius Integration
	 */
	function msrtm_fs() {
		global $msrtm_fs;

		if ( false === isset( $msrtm_fs ) ) {
			if ( false === defined( 'WP_FS__PRODUCT_4131_MULTISITE' ) ) {
				define( 'WP_FS__PRODUCT_4131_MULTISITE', true );
			}

			require_once dirname( MS_ROBOTSTXT_MANAGER_FILE ) . '/sdk/freemius/start.php';

			$msrtm_fs = fs_dynamic_init(
				array(
					'id'                  => '4131',
					'slug'                => 'multisite-robotstxt-manager',
					'premium_slug'        => 'multisite-robotstxt-manager-pro',
					'type'                => 'plugin',
					'public_key'          => 'pk_fbaf5afa36f15afd0f444f9ec08e5',
					'is_premium'          => false,
					'has_addons'          => false,
					'has_paid_plans'      => true,
					'delegation'          => false,
					'has_affiliation'     => 'selected',
					'is_live'             => true,
					'menu'                => array(
						'slug'        => 'multisite-robotstxt-manager',
						'account'     => true,
						'contact'     => false,
						'support'     => false,
						'network'     => true,
						'affiliation' => false,
						'pricing'     => false,
						'parent'      => array(
							'slug' => 'settings.php',
						),
					),
				)
			);
		}

		return $msrtm_fs;
	}//end msrtm_fs()

	msrtm_fs();
	do_action( 'msrtm_fs_loaded' );
}
