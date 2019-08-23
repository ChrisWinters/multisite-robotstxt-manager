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

use MsRobotstxtManager\Trait_Security_Check as TraitSecurityCheck;
use MsRobotstxtManager\Plugin_Admin_Notices as PluginAdminNotices;
use MsRobotstxtManager\Option_Manager as OptionManager;

/**
 * Save Network Robots.txt File With Preset.
 */
final class Do_Save_Preset_As_Robotstxt {
	use TraitSecurityCheck;

	/**
	 * Plugin Admin Post Object.
	 *
	 * @var array
	 */
	public $post_object = [];

	/**
	 * Post Action To Take.
	 *
	 * @var string
	 */
	public $post_action = [];

	/**
	 * Option_Manager Class.
	 *
	 * @var object
	 */
	public $option_manager = [];

	/**
	 * Plugin_Admin_Notices Class
	 *
	 * @var object
	 */
	public $admin_notices = [];


	/**
	 * Setup Class
	 *
	 * @param array $post_object Cleaned Post Object.
	 */
	public function __construct( $post_object = [] ) {
		if ( true === empty( $post_object ) || true === empty( $post_object['action'] ) ) {
			return;
		}

		$this->post_object    = $post_object;
		$this->post_action    = $post_object['action'];
		$this->option_manager = new OptionManager();
		$this->admin_notices  = new PluginAdminNotices();
	}//end __construct()


	/**
	 * Init Update Action
	 */
	public function init() {
		if ( true === empty( $this->post_object ) ) {
			return;
		}

		/*
		 * Fires as an admin screen or script is being initialized.
		 * https://developer.wordpress.org/reference/hooks/admin_init/
		 */
		add_action(
			'admin_init',
			[
				$this,
				'update',
			]
		);
	}//end init()


	/**
	 * Security Check & Update On Action
	 */
	public function update() {
		$this->security_check();

		// Save Preset Robots.txt as Network Robots.txt File.
		if ( 'presets' === $this->post_action ) {
			$this->save_preset_as_robotstxt();
		}
	}//end update()


	/**
	 * Save Preset Robots.txt as Network Robots.txt
	 */
	private function save_preset_as_robotstxt() {
		$message = false;
		$preset  = '';

		if ( true !== empty( $this->post_object['preset'] ) ) {
			$preset = $this->post_object['preset'];
		}

		switch ( $preset ) {
			case 'default-robotstxt':
				$this->option_manager->update_site_setting( 'robotstxt', $this->default_robotstxt() );
				$message = true;
				break;

			case 'defaultalt-robotstxt':
				$this->option_manager->update_site_setting( 'robotstxt', $this->defaultalt_robotstxt() );
				$message = true;
				break;

			case 'wordpress-robotstxt':
				$this->option_manager->update_site_setting( 'robotstxt', $this->wordpress_robotstxt() );
				$message = true;
				break;

			case 'open-robotstxt':
				$this->option_manager->update_site_setting( 'robotstxt', $this->open_robotstxt() );
				$message = true;
				break;

			case 'blogger-robotstxt':
				$this->option_manager->update_site_setting( 'robotstxt', $this->blogger_robotstxt() );
				$message = true;
				break;

			case 'block-robotstxt':
				$this->option_manager->update_site_setting( 'robotstxt', $this->blocked_robotstxt() );
				$message = true;
				break;

			case 'google-robotstxt':
				$this->option_manager->update_site_setting( 'robotstxt', $this->google_robotstxt() );
				$message = true;
				break;
		}

		if ( true === $message ) {
			$this->admin_notices->add_notice( 'success', 'save_success', 'network' );
		}
	}//end save_preset_as_robotstxt()


