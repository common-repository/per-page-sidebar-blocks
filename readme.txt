=== Per Page Sidebar Blocks ===
Contributors:  jcross
Donate link: http://www.immense.net/per-page-sidebar-blocks-plugin-wordpress/
Tags: sidebar, specific, per page, customize, blocks
Requires at least: 2.5
Tested up to: 3.3.1
Stable tag: 1.0.3

Include sidebar templates on a per-page basis.

== Description ==

= Background and goals of this plugin =
Part of offering WordPress as a CMS to my clients involves giving them as much control over the future of their website as possible. One pitfall I experience is offering per-page sidebar customization.

= Sidebar templates and conditionals =
I find myself creating several sidebar-name.php templates and using conditionals to display them where I want. Functions like is_page(), is_tree(), is_ancestor(), is_single(), etc. let me plan ahead for which sidebars should show on which pages. However, is_page(14) is not an acceptable solution for me, nor does it truly allow customizing sidebar output for pages created in the future outside the scope of my preemptive conditionals.

= Page-specific blocks of content in the sidebar =
Per Page Sidebar Blocks lets you, the theme developer, create several sidebar templates using WordPress’ naming convention sidebar-name.php.

= Automatically finds your sidebar templates =
PPSB will scan the current theme’s root directory for all your sidebar templates and let you decide which ones get displayed on each individual page by simply checking a box on that page’s Edit area.

= More Information =
A full writeup is available at http://www.immense.net/per-page-sidebar-blocks-plugin-wordpress/

= Known Bugs =
1. If you create a new page and check some PPSB boxes, the checks will not save if the page is published. You must check the boxes after the page is published and save again.

== Installation ==

1. Upload the 'per-page-sidebars' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Put the following code into your sidebar.php file: &lt;?php if( function_exists( 'ppsb_show_sidebars' ) ) echo ppsb_show_sidebars(); ?&gt;
4. Create necessary sidebar templates using WordPress' naming convention sidebar-name.php
5. Specify display order of sidebars in Settings > Per Page Sidebar Blocks
6. Check boxes in page editor to display those sidebars

== Frequently Asked Questions == 

= Why is this sidebar plugin different? =

Instead of simply letting you select a full sidebar for a page (which you could certainly setup using this plugin), I go a step further and let you create different blocks of content. Let’s say your client has a list of Company Partner’s logos, and they want to list them on the About and Services pages. Rather than create a specific sidebar for each of those pages, create a sidebar-partners.php block and just enable it on every page it’s needed; use sidebar templates as building blocks to customize sidebar content as needed.

== Changelog ==

= 1.0.3 = 
* Bug fix when reordering on PPSB Settings page

= 1.0.2 = 
* Bug fix Undefined variable on line 160

= 1.0.1 =
* Bug fix when no sidebars available

= 1.0.0 =
* Initial release

== Upgrade Notice == 

= 1.0.3 = 
Bug fix when reordering on PPSB Settings page

= 1.0.2 =
Bug fix Undefined variable on line 160

= 1.0.1 =
Bug fix when no sidebars available

= 1.0.0 =
Initial release

== Screenshots ==

1. Specify which sidebar blocks show per page
2. Drag and drop to set the display order of sidebar blocks

== Upgrade Notice ==

= 1.0.2 =
Bug fix Undefined variable on line 160