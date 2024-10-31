<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       http://kontur.us
 * @since      1.0.0
 *
 * @package    Plugin Name:No All in one SEO Notifications - STOP nagging me
 */

// If uninstall not called from WordPress, then exit. 
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
} 

delete_option( 'no_aioseop_nags_custom_css' ); 
delete_option( 'abl_no_aioseop_nags_version' ); 
delete_option( 'no_aioseop_nags_custom_css-checkbox' ); 
delete_option( 'no_aioseop_nags_your_custom-checkbox' ); 
delete_option( 'no_aioseop_nags_your_custom_css' );
delete_option( 'no_aioseop_nags_menu-checkbox' ); 
delete_option( 'no_aioseop_nags_yoast' ); 
delete_option( 'no_aioseop_nags_all_messages' ); 


