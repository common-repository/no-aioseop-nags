=== NO admin premium NAGS ===
Contributors: eilertbehrends, kontur.us, netzaufsicht
Donate link: https://www.paypal.com/paypalme/werbekontur/3EUR/
Tags: admin css, custom admin css, anti-spam, SEO, no nags
Requires at least: 5.6
Tested up to: 6.5
Stable tag: 3.4
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simply stop the abusive admin nags from All in One SEO plugin and as well from YOAST Seo! Plus: Add your own CSS to the Admin Area.

== Description ==


## Stopping the Admin Premium Ads for free
 **This simple Plugin, will clean most of the abusive admin Spam from the "All in One SEO" - Plugin. And NOW as well from the "YOAST SEO Plugin"**
AIOSEO ist a great plugin, and we love it. BUT it is enough to mention it once that there are premium versions. 
And there IS NO REASON to block functions, like e.g. the editing of Category Descriptions.
So this will clean things a little for us.

## What the plugin does
1. Clean the wp-admin bar from advertising AND useless links to functions that are not free, and therefor utterly useless links
2. Clean the AIOSEO set up pages or Yoast SEO pages from premium advertising and tabs that lead to useless settings, which are not available in the free version
3. Get rid of the strange ad on the category page
4. Clean the page / post editor screen from numerous premium ads that make the editor almost looking like an advertising board
5. Option to load your own CSS into the WP Admin Area. The cutom admin CSS input runs with CodeMirror for an easier handling of the CSS input ( line numbers, color highlight, autocomplete). 

> **Important: If you see new spam, PLEASE let us know!**
  We do write updates once we know, that new spam occurs! 


> **Note:**
 The version after 2.7 does now work as well with YOAST SEO.
## Add your custom css, to clean even more
You can add your own CSS to block other nags on the settings page. We intend to develop this part further with snippets for the most annoying plugin naggers out there.

> **If you like that approach,**
  please get involved and send uns your snippets. Via email or on the WordPress support page :-)


== Installation ==

To use as a normal plugin in WordPress single install and multisite.

1. Install the plugin through the WordPress admin interface, or upload the folder /no-aioseop-nags/ to /wp-content/plugins/ using ftp.
2. Activate the plugin via WordPress admin interface. If it is a multisite, network activate it.
3. If you want to add own admin css or deactivate the the blocking without deactivating the plugin itself.
Go to WordPress Admin > Appearance > No All in one SEO Notifications... OR use the settings link on the main the plugins page


Note: individual css added through this plugin will be deleted upon uninstall.


== Frequently Asked Questions ==

= How to use the custom CSS option? =

Just add your CSS into the field and hit save. This can be used to add your custom WP admin CSS, e.g. to change fonts, colors etc. OR to block other advertising, update, rate.. ads. Or you can use for example it to hide menu items. 

= Who is this plugin for? =

It's made for admins, site owners, blog owners who just don't want to see premium spam everywhere in their backend.

= Can I do this without the plugin? =

Sure, at least most of it! You could use your function.php and add / enque these admin styles and the de-registration of the AOSEOP script, that blocks you to save category descriptions from there.
Drop me a line, and I will send you the CSS / function. 

= Can I use this for Yoast SEO? =

Yep, since Version 2.8 we are as well blocking the YOAST Seo Premium Spam. 



= Can I use this to e.g. block nags from JetPack and others? =

Of course you can: with the custom CSS settings. You might want to use CSS comments there so as not to later get confused with the number of lines in your own CSS. For easier handling, we have integrated CodeMirror from version 3.3 to have line numbering, autocomplete, color highlighting and more features for your CSS code.


= I need something else. Can I hire you? =

Yes. Please get in touch via [email](mailto:hello@kontur.us) (hello@kontur.us) with a brief description of your requirement and budget for the project and we will start something else together.

= This plugin is simple, but I want to show my appreciation? =

