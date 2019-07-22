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
 * Retrieve the translation of $text and escapes it for safe use in HTML output.
 * https://developer.wordpress.org/reference/functions/esc_html__/
 *
 * Escaping for HTML attributes.
 * https://developer.wordpress.org/reference/functions/esc_attr/
 *
 * Checks and cleans a URL.
 * https://developer.wordpress.org/reference/functions/esc_url/
 *
 * Display translated text.
 * https://developer.wordpress.org/reference/functions/esc_html_e/
 *
 * Outputs the html checked attribute.
 * https://developer.wordpress.org/reference/functions/checked/
 *
 * Echoes a submit button, with provided text and appropriate class( es ).
 * https://developer.wordpress.org/reference/functions/submit_button/
 */
?>
<form enctype="multipart/form-data" method="post" action="">
<?php
wp_nonce_field(
	MS_ROBOTSTXT_MANAGER_SETTING_PREFIX . 'action',
	MS_ROBOTSTXT_MANAGER_SETTING_PREFIX . 'nonce'
);
?>
<input type="hidden" name="action" value="cleaner" />

<p class="text-dark font-weight-bold h4"><?php esc_html_e( 'Check For Old Robots.txt File Settings', 'multisite-robotstxt-manager' ); ?></p>
<p class="description"><?php esc_html_e( 'If you are having problems with a websites robots.txt file to displaying properly, it is possible that old robots.txt file data left over from other plugins is conflicting. Click the "scan for old data" button below to scan the network for left over data. If any is found, a notice will display with a new button to automatically clean out the left over data.', 'multisite-robotstxt-manager' ); ?></p>
<div class="mt-3"><input type="submit" name="check-data" id="submit" class="button button-secondary" value="scan for old data"></div>

<?php if ( 'error' === $checkdata ) { ?>
	<hr />
	<p class="text-danger font-weight-bold h4"><?php esc_html_e( 'Old Robots.txt File Settings Found', 'multisite-robotstxt-manager' ); ?></p>
	<p class="description"><?php esc_html_e( 'Click the "remove old data" button below to purge the old settings.', 'multisite-robotstxt-manager' ); ?></p>
	<div class="mt-3"><input type="submit" name="clean-data" id="submit" class="button button-primary" value="remove old data"></div>
<?php } ?>

<hr class="my-5" />

<p class="text-dark font-weight-bold h4"><?php esc_html_e( 'Check For Real (physical) Robots.txt File', 'multisite-robotstxt-manager' ); ?></p>
<p class="description"><?php esc_html_e( 'If network/website changes do not appear to override the robots.txt file or if the file is blank, it is possible that a plugin created a physical (hard) robots.txt file. Click the "scan for physical file" button below to check the website for a real robots.txt file. If one is found, a notice will display with a new button allowing you to delete the file.', 'multisite-robotstxt-manager' ); ?></p>
<div class="mt-3"><input type="submit" name="check-physical" id="submit" class="button button-secondary" value="scan for physical file"></div>

<?php if ( 'error' === $checkphysical ) { ?>
	<hr />
	<p class="text-danger font-weight-bold h4"><?php esc_html_e( 'A Real Robots.txt File Was Found', 'multisite-robotstxt-manager' ); ?></p>
	<p class="description"><?php esc_html_e( 'Click the "delete physical file" button below to delete the real robots.txt file.', 'multisite-robotstxt-manager' ); ?></p>
	<div class="mt-3"><input type="submit" name="clean-physical" id="submit" class="button button-primary" value="delete physical file"></div>
<?php } ?>

<hr class="my-5" />

<p class="text-dark font-weight-bold h4"><?php esc_html_e( 'Check For Robots.txt Rewrite Rule', 'multisite-robotstxt-manager' ); ?></p>
<p class="description"><?php esc_html_e( 'If your robots.txt files are blank, it is possible the website is missing the rewrite rule index.php?robots=1. Click the "scan for missing rule" button below to scan the for the missing rule. If the rule is missing, a notice will display with a new button to automatically add the rule for you.', 'multisite-robotstxt-manager' ); ?></p>
<div class="mt-3"><input type="submit" name="check-rewrite" id="submit" class="button button-secondary" value="scan for missing rule"></div>

<?php if ( 'error' === $checkrewrite ) { ?>
	<hr />
	<p class="text-danger font-weight-bold h4"><?php esc_html_e( 'Website Rewrite Rule Missing', 'multisite-robotstxt-manager' ); ?></p>
	<p class="description"><?php esc_html_e( 'Click the "add missing rule" button below to add the missing rule.', 'multisite-robotstxt-manager' ); ?></p>
	<div class="mt-3"><input type="submit" name="add-rewrite" id="submit" class="button button-primary" value="correct missing rule"></div>
<?php } ?>

</form>
