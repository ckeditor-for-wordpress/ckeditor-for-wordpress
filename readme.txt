=== CKEditor for WordPress ===
Contributors: wiktor, michal_cksource, dczepierga, Dean Lee
Tags: post, wysiwyg, CKEditor, FCKeditor, editor, rich text, rte, rich text editor
Requires at least: 3.2
Tested up to: 4.0
Stable tag: 4.4.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl.html
This plugin replaces the default WordPress editor with <a href="http://ckeditor.com/">CKEditor</a>.

== Description ==

This plugin replaces the default WordPress editor with <a href="http://ckeditor.com/">CKEditor</a>.

= Maintenance status =

<strong>Looking for maintainers.</strong> If you would like to take over the development of this extension or just help in developing a component used by thousands of users, then please contact me: w.walc /at/ cksource.com.
The extension is currently not maintained. Use it at your own risk.

For anyone willing to contribute: the extension is now <a href="http://github.com/ckeditor-for-wordpress/ckeditor-for-wordpress">available on GitHub</a>.
Anyone is welcome to contribute. Without your help the extension will not get any further updates.

= What is CKEditor? =

<strong>CKEditor</strong> is a text editor to be used inside web pages. It's a WYSIWYG editor, which means the
text being edited looks as similar as possible to the page once published.
It brings to the web common editing features found on desktop editing applications like Microsoft Word and OpenOffice.

<strong>CKEditor</strong> is compatible with most internet browsers and operating systems, including:
<ul>
<li>Internet Explorer 8+</li>
<li>Firefox</li>
<li>Safari</li>
<li>Google Chrome</li>
<li>Opera</li>
</ul>

Live demo is available at <a href="http://wordpress.ckeditor.com/">http://wordpress.ckeditor.com/</a>.

= Features =

* Replace the default WordPress editor with CKEditor
* Post comments with CKEditor to provide styled and colorful comments (optional)
* Built-in file manager and upload manager, also supports <a href="http://ckfinder.com">CKFinder</a> – an AJAX file browser
* Built-in WordPress "read more" button
* Integration plugin for <a href="http://wordpress.org/extend/plugins/vipers-video-quicktags/">Viper's Video Quicktags</a>
* Integration plugin for <a href="http://wordpress.org/extend/plugins/wp-polls/">Wp-Polls</a>
* Integration plugin for <a href="http://wordpress.org/extend/plugins/gd-star-rating/">GD Star Rating</a>
* Integration plugin for <a href="http://wordpress.org/extend/plugins/nextgen-gallery/">NextGEN Gallery</a>
* Integrated with WordPress media buttons
* Configurable output formatting
* Manage and insert smileys into your post
* Customizable toolbar buttons
* Customizable skin
* And more :)

== Installation ==

1. Upload this plugin to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Check your account profile settings and uncheck option "Disable the visual editor when writing" if checked.
4. To install CKFinder, please read ckfinder/readme.txt.

= Upgrading =

When upgrading from CKEditor For WordPress 3.6.3 to **CKEditor For WordPress 4.0**, make sure to **clear browser cache** (*Ctrl+Shift+Delete*).

== Screenshots ==

1. Add/Edit post
2. Leave comment through CKEditor

== Changelog ==

= V4.4.4 - 18.09.2014 =

* Fixed compatibility with WordPress 4.0.
* Updated CKEditor to 4.4.4.
* Added Advanced Content Filter setting in Advanced Settings.

= V4.0.0.1 - 15.07.2014 =

* Backported security patch from CKEditor 4.4.3.

= V4.0 dev - 20.12.2012 =

* Enabled bidi buttons

= V4.0 - 19.12.2012 =

* Updated CKEditor to version 4.0
* Set the default skin to Moono
* Modified the default toolbars
* Increased the default height of editor for comments
* Fixed image captions
* Added protection against caching JavaScript files by the browser by appending CKEditor timestamp to js files
* Fixed: CKEditor does not load when "external" plugin is enabled, but the required extension is not installed
* Minor fixes in the old built-in file browser
* Spellchecker plugins are now enabled in "Advanced Options"
 
