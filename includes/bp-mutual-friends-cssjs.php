<?php
/**
 * bmf_mutual_friends_add_js()
 *
 * This function will enqueue the components javascript file
 */
function bmf_mutual_friends_add_js() {

	if ( ! defined( 'DOING_AJAX' ) ) {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_style( 'magnific-popup', BP_MUTUAL_FRIENDS_PLUGIN_URL . 'assets/css/magnific-popup.css', array(), BP_MUTUAL_FRIENDS_VERSION );
		wp_enqueue_style( 'mutual-friends', BP_MUTUAL_FRIENDS_PLUGIN_URL . 'assets/css/bp-mutual-friends.css', array(), BP_MUTUAL_FRIENDS_VERSION );

		wp_register_script( 'jquery.magnific-popup', BP_MUTUAL_FRIENDS_PLUGIN_URL . 'assets/js/jquery-magnific-popup' . $suffix . '.js', array( 'jquery' ), BP_MUTUAL_FRIENDS_VERSION );
		wp_enqueue_script( 'mutual-friends', BP_MUTUAL_FRIENDS_PLUGIN_URL . 'assets/js/bp-mutual-friends' . $suffix . '.js', array(
			'jquery',
			'jquery.magnific-popup'
		), BP_MUTUAL_FRIENDS_VERSION );
	}
}

add_action( 'bp_before_members_loop', 'bmf_mutual_friends_add_js' );
add_action( 'bp_before_member_friend_requests_content', 'bmf_mutual_friends_add_js' );
