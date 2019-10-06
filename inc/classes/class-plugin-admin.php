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
use MsRobotstxtManager\Get_Robotstxt_Rules as GetRobotstxtRules;
use MsRobotstxtManager\Option_Manager as OptionManager;

/**
 * Load WordPress Plugin Admin Area
 */
final class Plugin_Admin {
	use TraitQueryString;

	/**
	 * Init Admin Display
	 */
	public function __construct() {
		/*
		 * Fires before the administration menu loads in the admin.
		 * https://developer.wordpress.org/reference/hooks/admin_menu/
		 */
		add_action(
			'admin_menu',
			[
				$this,
				'menu',
			]
		);

		/*
		 * Fires before the administration menu loads in the Network Admin.
		 * https://developer.wordpress.org/reference/hooks/network_admin_menu/
		 */
		add_action(
			'network_admin_menu',
			[
				$this,
				'menu',
			]
		);

		if ( $this->query_string( 'page' ) === MS_ROBOTSTXT_MANAGER_PLUGIN_NAME ) {
			/*
			 * Enqueue Scripts For Plugin Admin
			 * https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
			 */
			add_action(
				'admin_enqueue_scripts',
				[
					$this,
					'enqueue',
				]
			);
		}
	}//end __construct()


	/**
	 * Generate Settings Menu
	 */
	public function menu() {
		/*
		 * Add Settings Page Options
		 * https://developer.wordpress.org/reference/functions/add_submenu_page/
		 */
		add_submenu_page(
			'options-general.php',
			MS_ROBOTSTXT_MANAGER_PLUGIN_NAME,
			__( 'Robots.txt Manager', 'multisite-robotstxt-manager' ),
			'manage_options',
			MS_ROBOTSTXT_MANAGER_PLUGIN_NAME,
			[
				$this,
				'templates',
			]
		);

		/*
		 * Add Settings Page Options
		 * https://developer.wordpress.org/reference/functions/add_submenu_page/
		 */
		add_submenu_page(
			'settings.php',
			MS_ROBOTSTXT_MANAGER_PLUGIN_NAME,
			__( 'Robots.txt Manager', 'multisite-robotstxt-manager' ),
			'manage_options',
			MS_ROBOTSTXT_MANAGER_PLUGIN_NAME,
			[
				$this,
				'templates',
			]
		);
	}//end menu()


	/**
	 * Enqueue Stylesheet and jQuery
	 */
	public function enqueue() {
		/*
		 * Enqueue a CSS stylesheet.
		 * https://developer.wordpress.org/reference/functions/wp_enqueue_style/
		 *
		 * Retrieves a URL within the plugins directory.
		 * https://developer.wordpress.org/reference/functions/plugins_url/
		 */
		wp_enqueue_style(
			MS_ROBOTSTXT_MANAGER_PLUGIN_NAME,
			plugins_url( '/assets/css/style.min.css', MS_ROBOTSTXT_MANAGER_FILE ),
			'',
			date( 'YmdHis', time() ),
			'all'
		);
	}//end enqueue()


	/**
	 * Display Admin Templates
	 */
	public function templates() {
		$dir = dirname( MS_ROBOTSTXT_MANAGER_FILE );
		$tab = $this->query_string( 'tab' );

		$option = new OptionManager();

		if ( true !== is_network_admin() ) {
			$status       = $option->get_setting( 'disable' );
			$append_rules = $option->get_setting( 'append' );
			$uploadpath   = $option->get_setting( 'uploadpath' );
			$themepath    = $option->get_setting( 'themepath' );
			$sitemapurl   = $option->get_setting( 'sitemapurl' );
			$override     = $option->get_setting( 'override' );

			$website_robotstxt = $option->get_setting( 'robotstxt' );

			if ( true !== empty( $override ) ) {
				$website_robotstxt = $append_rules;
			}

			$rules      = new GetRobotstxtRules();
			$uploadpath = ( true === empty( $uploadpath ) ) ? $rules->get_uploadpath() : $uploadpath;
			$themepath  = ( true === empty( $themepath ) ) ? $rules->get_themepath() : $themepath;
			$sitemapurl = ( true === empty( $sitemapurl ) ) ? $rules->get_sitemapurl() : $sitemapurl;
		}

		if ( true === is_network_admin() ) {
			if ( 'cleaner' === $tab ) {
				$checkdata     = $option->get_setting( 'checkdata' );
				$checkphysical = $option->get_setting( 'checkphysical' );
				$checkrewrite  = $option->get_setting( 'checkrewrite' );
			}

			$network_upgrade = $option->get_site_setting( 'upgraded' );

			$sdk = $option->get_site_setting( 'sdk_action' );
		}

		$network_robotstxt = $option->get_site_setting( 'robotstxt' );

		include_once $dir . '/inc/templates/header.php';

		if ( true === file_exists( $dir . '/inc/templates/' . $tab . '.php' ) ) {
			include_once $dir . '/inc/templates/' . $tab . '.php';

			/*
			 * Whether the current request is for the network administrative interface.
			 * https://developer.wordpress.org/reference/functions/is_network_admin/
			 */
		} elseif ( true === is_network_admin() ) {
			include_once $dir . '/inc/templates/network.php';
		} else {
			include_once $dir . '/inc/templates/settings.php';
		}

		include_once $dir . '/inc/templates/footer.php';
	}//end templates()


	/**
	 * Display Admin Area Tabs
	 *
	 * @return string $html Tab Display
	 */
	public function tabs() {
		/*
		 * Escaping for HTML blocks.
		 * https://developer.wordpress.org/reference/functions/esc_html__/
		 */
		$admin_tabs = [
			'settings' => esc_html__( 'Settings', 'multisite-robotstxt-manager' ),
		];

		/*
		 * Whether the current request is for the network administrative interface.
		 * https://developer.wordpress.org/reference/functions/is_network_admin/
		 *
		 * Escaping for HTML blocks.
		 * https://developer.wordpress.org/reference/functions/esc_html__/
		 */
		if ( true === is_network_admin() ) {
			$admin_tabs = [
				'network' => esc_html__( 'Network', 'multisite-robotstxt-manager' ),
				'cleaner' => esc_html__( 'Cleaner', 'multisite-robotstxt-manager' ),
			];
		}

		$html = '<h2 class="nav-tab-wrapper">';

		if ( true !== empty( $this->query_string( 'tab' ) ) ) {
			$current_tab = $this->query_string( 'tab' );
		} else {
			$current_tab = key( $admin_tabs );
		}

		$pagename = $this->query_string( 'page' );

		$posttype = '';
		if ( MS_ROBOTSTXT_MANAGER_PLUGIN_NAME === $this->query_string( 'post_type' ) ) {
			$posttype = '&post_type=' . $this->query_string( 'post_type' );
		}

		foreach ( $admin_tabs as $tab => $name ) {
			$class = '';
			if ( $tab === $current_tab ) {
				$class = ' nav-tab-active';
			}

			$html .= '<a href="?page=' . $pagename .
			'&tab=' . $tab . $posttype .
			'" class="nav-tab' . $class . '">' . $name . '</a>';
		}

		$html .= '</h2><br />';

		return $html;
	}//end tabs()
}//end class