= V3.6.3 - 21.06.2012 =

 * Updated CKEditor to version 3.6.3
 * Fixed: CKEditor breaks ajax comment reply function on dasboard (http://wordpress.org/support/topic/ckeditor-breaks-wordpress-built-in-ajax-reply-function?replies=2)
 * Fixed: IE - remove image border when linked
 * New feature: Add option to use CKEditor in excerpt field (http://wordpress.org/support/topic/plugin-ckeditor-for-wordpress-having-ckeditor-for-excerpt).
 * Fixed: Remove calling for non-existent css file
 * Fixed bug with File Gallery plugin compatibilty: http://wordpress.org/support/topic/plugin-ckeditor-for-wordpress-ckeditor-isnt-show-by-default-when-page-loads
 * Changed default settings for CKEditor Output Formatting. This should fix problems with inserting YouTube videos to post.
 * Fixed: CKFinder cannot use its config variable when this variable is object
 * Refactor code: Changes leading spaces for tabs according to WordPress code syntax standard
 * Fixed: Duplicate class attribute for image caption (http://wordpress.org/support/topic/image-attachment-class-problem)
 * Fixed PHP E_STRICT warnings (http://wordpress.org/support/topic/php-strict-errors)
 * Fixed PHP Notice: Invalid argument supplied for foreach() in overview.php file.
 * Fixed: On page with comment form JavaScript errors occurs when W3 Total cache plugin is used. Turn off minfiy on page with comment form.
 * Fixed: Checking if SSL is being used (http://wordpress.org/support/topic/plugin-ckeditor-for-wordpress-blank-white-edit-screen)
 * Fixed look of plugin's overview page

= V3.6.2.5 - 23.02.2012 =

 * Fixed: Fix JavaScript error: instance is undefined
 * Fixed: Call to undefined method _WP_Editors::editor_settings() (http://wordpress.org/support/topic/plugin-ckeditor-for-wordpress-error-on-activation)
 * Fixed: Fix notice error of auto detecting language when viewing website (http://wordpress.org/support/topic/throwing-notice-error-when-viewing-website)
 * Fixed: Fix for hidden buttons below WordPress admin bar when 'Maximize' button is clicked
 * Fixed: Fix support for NextGEN Gallery Plugin (http://wordpress.org/support/topic/plugin-ckeditor-for-wordpress-ckeditor-and-nextgen-button-problem)
 * Fixed: Fix support for gd-star-rating plugin
 * Fixed: CKEditor plugin doesn't work with latest qTranslate plugin (http://wordpress.org/support/topic/plugin-ckeditor-for-wordpress-qtranslate-not-working)
 * Fixed: Try to load nextgen plugin button when user has no permission to do so
 * Fixed: CKEditor plugin, Uploading where admin is restricted to https
 * Fixed error: ckeditor_wordpress::can_upload() is private

= V3.6.2.4 - 13.12.2011 =

 * Fixed problems with upgrade and working correctly in new WordPress 3.3 “Sonny”.
 * Fixed problem with loading CKEditor inside element with id 'content' which is not textarea.

= V3.6.2.3 - 01.12.2011 =

 * This version of CKEditor for WordPress was released due to some issues with upgrading the plugin to version 3.6.2.2. The problem is now fixed.
 * Fixed problem with NextGEN Gallery plugin (http://wordpress.org/support/topic/plugin-ckeditor-for-wordpress-just-updated-to-ckeditor-3622-no-items-in-visual-editor)

= V3.6.2.2 - 29.11.2011 =

 * Fix for form token secure when browser send no http_referer
 * Fix for qTranslate plugin support (http://wordpress.org/support/topic/plugin-ckeditor-for-wordpress-cant-insert-image-or-another-html-tag-from-default-wordpress-media-uploader)
 * Fix for plugin path (http://wordpress.org/support/topic/plugin_path-doesnt-use-wp_plugin_url)
 * Fix for html markups in image caption
 * Fix for html entities in image caption
 * Added support for language settings (http://wordpress.org/support/topic/ckeditor-language-same-as-configphp-lang)
 * Fix for CSS default WordPress theme (http://wordpress.org/support/topic/use-theme-css-should-work-fine-with-the-default-theme)
 * Fix for JavaScript autosave.init call error (http://wordpress.org/support/topic/plugin-ckeditor-for-wordpress-ckeditor-for-wordpress-and-mailpress)
 * Fix for unnecessary html entities change in text. Now it only occurs in shortcodes tags in  [] (http://wordpress.org/support/topic/plugin-ckeditor-for-wordpress-using-html-entities-in-the-output)

= V3.6.2.1 - 14.10.2011 =

 * Added security fix (thx to Julio Potier from http://boiteaweb.fr)
 * Fixed: Cannot reply to an existing comment (http://wordpress.org/support/topic/plugin-ckeditor-for-wordpress-v362-cannot-reply-to-an-existing-comment)
 * Fixed: CKEditor 3.6.2 update and qTranslate incompatibility (http://wordpress.org/support/topic/plugin-ckeditor-for-wordpress-ckedtior-362-update-and-qtranslate-incompatibility)
 * Changed messages for CKFinder configuration

= V3.6.2 - 15.09.2011 =

 * Updated CKEditor to version 3.6.2
 * Fixed: CKEditor is in read only state after closing WordPress gallery popup (iframe)
 * Added support to "Custom fields template" plugin (http://wordpress.org/extend/plugins/custom-field-template/)
 * Refactor of functions used in WordPress gallery
 * Added index.html files to directories to protect against directory listing

= V3.6.1.1 DEV - 22.08.2011 =

 * Fix to work when "After the Deadline" plugin is installed

= V3.6.1 - 19.08.2011 =

 * Plugin naming conventions changed to match CKEditor version
 * Support for built-in WordPress file gallery added
 * Support for managing images via WordPress added
 * Shortcode support improved

= V1.0.9 - 05.07.2011 =

 * Added compatibility for WordPress 3.2
 * Updated CKEditor to version 3.6.1


= V1.0.8 - 10.05.2011 =

 * Updated CKEditor to version 3.6
 * Fixed error when calling undefinde getUserSetting function in ckeditor.utils.js


= V1.0.7 - 08.04.2011 =

 * Updated CKEditor to version 3.5.3
 * Viper’s Video Quicktags – show buttons only from enabled options
 * Successfully tested with WordPress 3.1


= V1.0.7 DEV - 17.03.2011 =

 * Viper’s Video Quicktags – show buttons only from enabled options
 * Successfully tested with WordPress 3.1

= V1.0.6 - 17.02.2011 =

 * Updated CKEditor to version 3.5.2

= V1.0.5 - 10.02.2011 =

 * Updated CKEditor to version 3.5.1

= V1.0.4 - 05.11.2010 =

 * Updated CKEditor to version 3.5

= V1.0.3 - 05.11.2010 =

 * Updated CKEditor to version 3.4.2
 * Corrected the default set of buttons that are available in comments

= V1.0.2 - 21.09.2010 =

 * Updated CKEditor to version 3.4.1
 * Fixed qTranslate plugin compatibility
 * Added Bidi (LTR/RTL) buttons to the toolbar
 * Fixed: Reply to comment freezes unless source button is pressed

= V1.0.1 - 14.06.2010 =

* Fixed usage of PHP short tag causing parse error
* Fixed "Read more" button
* Fixed issues when working with the qTranslate extension (unable to save edited content)
* Fixed issues with saving configuration files when using file editor

= V1.0 - 11.06.2010 =

* Updated CKEditor to version 3.3.1
* Fixed issue with loading templates inside of CKEditor
* Fixed compatibility with qTranslate
* Added option to enable/disable SCAYT
* Improved compatibility with WordPress 3.0
* Fixed problem with MediaEmbed plugin (unknown variable ckeditorVariables)
* Fixed built-in file browser

= V1.0 Beta2 - 17.03.2010 =

* Fixed compatibility with PHP4 and with disabled short tags

= V1.0 Beta - 10.03.2010 =

* Inital beta release
