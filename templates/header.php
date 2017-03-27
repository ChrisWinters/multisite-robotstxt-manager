<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }?>

<div class="wrap">
<h2><span class="dashicons dashicons-category"></span> <?php echo MS_ROBOTSTXT_MANAGER_PAGE_NAME;?></h2>

<?php echo $this->tabs();?>

<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2"><div id="post-body-content">
<div class="postbox"><div class="inside">
