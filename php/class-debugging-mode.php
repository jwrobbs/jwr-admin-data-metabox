<?php
/**
 * Enable or disable debugging.
 *
 * @author Josh Robbs <josh@joshrobbs.com>
 * @package JWR_admin_metabox
 * @version 0.5.0
 * @since   2024-02-22
 */

namespace JWR_Admin_Metabox\PHP;

defined( 'ABSPATH' ) || die();

/**
 * Class Debugging_Mode
 */
class Debugging_Mode {
	/**
	 * Get debugging status.
	 * Possible values: 'enabled', 'disabled', 'unset'.
	 *
	 * @return string
	 */
	public static function get_debugging_status() {
		return self::evaluate_constant( 'WP_DEBUG' );
	}

	/**
	 * Get logging status.
	 * Possible values: 'enabled', 'disabled', 'unset'.
	 *
	 * @return string
	 */
	public static function get_logging_status() {
		return self::evaluate_constant( 'WP_DEBUG_LOG' );
	}

	/**
	 * Get displaying status.
	 * Possible values: 'enabled', 'disabled', 'unset'.
	 *
	 * @return string
	 */
	public static function get_displaying_status() {
		return self::evaluate_constant( 'WP_DEBUG_DISPLAY' );
	}

	/**
	 * Evaluate the constant's status.
	 * Possible values: 'enabled', 'disabled', 'unset'.
	 *
	 * @param string $constant The constant to evaluate.
	 * @return string
	 */
	private static function evaluate_constant( $constant ) {
		if ( ! \defined( $constant ) ) {
			return 'unset';
		} elseif ( \constant( $constant ) ) {
			return 'enabled';
		} else {
			return 'disabled';
		}
	}

	/**
	 * Add symbols to the status.
	 *
	 * @param string $status The status to add symbols to.
	 * @return string
	 */
	public static function add_symbol( $status ) {
		if ( 'disabled' === $status ) {
			return '👍 disabled';
		} else {
			return '⚠️ ' . $status;
		}
	}

	/**
	 * Toggle debugging.
	 *
	 * @return void
	 */
	public static function toggle_debugging() {
		\SimpleLogger()->info( 'Toggling debugging: static fn called.' );
		// If debugging is enabled, disable it.
		// If debugging is disabled, enable it.
			// If logging is disabled or unset, enable it.
			// If displaying is disabled or unset, enable it.

		$debugging = self::get_debugging_status();

		if ( 'enabled' === $debugging ) {
			self::disable_debugging();
		} else {
			self::enable_debugging();
		}
	}

	/**
	 * Disable debugging.
	 *
	 * @return void
	 */
	private static function disable_debugging() {
		$config_file_path = ABSPATH . 'wp-config.php';

		$config_file    = \file_get_contents( $config_file_path );
		$debug_enabled  = "define( 'WP_DEBUG', true )";
		$debug_disabled = "define( 'WP_DEBUG', false )";

		if ( ! \str_contains( $config_file, $debug_enabled ) ) {
			return;
		}

		$config_file = \str_replace( $debug_enabled, $debug_disabled, $config_file );

		$res = \file_put_contents( $config_file_path, $config_file );
	}

	/**
	 * Enable debugging.
	 *
	 * @return void
	 */
	private static function enable_debugging() {
		\SimpleLogger()->info( 'Enabling debugging.' );

		$debug_enabled       = "define( 'WP_DEBUG', true );";
		$debug_disabled      = "define( 'WP_DEBUG', false );";
		$logging_enabled     = "define( 'WP_DEBUG_LOG', true );";
		$logging_disabled    = "define( 'WP_DEBUG_LOG', false );";
		$displaying_enabled  = "define( 'WP_DEBUG_DISPLAY', true );";
		$displaying_disabled = "define( 'WP_DEBUG_DISPLAY', false );";

		$config_file_path = ABSPATH . 'wp-config.php';
		$config_file      = \file_get_contents( $config_file_path );

		if ( ! \str_contains( $config_file, $debug_disabled ) ) {
			\SimpleLogger()->info( 'Debugging already enabled.' );
			return;
		}

		// Enable debugging.
		$config_file = \str_replace( $debug_disabled, $debug_enabled, $config_file );

		// Check for logging. Enable or add.
		if ( \str_contains( $config_file, $logging_enabled ) ) {
			$config_file = $config_file;
		} elseif ( \str_contains( $config_file, $logging_disabled ) ) {
			$config_file = \str_replace( $logging_disabled, $logging_enabled, $config_file );
		} else {
			$config_file = \str_replace( $debug_enabled, $debug_enabled . "\n" . $logging_enabled, $config_file );
		}

		// Check for displaying. Enable or add.
		if ( \str_contains( $config_file, $displaying_enabled ) ) {
			$config_file = $config_file;
		} elseif ( \str_contains( $config_file, $displaying_disabled ) ) {
			$config_file = \str_replace( $displaying_disabled, $displaying_enabled, $config_file );
		} else {
			$config_file = \str_replace( $logging_enabled, $logging_enabled . "\n" . $displaying_enabled, $config_file );
		}

		$res = \file_put_contents( $config_file_path, $config_file );
	}
}
