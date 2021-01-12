=== Openagenda ===
Contributors: vincentdubroeucq
Tags: open agenda, agenda, calendar, event, events
Requires at least: 4.7
Tested up to: 5.6
Stable tag: 0.1
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display any calendars from openagenda.com on your site.

== Description ==

## Basic usage

This WordPress plugin allows you to embed any calendar hosted on [https://openagenda.com](https://openagenda.com) on your WordPress site.

Upon activation, the plugin create a new post type named *Calendars*. Just create a new calendar, provide the UID of the calendar you wish to display in the calendar settings box, and that's it !

You can leave the content area for this calendar empty, as it will be populated automatically with your events !

## Settings

General settings can be found under the *Calendar* entry in the admin menu.

All data related to your API key or calendars can be found on https://openagenda.com.

The main settings page provides the following settings : 

 * *Open Agenda API key* : Your user API key. It is highly recommended you provide your account API key for performance reasons. It can be found in your account on [https://openagenda.com](https://openagenda.com)
 * *Allow for embedded content* : If your events contain embedded content, tick this box to allow the corresponding HTML tags.
 * *Load default stylesheets* : The plugin provides very basic styling and depends heavily on your theme's styles. Disable this to rely 100% on your theme styles.
 * *Cache duration* : For performance reasons, basic requests to Openagenda are temporarily kept in cache. This settings controls the time to keep them cached, in seconds.
 * *Default map tiles link* : This is the map tile used for the various maps displayed by the plugin.
 * *Default map tiles attribution link* : this is the default attribution link placed on OpenStreetMaps.


## Filter widget and shortcodes

To allow users to easily find relevant events, the plugin also provides a convenient filter widget. Place the widget in your sidebar or other widgetized area, pick a filter and tweak any additionnal settings in the widgets admin.

To integrate filters directly in your content instead of widget areas, the plugin also provide shortcodes.

Every shortcode listed here (except for `[openagenda]`) corresponds to a filter option in the widget.

Additionaly, shortcodes and widget filters have the same parameters, and every shortcode attribute corresponds to a filter setting.

### `[openagenda]`

Displays the calendar. You do not need to use this shortcode explicitely, as it is automatically injected in the content of your "calendars" posts.

However, if you need to insert static content after your list of events, you can do so by inserting this shortcode, then your static content after.

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


















== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is stored in the /assets directory.
2. This is the second screen shot

== Changelog ==

= 0.1 =
* Initial release

== Upgrade Notice ==

= 0.1 =
* Initial release