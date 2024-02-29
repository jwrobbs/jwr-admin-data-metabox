<?php
/**
 * Add server data to admin metaboxes.
 *
 * @author Josh Robbs <josh@joshrobbs.com>
 * @package JWR_admin_metabox
 * @version 0.7.0
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

	// Server data.
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

	$debug      = '';
	$debug_data = '';
	$button     = '';

	// Crawlability.
	$crawlability = \get_option( 'blog_public' ) ? '&#x1f7e2; Enabled' : '&#10060; Blocked';
	$crawl_text   = <<<HTML
		<div>
			<h5>Crawlability</h5>
			<div class='data-list'>
				<div>Bot crawling</div><div>{$crawlability}</div>
			</div>
		</div>
	HTML;
	// Debugging.
	if ( current_user_can( 'manage_options' ) ) {
		$debugging = Debugging_Mode::get_debugging_status();

		if ( 'enabled' === $debugging ) {
			$logging    = Debugging_Mode::get_logging_status();
			$displaying = Debugging_Mode::get_displaying_status();

			$logging    = Debugging_Mode::add_symbol( $logging );
			$displaying = Debugging_Mode::add_symbol( $displaying );
			$debugging  = Debugging_Mode::add_symbol( $debugging );

			$debug_data .= <<<HTML
			<div class='data-list'>
				<div>Debugging</div><div>{$debugging}</div>
				<div>Logging</div><div>{$logging}</div>
				<div>Displaying</div><div>{$displaying}</div>
			</div>
		HTML;

			$button_text = 'Disable Debugging';
		} else {
			$debugging   = Debugging_Mode::add_symbol( $debugging );
			$debug_data .= <<<HTML
			<div class='data-list'>
				<div>Debugging</div><div>{$debugging}</div>
			</div>
		HTML;

			$button_text = 'Enable Debugging';
		}

		$button = "<button id='debugging-toggle'>$button_text</button>";

		$debug = <<<HTML
		<div class='section'>
			<h5>Debugging</h5>
			$debug_data
			$button
		</div>
		HTML;
	}

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
			#debugging-toggle {
				margin: .5em 0;
				padding: .25em;
				color: white;
				background-color: #0073aa;
			}
			#debugging-toggle:hover {
				background-color: #0099ff;
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
			$crawl_text
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
