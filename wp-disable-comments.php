<?php
/*
Plugin Name:  Disable Comments
Plugin URI:   https://github.com/thinknathan/
Description:  Disable all comments.
Version:      1.0.1
Author:       Think_Nathan
Author URI:   https://thinknathan.ca
License:      MIT License
*/

namespace Think_Nathan\Utils;

// Credit to https://wordpress.org/plugins/disable-comments/
// which is a more comprehensive, better version of this plugin

// Remove comments page and comments options page
function filter_admin_menu() {
  remove_menu_page( 'edit-comments.php' );
  remove_submenu_page( 'options-general.php', 'options-discussion.php' );
}
add_action( 'admin_menu', __NAMESPACE__ . '\\filter_admin_menu', 999 );

// Remove comments widget in dashboard
function filter_dashboard() {
  remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\\filter_dashboard' );

// Remove comments widget in sidebar
function disable_rc_widget() {
  unregister_widget( 'WP_Widget_Recent_Comments' );
}
add_action( 'widgets_init', __NAMESPACE__ . '\\disable_rc_widget' );

function disable_comments_setup() {
  // Set comments to closed in options
  update_option( 'default_comment_status', 'closed' );

  // Remove comments links from admin bar
  remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );

  // Disable comments
  add_filter( 'comments_open', '__return_false', 10, 2 );

  // Disables comments feed link
  add_filter( 'feed_links_show_comments_feed', '__return_false' );
}
add_action( 'wp_loaded', __NAMESPACE__ . '\\disable_comments_setup' );