	/**
	 * Default Robots.txt File
	 */
	private function default_robotstxt() {
		$txt  = "# robots.txt\n";
		$txt .= "User-agent: *\n";
		$txt .= "Disallow: /feed\n";
		$txt .= "Disallow: /feed/\n";
		$txt .= "Disallow: /cgi-bin/\n";
		$txt .= "Disallow: /comment\n";
		$txt .= "Disallow: /comments\n";
		$txt .= "Disallow: /trackback\n";
		$txt .= "Disallow: /comment/\n";
		$txt .= "Disallow: /comments/\n";
		$txt .= "Disallow: /trackback/\n";
		$txt .= "Disallow: /wp-admin/\n";
		$txt .= "Disallow: /wp-content/\n";
		$txt .= "Disallow: /wp-includes/\n";
		$txt .= "Disallow: /wp-login.php\n";
		$txt .= "Allow: /wp-admin/admin-ajax.php\n";
		$txt .= '{APPEND_WEBSITE_ROBOTSTXT}';

		return $txt;
	}


	/**
	 * Default-Alt Robots.txt File
	 */
	private function defaultalt_robotstxt() {
		$txt  = "# robots.txt\n";
		$txt .= "User-agent: *\n";
		$txt .= "Disallow: */feed\n";
		$txt .= "Disallow: */feed/\n";
		$txt .= "Disallow: */comment/\n";
		$txt .= "Disallow: */comments/\n";
		$txt .= "Disallow: */trackback/\n";
		$txt .= "Disallow: */comment\n";
		$txt .= "Disallow: */comments\n";
		$txt .= "Disallow: */trackback\n";
		$txt .= "Disallow: /feed\n";
		$txt .= "Disallow: /feed/\n";
		$txt .= "Disallow: /cgi-bin/\n";
		$txt .= "Disallow: /comment\n";
		$txt .= "Disallow: /comment/\n";
		$txt .= "Disallow: /comments\n";
		$txt .= "Disallow: /comments/\n";
		$txt .= "Disallow: /trackback\n";
		$txt .= "Disallow: /trackback/\n";
		$txt .= "Disallow: /wp-admin/\n";
		$txt .= "Disallow: /wp-content/\n";
		$txt .= "Disallow: /wp-includes/\n";
		$txt .= "Disallow: /wp-login.php\n";
		$txt .= "Allow: /wp-admin/admin-ajax.php\n";
		$txt .= '{APPEND_WEBSITE_ROBOTSTXT}';

		return $txt;
	}


	/**
	 * WordPress Only Robots.txt File
	 */
	private function wordpress_robotstxt() {
		$txt  = "# robots.txt\n";
		$txt .= "User-agent: *\n";
		$txt .= "Disallow: /wp-admin/\n";
		$txt .= "Disallow: /wp-includes/\n";
		$txt .= "Allow: /wp-admin/admin-ajax.php\n";
		$txt .= '{APPEND_WEBSITE_ROBOTSTXT}';

		return $txt;
	}


	/**
	 * Open Robots.txt File
	 */
	private function open_robotstxt() {
		$txt  = "# robots.txt\n";
		$txt .= "User-agent: *\n";
		$txt .= "Disallow:\n";
		$txt .= '{APPEND_WEBSITE_ROBOTSTXT}';

		return $txt;
	}