Well, go for it! You can either [make a donation](https://www.paypal.com/paypalme/werbekontur/3EUR/) or leave a [rating](https://wordpress.org/support/plugin/no-aioseop-nags/reviews/?rate=5#new-post) to motivate me to keep working on the plugin. 

== Screenshots ==

1. Settings page
2. Add your own CSS to the WP admin area
3. Category page with advertising before
4. Cleaned category page
5. Before- Admin bar menu with numerous advertising links
6. After - Clean menu
7. All in one SEO Admin Dashboard before
8. After - removed ads from the view
9. WP-Dashbord with Premium Spam
10. Clean WP-Dashboard



== Changelog ==

= 3.4 =
* Date: 3.April.2024
* Bugfix: "is_plugin_active" was causing PHP errors in some installations
* Updated Readme.txt



= 3.3 =
* Date: 4.May.2023
* Added CodeMirror to the custom admin css
* Renaming no "NO admin premium NAGS - please", beacuse the AIOSEO was causing confusion with YOAST users
* Updated Readme.txt



= 3.2 =
* Date: 28.April.2023
* blocking multiple new spam ideas on AISOE after their recent update
* Updated Readme.txt


= 3.1 =
* Date: 24.April.2023
* minor bug fixes
* updated translation 
* Updated Readme.txt



= 3.0 =
* Date: 16.April.2023
* fixes problems due to incomplete plugin upload
* Updated Readme.txt



= 2.9 =
* Date: 16.April.2023
* minor fixes causing php errors
* minor fixes assuring YOAST span is blocked as well on the frontend
* Updated Readme.txt


= 2.8 =
* Date: 13.March.2023
* updated settings page
* added German language support, translation
* minor bug fixes due to the new YOAST funtions
* Updated Readme.txt



= 2.7 =
* Date: 12.March.2023
* added YOAST Seo blocking of premium ads
* updated settings page
* minor bug fixes
* Updated Readme.txt




= 2.6 =
* Date: 6.March.2023
* removed new search statistics spam
* removed openAI api spam
* updated settings page
* minor bug fixes
* Updated Readme.txt


= 2.5 =
* Date: 21.August.2022
* removed new spam
* removed misleading spam links on the post an page editor
* re-enabled General Settings > Webmaster Tools and removed the spam
* added new sub-menu link to the AIOSEO settings
* added new sub-menu link to WP admin bar for disabling the menu
* Updated Readme.txt


= 2.4 =
* Date: 2.April.2022
* removed new spam
* removed misleading spam links on the post an page editor
* re-enabled General Settings > Webmaster Tools and removed the spam
* Updated Readme.txt


= 2.3 =
* Date: 31.January.2022
* removed new spam link in admin bar
* added new option to disable the the seo menu in the admin-bar
* minor bugfixes caused by the recent wordpress update
* Updated Readme.txt

= 2.2 =
* Date: 30.December.2021
* added new option to disable the the seo menu in the admin-bar
* added check wether AIOSEO is installed
* updated language file
* minor bugfixes caused by the recent update
* Updated Readme.txt

= 2.1 =
* Date: 29.December.2021
* Added new function to enable custom css without using the blocking function enabled
* minor bugfixes (php errors)
* added blocking of the advertising "redirection" manager link
* Updated Readme.txt


= 2.0 =
* Date: 20.December.2021
* Added new functions to allow adding of own css to the wp admin area
* Added new plugin settings page
* Added spam-classes to be blocked
* Updated Readme.txt


= 1.2 =
* Date: 16.March.2021
* Added spam-classes to be blocked
* Updated Readme.txt


= 1.1 =
* Date: 16.July.2020
* Added Screenshots
* Updated Readme.txt

= 1.0 =
* Date: 10.July.2020
* First release of the plugin.

== Upgrade Notice ==

= 1.2 =
* Date: 16.July.2020
* Update for latest AIOSEO

= 1.1 =
* Date: 16.July.2020
* Added Screenshots

= 1.0 =
* Date: 10.July.2020
* First release of the plugin.


== Upgrade Notice ==
= 3.4 =
* Bugfix: "is_plugin_active" was causing PHP errors in some installations
* No need to update, if it runs on your system. A real Update is soon to come