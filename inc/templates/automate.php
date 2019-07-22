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

$pro_settings       = $option->get_site_option( '-pro' );
$pro_network_sites  = ( true !== empty( $pro_settings['network_sites'] ) ) ? '1' : '';
$pro_network_create = ( true !== empty( $pro_settings['network_create'] ) ) ? '1' : '';
$pro_upload_path    = ( true !== empty( $pro_settings['network_upload_path'] ) ) ? '1' : '';
$pro_theme_path     = ( true !== empty( $pro_settings['network_theme_path'] ) ) ? '1' : '';
$pro_sitemap_url    = ( true !== empty( $pro_settings['network_sitemap_url'] ) ) ? '1' : '';
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
<input type="hidden" name="action" value="automate" />

<h3><span class="text-dark font-weight-bold p-0 m-0 h5"><?php esc_html_e( 'Automation', 'multisite-robotstxt-manager' ); ?></span></h3>
<p class="description"><?php esc_html_e( 'Check to activate.', 'multisite-robotstxt-manager' ); ?></p>

<table class="form-table">
	<tbody>
		<tr>
		<td>
			<p><input type="checkbox" name="network_sites" value="1" id="network_sites" <?php checked( $pro_network_sites, '1' ); ?> /> <label for="network_sites"><?php esc_html_e( 'Automatically build/save robots.txt files when new websites are added to the network.', 'multisite-robotstxt-manager' ); ?></label></p>
			<p><input type="checkbox" name="network_create" value="1" id="network_create" <?php checked( $pro_network_create, '1' ); ?> /> <label for="network_create"><?php esc_html_e( 'Automatically build/save robots.txt files that have not generated when the robots.txt file is viewed.', 'multisite-robotstxt-manager' ); ?></label></p>
			<p><input type="checkbox" name="network_upload_path" value="1" id="network_upload_path" <?php checked( $pro_upload_path, '1' ); ?> /> <label for="network_upload_path"><?php esc_html_e( 'Automatically add upload path to website append rules.', 'multisite-robotstxt-manager' ); ?></label></p>
			<p><input type="checkbox" name="network_theme_path" value="1" id="network_theme_path" <?php checked( $pro_theme_path, '1' ); ?> /> <label for="network_theme_path"><?php esc_html_e( 'Automatically add theme path to website append rules.', 'multisite-robotstxt-manager' ); ?></label></p>
			<p><input type="checkbox" name="network_sitemap_url" value="1" id="network_sitemap_url" <?php checked( $pro_sitemap_url, '1' ); ?> /> <label for="network_sitemap_url"><?php esc_html_e( 'Automatically add sitemap urls to website append rules.', 'multisite-robotstxt-manager' ); ?></label></p>
		</td>
		</tr>
	</tbody>
</table>

<?php submit_button( esc_html__( ' save rules ', 'multisite-robotstxt-manager' ) ); ?>
</form>

<hr />
