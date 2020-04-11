# Changelog

# 3.0.0
**2020-04-11- Feature**
* Freemius upgrade
* Activation issue: https://github.com/ChrisWinters/multisite-robotstxt-manager/issues/8
* WordPress 5.4 Tested

# 2.1.1
**2020-01-11- Hotfix**

* Modified how robots.txt file is generated within class-robotstxt.php

# 2.1.0
**2019-10-06 - Feature**

* Added website override option to ignore network robots.txt file

# 2.1.0
**2019-10-06 - Feature**

* Added website override option to ignore network robots.txt file

# 2.0.4
**2019-08-28 - Hotfix**

* Removed Freemius nag notice.

# 2.0.3
**2019-08-22 - Hotfix**

* Corrected class-do-build-robotstxt.php array pairs for class-option-manager.php
* Corrected class-option-manager.php to correctly checking for array key before building the array
* Moved robotstxt build call in class-do-save-append-rules.php to fire only if the setting was updated
* Added {APPEND_WEBSITE_ROBOTSTXT} to open robots.txt file within class-do-save-preset-as-robotstxt.php

# 2.0.2
**2019-08-07 - Hotfix**

* Removed plugin-activation level upgrade in favor of manual upgrade
* Moved admin/network/public class includes into plugins_loaded hook
* Modified class-translate.php to use new translation call format
* Modified sidebar hardcoded images to use plugin_dir_url()
* Modified plugin settings upgrade message for new installs
* Corrected network delete all settings to correctly delete all settings
* Corrected function call in class-do-network-robotstxt-build.php
* Corrected function call in class-do-robotstxt-cleaner.php
* Corrected bump.js gulp task

# 2.0.1
**2019-07-25 - Hotfix**

* Created manual upgrade and delete old settings notice.

# 2.0.0
**2019-07-22 - Release**

* Tested: Wordpress Version 5.2.2
* Major code base upgrade
* Migrated settings to single option

# 1.0.12
**2017-9-6 - Hotfix**

* Tested: Wordpress Version 4.8
* Changed: Network & Admin Area Plugin Update Notice Handler.
* Fixed: Remove Rewrite Rule Flush After Correcting Rewrite Rules.

# 1.0.11
**2017-24-4 - Hotfix**

* Added: Added more Sitemap filenames to check/build for.
* Changed: Sitemap check/build, added rewrite rule & physical file checks if fopen is not enabled.

# 1.0.10
**2017-23-4 - Hotfix**

* Tested: Wordpress Version 4.7.4
* Changed: Review/Rating URL within templates/sidebar.php
* Fixed: Cleaner option name checks, using previous version names.
* Fixed: Cleaner rewrite_rule to delete/update the option when missing the robots.txt array.

# 1.0.9

* Fixed: Bad method call in class-cleaner.php.
* Fixed: Multiple incorrect update_option formats.
* Fixed: Network Robots.txt now saves when published | https://github.com/ChrisWinters/multisite-robotstxt-manager/issues/5
* Fixed: Removed append marker, if no append rules found.
* Fixed: Wrapped is_writable() check to physical robots.txt removal.
* Change: Option names for cleaner, appended cleaner_.
* Change: Modified update success/fail messages.
* Change: Deleted uninstall.php | https://github.com/ChrisWinters/multisite-robotstxt-manager/issues/6

# 1.0.8

* New plugin structure/files, using the same option names.
* Added: New tab "Cleaner" to the Network Admin area.
* Added: Two stage cleaning process - check & clean.
* Added: Check for a physical robots.txt file.
* Added: Check for missing robots.txt file rewrite rule.
* Added: Network tab to Websites for quick access to plugin admin within the Network.
* Added: Option to disable network robots.txt file on websites, allowing for full customization of websites robots.txt file.
* Change: Plugin admin areas to be more visually friendly.
* Moved: Screenshots/header/thumbnail images into the svn/assets folder.

# 1.0.7

 * Bug: Fixed bad calls from helper class causing options not saving for each site. Thanks https://github.com/benjaminniess

# 1.0.6

* Bug: Corrected class_helper->getSitemapUrl() - printing "No Sitemap Found" in robots.txt files
* Bug: Moved class_admin->updateNetwork()->throwMessage() outside of foreach when updating the network
* Change: templates/home.php to display No Sitemap Found within input field

# 1.0.5

* Modified class_helper->getSitemapUrl(): added get_option( 'siteurl' ) check for sitemap url
* Corrected commented out redirect action
* Corrected marketup in robots.txt file, again.
* Added final public to class_presets methods

# 1.0.4

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

# 1.0.3

* Moved upgrade process outside of activation method, into unique class
* Added message/method to detect and replace old plugin data with new data
* Re-added old robots.txt plugin detection and cleaning option
* Re-added bad rewrite rule detection and cleaning option

# 1.0.2

* Upgrade Bug Corrected
* Changed how Extention loads in
* Adjusted Extension calls throughout plugin
* Adjusted plugin activation order for detecting old plugin options
* Corrected static function calls for register_activation_hook
* Added feature to copy old sitemap url to new append option

# 1.0.1

* Because SVN sucks!

# 1.0.0

* Major rebuild, all files recreated, new code
* Set network robots.txt file as global file
* Created append rules for Websites
* Improved Sitemap Detection
* Added Theme & Upload Path Support
* Adjusted admin area layout and look
* Adjusted how Pro Extension adapts in
* Expanded automation features

# 0.4.0

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

# 0.3.1

* Created website admin areas.
* Added is_user_member_of_blog function for super admins.

# 0.3.0

* Modified add_submenu_page calls.
* Modified DB prepare() statements.
* Structure change to make room for automation feature.
* Cleaned undefined index errors.
* Ran PHP Debug and WP Debug and removed related errors.

# 0.2.2x

* Modified add_submenu_page calls.
* Modified DB prepare() statements.
* Structure change to make room for automation feature.

# 0.2.1

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

# 0.2.0

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

# 0.1.1

* Replaced action do_robots with filter robots_txt at call.
* Removed ob_gzhandler

# 0.1

* Created March 08, 2012
