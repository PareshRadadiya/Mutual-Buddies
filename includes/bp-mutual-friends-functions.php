<?php
/**
 * Fetch an array of users mutual friends.
 *
 * @param $retval
 *
 * @return mixed
 */
function bp_mutual_friends_user_filter( $arg ) {

	if ( defined( 'DOING_AJAX' ) && isset( $_REQUEST['user_id'] ) ) {

		if ( 'bmf_mutual_friends_dialog' === $_REQUEST['action'] ) {

			/**
			 * Exclude all common friends
			 */
			$arg['exclude'] = bp_uncommon_friends( intval( $_REQUEST['user_id'] ) );
			$arg['user_id'] = get_current_user_id();
		} else if ( 'bmf_friends_dialog' === $_REQUEST['action'] ) {

			/**
			 * Show friends if mutual friends count is 0
			 */
			$arg['user_id'] = $_REQUEST['user_id'];
		}

	} else if ( bp_is_mutual_friends_component() ) {

		$arg['exclude'] = bp_uncommon_friends();
		$arg['user_id'] = get_current_user_id();
	}


	return $arg;
}

add_filter( 'bp_after_core_get_users_parse_args', 'bp_mutual_friends_user_filter' );


/**
 * Get the unmutual friends of the current user
 * @since 1.0
 *
 * @params int $friend_user_id Friends id
 *
 * @return mixed|void
 */
function bp_uncommon_friends( $friend_user_id = '' ) {

	$result = array();

	$current_user_friends = friends_get_friend_user_ids( get_current_user_id() );


	if ( empty( $friend_user_id ) ) {

		$friend_user_id = bp_displayed_user_id();
	}

	$displayed_user_friends = friends_get_friend_user_ids( $friend_user_id );

	$current_user_friends_requested   = friends_get_friend_user_ids( get_current_user_id(), true );
	$displayed_user_friends_requested = friends_get_friend_user_ids( $friend_user_id, true );

	$result = array_merge( array_diff( $current_user_friends, $displayed_user_friends ), array_diff( $displayed_user_friends, $current_user_friends ) );

	$result = array_merge( $current_user_friends_requested, $displayed_user_friends_requested, $result );

	return apply_filters( 'bp_uncommon_friends', $result );
}

/**
 * Get the mutual friend count of a current user.
 *
 * @params $friend_user_id int
 *
 * @return mixed|void
 */
function bp_mutual_friend_total_count( $friend_user_id = 0 ) {

	$current_user_friends = friends_get_friend_user_ids( get_current_user_id() );

	if ( empty( $friend_user_id ) ) {
		$friend_user_id = bp_displayed_user_id();
	}

	$displayed_user_friends = friends_get_friend_user_ids( $friend_user_id );

	$result = count( array_intersect( $current_user_friends, $displayed_user_friends ) );

	return apply_filters( 'bp_mutual_friend_total_count', $result );
}

/**
 * Filters append the mutual friends counts html.
 *
 * @since 1.3
 *
 * @param string $last_activity Formatted time since last activity.
 * @param array $r Array of parsed arguments for query.
 *
 * @return string $last_activity Formatted html
 */
function bp_directory_mutual_friends_count( $last_activity, $r ) {
	global $members_template;

	if ( ! is_user_logged_in() ) {
		return;
	}

	$mutual_friends_count = bp_mutual_friend_total_count( $members_template->member->ID );

	if ( get_current_user_id() == $members_template->member->ID ) {
		return;
	}

	if ( 0 < absint( $mutual_friends_count ) ) {

		$mutual_friends_link = '<a href="" data-action="bmf_mutual_friends_dialog" data-effect="mfp-zoom-in" data-user-id="' . $members_template->member->ID . '"
		   class="mutual-friends">
			' . sprintf( _n( '%s mutual friend', '%s mutual friends', $mutual_friends_count, 'bmf' ), $mutual_friends_count ) . '
		</a>';
	} else {

		$friends_count = friends_get_total_friend_count( $members_template->member->ID );

		$mutual_friends_link = '<a href="" data-action="bmf_friends_dialog" data-effect="mfp-zoom-in" data-user-id="' . $members_template->member->ID . '"
		   class="mutual-friends">
			' . sprintf( _n( '%s friend', '%s friends', $friends_count, 'bmf' ), $friends_count ) . '
		</a>';
	}


	return $last_activity . $mutual_friends_link;
}

add_filter( 'bp_member_last_active', 'bp_directory_mutual_friends_count', 10, 2 );

/**
 * Remove the last update content from mutual friends popup
 *
 * @since 1.3
 *
 * @param string $update_content Formatted latest update for current member.
 *
 * @return string empty markup
 */
function bp_hide_member_latest_update( $update_content ) {
	if ( defined( 'DOING_AJAX' ) &&
	     (
		     ( isset( $_REQUEST['user_id'] )
		       && ( 'bmf_mutual_friends_dialog' === $_REQUEST['action']
		            || 'bmf_friends_dialog' === $_REQUEST['action'] ) )
		     || ( isset( $_REQUEST['bmf_dialog'] ) )
	     )
	) {
		$update_content = '';
	}

	return $update_content;
}

add_filter( 'bp_get_member_latest_update', 'bp_hide_member_latest_update', 10, 1 );