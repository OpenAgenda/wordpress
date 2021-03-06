# Openagenda WordPress Plugin

This WordPress plugin allows you to embed any calendar hosted on [https://openagenda.com](https://openagenda.com) on your WordPress site.

## Installation

This plugin is hosted on the official WordPress repository at the following URL : 

[https://wordpress.org/plugins/openagenda/](https://wordpress.org/plugins/openagenda/)

If you install this plugin from the official WordPress repository, the name of the folder in your `wp-content/plugins/` directory will be `openagenda/`.

If you wish to install this plugin on your local machine from this GitHub repository for development purposes, **please make sure its folder name IS NOT `openagenda/` as any update published on the official WordPress repository will overwrite your work.**

## Basic usage

Upon activation, the plugin creates a new post type named *Calendars*. Just create a new calendar, provide the UID of the calendar you wish to display in the  settings box, and that's it !

![A new *Calendars* menu entry is created, allowing you to manage your calendars and settings](assets/screenshots/screenshot-1.png)

You can leave the content area for this calendar empty, as it will be populated automatically with your events.

![Just create a new calendar post, and provide the Open Agenda calendar UID in the *Calendar settings* metabox.](assets/screenshots/screenshot-3.png)

Your events are automatically inserted after your content. If you wish to control where your events will be listed, just use the shortcode `[openagenda]` in your content.

## Settings

General settings can be found under the *Calendar > Settings* entry in the admin menu.

All data related to your API key or calendars can be found on [https://openagenda.com](https://openagenda.com).

![The simple settings page allow you to enter in your API key and tweak various settings.](assets/screenshots/screenshot-2.png)

The main settings page provides the following settings : 

 * *Open Agenda API key* : Your user API key. **Providing your account API key is required for the plugin to work properly.** It can be found in your account on [https://openagenda.com](https://openagenda.com)
 * *Allow for embedded content* : If your events contain embedded content, tick this box to allow the corresponding HTML tags.
 * *Load default stylesheets* : The plugin provides very basic styling and depends heavily on your theme's styles. Disable this to rely 100% on your theme styles.
 * *Cache duration* : For performance reasons, basic requests to Openagenda are temporarily kept in cache. This settings controls the time to keep them cached, in seconds.
 * *Default map tiles link* : This is the map tile used for the various maps displayed by the plugin.
 * *Default map tiles attribution link* : this is the default attribution link placed on OpenStreetMaps.
 * *Delete all calendar content on uninstall ?* : controls whether you want to delete all your content on uninstall.
 * *Delete all options on uninstall ?* : controls whether you want to delete all your calendar settings on uninstall.

In the *Permalinks* settings, you can change the prefix for your calendar pages. You cannot leave this blank as your URLs will conflict with WordPress' default pages and posts.

In the *Customizer*, a new panel is available to house various display settings. For now only a main color setting is available.

![A single section in the customizer houses your display settings.](assets/screenshots/screenshot-6.png)

## How to get my calendar UID ?

The UID of the calendar you wish to display can be found directly on your calendar page on [Openagenda](https://openagenda.com). Go to the site, and click *Look for an agenda*. Then use search box to find your calendar.

![Your UID is just under the widgets in the sidebar](assets/screenshots/screenshot-4.png)

Once you have it displayed, scroll down a little, and you will find your UID just under the last widget, in the sidebar on the right.

## Filter widget and shortcodes

To allow users to easily find relevant events, the plugin also provides a convenient filter widget. Place the widget in your sidebar or other widgetized area, pick a filter and tweak any additionnal settings in the widgets admin.

![You can use convenient filter widgets to add filtering functionnality to your calendars.](assets/screenshots/screenshot-5.png)

To integrate filters directly in your content instead of widget areas, the plugin also provide shortcodes.

Every shortcode listed here (except for `[openagenda]`) corresponds to a filter option in the widget.

Additionaly, shortcodes and widget filters have the same parameters, and every shortcode attribute corresponds to a widget filter setting.

**`[openagenda]`**

Displays the calendar. You do not need to use this shortcode explicitely, as it is automatically injected in the content of your "calendars" posts.

However, if you need to insert static content after your list of events, you can do so by inserting this shortcode, then your static content afterwards.

**`[openagenda_filter_active]`**

Displays the active filters. It takes no parameters.

**`[openagenda_filter_tags]`**

Displays a list of tags. It takes the following parameters : 

 * `tag_group`: the slug of a tag group you want to display.
 * `tags`: A comma-seperated list of tags you want to display.

**`[openagenda_filter_calendar]`**

Displays a calendar. It takes no parameters.

**`[openagenda_filter_map]`**

Displays an interactive map to locate and search events. It takes the following parameters :

 * `map_tiles_link` : Lien tiles link to use. Defaults to `https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png`
 * `map_auto` : Whether to automatically update map on scroll. 
 * `map_longitude` : Default longitude
 * `map_latitude` : Default latitude
 * `map_zoom` : Default zoom level. Defaults to 12. Used in conjunction with `map_latitude` and `map_longitude`.

**`[openagenda_filter_relative]`**

Filters events in the near future. It takes no parameters.

**`[openagenda_filter_search]`**

Displays a search field. It takes the following parameters :

 * `placeholder` : text field placeholder.

**`[openagenda_filter_preview]`**

Displays next events. It takes the following parameters : 

 * `preview_label` : Label while loading the items.
 * `uid` : UID of the calendar you wish to preview.
 
## Customization

Templates for the list of events and individual events can be customized in your theme.

Just create a folder named `openagenda/` in your theme, then copy and paste the template you wish to override located in the plugin's `templates/` folder.

The plugin provide convenient template tags for you to display event data in the `inc/template-tags.php` file. Feel free to define your own in your theme.

The plugin also provides many hooks to allow you to customize the html output or other various data. The hooks documentation is in writing for now !

## Usage of third party services and copyright information

This plugin displays data hosted and provided by [https://openagenda.com](https://openagenda.com). By using this plugin, you accept and agree with OpenAgenda's [terms and conditions](https://openagenda.zendesk.com/hc/fr/articles/201753991) and [privacy policy](https://openagenda.zendesk.com/hc/fr/articles/360003182014). Please make sure to read them before using this plugin. Also, using this plugin does NOT require an account at [https://openagenda.com](https://openagenda.com), though it is recommended to have one.

Maps displayed by this plugin use data from [https://openstreetmap.org/](https://openstreetmap.org/) and uses the [leaflet JS library](https://leafletjs.com/). By using this plugin, you accept and agree with OpenStreeMap's [terms of use](https://wiki.osmfoundation.org/wiki/Terms_of_Use), [acceptable use policy](https://wiki.openstreetmap.org/wiki/Acceptable_Use_Policy) and [privacy policy](https://wiki.osmfoundation.org/wiki/Privacy_Policy)

Icons used in the UI are [Genericons](https://genericons.com/), licenced under the GPL 2.0.

## Developer documentation

### Template overrides

You can build customized templates for the event list view or single event view. Default templates are located in the `templates/` folder. You can copy and paste the file you want to override in a folder called `openagenda/` in your theme or child theme directory, and customize its content.

The plugin will look for templates first in the `openagenda/` folder of your child theme, then in the `openagenda/` folder of your parent theme, and finally in the plugins `templates/` folder.

### Function reference

The file `inc/template-tags.php` contains functions used in templates to display various event data. The file `inc/helper-functions.php` contains functions used elsewhere throughout the plugin to help with various tasks or data formatting. 

Here is a quick rundown of the main functions you will need when customizing the templates.

#### `openagenda_get_event( $uid = false )`

Returns the event corresponding to the passed in UID or the current event in the event loop if not provided. Note that the function doesn't query the main [openagenda.com](https://openagenda.com) site, but looks in the events already queried on page load. So it will return `false` if no events can be found with the provided UID within the page's events.

#### `openagenda_get_field( $field, $uid = false )`

This functions returns the value corresponding to the field passed in for the event corresponding to the given UID, or for the current event in the event loop if no UID was provided.

Basically the functions reads the raw JSON event, except for `permalink` and `timings` fields, for which a custom treatment is needed.

For multilingual fields, the value corresponding to the current locale is returned.

**If you need the raw value from the JSON event, this function is the one to use.**

Returned value are passed through the following filter : `apply_filters( 'openagenda_field', $value, $field, $uid );`

#### `openagenda_field( $field, $uid = false )`

Like `openagenda_get_field( $field, $uid = false )`, but escapes and echoes the field value.

#### `openagenda_esc_field( $value, $field )`

This function is used internally by `openagenda_field()` to escape the field value properly, depending on the field type.

#### `openagenda_event_permalink( $uid = false, $echo = true, $use_context = false )`

Returns or echoes an event permalink, corresponding to the UID passed in or the current event in the event loop. The `use_context` param is used on event list views to append a string representing the page and current list filters.

The returned value is passed through the following filter : `apply_filters( 'openagenda_event_permalink', $permalink, $uid, $use_context )`.

#### `openagenda_get_event_image( $size = 'thumbnail', $uid = '' )`

Returns the HTML used to display an event image. You get the same result with `openagenda_get_field()`, passing in `thumbnail` or `image` as first parameter. `thumbnail` size is 200px by 200px by default. `image` size is 600px wide by default.

The returned HTML is passed through the following filter : `apply_filters( 'openagenda_event_image', $html, $uid, $size )`.

#### `openagenda_event_image( $size = 'thumbnail', $uid = '' )`

Echoes an event image. Same as `openagenda_field()` with `thumbnail` or `image` as a parameter.

#### `openagenda_event_timing( $display = 'date', $uid = false, $echo = true )`

Displays the next or last timing for a given event, in the format corresponding to the `$display` parameter. If no `$uid` is provided, it defaults to the current event.

`$display` accepts `date` (default), or `relative`. If `relative` the next or last event timing is displayed in a human readable time difference from now (e.g. 'In two weeks', '2 hours ago'). Else, its date is displayed.

The HTML returned is passed through the following filter : `apply_filters( 'openagenda_event_timing', $html, $uid, $display )`.

#### `openagenda_event_timings( $uid = false, $echo = true )`

Displays a formatted list of all timings for an event.

The HTML returned is passed through the following filter : `apply_filters( 'openagenda_event_timings', $html, $uid, $months )`.

#### `openagenda_event_map( $uid = false, $echo = true )`

Displays or returns the HTML for the map corresponding to the location of the given event.

The HTML returned is passed through the following filter : `apply_filters( 'openagenda_event_map_html', $html, $uid )`.

#### `openagenda_event_share_buttons( $uid = false, $echo = true )`

Displays or returns the HTML for the event share buttons. By default, Twitter, Facebook and Linkedin share links are provided. To add your own, use the following filter : `apply_filters( 'openagenda_sharers', $sharers, $uid, $event )`.

The HTML returned is passed through the following filter : `apply_filters( 'openagenda_sharers_html', $html, $uid, $event )`.

#### `openagenda_pagination( $args = array() )`

Displays pagination on list view. Works basically like WordPress' `paginate_links()` function. Here are the defaults arguments :

```php
$args = array(
    'end_size'     => 2,    // Number of items to display after the first page or before the last page
    'mid_size'     => 2,    // Number of page to display around the current page
    'label_format' => '%s', // format used in sprintf() function to display labels. Can be used to wrap labels in additional HTML.
    'prev_label'   => __( 'Previous page', 'openagenda' ),   // Previous page label
    'next_label'   => __( 'Next page', 'openagenda' ),       // Next page label
);
```

The arguments can be filtered using the following filter : `apply_filters( 'openagenda_page_links_args', $args, $uid )`. 

The final HTML can be filtered using the following filter : `apply_filters( 'openagenda_page_links', $links, $uid )`.

#### `openagenda_get_permalink( $uid = false )`

Returns the permalink to the calendar corresponding to the UID given. Defaults to the current calendar on calendar pages.

The permalink can be filtrered using the following filter : `apply_filters( 'openagenda_permalink', $permalink, $uid )`.

#### `openagenda_exports( $uid = false, $echo = true )`

Displays exports links for the calendar corresponding to the given UID. Defaults to current calendar. 

The returned HTML passes throught the following filter : `apply_filters( 'openagenda_exports_html', $html, $uid )`.

#### `openagenda_filter( $filter, $args = array() )`

Displays a filter widget. Values for the `$filter` parameter include `active`, `tags`, `calendar`, `map`, `preview`, `relative`, `search`. The `$args` array contains shortcode settings. See [Filter widget and shortcodes](#filter-widget-and-shortcodes) for details.

Avoid using inside the main template on list views. As the list of events may be refreshed with Ajax, the script handling the filter may loose connection to it as the DOM element will be removed and refreshed.

#### `openagenda_navigation( $echo = true )`

Displays or returns HTML corresponding to the event navigation on single event pages.

The HTML returned goes through the following filter : `apply_filters( 'openagenda_event_navigation', $html, $previous_link, $next_link )`.

#### `openagenda_get_adjacent_event_link( $direction = 'next', $uid = false )`

Used by `openagenda_navigation()`.

Returns link **used to fetch** the adjacent event link. Since content is fetched from a JSON export of the agenda, on single event pages, only one event is fetched. Since events are not stored in the database, a direct reference to the adjacent event is not available.

A little processing is necessary under the hood to get the actual link to the next or previous event, so this function returns the link to an admin-post action instead, where the magic happens.

The returned HTML is passed through the following filter : `apply_filters( 'openagenda_adjacent_event_link', $html, $uid, $direction )`.

#### `openagenda_get_back_link()`

Returns the link to the list page on event pages.

The returned HTML is passed through the following filter : `apply_filters( 'openagenda_back_link', $html, $page_link, $page, $context )`.

#### `openagenda_get_template( $slug )`

Returns the path to a template. Looks for the template first in the `openagenda/` folder of the child theme, then in the `openagenda/` folder in the parent theme, then in the plugin's `templates/` folder.

#### `openagenda_get_locale()`

Returns the current openagenda locale code, if supported. Else defaults to 'en'.

Supported locales can be added using this filter : `apply_filters( 'openagenda_supported_locales', $locales )`.

#### `openagenda_get_image_dimensions( $size = 'thumbnail' )`

Returns an array of dimensions for images of a given size.

You can register additional sizes using the following filter : `apply_filters( 'openagenda_image_sizes', $sizes )`.

You can customize the returned dimensions using the following filter : `apply_filters( 'openagenda_image_dimensions', $dimensions, $size )`.

#### `openagenda_is_i18n_field( $field )`

Returns whether an event field is a multilingual field. You can register additional multilingual fields using the following filter : `apply_filters( 'openagenda_i18n_fields', $i18n )`.

#### `openagenda_icon( $slug, $echo = true )`

Displays or returns an SVG icon. You can register new icons using the following filter : `apply_filters( 'openagenda_icons', $icons )`;

#### `openagenda_is_single()`

Returns `true` on a single event page.

#### `openagenda_is_archive()`

Returns `true` on a event list page.

#### `openagenda_format_timing( $timing, $datetimezone = null )`

Given an entry on the event `timings` field in the JSON data, this function wil return an array with formatted dates and times, based on a passed in PHP DateTimezone, or the site's timezone.
