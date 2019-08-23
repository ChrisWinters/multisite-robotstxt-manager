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

<?php if ( msrtm_fs()->is_anonymous() ) { ?>
<form enctype="multipart/form-data" method="post" action="">
	<?php
	wp_nonce_field(
		MS_ROBOTSTXT_MANAGER_SETTING_PREFIX . 'action',
		MS_ROBOTSTXT_MANAGER_SETTING_PREFIX . 'nonce'
	);
	?>
<input type="hidden" name="action" value="reconnect" />
<input type="submit" name="submit" value=" <?php esc_html_e( 'Connect To Plugin Services', 'multisite-robotstxt-manager' ); ?> " />
</form>
<?php } ?>
	<ul>
<?php if ( msrtm_fs()->is_not_paying() ) { ?>
		<li class="font-weight-bold">→ <a href="<?php echo esc_url( network_site_url( 'wp-admin/network' ) ); ?>/settings.php?page=multisite-robotstxt-manager-pricing"><?php esc_html_e( 'Pro Plugin: Automation Upgrade', 'multisite-robotstxt-manager' ); ?></a></li>
<?php } ?>
		<li class="font-weight-bold">&bull; <a href="<?php echo esc_url( network_site_url( 'wp-admin/network' ) ); ?>/settings.php?page=multisite-robotstxt-manager-affiliation"><?php esc_html_e( 'Affiliates Earn 50% Revshare', 'multisite-robotstxt-manager' ); ?></a></li>
		<li>&bull; <a href="<?php echo esc_url( network_site_url( 'wp-admin/network' ) ); ?>/settings.php?page=multisite-robotstxt-manager-contact"><?php esc_html_e( 'Contact Support', 'multisite-robotstxt-manager' ); ?></a></li>
		<li>&bull; <a href="https://wordpress.org/support/plugin/multisite-robotstxt-manager/" target="_blank"><?php esc_html_e( 'WordPress Forum', 'multisite-robotstxt-manager' ); ?></a></li>
		<li>&bull; <a href="https://github.com/ChrisWinters/multisite-robotstxt-manager" target="_blank"><?php esc_html_e( 'Plugin Home Page', 'multisite-robotstxt-manager' ); ?></a></li>
		<li>&bull; <a href="https://github.com/ChrisWinters/multisite-robotstxt-manager/issues" target="_blank"><?php esc_html_e( 'Bugs & Feature Requests', 'multisite-robotstxt-manager' ); ?></a></li>
	</ul>
</div></div> <!-- end inside-pad & inside -->
</div> <!-- end postbox -->

<div class="postbox">
	<div class="h5 p-1 font-weight-bold"><?php esc_html_e( 'Notice', 'multisite-robotstxt-manager' ); ?>:</div>
<div class="inside" style="clear:both;padding-top:1px;"><div class="para">

	<?php esc_html_e( 'Please report any issues, bugs, or problems you have - your help is greatly appreciated.', 'multisite-robotstxt-manager' ); ?>

	<ul>
		<li><a href="<?php echo esc_url( network_site_url( 'wp-admin/network' ) ); ?>/settings.php?page=multisite-robotstxt-manager-contact"><?php esc_html_e( 'Direct Email', 'multisite-robotstxt-manager' ); ?></a></li>
		<li><a href="https://github.com/ChrisWinters/multisite-robotstxt-manager/issues" target="_blank"><?php esc_html_e( 'Github Issues', 'multisite-robotstxt-manager' ); ?></a></li>
		<li><a href="https://wordpress.org/support/plugin/multisite-robotstxt-manager/" target="_blank"><?php esc_html_e( 'WordPress Forum', 'multisite-robotstxt-manager' ); ?></a></li>
	</ul>

</div></div> <!-- end inside-pad & inside -->
</div> <!-- end postbox -->

<?php if ( msrtm_fs()->is_not_paying() ) { ?>
<p><a href="<?php echo esc_url( network_site_url( 'wp-admin/network' ) ); ?>/settings.php?page=multisite-robotstxt-manager-pricing"><img src="<?php echo esc_url( plugin_dir_url( MS_ROBOTSTXT_MANAGER_FILE ) ); ?>/assets/images/sidebar_pro-plugin.gif" alt="<?php esc_html_e( 'Pro Automation Plugin!', 'multisite-robotstxt-manager' ); ?>" /></a></p>
<?php } ?>

<p><a href="https://wordpress.org/support/plugin/multisite-robotstxt-manager/reviews/?rate=5#new-post" target="_blank"><img src="<?php echo esc_url( plugin_dir_url( MS_ROBOTSTXT_MANAGER_FILE ) ); ?>/assets/images/sidebar_rate-plugin.gif" alt="<?php esc_html_e( 'Please Rate This Plugin At Wordpress.org!', 'multisite-robotstxt-manager' ); ?>" /></a></p>

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
