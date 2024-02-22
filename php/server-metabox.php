<?php
/**
 * Add server data to admin metaboxes.
 *
 * @author Josh Robbs <josh@joshrobbs.com>
 * @package JWR_admin_metabox
 * @version 0.5.0
 * @since   2024-02-22
 */

namespace JWR_Admin_Metabox\PHP;

defined( 'ABSPATH' ) || die();

/**
 * Server Data Dashboard Widget function.
 *
 * Modified from
 *
 * @link https://github.com/builtmighty/builtmighty-kit
 *
 * @return void
 */
function add_custom_dashboard_widget_server_data() {
	// Global.
	global $wpdb;

	// Get information for developers.
	$php         = phpversion();
	$db_version  = $wpdb->db_version();
	$wp          = get_bloginfo( 'version' );
	$server_info = $wpdb->db_server_info();

	$pattern = '%' . $db_version . '-(\w+)-%';
	$results = \preg_match( $pattern, $server_info, $matches );
	if ( $results ) {
		$database   = $matches[1];
		$db_version = "$database-{$db_version} ";
	}

	$debugging = \defined( 'WP_DEBUG' ) && \WP_DEBUG;

	if ( $debugging ) {
		$logging    = \defined( 'WP_DEBUG_LOG' ) && \WP_DEBUG_LOG;
		$displaying = \defined( 'WP_DEBUG_DISPLAY' ) && \WP_DEBUG_DISPLAY;

		$debug  = '';
		$debug .= '<p style="margin: 1rem 0 0;"><strong>Debugging</strong></p>';
		$debug .= '<ul style="margin:0;">';
		$debug .= '<li>Debugging is <code>enabled</code></li>';
		$debug .= '<li>Logging is <code>' . ( $logging ? 'enabled' : 'disabled' ) . '</code></li>';
		$debug .= '<li>Displaying is <code>' . ( $displaying ? 'enabled' : 'disabled' ) . '</code></li>';
		$debug .= '</ul>';
	}

	$html = <<<HTML
		<div class="built-panel">
			<p style="margin-top:0;"><strong>Developer Info</strong></p>
			<ul style="margin:0;">
				<li>PHP <code>{$php}</code></li>
				<li>Database <code>{$db_version}</code></li>
				<li>WordPress <code>{$wp}</code></li>
			</ul>
			$debug
		</div>
		HTML;

		echo \wp_kses_post( $html );
}

/**
 * Create Server Data Dashboard Widget.
 *
 * @return void
 */
function add_server_data_db_widget() {
	\wp_add_dashboard_widget(
		'jwr_server_data_dashboard_widget', // Widget slug.
		'Server Data',   // Widget title.
		__NAMESPACE__ . '\add_custom_dashboard_widget_server_data'  // Display function.
	);
}

add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\add_server_data_db_widget' );
