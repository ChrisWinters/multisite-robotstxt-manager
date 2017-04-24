=== Multisite Robots.txt Manager ===
Plugin Name: Multisite Robots.txt Manager | MS Robots.txt
Contributors: tribalNerd, Chris Winters
Tags: robotstxt, robots.txt, robots, robot, spiders, virtual, search, google, seo, plugin, network, mu, multisite, technerdia, tribalnerd
Requires at least: 3.8
Tested up to: 4.7.4
Stable tag: 1.0.11
License: GNU GPLv3
License URI: https://github.com/tribalNerd/ptt-manager/blob/master/LICENSE

A Simple Multisite Robots.txt Manager - Quickly and easily manage all robots.txt files on a WordPress Multisite Website Network.

== Description ==

A Simple Multisite Robots.txt Manager - Quickly and easily manage all robots.txt files on a WordPress Multisite Website Network.

!!! Network Enabled Multisite Installs Only !!!

This Plugin Was Created For Multisite Networks > Network Activations Only!


= For Support & Bugs =

Please [contact us directly](http://technerdia.com/help/) if you need assistance or have found a bug. The WordPress Support forum does not notify us of new support tickets, no idea why, so contact us directly.


= View, Report Bugs, Contribute! =

Visit this [Plugin on Github!](https://github.com/tribalNerd/multisite-robotstxt-manager/) Clone/fork yourself a copy, report a bug or submit a ticket & pull request!


= Features: =

* Network wide robots.txt file, shared across all sites.
* Append extra robots.txt file data per-website Admin.
* Create unique robots.txt files for each network Website.
* Manage all Websites from Network Administration Area.
* Manage a single Website through the Website Settings Admins.
* Auto-generated Sitemap URL's, Upload Path & Theme Path.
* Mass update the all Websites on the Network in a single click.
* Quickly publish preset robots.txt files across the Network.
* Scan and clean old robots.txt file plugin data to clear out conflicts.


= Quick Info: =

* The default "Network Wide" robots.txt file is NOT a live robots.txt file.
* If you deactivate the plugin, no options are removed but the plugins robots.txt file(s) are no longer displayed.
* If you delete this plugin, all options and settings will be removed from the database, for all Websites.

* Get The Plugin: Download > Install > Network Activate
* Network Access: Network Admin > Settings Tab > MS Robots.txt Link
* Website Access: Website Admin > Settings Tab > MS Robots.txt Link


= Make It Work: =

* Network Admin: Select either either with "Publish the network robots.txt file to all network websites" or "Publish the network robots.txt file to network websites you are a member of" then click the "update settings" button to publish the robots.txt files.
* Website Admin: Modify the appended robots.txt file (or create a website unique robots.txt file) then click the "update website rules" button to publish your changes.


== Installation ==

= Install through the WordPress Admin =

* It is recommended that you use the built in WordPress installer to install plugins.
	* Multisite Networks: Network Admin > Plugins Menu > Add New Button
* In the Search box, enter: robots.txt
* Find the Plugin "Multisite Robots.txt Manager"
* Click Install Now and proceed through the plugin setup process.
	* Activate / Network Activate the plugin when asked.
	* If you have returned to the Plugin Admin, locate the "Multisite Robots.txt Manager" Plugin and click the Activate link.

= Upload and Install =

* If uploading, upload the /multisite-robotstxt-manager/ folder to /wp-content/plugins/ directory for your Worpdress install.
* Then open the WordPress Network Admin:
	* Multisite Networks: Network Admin > Plugins Menu
* Locate the "Multisite Robots.txt Manager" Plugin in your listing of plugins. (sort by Inactive)
* Click the Activate link to start the plugin.


== Frequently Asked Questions ==

= Q) Can the plugin update all Websites at once? =

A) Yes.


= Q) Does this plugin work on Non-Multisite Installs? =

A) No, your install MUST be Multisite/Network enabled.


= Q) Does this plugin work on WordPress.COM (free hosted) Websites? =

A) No.


= Q) Can I activate this plugin within a Websites wp-admin? =

A) No, only within the Network Admin.


= Q) Do I have to access each Website to manage the robots.txt file? =

A) No, the Main Admin Area for the MS Robots.txt Manager is located within the Network Admin.


= Q) Can I add my own robots.txt file? =

A) Yes.


