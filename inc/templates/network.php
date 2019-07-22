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

<h3><span class="text-info"><?php esc_html_e( 'Network Robots.txt File', 'multisite-robotstxt-manager' ); ?></span></h3>
<p class="description"><?php esc_html_e( 'If used, the {APPEND_WEBSITE_ROBOTSTXT} marker will be replaced at the website level if the website has unique append rules. Saving and publishing an empty network robots.txt file will restore the default WordPress robots.txt file.', 'multisite-robotstxt-manager' ); ?></p>

<table class="form-table">
	<tbody>
		<tr>
		<td>
			<textarea name="robotstxt" cols="65" rows="20" class="w-100"><?php echo esc_html( $network_robotstxt ); ?></textarea>
			<p class="pt-3"><input type="radio" name="action" value="network" id="network" /> <label for="network"><?php esc_html_e( 'Rebuild all network websites robots.txt files.', 'multisite-robotstxt-manager' ); ?></label></p>
			<p><input type="radio" name="action" value="member" id="user" /> <label for="user"><?php esc_html_e( 'Rebuild all robots.txt files only on network websites you are a member of.', 'multisite-robotstxt-manager' ); ?></label></p>
			<p><input type="radio" name="action" value="save" id="save" checked="checked" /> <label for="save"><?php esc_html_e( 'Save the network robots.txt file / does not rebuild robots.txt files.', 'multisite-robotstxt-manager' ); ?></label></p>
		</td>
		</tr>
	</tbody>
</table>

<?php submit_button( esc_html__( ' submit ', 'multisite-robotstxt-manager' ) ); ?>
</form>

<hr />

<?php
if ( true === file_exists( dirname( MS_ROBOTSTXT_MANAGER_FILE ) . '/inc/templates/automate.php' ) ) {
	require_once dirname( MS_ROBOTSTXT_MANAGER_FILE ) . '/inc/templates/automate.php';
}
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
<input type="hidden" name="action" value="presets" />

