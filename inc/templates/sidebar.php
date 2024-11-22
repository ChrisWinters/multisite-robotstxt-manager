<?php
/**
 * Plugin Admin Template
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

/*
 * Retrieve or display nonce hidden field for forms.
 * https://developer.wordpress.org/reference/functions/wp_nonce_field/
 *
 * Display translated text.
 * https://developer.wordpress.org/reference/functions/esc_html_e/
 *
 * Escaping for HTML attributes.
 * https://developer.wordpress.org/reference/functions/esc_attr/
 *
 * Checks and cleans a URL.
 * https://developer.wordpress.org/reference/functions/esc_url/
 */
?>
<div class="postbox">
	<div class="h5 p-1 font-weight-bold"><?php esc_html_e( 'Robots.txt Manager', 'multisite-robotstxt-manager' ); ?></div>
<div class="inside" style="clear:both;padding-top:1px;"><div class="para">
	<ul>
		<li>&bull; <a href="https://github.com/ChrisWinters/multisite-robotstxt-manager" target="_blank"><?php esc_html_e( 'Plugin Home Page', 'multisite-robotstxt-manager' ); ?></a></li>
		<li>&bull; <a href="https://github.com/ChrisWinters/multisite-robotstxt-manager/issues" target="_blank"><?php esc_html_e( 'Bugs & Feature Requests', 'multisite-robotstxt-manager' ); ?></a></li>
	</ul>
</div></div> <!-- end inside-pad & inside -->
</div> <!-- end postbox -->

<p><a href="https://github.com/ChrisWinters/multisite-robotstxt-manager" target="_blank"><img src="<?php echo esc_url( plugin_dir_url( MS_ROBOTSTXT_MANAGER_FILE ) ); ?>/assets/images/sidebar_rate-plugin.gif" alt="<?php esc_html_e( 'Please Rate This Plugin At Wordpress.org!', 'multisite-robotstxt-manager' ); ?>" /></a></p>

<div class="postbox">
	<div class="h5 p-1 font-weight-bold"><?php esc_html_e( 'Robots.txt Help', 'multisite-robotstxt-manager' ); ?></div>
<div class="inside" style="clear:both;padding-top:1px;"><div class="para">

	<ul>
		<li>&bull; <a href="https://wordpress.org/support/article/search-engine-optimization/#robots-txt-optimization" target="_blank"><?php esc_html_e( 'Robots.txt Optimization Tips', 'multisite-robotstxt-manager' ); ?></a></li>
		<li>&bull; <a href="http://www.askapache.com/seo/wordpress-robotstxt-seo/" target="_blank"><?php esc_html_e( 'AskAapche Robots.txt Example', 'multisite-robotstxt-manager' ); ?></a></li>
		<li>&bull; <a href="https://developers.google.com/webmasters/control-crawl-index/docs/faq" target="_blank"><?php esc_html_e( 'Google Robots.txt F.A.Q.', 'multisite-robotstxt-manager' ); ?></a></li>
		<li>&bull; <a href="https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt" target="_blank"><?php esc_html_e( 'Robots.txt Specifications', 'multisite-robotstxt-manager' ); ?></a></li>
		<li>&bull; <a href="http://www.robotstxt.org/db.html" target="_blank"><?php esc_html_e( 'Web Robots Database', 'multisite-robotstxt-manager' ); ?></a></li>
	</ul>

</div></div> <!-- end inside-pad & inside -->
</div> <!-- end postbox -->
