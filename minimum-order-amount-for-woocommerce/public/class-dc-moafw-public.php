<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/dcurasi
 * @since      1.0.0
 *
 * @package    Dc_Moafw
 * @subpackage Dc_Moafw/public
 */

defined( 'ABSPATH' ) || exit;

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Dc_Moafw
 * @subpackage Dc_Moafw/public
 * @author     Dario Curasì <curasi.d87@gmail.com>
 */
class Dc_Moafw_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name The name of the plugin.
	 * @param    string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Check whether WooCommerce is available.
	 *
	 * @since    1.6.0
	 * @return   bool
	 */
	public static function is_woocommerce_active() {
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Check whether the plugin features are enabled.
	 *
	 * @since    1.6.0
	 * @access   private
	 * @return   bool
	 */
	private function is_enabled() {
		return self::is_woocommerce_active() && (bool) get_option( 'dc_moafw_activate' );
	}

	/**
	 * Validate the cart against the configured minimum order amount.
	 *
	 * Hooked on `woocommerce_check_cart_items`, which is fired by the classic
	 * cart and checkout pages as well as by the Store API used by the Cart and
	 * Checkout blocks.
	 *
	 * @since    1.6.0
	 * @return   void
	 */
	public function check_minimum_order() {

		if ( ! $this->is_enabled() ) {
			return;
		}

		$total = $this->get_cart_subtotal();

		if ( null === $total || $total <= 0 ) {
			return;
		}

		$minimum = $this->get_minimum_order_amount();

		if ( $minimum <= 0 || $total >= $minimum ) {
			return;
		}

		$notice = '<strong>' . $this->get_message( $minimum ) . '</strong>';

		$current_total_text = $this->get_current_total_text( $total );

		if ( '' !== $current_total_text ) {
			$notice .= '<br />' . $current_total_text;
		}

		$this->add_notice( $notice );

	}

	/**
	 * Display the minimum order notice on the shop pages, when enabled.
	 *
	 * @since    1.6.0
	 * @return   void
	 */
	public function shop_minimum_order_notice() {

		if ( ! $this->is_enabled() || ! get_option( 'dc_moafw_message_shop' ) ) {
			return;
		}

		// The cart and the checkout are already handled by check_minimum_order().
		if ( is_cart() || is_checkout() ) {
			return;
		}

		$total = $this->get_cart_subtotal();

		if ( null === $total || $total <= 0 ) {
			return;
		}

		$minimum = $this->get_minimum_order_amount();

		if ( $minimum <= 0 || $total >= $minimum ) {
			return;
		}

		$this->add_notice( '<strong>' . $this->get_message( $minimum ) . '</strong>' );

	}

	/**
	 * Add an error notice, avoiding duplicates.
	 *
	 * @since    1.6.0
	 * @access   private
	 * @param    string $notice The notice HTML.
	 * @return   void
	 */
	private function add_notice( $notice ) {

		if ( ! function_exists( 'wc_add_notice' ) || ( function_exists( 'wc_has_notice' ) && wc_has_notice( $notice, 'error' ) ) ) {
			return;
		}

		wc_add_notice( $notice, 'error' );

	}

	/**
	 * Get the cart subtotal, before taxes and shipping.
	 *
	 * @since    1.6.0
	 * @access   private
	 * @return   float|null Null when the cart is not available.
	 */
	private function get_cart_subtotal() {

		if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
			return null;
		}

		return round( (float) WC()->cart->get_subtotal(), wc_get_price_decimals() );

	}

	/**
	 * Get the minimum order amount, converted to the active currency when
	 * WooCommerce Price Based on Country is in use.
	 *
	 * @since    1.6.0
	 * @access   private
	 * @return   float
	 */
	private function get_minimum_order_amount() {

		$minimum = (float) get_option( 'dc_moafw_minimum' );
		$zone    = $this->get_wcpbc_zone();

		if ( $zone ) {
			$minimum *= (float) $this->get_wcpbc_exchange_rate( $zone );
		}

		/**
		 * Filters the minimum order amount.
		 *
		 * @since 1.6.0
		 * @param float $minimum The minimum order amount, in the active currency.
		 */
		return (float) apply_filters( 'dc_moafw_minimum_order_amount', $minimum );

	}

	/**
	 * Get the active WooCommerce Price Based on Country zone, if any.
	 *
	 * Supports both the current API (wcpbc_the_zone) and the legacy
	 * WCPBC_Customer class.
	 *
	 * @since    1.6.0
	 * @access   private
	 * @return   object|false
	 */
	private function get_wcpbc_zone() {

		if ( function_exists( 'wcpbc_the_zone' ) ) {
			$zone = wcpbc_the_zone();

			return $zone ? $zone : false;
		}

		if ( class_exists( 'WCPBC_Customer' ) ) {
			$customer = new WCPBC_Customer();

			return ! empty( $customer->zone_id ) ? $customer : false;
		}

		return false;

	}

	/**
	 * Get the exchange rate of a WooCommerce Price Based on Country zone.
	 *
	 * @since    1.6.0
	 * @access   private
	 * @param    object $zone The zone or legacy customer object.
	 * @return   float
	 */
	private function get_wcpbc_exchange_rate( $zone ) {

		if ( is_callable( array( $zone, 'get_exchange_rate' ) ) ) {
			$rate = (float) $zone->get_exchange_rate();
		} elseif ( isset( $zone->exchange_rate ) ) {
			$rate = (float) $zone->exchange_rate;
		} else {
			$rate = 1.0;
		}

		return $rate > 0 ? $rate : 1.0;

	}

	/**
	 * Get the currency, either as a symbol or as a currency code, according to
	 * the plugin settings.
	 *
	 * @since    1.3.0
	 * @return   string
	 */
	public function get_currency_display() {

		$zone = $this->get_wcpbc_zone();

		if ( 'symbol' === get_option( 'dc_moafw_currency_display_type' ) ) {
			return get_woocommerce_currency_symbol();
		}

		if ( $zone ) {
			if ( is_callable( array( $zone, 'get_currency' ) ) ) {
				return (string) $zone->get_currency();
			}

			if ( isset( $zone->currency ) ) {
				return (string) $zone->currency;
			}
		}

		return get_woocommerce_currency();

	}

	/**
	 * Format an amount using the WooCommerce currency settings.
	 *
	 * @since    1.6.0
	 * @access   private
	 * @param    float $amount The amount to format.
	 * @return   string
	 */
	private function format_price( $amount ) {

		$formatted = number_format(
			(float) $amount,
			wc_get_price_decimals(),
			wc_get_price_decimal_separator(),
			wc_get_price_thousand_separator()
		);

		return sprintf( get_woocommerce_price_format(), $this->get_currency_display(), $formatted );

	}

	/**
	 * Translate an option value through Polylang, when available.
	 *
	 * @since    1.6.0
	 * @access   private
	 * @param    string $value The string to translate.
	 * @return   string
	 */
	private function translate( $value ) {

		if ( function_exists( 'pll__' ) ) {
			return (string) pll__( $value );
		}

		return $value;

	}

	/**
	 * Get the "minimum order" message, with the amount placeholder replaced.
	 *
	 * @since    1.5.0
	 * @param    float $minimum The minimum order amount.
	 * @return   string
	 */
	public function get_message( $minimum ) {

		$message = $this->translate( (string) get_option( 'dc_moafw_message' ) );

		return str_replace( '[minimum]', $this->format_price( $minimum ), $message );

	}

	/**
	 * Get the "current total" text, with the amount placeholder replaced.
	 *
	 * @since    1.5.0
	 * @param    float $total The current cart subtotal.
	 * @return   string
	 */
	public function get_current_total_text( $total ) {

		$text = $this->translate( (string) get_option( 'dc_moafw_current_total_text' ) );

		if ( '' === trim( $text ) ) {
			return '';
		}

		return str_replace( '[current]', $this->format_price( $total ), $text );

	}

}
