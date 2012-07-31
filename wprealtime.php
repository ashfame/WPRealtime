<?php

/*
Plugin Name: WP Realtime
Plugin URI: http://github.com/ashfame/wprealtime
Description: Realtime goodies
Version: 0.1
Author: Ashfame
Author URI: http://blog.ashfame.com/
License: GPLv2
*/

/**
 *	Function to load engine script on WP Dashboard page
 */

add_action( 'admin_enqueue_scripts', 'wprealtime_get_scripts_ready' );

function wprealtime_get_scripts_ready() {
	global $pagenow;
	// Add script only on dashboard page
	if ( is_admin() && $pagenow == 'index.php' ) {
		wp_enqueue_script( 'wprealtime-engine', plugins_url( 'engine.js', __FILE__ ), array( 'jquery' ), null, true );
		wp_localize_script( 'wprealtime-engine', 'wprealtime', array( 'ajaxurl' => admin_url('admin-ajax.php') ) );
	}
}


/**
 *	Ajax handler function
 */

add_action( 'wp_ajax_nopriv_wprealtime_whats_new', 'wprealtime_ajax_handler' );
add_action( 'wp_ajax_wprealtime_whats_new', 'wprealtime_ajax_handler' );

function wprealtime_ajax_handler() {
	$result = array();

	$result['status'] = 'success';

	$result['count']['posts'] = wp_count_posts( 'post' );
	$result['count']['pages'] = wp_count_posts( 'page' );
	$result['count']['categories'] = wp_count_terms('category');
	$result['count']['tags'] = wp_count_terms('post_tag');
	$result['count']['comments'] = wp_count_comments();

	echo json_encode( $result );
	die();
}