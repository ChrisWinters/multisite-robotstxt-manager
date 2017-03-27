<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }

// Get Plugin Status
if ( parent::status() == true ) {?>
    <h3><span class="active"><?php _e( 'The Robots.txt File is Active on this Website', 'multisite-robotstxt-manager' );?></span></h3>
    <p><?php _e( 'The robots.txt file below is currently being displayed on this website websites. Unique robots.txt file rules for each website will replace the {APPEND_WEBSITE_ROBOTSTXT} marker.', 'multisite-robotstxt-manager' );?> <?php printf( __( '<a href="%s/robots.txt" target="_blank">Click here</a> to view the customized robots.txt file.', 'multisite-robotstxt-manager' ), $this->base_url );?></p>
<?php } else {?>
    <h3><span class="inactive"><?php _e( 'The Robots.txt File is Disabled on this Website', 'multisite-robotstxt-manager' );?></span></h3>
    <p><?php _e( 'The default WordPress robots.txt file is currently being displayed on this website.', 'multisite-robotstxt-manager' );?> <?php printf( __( '<a href="%s/robots.txt" target="_blank">Click here</a> to view the default robots.txt file.', 'multisite-robotstxt-manager' ), $this->base_url );?></p>
<?php }?>

<form enctype="multipart/form-data" method="post" action="">
<?php wp_nonce_field( $this->option_name . 'action', $this->option_name . 'nonce' );?>
<input type="hidden" name="type" value="website" />

    <table class="form-table">
        <tr>
            <td class="textcenter"><textarea name="append_rules" cols="65" rows="15"><?php echo parent::getAppendRules();?></textarea></td>
        </tr>
    </table>

    <div class="textcenter"><?php submit_button( __( 'update website rules', 'multisite-robotstxt-manager' ) );?></div>
    
</form>

    <table class="form-table">
        <tr>
            <td class="textcenter" colspan="2"><b>.:: <?php _e( 'Rule Suggestions', 'multisite-robotstxt-manager' );?> ::.</b></td>
        </tr>
        <tr>
            <td class="td30 textright"><label><?php _e( 'Upload Path', 'multisite-robotstxt-manager' );?>:</label></td>
            <td><input type="text" name="upload_path" value="<?php echo parent::getUploadPath();?>" class="regular-text" onclick="select()"></td>
        </tr>
        <tr>
            <td class="td30 textright"><label><?php _e( 'Theme Path', 'multisite-robotstxt-manager' );?>:</label></td>
            <td><input type="text" name="theme_path" value="<?php echo parent::getThemePath();?>" class="regular-text" onclick="select()"></td>
        </tr>
        <?php if ( parent::getSitemapUrl() ) {?>
        <tr>
            <td class="td30 textright"><label><?php _e( 'Sitemap URL', 'multisite-robotstxt-manager' );?>:</label></td>
            <td><input type="text" name="sitemap_url" value="<?php echo parent::getSitemapUrl();?>" class="regular-text" onclick="select()"></td>
        </tr>
        <?php }?>
    </table>

<br /><hr /><br />

<?php if ( parent::getWebsiteRobotstxt() && get_option( $this->option_name . 'status' ) ) {?>
    <h3><?php _e( 'Live Robots.txt File', 'multisite-robotstxt-manager' );?></h3>

        <table class="form-table">
        <tr>
            <td class="textcenter"><textarea name="website_readonly" cols="65" rows="20" class="textarea" readonly=""><?php echo parent::getWebsiteRobotstxt();?></textarea></td>
        </tr>
        </table>

    <br /><hr /><br />
    <?php } elseif ( parent::getNetworkRobotstxt() && ! get_option( $this->option_name . 'status' ) ) {?>
    <h3><?php _e( 'Network Robots.txt File', 'multisite-robotstxt-manager' );?></h3>

        <table class="form-table">
        <tr>
            <td class="textcenter"><textarea name="network_readonly" cols="65" rows="20" class="textarea" readonly=""><?php echo parent::getNetworkRobotstxt();?></textarea></td>
        </tr>
        </table>

    <br /><hr /><br />
    <?php }?>

<form enctype="multipart/form-data" method="post" action="">
<?php wp_nonce_field( $this->option_name . 'action', $this->option_name . 'nonce' );?>
<input type="hidden" name="type" value="status" />

    <table class="form-table">
    <tr>
        <td class="textcenter">
            <p class="textright"><label><?php _e( 'Disable the saved robots.txt file on this website, restoring the default WordPress robots.txt file.', 'multisite-robotstxt-manager' );?></label> <input type="checkbox" name="disable" value="website"></p>
            <?php if ( get_option( $this->option_name . 'default' ) ) {?>
                <p class="textright"><label><?php _e( 'Enable the network robots.txt file on this website, restoring the default behavior.', 'multisite-robotstxt-manager' );?></label> <input type="checkbox" name="disable" value="default-enable"></p>
            <?php } else {?>
                <p class="textright"><label><?php _e( 'Disable the network robots.txt file on this website, allowing you to fully customize the robots.txt file.', 'multisite-robotstxt-manager' );?></label> <input type="checkbox" name="disable" value="default-disable"></p>
            <?php }?>
        </td>
    </tr>
    </table>

    <p class="textright"><input type="submit" name="submit" value=" submit " onclick="return confirm( 'Are You Sure?' );" /></p>

</form>
