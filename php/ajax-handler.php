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
	\SimpleLogger()->info( 'Toggling debugging: ajax triggered.' );
	Debugging_Mode::toggle_debugging();
	die();
}

add_action( 'wp_ajax_toggle_debugging', __NAMESPACE__ . '\toggle_debugging' );
