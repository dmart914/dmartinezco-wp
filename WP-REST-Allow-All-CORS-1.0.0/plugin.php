<?php
/**
 * Plugin Name: WP-REST-Allow-All-CORS
 * Plugin URI: http://AhmadAwais.com/
 * Description: Allow all cross origin requests to your WordPress site's REST API..
 * Author: mrahmadawais, WPTie
 * Author URI: http://AhmadAwais.com/
 * Version: 1.0.1
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package WP
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



// Make sure the function is unique.
if ( ! function_exists( 'wp_rest_allow_all_cors' ) ) {
	// Hook.
	add_action( 'rest_api_init', 'wp_rest_allow_all_cors', 15 );
	/**
	 * Allow all CORS.
	 *
	 * @since 1.0.0
	 */
	function wp_rest_allow_all_cors() {
		// Remove the default filter.
		remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

		// Add a Custom filter.
		add_filter( 'rest_pre_serve_request', function( $value ) {
			header( 'Access-Control-Allow-Origin: *' );
			header( 'Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE' );
			header( 'Access-Control-Allow-Credentials: true' );
			return $value;
		});
	} // End fucntion wp_rest_allow_all_cors().
} // End if().

add_action( 'send_headers', function() {
	if ( ! did_action('rest_api_init') && $_SERVER['REQUEST_METHOD'] == 'HEAD' ) {
		header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Expose-Headers: Link' );
		header( 'Access-Control-Allow-Methods: HEAD' );
	}
} );

