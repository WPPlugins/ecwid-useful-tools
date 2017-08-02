=== Ecwid: Random Products ===
Contributors: Tony Sologubov
Tags: shopping cart, store, shop, ecwid, tools, random, products
Requires at least: 3.2 
Tested up to: 3.4.2
Stable tag: 0.7.6

This module allows to show random products from Ecwid store.

== Description ==

Ecwid: Random Products is plugin for Wordpress that allows to show random
products from Ecwid store. It allows to show products as widget or it can be
used as shortcode, so random products will be inserted into entry's body.

Ecwid: Random products must be used side by side with Ecwid Shopping cart
plugin (http://wordpress.org/extend/plugins/ecwid-shopping-cart/) and cannot
work without it. Also, Ecwid: Random products uses some settings of Ecwid 
Shopping cart plugin such as Ecwid store ID, so basically 
Ecwid: Random products extends the functionality of the core Ecwid Shopping
cart plugin.

== Installation ==

1. Log into your Wordpress back-end
2. Go to Plugins > Add New section
3. Search for "Ecwid random products" keywords
4. Install suggested module

== Configuration ==
After installation, Ecwid: Random Products is generally ready to work without
any configuration.

However, if you do not have paid Ecwid accout, you may experience problems
with currency display. In this case, you may want to define currency settings
manually. For that you should:

1. Go to the "Settings > Ecwid: Random Products" section in your Wordpress
back-end and tick on the "Enable usage of manually-defined currency settings"
checkbox.
2. After that define currency prefix or/and suffix.
3. Save changes.

For example, if you defined prefix as '&pound;' and suffix as '&euro;', your
prices will look like &pound;7.56&euro;

== Frequently Asked Questions ==

= Ecwid Random Products widget =

In order to use Ecwid Random Products widget, you need to:

1. Go to "Appearance > Widgets" area in your Wordpress.
2. Select Ecwid Random Products widget and drag it to desired Sidebar or
Area.
3. After your drop Ecwid Random Products widget you will be able to define
setting of the current widget.
3.1. "Title" field defines the title of widget.
3.2. "Number of random products to display" field defines how many products
will be displayed in this widget.
3.3. "Display product's title?" and "Display product's price?" defines whether
or not to display name and/or price of products near their thumbnails.
3.4. "Category ID to select products from" defines an ID of category from
which products will be displayed.

= Shortcode =

Shortcode in Wordpress is a sort of macros that allows to use different
features within the body of Wordpress entries such as Pages, Posts etc. There
is one shortcode in Ecwid Random Products plugin, which is
[ecwid_random_products]. There are following parameters that can define its
behaviour:

1. 'number' defines how many products will be displayed by shortcode. Example
of usage: [ecwid_random_products number="3"] Example will display 3 products.

2. 'show_title' defines whether to show title near product's thumbnail or not.
If ommited, the title will not be shown. Example of usage:
[ecwid_random_products number="5" show_title="true"]

3. 'show_price' defines whether to show price near each product's thumbnail or
now. If ommited, the price will not be shown. Very similar option as above.
Example of usage: [ecwid_random_products number="7" show_price="true"]

4. 'per_row' option defines how many products should be shown in a row option
is used. Example of usage:  [ecwid_random_products number="4" per_row="2"] 
This shortcode will display a table with products: two rows by two products. 
If you ommit this option, products will be shown in column, i.e. per_row will
be assumed as 1.

5. 'product_width' defines the width of area with one random product in pixels. Example:
[ecwid_random_products number="4" per_row="2" product_width="80"] Such
shortcode will output a table with products: two rows by two products. One
row's length will be 160px.

6. 'category' defines an ID of category from which products will be displayed.
If omitted, no restrictions are applied and products from the whole store are
displayed. Works for paid Ecwid accounts only.

== Changelog ==
= 0.7.6 =
- [!] Obsolete "In-Line SEO Catalog" option was removed.

= 0.7.5 =
- [!] Support of new Ecwid URLs is added.

= 0.7.4 =
- [!] Appearance bug related to `mfunc` tags has been fixed.

= 0.7.3 =
- [+] Now plugin works with cache plugins like WP Super Cache that supports
 `mfunc` tags. Make sure that the cache plugin supports 'late init' and
enable this option.
- [+] CSS classes for price and title spans were added back.
- [!] Fixed bug that WP went down if /cache folder could not be created.
- [!] Fixed bug that product links were incorrect sometimes.

= 0.7.2 =
- [!] Many bugs related to free Ecwid accounts were fixed.
- [!] However, pulling products from certain category works for paid Ecwid
  accounts only.
- [!] Widget name was changed. All widgets must be reconfigured after this
  update. Shortcodes will keep working.

= 0.7.1 =
- [!] Activation bug was hot-fixed.

= 0.7 =
- [+] Added cache.
- [+] Added possibility to show products from certain category only. Works
  only for paid Ecwid Accounts.

= 0.6 =
- [+] Huge refactoring was done.
- [+] Wordpress version requirement was changed. Now it requires at least 3.2.
  We did really need to switch to PHP 5.x.
- [!] Fixes to correlation between core plugin and Random Products were added.
- [!] Plugin now shows tips if Ecwid's page does not exist and it causes widget to
  fail.

= 0.5.1 = 
- [!] Widget's bug is hot-fixed.

= 0.5 =
- [+] Added deinstallation hook, so settings will be erased after
  uninstalling.
- [+] Added correlations between this plugin and Ecwid Shopping cart.
  http://wordpress.org/extend/plugins/ecwid-shopping-cart/ to settings page.
- [!] Bug that currency prefix could not be updated has been fixed.
- [!] Bugs regarding blank spaces in widget area are fixed.


= 0.4 =
- [+] Added possibility to display products in row using shortcode. Check
  features.txt file for instruction on how to do that.
- [!] Bug with incorrect price display has been fixed.
- [!] Bug with incorrect bradcrumbs has been fixed.

= 0.3 =
- [+] Settings page was added. Now it is possible to define currency settings
  there.
- [!] Module has been renamed from `Ecwid: useful tools` to `Ecwid: Random
  Products`.
- [!] Bug with Inline SEO Catalog has been fixed.
- [!] Small changes in widget settings.
- [!] Small refactoring of the whole module's code.

= 0.2 =
- [+] Now it is possible to show price and/or title for random products.
- [!] Some typos were fixed.
- [!] Problem with HTTPS was fixed.

= 0.1 =
- [+] Initial version.
