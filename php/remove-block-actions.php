<?php
/**
 * Remove Default Block Actions.
 *
 * @author Josh Robbs <josh@joshrobbs.com>
 * @package JWR_admin_metabox
 * @version 0.5.0
 * @since   2024-02-22
 */

namespace JWR_Admin_Metabox\PHP;

defined( 'ABSPATH' ) || die();

/**
 * Get the callbacks for a hook.
 *
 * @param string $hook_name The name of the hook.
 * @return array
 */

/**
 * Remove block callbacks from the 'init' hook.
 *
 * @return void
 */
function remove_block_actions() {
	$callbacks = array(
		'register_block_core_legacy_widget',
		'register_block_core_widget_group',
		'register_block_core_archives',
		'register_block_core_avatar',
		'register_block_core_block',
		'register_block_core_calendar',
		'register_block_core_categories',
		'register_block_core_comment_author_name',
		'register_block_core_comment_content',
		'register_block_core_comment_date',
		'register_block_core_comment_edit_link',
		'register_block_core_comment_reply_link',
		'register_block_core_comment_template',
		'register_block_core_comments',
		'register_block_core_comments_pagination',
		'register_block_core_comments_pagination_next',
		'register_block_core_comments_pagination_numbers',
		'register_block_core_comments_pagination_previous',
		'register_block_core_comments_title',
		'register_block_core_cover',
		'register_block_core_file',
		'register_block_core_footnotes',
		'register_block_core_gallery',
		'register_block_core_heading',
		'register_block_core_home_link',
		'register_block_core_image',
		'register_block_core_latest_comments',
		'register_block_core_latest_posts',
		'register_block_core_loginout',
		'register_block_core_navigation',
		'register_block_core_navigation_link',
		'register_block_core_navigation_submenu',
		'register_block_core_page_list',
		'register_block_core_page_list_item',
		'register_block_core_pattern',
		'register_block_core_post_author',
		'register_block_core_post_author_biography',
		'register_block_core_post_author_name',
		'register_block_core_post_comments_form',
		'register_block_core_post_content',
		'register_block_core_post_date',
		'register_block_core_post_excerpt',
		'register_block_core_post_featured_image',
		'register_block_core_post_navigation_link',
		'register_block_core_post_template',
		'register_block_core_post_terms',
		'register_block_core_post_title',
		'register_block_core_query',
		'register_block_core_query_no_results',
		'register_block_core_query_pagination',
		'register_block_core_query_pagination_next',
		'register_block_core_query_pagination_numbers',
		'register_block_core_query_pagination_previous',
		'register_block_core_query_title',
		'register_block_core_read_more',
		'register_block_core_rss',
		'register_block_core_search',
		'register_block_core_shortcode',
		'register_block_core_site_logo',
		'register_block_core_site_tagline',
		'register_block_core_site_title',
		'register_block_core_social_link',
		'register_block_core_tag_cloud',
		'register_block_core_template_part',
		'register_block_core_term_description',
		'register_core_block_types_from_metadata',
		'register_core_block_style_handles',
	);
	foreach ( $callbacks as $callback ) {
		\remove_action( 'init', $callback );
	}
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\remove_block_actions', 1 );
