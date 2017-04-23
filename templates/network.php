<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }

// Get Plugin Status
if ( parent::status() == true ) {?>
    <h3><span class="active"><?php _e( 'The Network Robots.txt File is Active', 'multisite-robotstxt-manager' );?></span></h3>
    <p><?php _e( 'The network robots.txt file below is currently being used across all active network websites. Unique robots.txt file rules for each website will replace the {APPEND_WEBSITE_ROBOTSTXT} marker.', 'multisite-robotstxt-manager' );?></p>
<?php } else {?>
    <h3><span class="inactive"><?php _e( 'The Network Robots.txt File is Disabled', 'multisite-robotstxt-manager' );?></span></h3>
    <p><?php _e( 'All network websites are currently displaying the default WordPress robots.txt file, unless modified at the local website.', 'multisite-robotstxt-manager' );?></p>
<?php }?>

<form enctype="multipart/form-data" method="post" action="">
<?php wp_nonce_field( $this->option_name . 'action', $this->option_name . 'nonce' );?>
<input type="hidden" name="type" value="network" />

    <table class="form-table">
        <tr>
            <td colspan="3" class="textcenter"><textarea name="robotstxt_file" cols="65" rows="20"><?php echo parent::getNetworkRobotstxt();?></textarea></td>
        </tr>
        <tr>
            <td class="td30"></td>
            <td class="textleft">
                <p><input type="radio" name="update" value="network" id="network" /> <label for="network"><?php _e( 'Publish the network robots.txt file to all network websites.', 'multisite-robotstxt-manager' );?></label></p>
                <p><input type="radio" name="update" value="member" id="user" /> <label for="user"><?php _e( 'Publish the network robots.txt file to network websites you are a member of.', 'multisite-robotstxt-manager' );?></label></p>
                <p><input type="radio" name="update" value="save" id="save" checked="checked" /> <label for="save"><?php _e( 'Save the network robots.txt file / does not publish changes.', 'multisite-robotstxt-manager' );?></label></p>
            </td>
            <td class="td30"></td>
        </tr>
    </table>

    <div class="textcenter"><?php submit_button( __( 'update settings', 'multisite-robotstxt-manager' ) );?></div>
    
</form>

<?php echo parent::getSettings();?>

<br /><hr /><br />

<h3><?php _e( 'Robots.txt File Presets', 'multisite-robotstxt-manager' );?></h3>
<p><?php _e( 'Select a preset robots.txt file to load in the textarea above. This action does NOT publish the robots.txt file to the network.', 'multisite-robotstxt-manager' );?></p>

<form enctype="multipart/form-data" method="post" action="">
<?php wp_nonce_field( $this->option_name . 'action', $this->option_name . 'nonce' );?>
<input type="hidden" name="type" value="presets" />

    <table class="form-table">
    <tr>
        <td>
            <p><input type="radio" name="preset" value="default" id="default" /> <label for="default"><?php _e( 'Default Robots.txt File: The plugins default installed robots.txt file.', 'multisite-robotstxt-manager' );?></label></p>
            <p><input type="radio" name="preset" value="default-alt" id="default-alt" /> <label for="default-alt"><?php _e( 'Alternative Robots.txt File: Similar to the plugins default robots.txt file, with more disallows.', 'multisite-robotstxt-manager' );?></label></p>
            <p><input type="radio" name="preset" value="wordpress" id="wordpress" /> <label for="wordpress"><?php _e( 'WordPress Limited Robots.txt File: Only disallows wp-includes and wp-admin.', 'multisite-robotstxt-manager' );?></label></p>
            <p><input type="radio" name="preset" value="open" id="open" /> <label for="open"><?php _e( 'Open Robots.txt File: Fully open robots.txt file, no disallows.', 'multisite-robotstxt-manager' );?></label></p>
            <p><input type="radio" name="preset" value="blogger" id="blogger" /> <label for="blogger"><?php _e( 'A Bloggers Robots.txt File: Optimized for blog focused WordPress websites.', 'multisite-robotstxt-manager' );?></label></p>
            <p><input type="radio" name="preset" value="google" id="google" /> <label for="google"><?php _e( 'Google Robots.txt File: A Google friendly robots.txt file.', 'multisite-robotstxt-manager' );?></label></p>
            <p><input type="radio" name="preset" value="block" id="block" /> <label for="block"><?php _e( 'Lockdown Robots.txt File: Disallow everything, prevent spiders from indexing the website.', 'multisite-robotstxt-manager' );?></label></p>
        </td>
    </tr>
    </table>

    <div class="textcenter"><?php submit_button( __( 'update settings', 'multisite-robotstxt-manager' ) );?></div>

</form>

<br /><hr /><br />

<form enctype="multipart/form-data" method="post" action="">
<?php wp_nonce_field( $this->option_name . 'action', $this->option_name . 'nonce' );?>
<input type="hidden" name="type" value="status" />

    <table class="form-table">
    <tr>
        <td>
            <p class="textright"><label><?php _e( 'Disable saved robots.txt files across all network websites, restoring the default WordPress robots.txt file.', 'multisite-robotstxt-manager' );?></label> <input type="checkbox" name="disable" value="network" /></p>
            <p class="textright"><label><?php _e( 'WARNING: Delete all settings related to the Multisite Robots.txt Manager Plugin across the entire network.', 'multisite-robotstxt-manager' );?></label> <input type="checkbox" name="disable" value="all" /></p>
        </td>
    </tr>
    </table>

    <p class="textright"><input type="submit" name="submit" value=" submit " onclick="return confirm( 'Are You Sure?' );" /></p>

</form>
