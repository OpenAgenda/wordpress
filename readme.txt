=== Openagenda ===
Contributors: openagenda, vincentdubroeucq
Tags: openagenda, open agenda, agenda, calendar, event, events
Requires at least: 4.9
Tested up to: 5.6
Stable tag: 0.1
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display calendars from openagenda.com on your site.

== Description ==

## Basic usage

This WordPress plugin allows you to embed any calendar hosted on [https://openagenda.com](https://openagenda.com) on your WordPress site.

Upon activation, the plugin creates a new post type named *Calendars*. Just create a new calendar, provide the UID of the calendar you wish to display in the calendar settings box, and that's it !

You can leave the content area for this calendar empty, as it will be populated automatically with your events !

Your events are automatically inserted after your content. If you wish to control where your events will be listed, just use the shortcode `[openagenda]` in your content.

## Settings

General settings can be found under the *Calendar > Settings* entry in the admin menu.

All data related to your API key or calendars can be found on https://openagenda.com.

The main settings page provides the following settings : 

 * *Open Agenda API key* : Your user API key. It is highly recommended you provide your account API key for performance reasons. It can be found in your account on [https://openagenda.com](https://openagenda.com)
 * *Allow for embedded content* : If your events contain embedded content, tick this box to allow the corresponding HTML tags.
 * *Load default stylesheets* : The plugin provides very basic styling and depends heavily on your theme's styles. Disable this to rely 100% on your theme styles.
 * *Cache duration* : For performance reasons, basic requests to Openagenda are temporarily kept in cache. This settings controls the time to keep them cached, in seconds.
 * *Default map tiles link* : This is the map tile used for the various maps displayed by the plugin.
 * *Default map tiles attribution link* : this is the default attribution link placed on OpenStreetMaps.
 * *Delete all calendar content on uninstall ?* : controls whether you want to delete all your content on uninstall.
 * *Delete all options on uninstall ?* : controls whether you want to delete all your calendar settings on uninstall.

In the *Permalinks* settings, you can change the prefix for your calendar pages. You cannot leave this blank as your URLs will conflict with WordPress' default pages and posts.

In the *Customizer*, a new panel is available to house various display settings. For now only a main color setting is available.

## Filter widget and shortcodes

To allow users to easily find relevant events, the plugin also provides a convenient filter widget. Place the widget in your sidebar or other widgetized area, pick a filter and tweak any additionnal settings in the widgets admin.

To integrate filters directly in your content instead of widget areas, the plugin also provide shortcodes.

Every shortcode listed here (except for `[openagenda]`) corresponds to a filter option in the widget.

Additionaly, shortcodes and widget filters have the same parameters, and every shortcode attribute corresponds to a widget filter setting.

### `[openagenda]`

Displays the calendar. You do not need to use this shortcode explicitely, as it is automatically injected in the content of your "calendars" posts.

However, if you need to insert static content after your list of events, you can do so by inserting this shortcode, then your static content afterwards.

### `[openagenda_filter_active]`

Displays the active filters. It takes no parameters.

### `[openagenda_filter_tags]`

Displays a list of tags. It takes the following parameters : 

 * `tag_group`: the slug of a tag group you want to display.
 * `tags`: A comma-seperated list of tags you want to display.

### `[openagenda_filter_calendar]`

Displays a calendar. It takes no parameters.

### `[openagenda_filter_map]`

Displays an interactive map to locate and search events. It takes the following parameters :

 * `map_tiles_link` : Map tiles link to use. Defaults to `https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png`
 * `map_auto` : Whether to automatically update map on scroll. 
 * `map_longitude` : Default longitude
 * `map_latitude` : Default latitude
 * `map_zoom` : Default zoom level. Defaults to 12. Used in conjunction with `map_latitude` and `map_longitude`.

### `[openagenda_filter_preview]`

Displays next events. It takes the following parameters : 

 * `preview_label` : Label while loading the items.

### `[openagenda_filter_relative]`

Filters events in the near future. It takes no parameters.

### `[openagenda_filter_search]`

Displays a search field. It takes the following parameters :

 * `placeholder` : text field placeholder.

## Customization

Templates for the list of events and individual events can be customized in your theme.

Just create a folder named `openagenda/` in your theme, then copy and paste the template you wish to override located in the plugin's `templates/` folder.

The plugin provide convenient template tags for you to display event data in the `inc/template-tags.php` file. Feel free to define your own in your theme.

The plugin also provides many hooks to allow you to customize the html output or other various data. The hooks documentation is in writing for now !

## Usage of third party services and copyright information

This plugin displays data hosted and provided by [https://openagenda.com](https://openagenda.com). By using this plugin, you accept and agree with OpenAgenda's [terms and conditions](https://openagenda.zendesk.com/hc/fr/articles/201753991) and [privacy policy](https://openagenda.zendesk.com/hc/fr/articles/360003182014). Please make sure to read them before using this plugin. Also, using this plugin does NOT require an account at [https://openagenda.com](https://openagenda.com), though it is recommended to have one.

By default, maps displayed by this plugin use data from [https://openstreetmap.org/](https://openstreetmap.org/) and uses the [leaflet JS library](https://leafletjs.com/). By using this plugin, you accept and agree with OpenStreeMap's [terms of use](https://wiki.osmfoundation.org/wiki/Terms_of_Use), [acceptable use policy](https://wiki.openstreetmap.org/wiki/Acceptable_Use_Policy) and [privacy policy](https://wiki.osmfoundation.org/wiki/Privacy_Policy) 

Icons used in the UI are [Genericons](https://genericons.com/), licenced under the GPL 2.0.

== Frequently Asked Questions ==

= Where is the settings page ? =

The settings page is located under the *Calendar* main menu entry, just alongside your content. It is not polluting the main *Settings* menu entry, or adding any top-level entry. 

= Where can I find API key and calendar UIDs ? =

All data related to your personal account and API keys can be found on your profile page at [https://openagenda.com/settings](https://openagenda.com/settings).

All data related to calendars can be found on the calendar itself on [https://openagenda.com](https://openagenda.com). Just look for the calendar you wish to display, and find the UID in the sidebar, under the filter widgets.

= Can I display any calendar ? Even if it's not mine ? =

Yes ! No problem ! Just create a new Calendar post, provide its UID and it will work. 

== Screenshots ==

1. A new *Calendars* menu entry is created, allowing you to manage your calendars and settings.
2. The simple settings page allow you to enter in your API key and tweak various settings.
3. Just create a new calendar post, and provide the Open Agenda calendar UID in the *Calendar settings* metabox.
4. You can use convenient filter widgets to add filtering functionnality to your calendars.
5. Enjoy !
6. In the *Customizer*, a new panel is available to house various display settings.

== Changelog ==

= 0.1 =
* Initial release

== Upgrade Notice ==

= 0.1 =
* Initial release