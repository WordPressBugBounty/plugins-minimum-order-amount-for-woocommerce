<?php
/**
 * The plugin bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/dcurasi
 * @since             1.5.0
 * @package           Dc_Moafw
 *
 * @wordpress-plugin
 * Plugin Name:       Minimum Order Amount for WooCommerce
 * Plugin URI:        https://github.com/dcurasi/dc-moafw
 * Description:       Minimum Order Amount for WooCommerce allows you to set easily and fast a minimum amount for the WooCommerce orders.
 * Version:           1.6.0
 * Requires at least: 5.6
 * Tested up to: 	  7.1
 * Requires PHP:      7.2
 * Author:            Dario Curasì
 * Author URI:        https://github.com/dcurasi
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dc-moafw
 * Domain Path:       /languages
 * Requires Plugins:  woocommerce
 * WC requires at least: 4.0
 * WC tested up to:   9.4
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Currently plugin version.
 */
define( 'DC_MOAFW_VERSION', '1.6.0' );

/**
 * Absolute path to the plugin directory, with trailing slash.
 */
define( 'DC_MOAFW_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Plugin basename (e.g. dc-moafw/dc-moafw.php).
 */
define( 'DC_MOAFW_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dc-moafw-activator.php
 *
 * @return void
 */
function activate_dc_moafw() {
	require_once DC_MOAFW_PATH . 'includes/class-dc-moafw-activator.php';
	Dc_Moafw_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dc-moafw-deactivator.php
 *
 * @return void
 */
function deactivate_dc_moafw() {
	require_once DC_MOAFW_PATH . 'includes/class-dc-moafw-deactivator.php';
	Dc_Moafw_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dc_moafw' );
register_deactivation_hook( __FILE__, 'deactivate_dc_moafw' );

/**
 * Declare compatibility with the WooCommerce features that require an explicit opt-in.
 *
 * - custom_order_tables: High-Performance Order Storage (HPOS).
 * - cart_checkout_blocks: the block based Cart and Checkout pages.
 *
 * @since 1.6.0
 * @return void
 */
function dc_moafw_declare_woocommerce_compatibility() {
	if ( ! class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		return;
	}

	\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', __FILE__, true );
}
add_action( 'before_woocommerce_init', 'dc_moafw_declare_woocommerce_compatibility' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require DC_MOAFW_PATH . 'includes/class-dc-moafw.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 * @return void
 */
function run_dc_moafw() {
	$plugin = new Dc_Moafw();
	$plugin->run();
}
run_dc_moafw();
