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
 * Retrieve the translation of $text and escapes it for safe use in HTML output.
 * https://developer.wordpress.org/reference/functions/esc_html__/
 *
 * Checks and cleans a URL.
 * https://developer.wordpress.org/reference/functions/esc_url/
 *
 * Display translated text.
 * https://developer.wordpress.org/reference/functions/esc_html_e/
 *
 * Echoes a submit button, with provided text and appropriate class( es ).
 * https://developer.wordpress.org/reference/functions/submit_button/
 */
?>
<form enctype="multipart/form-data" method="post" action="">
<?php

/*
 * Retrieve or display nonce hidden field for forms.
 * https://developer.wordpress.org/reference/functions/wp_nonce_field/
 */
wp_nonce_field(
	MS_ROBOTSTXT_MANAGER_SETTING_PREFIX . 'action',
	MS_ROBOTSTXT_MANAGER_SETTING_PREFIX . 'nonce'
);
?>
<input type="hidden" name="action" value="append" />

<?php if ( true !== empty( $status ) ) { ?>
	<p><span class="text-danger font-weight-bold"><?php esc_html_e( 'WARNING', 'multisite-robotstxt-manager' ); ?></span> <?php esc_html_e( 'The Default WordPress Robots.txt File Is Current Displaying! Update the append rules to enable the robots.txt manager for this website.', 'multisite-robotstxt-manager' ); ?></p>
<?php } ?>

<table class="form-table">
	<tbody>
		<tr>
		<td>
			<div class="text-dark font-weight-bold p-0 m-0 h5"><?php esc_html_e( 'Robots.txt Custom Append Rules', 'multisite-robotstxt-manager' ); ?></div>
			<p class="description"><?php esc_html_e( 'The custom append rules below will replace the {APPEND_WEBSITE_ROBOTSTXT} marker from the network robots.txt file, potentially creating a unique robots.txt file for this website.', 'multisite-robotstxt-manager' ); ?> &bull; <a href="<?php esc_url( get_bloginfo( 'url' ) ); ?>/robots.txt" target="_blank"><?php esc_html_e( 'View robots.txt file', 'multisite-robotstxt-manager' ); ?></a></p>
		</td>
		</tr>
		<tr>
		<td>
			<textarea name="append" cols="65" rows="15" class="w-100"><?php echo esc_html( $append_rules ); ?></textarea>
		</td>
		</tr>
<?php if ( true === is_multisite() ) { ?>
		<tr>
		<td>
			<p><input type="checkbox" name="override" value="1" id="override" <?php checked( $override , '1' ); ?> /> <label for="override"><?php esc_html_e( 'Check to use the saved data (above) as this websites robots.txt file, overriding the network robots.txt file.', 'multisite-robotstxt-manager' ); ?></label></p>
		</td>
		</tr>
<?php } ?>
	</tbody>
</table>

<?php submit_button( esc_html__( 'update append rules', 'multisite-robotstxt-manager' ) ); ?>

<table class="form-table">
	<tbody>
		<tr>
		<td colspan="2">
			<div class="text-dark font-weight-bold p-0 m-0 h6"><?php esc_html_e( 'Manual Rule Suggestions', 'multisite-robotstxt-manager' ); ?></div>
			<p class="description"><?php esc_html_e( 'The rules below will need to be manually added to the end of the robots.txt file.', 'multisite-robotstxt-manager' ); ?></p>
		</td>
		</tr>
		<tr>
		<th scope="row"><label><?php esc_html_e( 'Upload Path', 'multisite-robotstxt-manager' ); ?></label></th>
		<td><input type="text" name="upload_path" value="<?php echo esc_html( $uploadpath ); ?>" class="regular-text" onclick="select()" /></td>
		</tr>
		<tr>
		<th scope="row"><label><?php esc_html_e( 'Theme Path', 'multisite-robotstxt-manager' ); ?></label></th>
		<td><input type="text" name="theme_path" value="<?php echo esc_html( $themepath ); ?>" class="regular-text" onclick="select()" /></td>
		</tr>
		<tr>
		<th scope="row"><label><?php esc_html_e( 'Sitemap URL', 'multisite-robotstxt-manager' ); ?></label></th>
		<td><input type="text" name="sitemap_url" value="<?php echo esc_html( $sitemapurl ); ?>" class="regular-text" onclick="select()" /></td>
		</tr>
	</tbody>
</table>
</form>

<?php if ( true !== empty( $website_robotstxt ) ) { ?>
<hr />

<form>
<table class="form-table">
	<tbody>
		<tr>
		<td><div class="text-dark font-weight-bold p-0 m-0 h5"><?php esc_html_e( 'Live Robots.txt File', 'multisite-robotstxt-manager' ); ?></div></td>
		</tr>
		<tr>
		<td>
			<textarea name="live_robotstxt" name="network_readonly" readonly cols="65" rows="15" class="w-100"><?php echo esc_html( $website_robotstxt ); ?></textarea>
		</td>
		</tr>
	</tbody>
</table>
</form>
<?php } ?>

<?php if ( true !== empty( $network_robotstxt ) ) { ?>
<form>
<table class="form-table">
	<tbody>
		<tr>
		<td><div class="text-dark font-weight-bold p-0 m-0 h5"><?php esc_html_e( 'Current Network Robots.txt File', 'multisite-robotstxt-manager' ); ?></div></td>
		</tr>
		<tr>
		<td>
			<textarea name="network_robotstxt" name="network_readonly" readonly cols="65" rows="15" class="w-100"><?php echo esc_html( $network_robotstxt ); ?></textarea>
		</td>
		</tr>
	</tbody>
</table>
</form>
<?php } ?>

<br /><br /><hr />

<form enctype="multipart/form-data" method="post" action="">
<?php

/*
 * Retrieve or display nonce hidden field for forms.
 * https://developer.wordpress.org/reference/functions/wp_nonce_field/
 */
wp_nonce_field(
	MS_ROBOTSTXT_MANAGER_SETTING_PREFIX . 'action',
	MS_ROBOTSTXT_MANAGER_SETTING_PREFIX . 'nonce'
);
?>
<input type="hidden" name="disable" value="1" />
<table class="form-table">
	<tbody>
		<tr>
		<td class="text-right"><span class="description"><?php esc_html_e( 'Restore the default WordPress robots.txt file on this website.', 'multisite-robotstxt-manager' ); ?></span> <input type="radio" name="action" value="disable" /></td>
		</tr>
	</tbody>
</table>

<p class="textright"><input type="submit" name="submit" value=" submit " onclick="return confirm( 'Are You Sure?' );" /></p>
</form>