	/**
	 * Blogger Robots.txt File
	 */
	private function blogger_robotstxt() {
		$txt  = "# robots.txt\n";
		$txt .= "User-agent: *\n";
		$txt .= "Disallow: *?\n";
		$txt .= "Disallow: *.inc$\n";
		$txt .= "Disallow: *.php$\n";
		$txt .= "Disallow: */feed\n";
		$txt .= "Disallow: */feed/\n";
		$txt .= "Disallow: */author\n";
		$txt .= "Disallow: */comment/\n";
		$txt .= "Disallow: */comments/\n";
		$txt .= "Disallow: */trackback/\n";
		$txt .= "Disallow: */comment\n";
		$txt .= "Disallow: */comments\n";
		$txt .= "Disallow: */trackback\n";
		$txt .= "Disallow: /wp-\n";
		$txt .= "Disallow: /wp-*\n";
		$txt .= "Disallow: /feed\n";
		$txt .= "Disallow: /feed/\n";
		$txt .= "Disallow: /author\n";
		$txt .= "Disallow: /cgi-bin/\n";
		$txt .= "Disallow: /wp-admin/\n";
		$txt .= "Disallow: /comment/\n";
		$txt .= "Disallow: /comments/\n";
		$txt .= "Disallow: /trackback/\n";
		$txt .= "Disallow: /comment\n";
		$txt .= "Disallow: /comments\n";
		$txt .= "Disallow: /trackback\n";
		$txt .= "Disallow: /wp-admin/\n";
		$txt .= "Disallow: /wp-content/\n";
		$txt .= "Disallow: /wp-includes/\n";
		$txt .= "Disallow: /wp-login.php\n";
		$txt .= "Disallow: /wp-content/cache/\n";
		$txt .= "Disallow: /wp-content/themes/\n";
		$txt .= "Disallow: /wp-content/plugins/\n";
		$txt .= "Allow: /wp-admin/admin-ajax.php\n";
		$txt .= '{APPEND_WEBSITE_ROBOTSTXT}';

		return $txt;
	}


	/**
	 * Disallow Website Robots.txt File
	 */
	private function blocked_robotstxt() {
		$txt  = "# robots.txt\n";
		$txt .= "User-agent: *\n";
		$txt .= 'Disallow: /';

		return $txt;
	}


	/**
	 * Google Friendly Robots.txt File
	 */
	private function google_robotstxt() {
		$txt  = "# robots.txt\n";
		$txt .= "User-agent: *\n";
		$txt .= "Disallow: /wp-\n";
		$txt .= "Disallow: /feed\n";
		$txt .= "Disallow: /feed/\n";
		$txt .= "Disallow: /author\n";
		$txt .= "Disallow: /cgi-bin/\n";
		$txt .= "Disallow: /wp-admin/\n";
		$txt .= "Disallow: /comment/\n";
		$txt .= "Disallow: /comments/\n";
		$txt .= "Disallow: /trackback/\n";
		$txt .= "Disallow: /comment\n";
		$txt .= "Disallow: /comments\n";
		$txt .= "Disallow: /trackback\n";
		$txt .= "Disallow: /wp-content/\n";
		$txt .= "Disallow: /wp-includes/\n";
		$txt .= "Disallow: /wp-login.php\n";
		$txt .= "Disallow: /wp-content/cache/\n";
		$txt .= "Disallow: /wp-content/themes/\n";
		$txt .= "Disallow: /wp-content/plugins/\n";
		$txt .= "Allow: /wp-content/uploads\n";
		$txt .= "Allow: /wp-content/uploads/\n";
		$txt .= "Allow: /wp-admin/admin-ajax.php\n";
		$txt .= '{APPEND_WEBSITE_ROBOTSTXT}';
		$txt .= "\n";
		$txt .= "# google bot\n";
		$txt .= "User-agent: Googlebot\n";
		$txt .= "Disallow: /wp-*\n";
		$txt .= "Disallow: *?\n";
		$txt .= "Disallow: *.inc$\n";
		$txt .= "Disallow: *.php$\n";
		$txt .= "Disallow: */feed\n";
		$txt .= "Disallow: */feed/\n";
		$txt .= "Disallow: */author\n";
		$txt .= "Disallow: */comment/\n";
		$txt .= "Disallow: */comments/\n";
		$txt .= "Disallow: */trackback/\n";
		$txt .= "Disallow: */comment\n";
		$txt .= "Disallow: */comments\n";
		$txt .= "Disallow: */trackback\n";
		$txt .= "\n";
		$txt .= "# google image bot\n";
		$txt .= "User-agent: Googlebot-Image\n";
		$txt .= "Allow: /*\n";

		return $txt;
	}
}//end class
