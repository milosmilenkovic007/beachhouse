<?php
/**
 * Disable comments functionality.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Disable support for comments and trackbacks in post types.
 *
 * @return void
 */
function disable_comments_support() {
	// Redirect any user trying to access comments page.
	global $pagenow;

	if ( 'edit-comments.php' === $pagenow ) {
		wp_redirect( admin_url() );
		exit;
	}

	// Remove comments metabox from dashboard.
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

	// Disable support for comments and trackbacks in post types.
	foreach ( get_post_types() as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}
add_action( 'admin_init', 'disable_comments_support' );

/**
 * Close any comments open comments on the front-end just in case.
 *
 * @return boolean
 */
function df_disable_comments_status() {
	return false;
}
add_filter( 'comments_open', 'df_disable_comments_status', 20, 2 );
add_filter( 'pings_open', 'df_disable_comments_status', 20, 2 );

/**
 * Hide any existing comments that are on the site.
 *
 * @param  mixed $comments Array of comments.
 * @return array Array of comments.
 */
function df_disable_comments_hide_existing_comments( $comments ) {
	$comments = array();
	return $comments;
}
add_filter( 'comments_array', 'df_disable_comments_hide_existing_comments', 10, 2 );

// Remove comments page in menu.
add_action(
	'admin_menu',
	function () {
		remove_menu_page( 'edit-comments.php' );
	}
);

// Remove comments links from admin bar.
add_action(
	'init',
	function () {
		if ( is_admin_bar_showing() ) {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
		}
	}
);
