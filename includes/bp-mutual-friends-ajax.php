<?php
/***
 * You can hook in ajax functions in WordPress/BuddyPress by using the 'wp_ajax' action.
 *
 * When you post your ajax call from javascript using jQuery, you can define the action
 * which will determin which function to run in your PHP component code.
 */

/**
 * HTML markup for mutual friend dialog box
 */
function bmf_mutual_friends_dialog() {
	bmf_get_template_part( 'friends', 'loop-dialog' );
	exit;
}

add_action( 'wp_ajax_bmf_mutual_friends_dialog', 'bmf_mutual_friends_dialog' );

/**
 * HTML markup for friend dialog box
 */
function bmf_friends_dialog() {
	bmf_get_template_part( 'friends', 'loop-dialog' );
	exit;
}

add_action( 'wp_ajax_bmf_friends_dialog', 'bmf_friends_dialog' );
