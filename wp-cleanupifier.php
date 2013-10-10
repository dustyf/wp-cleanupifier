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
add_action( 'init', 'wpc_remove_head_links' );
function wpc_remove_head_links() {
   	remove_action( 'wp_head', 'rsd_link' );
   	remove_action( 'wp_head', 'wlwmanifest_link' );
   	remove_action( 'wp_head', 'wp_generator' );
}

/**
 * Remove WP Admin Bar WP Menu
 */
add_action( 'add_admin_bar_menus', 'wpc_remove_wp_admin_bar_wp_menu', 1 );
function wpc_remove_wp_admin_bar_wp_menu() {
  remove_action( 'admin_bar_menu', 'wp_admin_bar_wp_menu', 10 );
}

/**
 * To Disable RSS Feeds, uncomment the below lines
 */

// function wpc_disable_all_feeds() {
//    wp_die( __( 'Sorry, our content is not available by RSS. Please head over to <a href="'. get_bloginfo('url') .'">our site</a>' ) );
// }

//add_action( 'do_feed', 'wpc_disable_all_feeds', 1) ;
//add_action( 'do_feed_rdf', 'wpc_disable_all_feeds', 1 );
//add_action( 'do_feed_rss', 'wpc_disable_all_feeds', 1 );
//add_action( 'do_feed_rss2', 'wpc_disable_all_feeds', 1 );
//add_action( 'do_feed_atom', 'wpc_disable_all_feeds', 1) ;
//remove_action( 'wp_head', 'feed_links_extra', 3 ); 
//remove_action( 'wp_head', 'feed_links', 2 );

/**
 * Disable theme file editing
 */
define( 'DISALLOW_FILE_EDIT', true );


/**
 * Remove Dashboard Widgets
 */
add_action( 'admin_init', 'wpc__remove_dashboard_widgets' );
function wpc__remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );   // right now
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // recent comments
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal') ;  // incoming links
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );   // plugins
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'normal' );  // quick press
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'normal' );  // recent drafts
	remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );   // wordpress blog
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );   // other wordpress news
}
add_action( 'wp_dashboard_setup', 'wpc_remove_dashboard_widgets' );

/**
 * Remove Screen Options
 */
// function wpc_remove_screen_options_tab()
// {
//     return false;
// }
// add_filter( 'screen_options_show_screen', 'wpc_remove_screen_options_tab' );
 
 /**
 * Remove Help Tab
 */
function wpc_hide_help() {
    echo '<style type="text/css">
           #contextual-help-link-wrap { display: none !important; }
         </style>';
}
add_action( 'admin_head', 'wpc_hide_help' );

function wpc_custom_dashboard_widgets() {
global $wp_meta_boxes;
 
wp_add_dashboard_widget( 'custom_help_widget', 'My Widget Title', 'wpc_custom_dashboard_help' );
}

 /**
 * Create a custom dashboard widget
 */
function wpc_custom_dashboard_help() {
echo 'My widget content';
}
add_action( 'wp_dashboard_setup', 'wpc_custom_dashboard_widgets' );

/**
 * Filter Yoast Meta Priority
 **/
function wpc_wpseo_metabox_prio() {
	return 'low' ;								  
}
add_filter( 'wpseo_metabox_prio' , 'wpc_wpseo_metabox_prio' );

/**
 * Remove AIM, Jabber, YIM from User Profile
 **/
if ( ! function_exists( 'wpc_extra_contact_info' ) ) :
	function wpc_extra_contact_info( $contactmethods ) {
	
	    unset( $contactmethods['aim'] );
	    unset( $contactmethods['jabber'] );
	    unset( $contactmethods['yim'] );
	
	    return $contactmethods;
	}
	add_filter( 'user_contactmethods', 'wpc_extra_contact_info' );
endif;