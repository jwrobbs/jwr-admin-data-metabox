<?php
/**
 * Plugin Name: JWR's Admin Metabox
 * Description: Adds a metabox to the WP admin dashboard with server and debug data.
 * Version: 0.5.0
 * Author: Josh Robbs
 * Author URI: https://joshrobbs.com
 *
 * Creates a WP admin metabox containing:
 *  - Server data
 *  - Debug data
 *  - Debug toggle
 * Removes many default WP dashboard widgets.
 *
 * @author Josh Robbs <josh@joshrobbs.com>
 * @package JWR_admin_metabox
 * @version 0.5.0
 * @since   2024-02-22
 */

namespace JWR_Admin_Metabox;

defined( 'ABSPATH' ) || die();

require_once 'php/admin-metabox-cleanup.php';
require_once 'php/ajax-handler.php';
require_once 'php/git-metabox.php';
require_once 'php/server-metabox.php';

// Remove after setting up autoloder.
require_once 'php/class-debugging-mode.php';

/**
 * Enqueue admin scripts.
 *
 * @return void
 */
function enqueue_admin_metabox_scripts() {
	$file = plugin_dir_url( __FILE__ ) . 'js/debug-toggle.js';
	wp_enqueue_script(
		'jwr-admin-metabox',
		$file,
		array(),
		filemtime( $file ),
		true
	);
}

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_admin_metabox_scripts' );
