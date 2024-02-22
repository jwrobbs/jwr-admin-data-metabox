<?php
/**
 * AJAX handler for toggling debugging.
 *
 * @author Josh Robbs <josh@joshrobbs.com>
 * @package JWR_admin_metabox
 * @version 0.5.0
 * @since   2024-02-22
 */

namespace JWR_Admin_Metabox\PHP;

defined( 'ABSPATH' ) || die();

/**
 * Toggle debugging AJAX handler.
 *
 * @return void
 */
function toggle_debugging() {
	if ( ! isset( $_POST['nonce'] ) ) {
		\SimpleLogger()->error( 'Nonce not set. (Disable Debug button)' );
		die();
	}

	$nonce_verification = wp_verify_nonce( $_POST['nonce'], 'admin_metabox_nonce' ); // phpcs:ignore

	if ( ! $nonce_verification ) {
		\SimpleLogger()->error( 'Nonce verification failed. (Disable Debug button)' );
		die();
	}

	Debugging_Mode::toggle_debugging();
	die();
}

add_action( 'wp_ajax_toggle_debugging', __NAMESPACE__ . '\toggle_debugging' );
add_action( 'wp_ajax_nopriv_toggle_debugging', __NAMESPACE__ . '\toggle_debugging' );
