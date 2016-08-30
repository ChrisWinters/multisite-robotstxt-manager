<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }

/**
 * Plugin Admin Header
 */
?>

<div class="wrap">
<div id="icon-themes" class="icon32"><br /></div><h2><?php echo MS_ROBOTSTXT_MANAGER_PAGE_NAME;?></h2>
<p><?php echo MS_ROBOTSTXT_MANAGER_PAGE_ABOUT;?></p>

<?php if ( ! empty( $message ) ) {?><div class="updated" id="message" onclick="this.parentNode.removeChild(this)"><p><strong><em><?php echo $message;?></em></strong></p></div><?php }?>

<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2"><div id="post-body-content">