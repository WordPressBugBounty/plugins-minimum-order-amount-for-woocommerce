<?php
/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/dcurasi
 * @since      1.3.0
 *
 * @package    Dc_Moafw
 * @subpackage Dc_Moafw/admin/partials
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="wrap">
	<h1><?php esc_html_e( 'Minimum Order Amount for WooCommerce', 'dc-moafw' ); ?></h1>

	<form method="post" action="options.php">
		<?php
		settings_fields( Dc_Moafw_Admin::OPTION_GROUP );
		settings_errors();
		?>

		<h2><?php esc_html_e( 'Configuration', 'dc-moafw' ); ?></h2>

		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row">
						<label for="dc_moafw_activate"><?php esc_html_e( 'Enable / Disable', 'dc-moafw' ); ?></label>
					</th>
					<td>
						<label for="dc_moafw_activate">
							<input type="checkbox" id="dc_moafw_activate" name="dc_moafw_activate" value="1" <?php checked( get_option( 'dc_moafw_activate' ), 1 ); ?> />
							<?php esc_html_e( 'Activate Options', 'dc-moafw' ); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="dc_moafw_minimum"><?php esc_html_e( 'Minimum Order', 'dc-moafw' ); ?></label>
					</th>
					<td>
						<input type="number" step="any" min="0" id="dc_moafw_minimum" name="dc_moafw_minimum" value="<?php echo esc_attr( get_option( 'dc_moafw_minimum' ) ); ?>" class="regular-text" />
						<p class="description"><?php esc_html_e( 'The minimum amount with which you can place your order.', 'dc-moafw' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="dc_moafw_message"><?php esc_html_e( 'Message', 'dc-moafw' ); ?></label>
					</th>
					<td>
						<textarea id="dc_moafw_message" name="dc_moafw_message" class="large-text" cols="50" rows="5"><?php echo esc_textarea( get_option( 'dc_moafw_message' ) ); ?></textarea>
						<p class="description"><?php esc_html_e( 'The notice message that appears if the minimum amount is not reached. Insert [minimum] in the position where you want to show the minimum value in the message.', 'dc-moafw' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="dc_moafw_current_total_text"><?php esc_html_e( 'Current Total Text', 'dc-moafw' ); ?></label>
					</th>
					<td>
						<input type="text" id="dc_moafw_current_total_text" name="dc_moafw_current_total_text" value="<?php echo esc_attr( get_option( 'dc_moafw_current_total_text' ) ); ?>" class="regular-text" />
						<p class="description"><?php esc_html_e( 'The text of the current cart total. Insert [current] in the position where you want to show the current cart total. Leave it empty to hide it.', 'dc-moafw' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="dc_moafw_currency_display_type"><?php esc_html_e( 'Currency Display Type', 'dc-moafw' ); ?></label>
					</th>
					<td>
						<select id="dc_moafw_currency_display_type" name="dc_moafw_currency_display_type">
							<option value="symbol" <?php selected( get_option( 'dc_moafw_currency_display_type' ), 'symbol' ); ?>><?php esc_html_e( 'Symbol', 'dc-moafw' ); ?></option>
							<option value="text" <?php selected( get_option( 'dc_moafw_currency_display_type' ), 'text' ); ?>><?php esc_html_e( 'Text', 'dc-moafw' ); ?></option>
						</select>
						<p class="description"><?php esc_html_e( 'The way the currency appears in the notification message (i.e. "€" if is "symbol", "EUR" if is "text").', 'dc-moafw' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="dc_moafw_message_shop"><?php esc_html_e( 'Show message in the shop', 'dc-moafw' ); ?></label>
					</th>
					<td>
						<label for="dc_moafw_message_shop">
							<input type="checkbox" id="dc_moafw_message_shop" name="dc_moafw_message_shop" value="1" <?php checked( get_option( 'dc_moafw_message_shop' ), 1 ); ?> />
							<?php esc_html_e( 'Enable', 'dc-moafw' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Enable this option to show the notification message also in the shop pages. (Note: the message will not be displayed if the cart is empty)', 'dc-moafw' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>

		<?php submit_button(); ?>
	</form>
</div>
