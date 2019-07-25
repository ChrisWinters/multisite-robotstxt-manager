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
 * Display translated text that has been escaped for safe use in HTML output.
 * https://developer.wordpress.org/reference/functions/esc_html_e/
 */
?>
<div class="wrap">
<h2><span class="dashicons dashicons-admin-site-alt3 mt-1 pt-1"></span> <?php esc_html_e( 'Multisite Robots.txt Manager', 'multisite-robotstxt-manager' ); ?> &#8594; <small><?php esc_html_e( 'A Multisite Robots.txt Manager Plugin For WordPress.', 'multisite-robotstxt-manager' ); ?></small></h2>
<?php
require_once dirname( MS_ROBOTSTXT_MANAGER_FILE ) . '/inc/templates/notice.php';
require_once dirname( MS_ROBOTSTXT_MANAGER_FILE ) . '/inc/templates/upgrade.php';

/*
 * Sanitizes content for allowed HTML tags for post content.
 * https://developer.wordpress.org/reference/functions/wp_kses_post/
 */
echo wp_kses_post( $this->tabs() );
?>

<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2"><div id="post-body-content">
<div class="postbox"><div class="inside">
