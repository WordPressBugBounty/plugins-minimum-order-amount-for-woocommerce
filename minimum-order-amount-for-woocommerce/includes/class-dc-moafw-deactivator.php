<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/dcurasi
 * @since      1.0.0
 *
 * @package    Dc_Moafw
 * @subpackage Dc_Moafw/includes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Fired during plugin deactivation.
 *
 * The settings are intentionally preserved on deactivation; they are removed
 * on uninstall only (see uninstall.php).
 *
 * @since      1.0.0
 * @package    Dc_Moafw
 * @subpackage Dc_Moafw/includes
 * @author     Dario Curasì <curasi.d87@gmail.com>
 */
class Dc_Moafw_Deactivator {

	/**
	 * Nothing to clean up on deactivation.
	 *
	 * @since    1.3.0
	 * @return   void
	 */
	public static function deactivate() {}

}
