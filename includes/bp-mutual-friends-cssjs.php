<?php

/**
 * NOTE: You should always use the wp_enqueue_script() and wp_enqueue_style() functions to include
 * javascript and css files.
 */
/**
 * bp_mutual_friends_add_js()
 *
 * This function will enqueue the components javascript file, so that you can make
 * use of any javascript you bundle with your component within your interface screens.
 */
function bp_mutual_friends_add_js() {

	wp_enqueue_style( 'magnific-popup', BP_MUTUAL_FRIENDS_PLUGIN_URL.'assets/css/magnific-popup.css', array(), BP_MUTUAL_FRIENDS_VERSION );
	wp_enqueue_script( 'jquery.magnific-popup', BP_MUTUAL_FRIENDS_PLUGIN_URL.'assets/js/jquery.magnific-popup.js', array('jquery'), BP_MUTUAL_FRIENDS_VERSION );
	wp_enqueue_script( 'mutual-friends', BP_MUTUAL_FRIENDS_PLUGIN_URL.'assets/js/mutual-friends.js', array('jquery'), BP_MUTUAL_FRIENDS_VERSION );
}
add_action( 'bp_before_members_loop', 'bp_mutual_friends_add_js' );