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

	$debug_data = '';
	if ( $debugging ) {
		$logging    = \defined( 'WP_DEBUG_LOG' ) && \WP_DEBUG_LOG;
		$displaying = \defined( 'WP_DEBUG_DISPLAY' ) && \WP_DEBUG_DISPLAY;

		$logging    = $logging ? '⚠️ enabled' : '👍disabled';
		$displaying = $displaying ? '⚠️ enabled' : '👍disabled';

		$debugging = '⚠️ enabled';

		$debug_data .= <<<HTML
			<div class='data-list'>
				<div>Debugging</div><div>{$debugging}</div>
				<div>Logging</div><div>{$logging}</div>
				<div>Displaying</div><div>{$displaying}</div>
			</div>
			HTML;
	} else {
		$debugging   = '👍 disabled';
		$debug_data .= <<<HTML
			<div class='data-list'>
				<div>Debugging</div><div>{$debugging}</div>
			</div>
			HTML;
	}

	$debug = <<<HTML
		<div class='section'>
			<h5>Debugging</h5>
			$debug_data
		</div>
		HTML;

	$html = <<<HTML
		<style>
			html .jwr-dev-info-container * {
				font-size: 1rem;
			}
			.jwr-dev-info-container h5 {
				font-size: 1rem;
				font-weight: bold;
				text-transform: uppercase;
				margin: 1rem 0 .25rem;
			}
			.jwr-dev-info-container .data-list{
				display: grid;
				grid-template-columns: 100px 1fr;
			}
		</style>
		<div class='jwr-dev-info-container'>
			<div class='section'>
				<h5>Server Data</h5>
				<div class='data-list'>
					<div>PHP</div><div>{$php}</div>
					<div>Database</div><div>{$db_version}</div>
					<div>WordPress</div><div>{$wp}</div>
				</div>
			</div>
			$debug
		</div>
		HTML;

		$normal_allowed_html          = \wp_kses_allowed_html( 'post' );
		$custom_allowed_html          = $normal_allowed_html;
		$custom_allowed_html['style'] = array();

		echo \wp_kses( $html, $custom_allowed_html );
}

/**
 * Create Server Data Dashboard Widget.
 *
 * @return void
 */
function add_server_data_db_widget() {
	\wp_add_dashboard_widget(
		'jwr_server_data_dashboard_widget', // Widget slug.
		'Developer Info',   // Widget title.
		__NAMESPACE__ . '\add_custom_dashboard_widget_server_data'  // Display function.
	);
}

add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\add_server_data_db_widget' );
