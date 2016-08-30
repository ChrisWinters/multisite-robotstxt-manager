<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }

/**
 * Plugin Admin Footer
 */
?>

</div> <!-- end post-body-content -->

<div id="postbox-container-1" class="postbox-container"><?php require_once( MS_ROBOTSTXT_MANAGER_TEMPLATES .'/sidebar.php' );?></div>

<br class="clear" />
</div></div> <!-- close poststuff and post-body -->

<br /><hr />
<p style="text-align:right;"><small><b><?php _e( 'Created by', 'multisite-robotstxt-manager' );?></b>: <a href="http://technerdia.com/" target="_blank">techNerdia</a></small></p>
</div> <!-- end wrap -->

<br class="clear" />