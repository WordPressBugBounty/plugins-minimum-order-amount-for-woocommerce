<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/dcurasi
 * @since      1.0.0
 *
 * @package    Dc_Moafw
 * @subpackage Dc_Moafw/includes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Define the internationalization functionality.
 *
 * @since      1.0.0
 * @package    Dc_Moafw
 * @subpackage Dc_Moafw/includes
 * @author     Dario Curasì <curasi.d87@gmail.com>
 */
class Dc_Moafw_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * Runs on `init`, as required since WordPress 6.7.
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'dc-moafw',
			false,
			dirname( DC_MOAFW_BASENAME ) . '/languages/'
		);

	}

}
