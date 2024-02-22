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
require_once 'php/server-metabox.php';
require_once 'php/git-metabox.php';
