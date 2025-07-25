=== OpenAgenda ===
Contributors: openagenda, vincentdubroeucq
Tags: openagenda, agenda, calendar, event, events
Requires at least: 5.0
Tested up to: 6.8.2
Stable tag: 2.14.1
Requires PHP: 7.4.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display calendars from https://openagenda.com on your site.

== Description ==

## Basic usage

This WordPress plugin allows you to embed any calendar hosted on [https://openagenda.com](https://openagenda.com) on your WordPress site.

Upon activation, the plugin creates a new post type named *Calendars*. Just create a new calendar, provide the UID of the calendar you wish to display in the calendar settings box, and that's it !

You can leave the content area for this calendar empty, as it will be populated automatically with your events !

Your events are automatically inserted after your content. If you wish to control where your events will be listed, just use the shortcode `[openagenda]` in your content.

## Settings

General settings can be found under the *Calendar > Settings* entry in the admin menu.

All data related to your API key or calendars can be found on https://openagenda.com.

The settings are divided into two tabs: General and Integrations.

### General settings

The General settings page provides the following settings : 

 * *OpenAgenda API key* : Your user API key. **Providing your account API key is required for the plugin to work properly.** It can be found in your account on [https://openagenda.com](https://openagenda.com)
 * *Allow for embedded content* : If your events contain embedded content, tick this box to allow the corresponding HTML tags.
 * *Load default stylesheets* : The plugin provides very basic styling and depends heavily on your theme's styles. Disable this to rely 100% on your theme styles.
 * *Cache duration* : For performance reasons, basic requests to OpenAgenda are temporarily kept in cache. This settings controls the time to keep them cached, in seconds.
 * *Default event image* : Choose an image to use in case events do not have one.
 * *Delete all calendar content on uninstall ?* : controls whether you want to delete all your calendars on uninstall.
 * *Delete all options on uninstall ?* : controls whether you want to delete all your calendar settings on uninstall.
 * *Allow OpenAgenda to collect usage stats ?* : controls whether you want to send CMS used and site URL to OpenAgenda, for statistic purposes.

### Integrations settings

The *Integrations* tab allows you to fine tune settings for various third party services the plugin uses.

**OpenStreetmap integration settings :**

 * *Default map tiles link* : This is the map tile used for the various maps displayed by the plugin.
 * *Default map tiles attribution link* : this is the default attribution link placed on OpenStreetMaps.

**CloudImage integration settings :**

 * *CloudImage API key* : If you wish to use CloudImage to serve your images, enter your API key here.

### Permalinks settings

In the *Permalinks* settings, you can change the prefix for your calendar pages. You cannot leave this blank as your URLs will conflict with WordPress' default pages and posts.

In the *Settings > Reading* section, you can set a calendar page as your front page. Note that it will still use the default calendar template provided by the plugin and the default front page template provided by your theme.

### Customizer settings

In the *Customizer*, a new panel is available to house various display settings. For now only a main color setting is available.

![A single section in the customizer houses your display settings.](assets/screenshots/screenshot-6.png)

If you add Openagenda Filter widgets via the customizer, **the preview will not display them immediately**. That's simply because filters are initialized on page load and the customizer preview is not always fully refreshed when a setting is changed.

Simply publish your settings and refresh the page, or open your agenda page in another tab. Your filter should work just fine. 

## Filter widget and shortcodes

To allow users to easily find relevant events, the plugin also provides a convenient filter widget. Place the widget in your sidebar or other widgetized area, pick a filter and tweak any additionnal settings in the widgets admin.

To integrate filters directly in your content instead of widget areas, the plugin also provide shortcodes.

Every shortcode listed here (except for `[openagenda]`) corresponds to a filter option in the widget.

Additionaly, shortcodes and widget filters have the same parameters, and every shortcode attribute corresponds to a widget filter setting.

**`[openagenda]`**

Displays the calendar. You do not need to use this shortcode explicitely, as it is automatically injected in the content of your "calendars" posts.

However, if you need to insert static content after your list of events, you can do so by inserting this shortcode, then your static content afterwards.

**`[openagenda_filter_active]`**

Displays the active filters. It takes no parameters.

**`[openagenda_filter_choice]`**

Displays a list of choices, depending on the field chosen. It takes the following parameters : 

 * `field`: the slug of the choice field you want to display (e.g. "cities", "keywords", "departments", "favorites", etc... ).
 * `additional_field`: Any custom field you have setup in your OpenAgenda administration. Only works when 'Additional Field' is the chosen field.
 * `page_size`: Number of options to display before the 'More options' button.

You can find the list of available additional fields in the Forms section of your agenda settings on openagenda.com (ex: https://openagenda.com/[your-agenda]/admin/schema)

**`[openagenda_filter_calendar]`**

Displays a calendar. It takes no parameters.

**`[openagenda_filter_map]`**

Displays an interactive map to locate and search events. It takes the following parameters :

 * `map_tiles_link` : Map tiles link to use. Defaults to `https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png`
 * `map_auto` : Whether to automatically update map on scroll. 

**`[openagenda_preview]`**

Displays a preview of any calendar. It takes the following parameters : 

 * `uid` : UID of the calendar you wish to preview.
 * `size` : Number of events to display.
 * `sort` : Event sort option. Accepts `lastTimingWithFeatured.asc`, `timingsWithFeatured.asc`, `lastTiming.asc`, `timings.asc`, `updatedAt.asc` or `updatedAt.desc`. 
 * `filters` : Query string representing filters to apply to the request. **To ensure it works properly and avoid breaking the shortcode, you should urlencode the query string**. You can do so via a simple tool like [https://www.urlencoder.org/fr/](https://www.urlencoder.org/fr/)
 * `links` : Accepts `oa` or an empty string. If set to `oa`, event links will point to events pages on https//openagenda.com instead of local pages.

**`[openagenda_filter_relative]`**

Allows to filters past or upcoming events. It takes no parameters.

**`[openagenda_filter_search]`**

Displays a search field. It takes the following parameters :

 * `placeholder` : text field placeholder.

## Customization

Templates for the list of events and individual events can be customized in your child theme.

If you're not already using a child theme, it is recommended to create one.

[https://developer.wordpress.org/themes/advanced-topics/child-themes/](https://developer.wordpress.org/themes/advanced-topics/child-themes/)

Just create a folder named `openagenda/` in your child theme, then copy and paste the template you wish to override from the plugin's `templates/` folder.

Here is a list of templates you can find in the plugin's `templates/` folder : 

* `event-loop.php` : main wrapper for list view and single event view. Displays exports button and pagination at the top and bottom. 
* `list-header.php` : contains the total number of events and active filters display.
* `event.php` : template used to display the event information on list views.
* `single-event.php` : template used to display the event information on single event views.
* `event-location.php` : template used to display the location information on single event views.
* `event-additional-fields.php` : template used to the list of additional fields on single event views.
* `preview-loop.php` : main wrapper for the preview widget and shortcode.
* `preview-event.php` : template used to display events in the preview widget.

The plugin provide convenient template tags for you to display event data in the `inc/template-tags.php` file. Feel free to define your own in your theme.

The plugin also provides many hooks to allow you to customize the html output or other various data.

## Usage of third party services and copyright information

This plugin displays data hosted and provided by [https://openagenda.com](https://openagenda.com). By using this plugin, you accept and agree with OpenAgenda's [terms and conditions](https://openagenda.zendesk.com/hc/fr/articles/201753991) and [privacy policy](https://openagenda.zendesk.com/hc/fr/articles/360003182014). Please make sure to read them before using this plugin. Also, using this plugin DOES require an account at [https://openagenda.com](https://openagenda.com), and an API key.

By default, maps displayed by this plugin use data from [https://openstreetmap.org/](https://openstreetmap.org/) and uses the [leaflet JS library](https://leafletjs.com/). By using this plugin, you accept and agree with OpenStreetMap's [terms of use](https://wiki.osmfoundation.org/wiki/Terms_of_Use), [acceptable use policy](https://wiki.openstreetmap.org/wiki/Acceptable_Use_Policy) and [privacy policy](https://wiki.osmfoundation.org/wiki/Privacy_Policy) 

The plugin provides optional integration with CloudImage. The integration requires to create an account at [https://cloudimage.io](https://cloudimage.io) and accept and agree their [terms of use](https://assets.scaleflex.com/Sales/Legal/Scaleflex+Services+Terms+and+Conditions+%5BFR%5D.pdf).

Icons used in the UI are [Genericons](https://genericons.com/), licenced under the GPL 2.0.

== Frequently Asked Questions ==

= Where is the settings page ? =

The settings page is located under the *Calendar* main menu entry, just alongside your content. It is not polluting the main *Settings* menu entry, or adding any top-level entry. 

= Where can I find API key and calendar UIDs ? =

All data related to your personal account and API keys can be found on your profile page at [https://openagenda.com/settings](https://openagenda.com/settings).

All data related to calendars can be found on the calendar itself on [https://openagenda.com](https://openagenda.com). Just look for the calendar you wish to display, and find the UID in the sidebar, under the filter widgets.

= Can I display any calendar ? Even if it's not mine ? =

Yes ! No problem ! Just create a new Calendar post, provide its UID and it will work.

= Where can I find developer documentation ? =

You can find more thorough documentation on [https://developers.openagenda.com/extension-wordpress/](https://developers.openagenda.com/extension-wordpress/) (in French) or on the Github repository at [https://github.com/OpenAgenda/wordpress](https://github.com/OpenAgenda/wordpress)

== Screenshots ==

1. A new *Calendars* menu entry is created, allowing you to manage your calendars and settings.
2. The simple settings page allow you to enter in your API key and tweak various settings.
3. Just create a new calendar post, and provide the OpenAgenda calendar UID in the *Calendar settings* metabox.
4. Find your Calendar UID on the openagenda.com site, just under the sidebar.
5. You can use convenient filter widgets to add filtering functionnality to your calendars.
6. In the *Customizer*, a new panel is available to house various display settings.
7. Enjoy !

== Changelog ==

= 2.14.1 =
* Fix : Fixed initial map zoom
* Improvement : Updated React Filters JS

= 2.14.0 =
* Feature : Added sort parameter to calendars
* Fix     : Minor code corrections to prevent PHP warnings
* Improvement : Updated React Filters JS

= 2.13.1 =
* Fixed   : Fixed external links not working on previews

= 2.13.0 =
* Fixed   : Moved translations loading to init.
* Fixed   : Updated checkboxes styles on calendar edit page.
* Feature : Added support for grid or list view for Preview widget.
* Feature : Added template for displaying all additional fields on single event views.
* Improvement : Streamlined default list view template. Minor css fixes.

= 2.12.0 =
* Feature : Added infinite scroll functionnality for agendas

= 2.11.0 =
* Fixed   : Calendar filter now uses the site's date format setting
* Fixed   : Added a few guard clauses to prevent unexpected fatal errors
* Fixed   : Added tel prefix to contact links
* Fixed   : Added ii value for accessibility field
* Feature : Added default event image setting 

= 2.10.0 =
* Feature : Added defined range filter

= 2.9.0 =
* Feature : Move API key to request headers
* Feature : Added `links` parameter to allow for external linking in preview.

= 2.8.0 =
* Feature : Added sort parameter to choice filter

= 2.7.0 =
* Fixed   : Basic post URL front no longer used
* Feature : Added Rich snippets to event list view.

= 2.6.1 =
* Fixed   : Rich snippets triggering erros on some events.
* Feature : Added optional CMS and site url tracking option.

= 2.6.0 =
* Feature : Added a event rich snippets in head tag

= 2.5.0 =
* Feature : Added a basic language switcher

= 2.4.2 =
* Fixed : Next timings calculation

= 2.4.1 =
* Fixed : Removed date offset when filtering timings.

= 2.4.0 =
* Feature : Added setting to exclude past events.
* Feature : Added pre-filters setting to Preview widget

= 2.3.0 =
* Feature : Added support for default filters.

= 2.2.1 =
* Fixed : Wrong current month displayed in timings.

= 2.2.0 =
* Feature : Added support for Districts in filters.

= 2.1.5 =
* Fixed : Fixed <title> tag on single event when using WordPress SEO.
* Fixed : Fixed image <meta> properties.

= 2.1.4 =
* Fixed : Bug with ajax requests when size argument is 0.

= 2.1.3 =
* Feature : Added support for multilingual additional fields

= 2.1.2 =
* Fixed : Minor bug fix

= 2.1.1 =
* Fixed : slug sanitization

= 2.1.0 =
* Feature : Added Favorite feature.
* Fixed : Fixed various handlers for changed reponse keys.
* Fixed : Modified [openagenda_filter_tags] shortcode to use [openagenda_filter_choice] instead

= 2.0.0 =
* Feature : Major API calls refactor: fetches events using API calls instead of JSON export
* Feature : Major filter widget refactor: uses new React filters 

= 1.1.1 =
* Fixed : canonical url in <meta> tag
* Feature : Added compatibility with Yoast SEO meta tags

= 1.1.0 =
* Feature : Added "Integrations" settings tab
* Feature : Added integration with CloudImage
* Feature : Preview widget templates are overridable in the child theme.
* Fixed : Passed events can be displayed on single event view.

= 1.0.1 =
* Fixed : Bug fix on `openagenda_get_field()` function, when called with 'image' and 'thumbnail' parameter.

= 1.0.0 =
* Fixed : location template.
* Feature : Added event count and active filters on top of the list view.
* Feature : Added online access link display for online events.
* Fixed : Fix for viewing single passed event.

= 0.2 =
* Feature : Added icons.
* Fixed : Minor CSS fixes

= 0.1 =
* Initial release