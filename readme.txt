=== Multisite Robots.txt Manager ===
Plugin Name: Multisite Robots.txt Manager | MS Robots.txt
Contributors: Chris Winters
Tags: robots.txt, seo, multisite
Requires at least: 3.8
Tested up to: 6.7.1
Stable tag: 3.1.0
License: GNU GPLv3
License URI: https://github.com/ChrisWinters/multisite-robotstxt-manager/blob/master/LICENSE

A Robots.txt Manager Plugin for WordPress Multisite Networks. Quickly and easily manage all robots.txt files on a WordPress Multisite Website Network.

== Description ==

A Robots.txt Manager Plugin for WordPress Multisite Networks. Quickly and easily manage all robots.txt files on a WordPress Multisite Website Network.

!!! Network Enabled Multisite Installs Only !!!

This Plugin Was Created For Multisite Networks > Network Activations Only!

== For Support & Bugs ==

Please [report issues](https://github.com/ChrisWinters/multisite-robotstxt-manager/issues) you may have found.

== Features ==

* Network-wide robots.txt file shared across all sites.
* Append extra robots.txt data per-site Admin.
* Create unique robots.txt files for each network website.
* Manage all websites from the Network Admin Area.
* Manage a single website through individual Site Admins.
* Auto-generate Sitemap URLs, Upload Paths, and Theme Paths.
* Mass update all websites on the network in one click.
* Quickly publish preset robots.txt files across the network.
* Scan and clean old plugin data to avoid conflicts.

== Quick Info ==

* The default "Network Wide" robots.txt file is NOT a live robots.txt file.
* Deactivating the plugin keeps all options but stops showing robots.txt files.
* Deleting the plugin removes all options/settings from the database for all websites.

**How to Access:**

- Get the Plugin: Download > Install > Network Activate
- Network Admin: Settings Tab > MS Robots.txt Link
- Website Admin: Settings Tab > MS Robots.txt Link

**Steps to Publish:**

1. Network Admin:
  - Choose "Publish the network robots.txt file to all network websites" or "Publish to websites you are a member of."
  - Click "Update Settings" to publish.
2. Website Admin:
  - Modify the appended robots.txt file or create a unique file.
  - Click "Update Website Rules" to save changes.

== Installation ==

**Install through WordPress Admin:**

1. Navigate to **Network Admin > Plugins > Add New**.
2. Search for "robots.txt".
3. Locate "Multisite Robots.txt Manager" and click **Install Now**.
4. Activate the plugin or Network Activate it.

**Manual Upload and Install:**

1. Upload `/multisite-robotstxt-manager/` to `/wp-content/plugins/`.
2. Go to **Network Admin > Plugins**.
3. Find "Multisite Robots.txt Manager" (sort by inactive) and click **Activate**.

== FAQs ==

**Q) Can the plugin update all websites at once?**
A) Yes.

**Q) Does this plugin work on non-multisite installs?**
A) No, it requires Multisite/Network activation.

**Q) Can every website have a different robots.txt file?**
A) Yes, each site can append unique rules or fully customize its robots.txt file.

**Q) Does this plugin handle Sitemap links?**
A) Yes, the Pro version adds them automatically; the Free version requires manual addition.

**Q) My robots.txt file is 404—what's wrong?**
A) Missing rewrite rules. Use the plugin's Cleaner tab in the Network Admin to fix this.

**Q) Does this plugin work with other robots.txt plugins?**
A) No, multiple plugins managing robots.txt files can cause conflicts.

**Q) Does the plugin clean up settings when deleted?**
A) Yes, all settings and options are removed upon deletion.

== Additional Info ==

**Markers in Network Robots.txt File:**
- Use `{APPEND_WEBSITE_ROBOTSTXT}` in the network robots.txt file to insert unique rules from individual websites.

**Robots.txt File Testing:**
- Use [Google's Robots.txt Tester](https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt).

== Changelog ==

**3.0.1**
- Released: 2024-11-21
- [Changelog Details](https://github.com/ChrisWinters/multisite-robotstxt-manager/blob/master/CHANGELOG.md#301)

== Screenshots ==

1. Network Admin - All Features Shown
2. Preset Robots.txt File Loaded & Published
3. Cleaner Tab
4. Website Admin - Features Overview
5. Robots.txt File Using Append Rules
6. Custom Robots.txt File Example