= Q) Can every Website have a different robots.txt file? =

A) Yes.

Typically, each Website uses the Network robots.txt file as the 'base' robots.txt file. Websites can then inject unique robots.txt file rules into the Network robots.txt file.

However, within the Admin Area for each website, scroll down and click the "Disable the network robots.txt file..." checkbox. Allowing you to fully customize the robots.txt file.

You can also: Disable the "network robots.txt file," allowing you to manually add your own robots.txt file to each Network Website.
You can also: Save/publish a blank robots.txt file from the network admin.


= Q) Does this plugin add Sitemap links to the robots.txt file? =

A) Yes.


= Q) Can I add multiple or custom sitemap urls?

A) Yes.


= Q) Does this plugin add the Sitemap URL to the robots.txt file? =

A) Yes & No.

No, the Free Plugin only generates the Sitemap URL, you must manually add to the robots.txt file.

Yes, the Pro Plugin automatically adds the Sitemap URL to robots.txt files for you.


= Q) Does this plugin add the Theme Path to the robots.txt file? =

A) Yes & No.

No, the Free Plugin only generates the Theme Path, you must manually add to the robots.txt file.

Yes, the Pro Plugin automatically adds the Theme Path to robots.txt files for you.


= Q) Does this plugin add the Upload Path to the robots.txt file? =

A) Yes & No.

No, the Free Plugin only generates the Upload Path, you must manually add to the robots.txt file.

Yes, the Pro Plugin automatically adds the Upload Path to robots.txt files for you.


= Q) Does the robots.txt file render for non-root domains / Websites with a path? =

A) Yes, however.... Search Engine Spiders do not read robots.txt files within a directory, robots.txt files for non-mapped domains are for for error checking purposes only.


= Q) I run a real Multisite Network, all Sites are in a Path, don't they need a robots.txt file? =

A) From what I understand, no.... The root / network Website will contain the only robots.txt file.


= Q) My robots.txt files are 404 - file not found, what's wrong? =

A) The issue is due to an option called "rewrite rules" missing the robots.txt entry.

Visit the Network Admin for the plugin, then click the Cleaner tab. If the Rewrite Rule an error message and a unique button will appear allowing you scan and update the rule for all Websites.


= Q) The incorrect robots.txt file is displaying, what's wrong? =

A) Typically this issue is due to either an a different robots.txt file plugin is active or that plugins robots.txt file data was never deleted when the plugin was removed.

Visit the Network Admin for the plugin, then click the Cleaner tab. Click the "scan for old data" button to check for left over plugin data by other robots.txt file plugins.


= Q) Can I use other robots.txt file plugins with the MS Robots.txt Manager Plugin? =

A) No, multiple plugins will cause display issues with the robots.txt files.


= Q) Can I use other Sitemap Plugins to add more Sitemap URL's to the robots.txt files? =

A) Yes, however they typically only work for the default WordPress robots.txt file.


= Q) Does the plugin remove the settings when it is disabled or deleted? =

A) No! However you can disable the plugin and delete settings within the plugin admin area.


== Arbitrary section ==

= Understanding the Default Settings =

When you first enter the plugin admin via the Network Admin, the displayed robots.txt file is the default "network only" copy.


= The Network Append Marker =

The marker {APPEND_WEBSITE_ROBOTSTXT} within the Network Robots.txt File is replaced by Website unique robots.txt file append rules. Use the marker in your customized Network robots.txt files to automatically append the Website robots.txt file rules when the Network is updated.


= Robots.txt Files within Directories =

* This plugin WILL render robots.txt files within directories - however,

* Search Engine Spiders only read robots.txt files found within the root directory of a Website. Spiders do not read robots.txt files within directories, such as: domain.com/PATH-or-FOLDER/robots.txt is NOT a valid location.

* From Google: "The robots.txt file must be in the top-level directory of the host.....Crawlers will not check for robots.txt files in sub-directories."


= Testing Robots.txt Files =

* Use Google's Webmaster Tools to Validate your Robots.txt Files.... with Google at least.:
* Log into your Google Account and access the Log into your Webmaster Tools feature. Select a Website or Add a Website....

* On the Webmaster Tools Home page, click the site you want.
* Under Health, click Blocked URLs.
* If it is not already selected, click the Test robots.txt tab.
* Copy the content of your robots.txt file, and paste it into the first box.
* In the URLs box, list the site to test against.
* In the User-agents list, select the user-agents you want.
* https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt


