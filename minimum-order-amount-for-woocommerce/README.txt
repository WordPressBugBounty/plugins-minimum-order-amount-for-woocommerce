=== Minimum Order Amount for WooCommerce ===

Contributors: dcurasi
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=KZRGHFSGGRXU6
Tags: woocommerce, minimum order, cart, checkout, order amount
Requires at least: 5.6
Tested up to: 7.1
Requires PHP: 7.2
Stable tag: 1.6.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.txt

Set a minimum order amount for WooCommerce, with a customizable notice shown in the cart, at the checkout and in the shop pages.


== Description ==

Minimum Order Amount for WooCommerce allows you to set easily and fast a minimum amount for the WooCommerce orders. Moreover, it is possible to set the notification message in the case in which the minimum amount is not reached.

The check runs on the cart and at the checkout, on both the classic shortcode pages and the new Cart and Checkout blocks, so customers cannot place an order below the amount you configured.

= Features =

* Minimum order amount enforced on the cart and at the checkout.
* Fully customizable notice message, with the `[minimum]` and `[current]` placeholders.
* Amounts formatted according to your WooCommerce currency, decimal, thousand separator and number of decimals settings.
* Optional notice on the shop pages.
* Currency shown as a symbol (€) or as a currency code (EUR).

= Compatibility =

* WooCommerce High-Performance Order Storage (HPOS).
* WooCommerce Cart and Checkout blocks.
* Polylang and Polylang Pro.
* WooCommerce Price Based on Country.

= Available Languages =

* English
* Italiano
* Polski
* Français

It is based on the [WordPress Plugin Boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate).

= If you like the plugin, please give it a rating. =
If you have a feature request, let me know, they're always welcome!


== Installation ==

1. Unzip the downloaded zip file.
2. Upload the `minimum-order-amount-for-woocommerce` folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Go to WooCommerce > Minimum Order to change the default options.


== Frequently Asked Questions ==

= Does it work with the Cart and Checkout blocks? =

Yes. Since version 1.6.0 the validation also runs through the WooCommerce Store API, so the notice is displayed by the block based Cart and Checkout too.

= Is the minimum amount checked before or after taxes and shipping? =

The cart subtotal is used, so before taxes and shipping charges.

= Can I change the minimum amount programmatically? =

Yes, use the `dc_moafw_minimum_order_amount` filter:

`add_filter( 'dc_moafw_minimum_order_amount', function ( $minimum ) {
    return 100;
} );`

= Can I contribute to the project? =

If you want to contribute to the project please contact me (curasi.d87@gmail.com).
This is the GitHub Repository [dc-moafw](https://github.com/dcurasi/dc-moafw).


== Screenshots ==

1. The admin panel


== Changelog ==

= 1.6.0 =
* New - Compatibility with the WooCommerce Cart and Checkout blocks (Store API).
* New - Declared compatibility with WooCommerce High-Performance Order Storage (HPOS).
* New - Added the `dc_moafw_minimum_order_amount` filter.
* New - Added a "Settings" link on the plugins list page.
* New - Support for the current WooCommerce Price Based on Country API.
* Fix - The options were not deleted on uninstall because of an inverted condition; they are now removed on single sites and across a multisite network.
* Fix - Settings are no longer lost when a message contains a percent sign.
* Fix - The "Current Total Text" can now be left empty.
* Dev - All settings are now registered with a sanitize callback, and every admin output is escaped.
* Dev - The admin stylesheet is only loaded on the plugin settings page.
* Dev - Translations are loaded on `init`, as required since WordPress 6.7.
* Dev - The settings page now requires the `manage_woocommerce` capability.
* Dev - Requires WordPress 5.6+, PHP 7.2+ and WooCommerce 4.0+.

= 1.5.0 - 02/11/18 =
* New - Added compatibility with Polylang Pro, thanks to King Lui
* New - Added French translation, thanks to Steven Ray
* Fix - Fixed Polish translation, thanks to Steven Ray

= 1.4.0 - 04/03/18 =
* Fix - Now if the cart is empty, the minimum order notification is not shown
* New - Now the decimal and thousands separators are displayed as woocommerce settings
* New - Now the number of decimals in the price is the same as the woocommerce settings
* New - Now the currency position in the price is set as in the woocommerce settings

= 1.3.1 - 03/01/18 =
* Fix - Fix the fatal error on the cart page (if WCPBC_Customer class does not exist)

= 1.3.0 - 02/01/18 =
* New - Added the ability to choose how to display the currency
* Fix - Now the options are deleted when the plugin is uninstalled and not when the plugin is deactivate
* Fix - The cart total and the minimum order were formatted with two decimal places
* Dev - The function for set the minimum order has been restructured
* Dev - Update translations

= 1.2.0 - 12/03/17 =
* New - Added compatibility with WooCommerce Price Based on Country
* New - Added option for display notice message in the shop pages
* Dev - Removed the inclusion of css and js files not needed
* Fix - Fix the name and the group of strings registered in Polylang
* Dev - Update translations

= 1.1.1 - 21/01/17 =
* New - Added Polish translation, thanks to Jerzy Afanasjew

= 1.1.0 - 07/01/17 =
* New - Added compatibility with Polylang
* New - Added Italian translation
* Dev - Edit submit button of the admin panel for translations
* Fix - Fix Current Total Text
* Dev - Added donation link

= 1.0 =
* Initial public version


== Upgrade Notice ==

= 1.6.0 =
Compatibility with the latest WordPress and WooCommerce (HPOS, Cart/Checkout blocks), security hardening and several bug fixes. Requires PHP 7.2+.
