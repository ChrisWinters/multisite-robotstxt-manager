<?php
if( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }

/**
 * Plugin Admin Sidebar
 */
?>

<div class="postbox">
    <h3><span><?php _e( 'Quick Info', 'multisite-robotstxt-manager' );?></span></h3>
    <div class="inside" style="clear:both;padding-top:1px;"><div class="para">

    <ul>
        <?php if( ! defined( 'MSRTM' ) ) {?>
            <li><strong><span style="color:#cc0000;font-size:16px;"><?php _e( 'Pro Automation Extension', 'multisite-robotstxt-manager' );?></span></strong> [<a href="http://technerdia.com/multisite-robotstxt-manager-pro/" target="_blank"><?php _e( 'details', 'multisite-robotstxt-manager' );?></a>]<br /><?php _e( 'Fully automate the population and creation of all network website robots.txt files!', 'multisite-robotstxt-manager' );?>!</li>
        <?php } ?>
        <li><strong>&raquo; <a href="http://wordpress.org/extend/plugins/multisite-robotstxt-manager/" target="_blank"><?php _e( 'Please Rate This Plugin', 'multisite-robotstxt-manager' );?>!</a></strong><br />
        <?php _e( 'It only takes a few seconds to <a href="http://wordpress.org/extend/plugins/multisite-robotstxt-manager/" target="_blank">rate this plugin</a>! Your rating helps create motivation for future developments', 'multisite-robotstxt-manager' );?>!</li>
    </ul>

</div></div> <!-- end inside-pad & inside -->
</div> <!-- end postbox -->


<div class="postbox">
    <h3><span><?php _e( 'Multisite Robots.txt Manager', 'multisite-robotstxt-manager' );?></span></h3>
<div class="inside" style="clear:both;padding-top:1px;"><div class="para">

    <ul>
        <li>&bull; <a href="http://technerdia.com/multisite-robotstxt-manager/" target="_blank"><?php _e( 'Plugin Home Page', 'multisite-robotstxt-manager' );?></a></li>
        <li>&bull; <a href="http://wordpress.org/extend/plugins/multisite-robotstxt-manager/" target="_blank"><?php _e( 'Plugin at Wordpress.org', 'multisite-robotstxt-manager' );?></a></li>
        <li>&bull; <a href="http://technerdia.com/help/" target="_blank"><?php _e( 'Contact Support', 'multisite-robotstxt-manager' );?></a></li>
        <li>&bull; <a href="http://msrtm.technerdia.com/feedback/" target="_blank"><?php _e( 'Submit Feedback', 'multisite-robotstxt-manager' );?></a></li>
        <li>&bull; <a href="http://technerdia.com/projects/" target="_blank"><?php _e( 'More Plugins!', 'multisite-robotstxt-manager' );?></a></li>
    </ul>

</div></div> <!-- end inside-pad & inside -->
</div> <!-- end postbox -->


<div class="postbox">
    <h3><span><?php _e( 'Robots.txt Documentation', 'multisite-robotstxt-manager' );?></span></h3>
<div class="inside" style="clear:both;padding-top:1px;"><div class="para">

    <ul>
        <li>&bull; <a href="http://codex.wordpress.org/Search_Engine_Optimization_for_WordPress#Robots.txt_Optimization" target="_blank"><?php _e( 'Robots.txt Optimization Tips', 'multisite-robotstxt-manager' );?></a></li>
        <li>&bull; <a href="http://www.askapache.com/seo/updated-robotstxt-for-wordpress.html" target="_blank"><?php _e( 'AskAapche Robots.txt Example', 'multisite-robotstxt-manager' );?></a></li>
        <li>&bull; <a href="https://developers.google.com/webmasters/control-crawl-index/docs/faq" target="_blank"><?php _e( 'Google Robots.txt F.A.Q.', 'multisite-robotstxt-manager' );?></a></li>
        <li>&bull; <a href="https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt" target="_blank"><?php _e( 'Robots.txt Specifications', 'multisite-robotstxt-manager' );?></a></li>
        <li>&bull; <a href="http://www.robotstxt.org/db.html" target="_blank"><?php _e( 'Web Robots Database', 'multisite-robotstxt-manager' );?></a></li>
    </ul>

</div></div> <!-- end inside-pad & inside -->
</div> <!-- end postbox -->