=== Multisite Robots.txt Manager ===
Plugin Name: Multisite Robots.txt Manager | MS Robots.txt
Contributors: tribalNerd, Chris Winters
Tags: robotstxt, robots.txt, robots, robot, spiders, virtual, search, google, seo, plugin, network, mu, multisite, technerdia, tribalnerd
Requires at least: 3.8
Tested up to: 5.4
Stable tag: 3.0.0
License: GNU GPLv3
License URI: https://github.com/ChrisWinters/multisite-robotstxt-manager/blob/master/LICENSE

A Robots.txt Manager Plugin for WordPress Multisite Networks. Quickly and easily manage all robots.txt files on a WordPress Multisite Website Network.

== Description ==

A Robots.txt Manager Plugin for WordPress Multisite Networks. Quickly and easily manage all robots.txt files on a WordPress Multisite Website Network.

!!! Network Enabled Multisite Installs Only !!!

This Plugin Was Created For Multisite Networks > Network Activations Only!


= For Support & Bugs =

Please [contact us directly](http://technerdia.com/help/) if you need assistance or have found a bug. The WordPress Support forum does not notify us of new support tickets, no idea why, so contact us directly.


= View, Report Bugs, Contribute! =

Visit this [Plugin on Github!](https://github.com/ChrisWinters/multisite-robotstxt-manager/) Clone/fork yourself a copy, report a bug or submit a ticket & pull request!


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

= 3.0.0 =
* Released: 2020-04-11
* Changelog: https://github.com/ChrisWinters/multisite-robotstxt-manager/blob/master/CHANGELOG.md#300



== Screenshots ==

1. Network Admin - All Features Shown

2. Network Admin - Preset Robots.txt File Loaded & Published

3. Network Admin - Cleaner Tab

4. Website Admin - All Features Shown

5. Website Admin - Robots.txt File Using Append Rules

6. Website Admin - Custom Robots.txt File In Use
