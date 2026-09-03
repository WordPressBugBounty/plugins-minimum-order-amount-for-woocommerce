<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * Removes every option created by the plugin, on single sites and on every
 * site of a multisite network.
 *
 * @link       https://github.com/dcurasi
 * @since      1.3.0
 *
 * @package    Dc_Moafw
 */

// If uninstall is not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Delete the plugin options for the current site.
 *
 * @since 1.6.0
 * @return void
 */
function dc_moafw_delete_options() {

	$options = array(
		'dc_moafw_activate',
		'dc_moafw_minimum',
		'dc_moafw_message',
		'dc_moafw_current_total_text',
		'dc_moafw_currency_display_type',
		'dc_moafw_message_shop',
	);

	foreach ( $options as $option ) {
		delete_option( $option );
	}

}

if ( is_multisite() ) {

	$dc_moafw_site_ids = get_sites(
		array(
			'fields' => 'ids',
			'number' => 0,
		)
	);

	foreach ( $dc_moafw_site_ids as $dc_moafw_site_id ) {
		switch_to_blog( $dc_moafw_site_id );
		dc_moafw_delete_options();
		restore_current_blog();
	}
} else {
	dc_moafw_delete_options();
}
