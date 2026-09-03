<?php
/**
 * Fired during plugin activation
 *
 * @link       https://github.com/dcurasi
 * @since      1.0.0
 *
 * @package    Dc_Moafw
 * @subpackage Dc_Moafw/includes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Dc_Moafw
 * @subpackage Dc_Moafw/includes
 * @author     Dario Curasì <curasi.d87@gmail.com>
 */
class Dc_Moafw_Activator {

	/**
	 * Create the default options.
	 *
	 * Existing options are left untouched, so that the settings survive a
	 * deactivate/activate cycle.
	 *
	 * @since    1.3.0
	 * @return   void
	 */
	public static function activate() {

		add_option( 'dc_moafw_activate', 1 );
		add_option( 'dc_moafw_minimum', 50 );
		/* translators: [minimum] is a placeholder replaced by the minimum order amount. */
		add_option( 'dc_moafw_message', __( 'A Minimum of [minimum] is required before checking out.', 'dc-moafw' ) );
		/* translators: [current] is a placeholder replaced by the current cart total. */
		add_option( 'dc_moafw_current_total_text', __( "Current cart's total: [current]", 'dc-moafw' ) );
		add_option( 'dc_moafw_currency_display_type', 'text' );
		add_option( 'dc_moafw_message_shop', 0 );

	}

}
