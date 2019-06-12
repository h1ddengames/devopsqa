=== Simple Documentation ===
Contributors: mathieuhays
Tags: documentation,video,link,file,note,screenr,youtube,vimeo,backend,embed,multisite
Requires at least: 3.0.1
Tested up to: 5.0.2
Stable tag: 1.2.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin helps webmasters/developers to provide documentation through the Wordpress dashboard.

== Description ==

This plugin helps webmasters/developers to provide documentation through the wordpress dashboard.

This plugins allows you to share 4 types of content:

*   "Link" It is a simple link with a custom title and url which will open in a new tab
*   "Video" Allow you to put an embed code from websites like Youtube, Vimeo, ScreenR (all the ones which gives you iframe based code)
*   "Quick Note" This a short text which intend to help by giving a short tip! (for longer content use Links!)
*   "File" Upload a file to the wordpress installation and display the link. (The file link can be filled manually if you upload content by FTP).

As an administrator, you can add, edit or remove content, choose the number of items displayed per page in the widget, the targeted backend user role and customize the widget title and welcome message.

Backend Users and Administrators can pin items to highlight them.

I'm currently working on rewriting this plugin from scratch in order to improve its reliability and make it easier to maintain. Thanks for your patience.

= Features =

* Multisite support
* Import / Export

= Languages =

* English
* French
* German (thanks to [Alexander Pfabel](http://alexander.pfabel.de/))
* Spanish (thanks to [Sugartoys](http://sugartoys.net)) (adapted from version 1.1.x)
* Serbo-Croatian (thanks to [Borisa Djuraskovic](http://www.webhostinghub.com/)) (adapted from version 1.1.x)
* Dutch (thanks to [Gerhard Hoogterp](http://www.funsite.eu))

= Contribute =

You can submit issues and pull request on [Github](https://github.com/mathieuhays/Simple-Documentation)

== Installation ==

The installation is not tricky. It's simple as activating the plugin and Add content !
Hit the import/export button to copy your installation on multiple WP installations.

== Changelog ==

= 1.2.8 =

* Fix potential plugin conflict

= 1.2.7 =

* [Security] Fix vulnerability

= 1.2.6 =

* Fix bug when trying to add empty item
* Add compatibility with translate.wordpress.org

= 1.2.5 =

* Fix bug when using the editor in "Text" mode

= 1.2.4 =

* Fix file attachment edition issues

= 1.2.3 =

* Fix translation issues & Dutch translation by [Gerhard Hoogterp](http://www.funsite.eu)

= 1.2.2 =

* Remove slashes appearing after editing an item.

= 1.2.1 =

* User restriction issue fix.

= 1.2.0 =

* Re-order by Drag & Drop
* Per item user limitation
* Serbo-Croatian adapted from version 1.1.8 version. (Provided by [Borisa Djuraskovic](http://www.webhostinghub.com/))

= 1.1.8 =

* German translation improved
* Text edition. Correction.

Thanks to Alexander Pfabel and Vernon Fowler.

= 1.1.7 =

* German Translation added. Thanks to [Alexander Pfabel](http://alexander.pfabel.de/)

= 1.1.6 =

* Video and File edition Fix
* Retina support on Menu icon
* Loading statement added on edit/add buttons.

= 1.1.5 =

* Now you can add code snippets in note using &lt;code&gt; tag.
* &lt;br&gt; tag fix on note and video

= 1.1.4 =

* Edit field MySQL optimization
* Quick note and Video now support br tag
* Menu position conflicts fixed

= 1.1.3 =

* Field edition fix.
* Basic html support added to quick note content. (a,strong,b,em,i)

= 1.1.2 =

* MP6 optimization on modal box
* Cache issue fix

= 1.1.1 =

* CSS version fix

= 1.1.0 =

* Multisite basic support
* Import / Export feature added
* String issues fixed.
* Welcome, Pinned and All items customization added.

= 1.0.4 =

* Welcome message now support HTML tags
* Video height issue fixed

= 1.0.3 =

* Add Welcome message customization
* Custom role support

= 1.0.2 =

* Icons fix

= 1.0.1 =

* Plugin's Name and Description Fix

= 1.0 =

* Initial Version

== Upgrade Notice ==

New version completely rebuilt from scratch including new features such as reorder and per item limitation.

== Frequently Asked Questions ==
= What's happenning when I delete this plugin ? =
All the data stored in your database and Wordpress options are also deleted ! When the plugin is desactivated, all data remains in your database.

= How to add code snippets to my notes ? =
You must add your code snippet between &lt;code&gt; tags.

== Screenshots ==

1. Simple Documentation in your dashboard
2. Main editor. Choose between different type of content
3. Setting page