= New Website Added to Network =

* If all Websites use the saved Network default robots.txt file, click the "update setting" button to copy the default robots.txt file over to any new Websites you have.
* Per Site: Then click the "update website rules" button to copy the default robots.txt file to this Website.


= Disabling =

* Disable a Website: Within the website plugin admin, for each unique website, scroll down and click the "Disable the saved robots.txt file..." checkbox then click the submit button. This will disable the robots.txt file the Website only, making the WordPress default robots.txt file display.
* Disable Across Network: Within the network plugin admin, scroll down and click the "Disable saved robots.txt files..." checkbox, then click the submit button.


= Presets

* This feature allows you to quickly duplicate premade robots.txt files and a sitemap structure url to the default network robots.txt file. This action does not publish the robots.txt files to the network.


= Recommended Sitemap Plugins =

* Google XML Sitemaps: http://wordpress.org/extend/plugins/google-sitemap-generator/
* Better WordPress Google XML Sitemaps: http://wordpress.org/extend/plugins/bwp-google-xml-sitemaps/
* Search For Others: http://wordpress.org/extend/plugins/search.php?q=multisite+sitemap

For "real" Multisite HOST Networks, use the WordPress plugin: BWP Google XML Sitemaps - This plugin will list each Websites Sitemap URL's in the Root Network Website's robots.txt file.


== Changelog ==

= 1.0.11 2017-24-4 =

* Added: Added more Sitemap filenames to check/build for.
* Changed: Sitemap check/build, added rewrite rule & physical file checks if fopen is not enabled.

= 1.0.10 2017-23-4 =

* Tested: Wordpress Version 4.7.4
* Changed: Review/Rating URL within templates/sidebar.php
* Fixed: Cleaner option name checks, using previous version names.
* Fixed: Cleaner rewrite_rule to delete/update the option when missing the robots.txt array.

= 1.0.9 =

* Fixed: Bad method call in class-cleaner.php.
* Fixed: Multiple incorrect update_option formats.
* Fixed: Network Robots.txt now saves when published | https://github.com/tribalNerd/multisite-robotstxt-manager/issues/5
* Fixed: Removed append marker, if no append rules found.
* Fixed: Wrapped is_writable() check to physical robots.txt removal.
* Change: Option names for cleaner, appended cleaner_.
* Change: Modified update success/fail messages.
* Change: Deleted uninstall.php | https://github.com/tribalNerd/multisite-robotstxt-manager/issues/6

= 1.0.8 =

* New plugin structure/files, using the same option names.
* Added: New tab "Cleaner" to the Network Admin area.
* Added: Two stage cleaning process - check & clean.
* Added: Check for a physical robots.txt file.
* Added: Check for missing robots.txt file rewrite rule.
* Added: Network tab to Websites for quick access to plugin admin within the Network.
* Added: Option to disable network robots.txt file on websites, allowing for full customization of websites robots.txt file.
* Change: Plugin admin areas to be more visually friendly.
* Moved: Screenshots/header/thumbnail images into the svn/assets folder.

= 1.0.7 =

 * Bug: Fixed bad calls from helper class causing options not saving for each site. Thanks https://github.com/benjaminniess

= 1.0.6 =

* Bug: Corrected class_helper->getSitemapUrl() - printing "No Sitemap Found" in robots.txt files
* Bug: Moved class_admin->updateNetwork()->throwMessage() outside of foreach when updating the network
* Change: templates/home.php to display No Sitemap Found within input field

= 1.0.5 =

* Modified class_helper->getSitemapUrl(): added get_option( 'siteurl' ) check for sitemap url
* Corrected commented out redirect action
* Corrected marketup in robots.txt file, again.
* Added final public to class_presets methods

= 1.0.4 =

* Add options to update the full network or only blogs the admin is a user of
* Added message for missing sitemap.xml files within website plugin admin
* Added user notice & error message to all form actions
* Corrected readme.txt file formating
* Corrected notice locations for all 3 detection rules
* Corrected network admin showing website admin status messages
* Corrected message when updating network from disabled network
* Corrected missing new line in the preset WordPress Limited option
* Adjusted disable/delete input names to be code-reader friendly
* Removed class_core.php, functions moved to plugin root
* Commented out $rewrite_rule check/update, until new solution is found

