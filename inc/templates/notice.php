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

if ( true !== is_network_admin() ) {
	return;
}

if ( true !== empty( $sdk ) ) {
	return;
}

/*
 *
 * Echoes a submit button, with provided text and appropriate class( es ).
 * https://developer.wordpress.org/reference/functions/submit_button/
 */

?>
<div class="notice notice-info">
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

/*
 * Display translated text.
 * https://developer.wordpress.org/reference/functions/esc_html_e/
 */
?>
	<input type="hidden" name="action" value="sdk" />
		<p><?php esc_html_e( 'Never miss an important update! Opt-in to our security and feature update notifications, and non-sensitive diagnostic tracking with freemius.', 'multisite-robotstxt-manager' ); ?></p>
		<p>
			<button class="button button-primary" role="button" type="submit" name="optin" value="1"><?php esc_html_e( 'Opt-In', 'multisite-robotstxt-manager' ); ?></button>
			<a class="button button-secondary" href="#" role="button"><?php esc_html_e( 'Learn More', 'multisite-robotstxt-manager' ); ?></a>
			<button class="button button-secondary float-right" role="button" type="submit" name="dismiss" value="1"><?php esc_html_e( 'Dismiss', 'multisite-robotstxt-manager' ); ?></button>
		</p>
	</form>
</div>
