<?php
/**
 * Remove unneeded admin metaboxes.
 *
 * @author Josh Robbs <josh@joshrobbs.com>
 * @package JWR_admin_metabox
 * @version 0.5.0
 * @since   2024-02-22
 */

namespace JWR_Admin_Metabox\PHP;

defined( 'ABSPATH' ) || die();

/**
 * Clean up the admin dashboard.
 *
 * @return void
 */
function clean_up_dashboard() {
	\remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	\remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	\remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	\remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	\remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	\remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	\remove_meta_box( 'dashboard_welcome', 'dashboard', 'normal' );
	\remove_meta_box( 'dashboard_at_a_glance', 'dashboard', 'normal' );
	\remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	\remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	\remove_meta_box( 'ws-ame-screen-options', 'dashboard', 'normal' );
}

add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\clean_up_dashboard' );
