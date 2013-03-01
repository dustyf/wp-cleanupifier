<?php
/*
Plugin Name: WP Cleanupifier
Plugin URI: http://dustyf.com
Description: Cleaning up parts of WordPress that we may not need.  There are no options to this plugin, everything is controlled by commenting out the code in the plugin file.
Version: 1.0
Author: Dustin Filippini
Author URI: http://dustyf.com
License: GPL2
*/


/**
 * WP Head Cleaner
 */
function removeHeadLinks() {
   	remove_action('wp_head', 'rsd_link');
   	remove_action('wp_head', 'wlwmanifest_link');
   	remove_action('wp_head', 'wp_generator');
}
add_action('init', 'removeHeadLinks');

add_action( 'add_admin_bar_menus', 'remove_wp_admin_bar_wp_menu', 1 );
/**
 * Remove WP Admin Bar WP Menu
 * 
 * @return null void
 */
function remove_wp_admin_bar_wp_menu() {
  remove_action( 'admin_bar_menu', 'wp_admin_bar_wp_menu', 10 );
}

/**
 * To Disable RSS Feeds, uncomment the below lines
 */

// function disable_all_feeds() {
//    wp_die( __('Sorry, our content is not available by RSS. Please head over to <a href="'. get_bloginfo('url') .'">our site</a>') );
// }

//add_action('do_feed', 'disable_all_feeds', 1);
//add_action('do_feed_rdf', 'disable_all_feeds', 1);
//add_action('do_feed_rss', 'disable_all_feeds', 1);
//add_action('do_feed_rss2', 'disable_all_feeds', 1);
//add_action('do_feed_atom', 'disable_all_feeds', 1);
//remove_action( 'wp_head', 'feed_links_extra', 3 ); 
//remove_action( 'wp_head', 'feed_links', 2 );

/**
 * Disable theme file editing
 */
define('DISALLOW_FILE_EDIT',true);


/**
 * Remove Dashboard Widgets
 */
add_action('admin_init', 'rw_remove_dashboard_widgets');
function rw_remove_dashboard_widgets() {
	remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // right now
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // recent comments
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // incoming links
	remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // plugins
	remove_meta_box('dashboard_quick_press', 'dashboard', 'normal');  // quick press
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal');  // recent drafts
	remove_meta_box('dashboard_primary', 'dashboard', 'normal');   // wordpress blog
	remove_meta_box('dashboard_secondary', 'dashboard', 'normal');   // other wordpress news
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

/**
 * Remove Screen Options
 */
// function remove_screen_options_tab()
// {
//     return false;
// }
// add_filter('screen_options_show_screen', 'remove_screen_options_tab');
 
 /**
 * Remove Help Tab
 */
function hide_help() {
    echo '<style type="text/css">
           #contextual-help-link-wrap { display: none !important; }
         </style>';
}
add_action('admin_head', 'hide_help');

function my_custom_dashboard_widgets() {
global $wp_meta_boxes;
 
wp_add_dashboard_widget('custom_help_widget', 'My Widget Title', 'custom_dashboard_help');
}

 /**
 * Create a custom dashboard widget
 */
function custom_dashboard_help() {
echo 'My widget content';
}
 
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');