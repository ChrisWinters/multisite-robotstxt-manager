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

if ( true === $network_upgrade ) {
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
	<input type="hidden" name="action" value="upgrade" />
		<p><?php esc_html_e( 'Notice! - Possible Setting Migration Needed! NEW INSTALLS CAN DISMISS THIS NOTICE! Click the Migrate button below to maybe migrate old plugin settings to the new format, or click the dismiss button to ignore and remove this message. (This message will be removed in the next major version release.)', 'multisite-robotstxt-manager' ); ?></p>
		<p>
			<?php if ( 'delete' === $network_upgrade ) { ?>
				<button class="button button-primary" role="button" type="submit" name="delete" value="1"><?php esc_html_e( 'Delete Old Settings', 'multisite-robotstxt-manager' ); ?></button>
			<?php } else { ?>
				<button class="button button-primary" role="button" type="submit" name="migrate" value="1"><?php esc_html_e( 'Migrate', 'multisite-robotstxt-manager' ); ?></button>
			<?php } ?>
			<button class="button button-secondary float-right" role="button" type="submit" name="dismiss" value="1"><?php esc_html_e( 'Dismiss', 'multisite-robotstxt-manager' ); ?></button>
		</p>
	</form>
</div>
