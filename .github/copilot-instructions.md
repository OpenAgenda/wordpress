# Instructions for Openagenda for WordPress

## Description

Openagenda for WordPress is a WordPress plugin allowing users to display events hosted on https://openagenda.com.

It provides customizable templates, and filters users can add to their agenda pages, to filter the list of event displayed. It requires an Openagenda API key.

## Organisation

The plugin has only a handful of important files : 

 - `openagenda.php` : plugin root file. Loads text domain, and boots plugin. 
 - `inc/class-main.php` : load dependencies and initializes the current agenda.
 - `inc/functions/template-tags.php`: functions used in templates to display event data.
 - `inc/functions/helper-functions.php`: functions used by template tags to format fields, or other helper functions.
 - `inc/frontend/class-shortcodes.php`: contains all shortcodes definition. All filters are shortcodes.
 - `inc/frontend/class-openagenda.php`: main Openagenda client. Fetches events and handles context, event loop and pagination.

The rest of the files are used to declare global plugin settings, agenda metaboxes fields, and admin pages. Widgets are also declared, and the function as wrappers for shortcodes.

Note about filters : The filter shortcodes defined in `inc/class-shortcodes` only print empty `<div>` tags with custom parameters. Filters are handled by the `assets/js/filter.js` file. This file is provided by the Openagenda company. DO NOT MODIFY THIS FILE. 

As a general rule, all assets files registered with a fixed arbitrary version number instead of the OPENAGENDA_VERSION constant in the `inc/class-main.php` file are external libraries. DO NOT MODIFY THE SOURCE FILES FOR THESE SCRIPTS.

## PHP standard

- Use WordPress coding standards.
- Avoid string concatenation with `.`. Use `sprintf()` or similar functions instead.
- Run `composer run phpcbf` to format files.
- Run `composer run phpstan` to check for PHP errors.
- Run `composer run phpcs` to check for formatting errors.
- When checking code, use build scripts from the `composer.json` file instead of direct calls to binaries in vendor/ folder.

## JavaScript Standard

- Use semi-colon to end statements.
- Use arrow functions and `const` variable declaration.
- When checking builds, use build scripts from the `package.json` file instead of direct calls to node_modules

## Build processes