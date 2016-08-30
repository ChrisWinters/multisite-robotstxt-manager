<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }

/**
 * Plugin Admin Home
 */
?>

<div class="postbox"><div class="inside">
<div class="inside-box"><div class="inside-pad para">

<?php echo $this->statusMessages();?>

<br />

<?php if ( is_network_admin() ) {?>
    <?php $this->echoForm( 'network', false );?>
        <table class="table">
            <tr>
                <td colspan="3"><?php $this->echoTextarea( $get_network_robotstxt, 65, 20, false );?></td>
            </tr>
            <tr>
                <td class="textcenter" colspan="3"><?php echo $this->echoSubmit( __( 'update network', 'multisite-robotstxt-manager' ) );?></td>
            </tr>
        </table>
    <?php $this->echoForm( false, true );?>

    <?php $this->echoForm( 'settings', false ); $this->echoSettings();?>

    <br /><hr /><br />

    <?php $this->echoForm( 'presets', false ); $this->echoPresets();?>

    <br /><hr /><br />

    <?php $this->echoForm( 'status', false, true ); $this->echoRemoves();?>
<?php }?>

<?php if ( ! is_network_admin() ) {?>
    <?php $this->echoForm( 'website', false );?>

    <table class="table">
        <tr>
            <td class="textcenter" colspan="2"><?php $this->echoTextarea( $get_website_append_data, 65, 8, false );?></td>
        </tr>
        <tr>
            <td class="textcenter" colspan="2"><b>.:: <?php _e( 'Rule Suggestions', 'multisite-robotstxt-manager' );?> ::.</b></td>
        </tr>

        <?php if ( ! empty( $get_upload_path ) ) {?>
        <tr>
            <td class="textright"><b><?php _e( 'Allow Upload Path', 'multisite-robotstxt-manager' );?>:</b></td>
            <td class="textcenter"><input type="text" name="upload_path" value="<?php echo $get_upload_path;?>" style="width:98%" onclick="select()" /></td>
        </tr>
        <?php }?>

        <?php if ( ! empty( $get_theme_path ) ) {?>
        <tr>
            <td class="textright"><b><?php _e( 'Allow Theme Path', 'multisite-robotstxt-manager' );?>:</b></td>
            <td class="textcenter"><input type="text" name="theme_path" value="<?php echo $get_theme_path;?>" style="width:98%" onclick="select()" /></td>
        </tr>
        <?php }?>

        <?php if ( ! empty( $get_sitemap_url ) ) {?>
            <tr>
                <td class="textright"><b><?php _e( 'Add Sitemap URL', 'multisite-robotstxt-manager' );?>:</b></td>
                <td class="textcenter"><input type="text" name="sitemap_url" value="<?php echo $get_sitemap_url;?>" style="width:98%" onclick="select()" /></td>
            </tr>
        <?php }?>
        <tr>
            <td class="textcenter" colspan="2"><?php echo $this->echoSubmit( __( 'update website rules', 'multisite-robotstxt-manager' ) );?></td>
        </tr>
    </table>

    <?php if ( ! empty( $get_website_robotstxt ) && get_option( "ms_robotstxt_manager_status" ) ) {?>
        <br />

        <table class="table">
            <tr>
                <td><b><?php _e( 'Saved Robots.txt File', 'multisite-robotstxt-manager' );?></b>: <?php _e( 'The live robots.txt file for this website.', 'multisite-robotstxt-manager' );?><br /><?php $this->echoTextarea( $get_website_robotstxt, 65, 20, true );?></td>
            </tr>
        </table>
    <?php }?>

    <?php if ( empty( $get_website_robotstxt ) && ! empty( $get_network_robotstxt ) ) {?>
        <br />

        <table class="table">
            <tr>
                <td><b><?php _e( 'Network Locked Robots.txt File', 'multisite-robotstxt-manager' );?></b>: <?php _e( 'Website settings (above) will automatically be appended to the network robots.txt file and saved as the robots.txt for this website.', 'multisite-robotstxt-manager' );?><br /><?php $this->echoTextarea( $get_network_robotstxt, 65, 20, true );?></td>
            </tr>
        </table>
    <?php }?>

    <?php $this->echoForm( false, true );?>

    <br /><hr /><br />

    <?php $this->echoForm( 'status', false, true ); $this->echoRemoves();?>
<?php }?>

</div></div><!-- end inside-box and inside-pad -->
</div></div><!-- end inside and postbox -->