<table class="form-table">
	<tbody>
		<tr>
		<td colspan="2">
			<div class="text-dark font-weight-bold p-0 m-0 h5"><?php esc_html_e( 'Robots.txt File Presets', 'multisite-robotstxt-manager' ); ?></div>
			<p class="description"><?php esc_html_e( 'Select a preset robots.txt file to save as the network robots.txt file.', 'multisite-robotstxt-manager' ); ?></p>
		</td>
		</tr>
		<tr>
		<th scope="row"><label for="default"><?php esc_html_e( 'Plugin Default Robots.txt File', 'multisite-robotstxt-manager' ); ?></label></th>
		<td><input type="radio" name="preset" value="default-robotstxt" id="default" /> <span class="description"><?php esc_html_e( 'The plugins default installed robots.txt file.', 'multisite-robotstxt-manager' ); ?></span> <span class="small">[<a href="<?php esc_url( get_bloginfo( 'url' ) ); ?>/wp-content/plugins/multisite-robotstxt-manager/assets/examples/default-robots.txt" target="_blank">view</a>]</span></td>
		</tr>
		<tr>
		<th scope="row"><label for="default-alt"><?php esc_html_e( 'Alternative Robots.txt File', 'multisite-robotstxt-manager' ); ?></label></th>
		<td><input type="radio" name="preset" value="defaultalt-robotstxt" id="default-alt" /> <span class="description"><?php esc_html_e( 'Similar to the plugins default robots.txt file, with more disallows.', 'multisite-robotstxt-manager' ); ?></span> <span class="small">[<a href="<?php esc_url( get_bloginfo( 'url' ) ); ?>/wp-content/plugins/multisite-robotstxt-manager/assets/examples/defaultalt-robots.txt" target="_blank">view</a>]</span></td>
		</tr>
		<tr>
		<th scope="row"><label for="wordpress"><?php esc_html_e( 'WordPress Limited Robots.txt File', 'multisite-robotstxt-manager' ); ?></label></th>
		<td><input type="radio" name="preset" value="wordpress-robotstxt" id="wordpress" /> <span class="description"><?php esc_html_e( 'Only disallows wp-includes and wp-admin.', 'multisite-robotstxt-manager' ); ?></span> <span class="small">[<a href="<?php esc_url( get_bloginfo( 'url' ) ); ?>/wp-content/plugins/multisite-robotstxt-manager/assets/examples/wordpress-robots.txt" target="_blank">view</a>]</span></td>
		</tr>
		<tr>
		<th scope="row"><label for="open"><?php esc_html_e( 'Open Robots.txt File', 'multisite-robotstxt-manager' ); ?></label></th>
		<td><input type="radio" name="preset" value="open-robotstxt" id="open" /> <span class="description"><?php esc_html_e( 'Fully open robots.txt file, no disallows.', 'multisite-robotstxt-manager' ); ?></span> <span class="small">[<a href="<?php esc_url( get_bloginfo( 'url' ) ); ?>/wp-content/plugins/multisite-robotstxt-manager/assets/examples/open-robots.txt" target="_blank">view</a>]</span></td>
		</tr>
		<tr>
		<th scope="row"><label for="blogger"><?php esc_html_e( 'A Bloggers Robots.txt File', 'multisite-robotstxt-manager' ); ?></label></th>
		<td><input type="radio" name="preset" value="blogger-robotstxt" id="blogger" /> <span class="description"><?php esc_html_e( 'Optimized for blog focused WordPress websites.', 'multisite-robotstxt-manager' ); ?></span> <span class="small">[<a href="<?php esc_url( get_bloginfo( 'url' ) ); ?>/wp-content/plugins/multisite-robotstxt-manager/assets/examples/blogger-robots.txt" target="_blank">view</a>]</span></td>
		</tr>
		<tr>
		<th scope="row"><label for="google"><?php esc_html_e( 'Google Robots.txt File', 'multisite-robotstxt-manager' ); ?></label></th>
		<td><input type="radio" name="preset" value="google-robotstxt" id="google" /> <span class="description"><?php esc_html_e( 'A Google friendly robots.txt file.', 'multisite-robotstxt-manager' ); ?></span> <span class="small">[<a href="<?php esc_url( get_bloginfo( 'url' ) ); ?>/wp-content/plugins/multisite-robotstxt-manager/assets/examples/google-robots.txt" target="_blank">view</a>]</span></td>
		</tr>
		<tr>
		<th scope="row"><label for="block"><?php esc_html_e( 'Lockdown Robots.txt File', 'multisite-robotstxt-manager' ); ?></label></th>
		<td><input type="radio" name="preset" value="block-robotstxt" id="block" /> <span class="description"><?php esc_html_e( 'Disallow everything, prevent spiders from indexing the website.', 'multisite-robotstxt-manager' ); ?> <span class="small">[<a href="<?php esc_url( get_bloginfo( 'url' ) ); ?>/wp-content/plugins/multisite-robotstxt-manager/assets/examples/blocked-robots.txt" target="_blank">view</a>]</span></span></td>
		</tr>
	</tbody>
</table>

<?php submit_button( esc_html__( 'update robots.txt file', 'multisite-robotstxt-manager' ) ); ?>
</form>

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
<input type="hidden" name="delete" value="1" />
<table class="form-table">
	<tbody>
		<tr>
		<td class="text-right"><span class="description"><?php esc_html_e( 'WARNING: Delete all settings related to the Multisite Robots.txt Manager Plugin across the entire network.', 'multisite-robotstxt-manager' ); ?></span> <input type="radio" name="action" value="delete" /></td>
		</tr>
	</tbody>
</table>

<p class="textright"><input type="submit" name="submit" value=" submit " onclick="return confirm( 'Are You Sure?' );" /></p>
</form>