= 1.0.3 =

* Moved upgrade process outside of activation method, into unique class
* Added message/method to detect and replace old plugin data with new data
* Re-added old robots.txt plugin detection and cleaning option
* Re-added bad rewrite rule detection and cleaning option

= 1.0.2 =

* Upgrade Bug Corrected
* Changed how Extention loads in
* Adjusted Extension calls throughout plugin
* Adjusted plugin activation order for detecting old plugin options
* Corrected static function calls for register_activation_hook
* Added feature to copy old sitemap url to new append option

= 1.0.1 =

* Because SVN sucks!

= 1.0.0 =

* Major rebuild, all files recreated, new code
* Set network robots.txt file as global file
* Created append rules for Websites
* Improved Sitemap Detection
* Added Theme & Upload Path Support
* Adjusted admin area layout and look
* Adjusted how Pro Extension adapts in
* Expanded automation features

= 0.4.0 =

* Major rebuild
* Modified how and when the sitemap urls are created.
* Created top-level domain array for sitemap url breakdown.
* Removed network map checks due to alt setup methods.
* Update preset robots.txt files and create 2 new styles.
* Rebuilt all options to use array format.
* Renamed classes and functions.
* Added better sanitization and escaping throughout.
* Adjusted how pro extension integrates in.
* Modified admin html/css to work better for mobile.
* Removed a few pounds of code.
* Improved help text throughout.
* Improved error checking.
* Adjusted install/uninstall functions for non-network installs.
* Merged network admin and website admin template.
* Add old robots.txt plugin detection and cleaning option.

= 0.3.1 =

* Created website admin areas.
* Added is_user_member_of_blog function for super admins.

= 0.3.0 =

* Modified add_submenu_page calls.
* Modified DB prepare() statements.
* Structure change to make room for automation feature.
* Cleaned undefined index errors.
* Ran PHP Debug and WP Debug and removed related errors.

= 0.2.2 =

* Modified add_submenu_page calls.
* Modified DB prepare() statements.
* Structure change to make room for automation feature.

= 0.2.1 =

* Made robots.txt file display when a Website within a directory (domain.com/domain-path) is called.
* Added is_network_admin() and $_SERVER script checks around extra links function.
* Cleaned up activation & deactivation hook calls to only be called when executed.
* Added do_action( 'do_robotstxt' ); call after header call of robots.txt display.
* Adjusted robots.txt display to use public/private blog feature correctly.
* Removed is_user_member_of_blog() check around add_submenu_page() calls.
* Added $_GET['page'] :: "ms_robotstxt.php" wrap around tab display call.
* Improved sitemap structure url output with various domain structures.
* Added current_user_can() && is_super_admin() check to uninstall.php
* Added / adjusted wp_nonce_field and check_admin_referer calls.
* Created second set of tab links at the bottom of plugin admin.
* Cleaned up robots.txt display class - add_filter call.
* Setup better error handling on all form submits.
* Added in version check and file check calls.
* Improved sitemap structure function.
* More comments.

= 0.2.0 =

* Made the site dropdown list populate in a new way, and list site names insted of domains.
* Added sitemap option, url, and structure to default robots.txt, per site, and pre-sets.
* Adjusted all post types and preset values, and option arrays to use sitemap structure.
* Adjusted default option for websites robots.txt to store data within an array.
* Created a new sitemap option to store sitemap data at the Website level.
* Adusted, cleaned html and corrected typos within admin area template.
* Adjusted default robots.txt option to store data within an array.
* Created instructions for the Sitemap URL Structure feature.
* Adjusted robots.txt display to include sitemap urls.
* Adjusted uninstall.php to use new option names.
* Removed transient cache and related db calls.
* New screenshot file and readme.txt updated.
* Updated WordPress Function References.
* Added non-network check on install.
* Serialize proper option data.

= 0.1.1 =

* Replaced action do_robots with filter robots_txt at call.
* Removed ob_gzhandler

= 0.1 =

* Created March 08, 2012



== Screenshots ==

1. Network Admin - All Features Shown

2. Network Admin - Preset Robots.txt File Loaded & Published

3. Network Admin - Cleaner Tab

4. Website Admin - All Features Shown

5. Website Admin - Robots.txt File Using Append Rules

6. Website Admin - Custom Robots.txt File In Use
