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
 * Escaping for HTML blocks.
 * https://developer.wordpress.org/reference/functions/esc_html/
 *
 * Checks and cleans a URL.
 * https://developer.wordpress.org/reference/functions/esc_url/
 *
 * Display translated text.
 * https://developer.wordpress.org/reference/functions/_e/
 */

?>
</div></div><!-- .postbox & inside -->
</div><!-- .post-body-content -->

<div id="postbox-container-1" class="postbox-container"><?php require_once dirname( MS_ROBOTSTXT_MANAGER_FILE ) . '/inc/templates/sidebar.php'; ?></div>

<br class="clear" />
</div></div><!-- .poststuff and post-body -->
	<div class="clearfix">
		<div class="float-left text-left"><small>&#9829; <?php esc_html_e( 'Multisite Robots.txt Manager', 'multisite-robotstxt-manager' ); ?></small></div>
		<div class="float-right text-right"><a href="#top"><span class="dashicons-before dashicons-arrow-up"><?php esc_html_e( 'top', 'multisite-robotstxt-manager' ); ?></span></a></div>
	</div>
</div><!-- .wrap -->

<br class="clear" />
