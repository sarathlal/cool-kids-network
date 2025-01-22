=== Cool Kids Network ===
Contributors: sarathlal
Donate link: https://sarathlal.com/
Tags: users, roles, custom, network
Requires at least: 6.0
Tested up to: 6.7
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin that adds custom roles and functionalities to manage user capabilities and provides a dynamic shortcode for displaying user-specific data.

== Description ==

Cool Kids Network is a WordPress plugin that introduces three custom roles:
- **Cool Kid**: View only their own data.
- **Cooler Kid**: View their data and limited information about others.
- **Coolest Kid**: View all details of other users.

The plugin also provides a shortcode `[cool_kids_network]` to dynamically display user details or a login/registration form for guests.

---

=== Features ===

- Adds custom roles: `Cool Kid`, `Cooler Kid`, `Coolest Kid`.
- Shortcode `[cool_kids_network]`:
  - Displays user-specific data.
  - Shows a login form for guests.
  - Includes registration functionality.
- Allows role-based data restrictions.
- Pagination support for user lists.

=== Usage ===

==== Shortcode ====

Add `[cool_kids_network]` to any page or widget to display:
- User details for logged-in users.
- Login form for guests with a link to the registration form.

==== REST API ====

The plugin provides a custom REST API endpoint to update user roles dynamically:
- **Endpoint:** `/wp-json/cool-kids-network/v1/role`
- **Method:** `PUT` or `PATCH`


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/` directory or install it via the WordPress Plugin Repository.
2. Activate the plugin through the 'Plugins' menu in WordPress.


== Changelog ==

= 1.0 =
* Initial release.
