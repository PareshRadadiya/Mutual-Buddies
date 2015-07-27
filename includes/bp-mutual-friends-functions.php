<?php

/**
 * Fetch an array of users mutual friends.
 *
 * @param $retval
 *
 * @return mixed
 */
function bp_mutual_friends_user_filter( $arg ) {

	if ( bp_is_mutual_friends_component() ) {
		$arg['exclude']  = bp_uncommon_friends();
		$arg['per_page'] = apply_filters( 'bp_mutual_friends_per_page', 0 );
	}

	return $arg;
}

add_filter( 'bp_after_core_get_users_parse_args', 'bp_mutual_friends_user_filter' );


/**
 * Get the unmutual friends of the current user
 * @since 1.0
 * @return mixed|void
 */
function bp_uncommon_friends() {

	$result = array();

	$current_user_friends   = friends_get_friend_user_ids( get_current_user_id() );
	$displayed_user_friends = friends_get_friend_user_ids( bp_displayed_user_id() );

	$current_user_friends_requested   = friends_get_friend_user_ids( get_current_user_id(), true );
	$displayed_user_friends_requested = friends_get_friend_user_ids( bp_displayed_user_id(), true );

	$result = array_merge( array_diff( $current_user_friends, $displayed_user_friends ), array_diff( $displayed_user_friends, $current_user_friends ) );

	$result = array_merge( $current_user_friends_requested, $displayed_user_friends_requested, $result );

	return apply_filters( 'bp_uncommon_friends', $result );
}

/**
 * Get the mutual friend count of a current user.
 * @return mixed|void
 */
function bp_mutual_friend_total_count() {

	$current_user_friends   = friends_get_friend_user_ids( get_current_user_id() );
	$displayed_user_friends = friends_get_friend_user_ids( bp_displayed_user_id() );

	$result = count( array_intersect( $current_user_friends, $displayed_user_friends ) );

	return apply_filters( 'bp_mutual_friend_total_count', $result );
}


