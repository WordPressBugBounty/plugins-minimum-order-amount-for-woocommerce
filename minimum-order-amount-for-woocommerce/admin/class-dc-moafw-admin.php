<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/dcurasi
 * @since      1.0.0
 *
 * @package    Dc_Moafw
 * @subpackage Dc_Moafw/admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Dc_Moafw
 * @subpackage Dc_Moafw/admin
 * @author     Dario Curasì <curasi.d87@gmail.com>
 */
class Dc_Moafw_Admin {

	/**
	 * The settings page slug.
	 *
	 * @since 1.6.0
	 * @var   string
	 */
	const PAGE_SLUG = 'dc-moafw-menu-page';

	/**
	 * The settings group name.
	 *
	 * @since 1.6.0
	 * @var   string
	 */
	const OPTION_GROUP = 'dc_moafw_options_group';

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
	 * The hook suffix of the settings page.
	 *
	 * @since    1.6.0
	 * @access   private
	 * @var      string|false
	 */
	private $page_hook = false;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name The name of this plugin.
	 * @param    string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * The stylesheet is only loaded on the plugin settings page.
	 *
	 * @since    1.0.0
	 * @param    string $hook_suffix The current admin page.
	 * @return   void
	 */
	public function enqueue_styles( $hook_suffix = '' ) {

		if ( ! $this->page_hook || $hook_suffix !== $this->page_hook ) {
			return;
		}

		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/dc-moafw-admin.css',
			array(),
			$this->version,
			'all'
		);

	}

	/**
	 * Register the settings page under the WooCommerce menu.
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	public function add_menu_page() {

		$this->page_hook = add_submenu_page(
			'woocommerce',
			__( 'Minimum Order Amount for WooCommerce', 'dc-moafw' ),
			__( 'Minimum Order', 'dc-moafw' ),
			'manage_woocommerce',
			self::PAGE_SLUG,
			array( $this, 'create_admin_interface' )
		);

	}

	/**
	 * Add a "Settings" link on the plugins list page.
	 *
	 * @since    1.6.0
	 * @param    array $links The existing action links.
	 * @return   array
	 */
	public function add_settings_link( $links ) {

		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'admin.php?page=' . self::PAGE_SLUG ) ),
			esc_html__( 'Settings', 'dc-moafw' )
		);

		array_unshift( $links, $settings_link );

		return $links;

	}

	/**
	 * Callback function for the admin settings page.
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	public function create_admin_interface() {

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'dc-moafw' ) );
		}

		require DC_MOAFW_PATH . 'admin/partials/dc-moafw-admin-display.php';

	}

	/**
	 * Register the plugin settings, each one with its own sanitize callback.
	 *
	 * @since    1.3.0
	 * @return   void
	 */
	public function settings_api_init() {

		register_setting(
			self::OPTION_GROUP,
			'dc_moafw_activate',
			array(
				'type'              => 'boolean',
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
				'default'           => 0,
				'show_in_rest'      => false,
			)
		);

		register_setting(
			self::OPTION_GROUP,
			'dc_moafw_minimum',
			array(
				'type'              => 'number',
				'sanitize_callback' => array( $this, 'sanitize_amount' ),
				'default'           => 0,
				'show_in_rest'      => false,
			)
		);

		register_setting(
			self::OPTION_GROUP,
			'dc_moafw_message',
			array(
				'type'              => 'string',
				'sanitize_callback' => array( $this, 'sanitize_message' ),
				'default'           => '',
				'show_in_rest'      => false,
			)
		);

		register_setting(
			self::OPTION_GROUP,
			'dc_moafw_current_total_text',
			array(
				'type'              => 'string',
				'sanitize_callback' => array( $this, 'sanitize_message' ),
				'default'           => '',
				'show_in_rest'      => false,
			)
		);

		register_setting(
			self::OPTION_GROUP,
			'dc_moafw_currency_display_type',
			array(
				'type'              => 'string',
				'sanitize_callback' => array( $this, 'sanitize_currency_display_type' ),
				'default'           => 'text',
				'show_in_rest'      => false,
			)
		);

		register_setting(
			self::OPTION_GROUP,
			'dc_moafw_message_shop',
			array(
				'type'              => 'boolean',
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
				'default'           => 0,
				'show_in_rest'      => false,
			)
		);

	}

	/**
	 * Sanitize a checkbox value.
	 *
	 * @since    1.6.0
	 * @param    mixed $value The submitted value.
	 * @return   int
	 */
	public function sanitize_checkbox( $value ) {
		return empty( $value ) ? 0 : 1;
	}

	/**
	 * Sanitize the minimum order amount.
	 *
	 * @since    1.6.0
	 * @param    mixed $value The submitted value.
	 * @return   string
	 */
	public function sanitize_amount( $value ) {

		$value = str_replace( ',', '.', trim( (string) $value ) );
		$value = (float) preg_replace( '/[^0-9.]/', '', $value );

		if ( $value < 0 ) {
			$value = 0;
		}

		if ( function_exists( 'wc_format_decimal' ) ) {
			return wc_format_decimal( $value, false, true );
		}

		return (string) $value;

	}

	/**
	 * Sanitize a notice message.
	 *
	 * @since    1.6.0
	 * @param    mixed $value The submitted value.
	 * @return   string
	 */
	public function sanitize_message( $value ) {
		return wp_kses_post( trim( (string) $value ) );
	}

	/**
	 * Sanitize the currency display type.
	 *
	 * @since    1.6.0
	 * @param    mixed $value The submitted value.
	 * @return   string
	 */
	public function sanitize_currency_display_type( $value ) {
		return ( 'symbol' === $value ) ? 'symbol' : 'text';
	}

	/**
	 * Show an admin notice when WooCommerce is not available.
	 *
	 * @since    1.1.0
	 * @return   void
	 */
	public function error_notice() {

		if ( Dc_Moafw_Public::is_woocommerce_active() || ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		printf(
			'<div class="notice notice-error is-dismissible"><p>%s</p></div>',
			esc_html__( 'Minimum Order Amount for WooCommerce is active but does not work. You need to install and activate WooCommerce for the plugin to work properly.', 'dc-moafw' )
		);

	}

	/**
	 * Register the translatable strings in Polylang.
	 *
	 * @since    1.2.0
	 * @return   void
	 */
	public function register_string_polylang() {

		if ( ! function_exists( 'pll_register_string' ) ) {
			return;
		}

		pll_register_string( 'message', (string) get_option( 'dc_moafw_message' ), 'dc-moafw', true );
		pll_register_string( 'current_total_text', (string) get_option( 'dc_moafw_current_total_text' ), 'dc-moafw' );

	}

}
