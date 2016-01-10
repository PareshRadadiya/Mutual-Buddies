<?php
/**
 * Fetch an array of users mutual friends.
 *
 * @param $retval
 *
 * @return mixed
 */
function bmf_mutual_friends_user_filter( $arg ) {

	if ( defined( 'DOING_AJAX' ) && isset( $_REQUEST['user_id'] ) ) {

		if ( 'bmf_mutual_friends_dialog' === $_REQUEST['action'] ) {

			/**
			 * Exclude all common friends
			 */
			$arg['exclude'] = bmf_uncommon_friends( intval( $_REQUEST['user_id'] ) );
			$arg['user_id'] = get_current_user_id();
		} else if ( 'bmf_friends_dialog' === $_REQUEST['action'] ) {

			/**
			 * Show friends if mutual friends count is 0
			 */
			$arg['user_id'] = $_REQUEST['user_id'];
		}

	} else if ( bp_is_mutual_friends_component() ) {

		$arg['exclude'] = bmf_uncommon_friends();
		$arg['user_id'] = get_current_user_id();
	}


	return $arg;
}

add_filter( 'bp_after_core_get_users_parse_args', 'bmf_mutual_friends_user_filter' );


/**
 * Get the unmutual friends of the current user
 * @since 1.0
 *
 * @params int $friend_user_id Friends id
 *
 * @return mixed|void
 */
function bmf_uncommon_friends( $friend_user_id = '' ) {

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

	return apply_filters( 'bmf_uncommon_friends', $result );
}

/**
 * Get the mutual friend count for the current user.
 *
 * @params $friend_user_id int
 *
 * @return mixed|void
 */
function bmf_mutual_friend_total_count( $friend_user_id = 0 ) {

	$current_user_friends = friends_get_friend_user_ids( get_current_user_id() );

	if ( empty( $friend_user_id ) ) {
		$friend_user_id = bp_displayed_user_id();
	}

	$displayed_user_friends = friends_get_friend_user_ids( $friend_user_id );

	$result = count( array_intersect( $current_user_friends, $displayed_user_friends ) );

	return apply_filters( 'bmf_mutual_friend_total_count', $result );
}

/**
 * Output mutual friends counts for the current member in the loop.
 *
 * @since 1.3
 *
 * @param string $last_activity Formatted time since last activity.
 * @param array $r Array of parsed arguments for query.
 *
 * @return string $last_activity Formatted html
 */
function bmf_member_loop_show_total_count( $last_activity, $r ) {

	$bmf_show_total_mutual_friend_count = apply_filters( 'bmf_member_loop_show_total_count', true );

	if ( ! $bmf_show_total_mutual_friend_count ) {
		return $last_activity;
	}

	$mutual_friends_link = bmf_get_total_mutual_friend_count();

	return $last_activity . apply_filters( 'bmf_member_loop_total_count', $mutual_friends_link );
}

add_filter( 'bp_member_last_active', 'bmf_member_loop_show_total_count', 10, 2 );

/**
 * Return mutual friends counts for the current member in the loop.
 *
 * @since 1.5
 *
 *
 * @param array $classes Array of custom classes
 *
 * @return string Row class of the member
 */
function bmf_get_total_mutual_friend_count() {
	global $members_template;

	if ( ! is_user_logged_in() ) {
		return;
	}

	if ( get_current_user_id() == $members_template->member->ID ) {
		return;
	}

	$user_domain               = bp_core_get_user_domain( $members_template->member->ID );
	$mutual_friends_link       = '';
	$mutual_friends_count      = bmf_mutual_friend_total_count( $members_template->member->ID );
	$show_mutual_friends_count = apply_filters( 'bmf_show_mutual_friend_count', true );

	if ( $show_mutual_friends_count && 0 < absint( $mutual_friends_count ) ) {

		$mutual_friends_link = trailingslashit( $user_domain . bmf_get_mutual_friends_slug() );

		$mutual_friends_link = '<a href="' . $mutual_friends_link . '" data-action="bmf_mutual_friends_dialog" data-effect="mfp-zoom-in" data-user-id="' . $members_template->member->ID . '"
		   class="mutual-friends">
			' . sprintf( _n( '%s mutual friend', '%s mutual friends', $mutual_friends_count, 'mutual-buddies' ), $mutual_friends_count ) . '
		</a>';
	} else {

		$friends_count = $members_template->member->total_friend_count;

		$show_friends_count = apply_filters( 'bmf_show_friend_count', true );

		if ( 0 < $friends_count && $show_friends_count ) {

			$friends_link = trailingslashit( $user_domain . bp_get_friends_slug() );

			$mutual_friends_link = '<a href="' . $friends_link . '" data-action="bmf_friends_dialog" data-effect="mfp-zoom-in" data-user-id="' . $members_template->member->ID . '"
		   class="mutual-friends">
			' . sprintf( _n( '%s friend', '%s friends', $friends_count, 'mutual-buddies' ), $friends_count ) . '
		</a>';
		}

	}

	return apply_filters( 'bmf_get_total_mutual_friend_count', $mutual_friends_link );
}

/**
 * Remove the last update content from mutual friends popup for the current member in the loop
 *
 * @since 1.3
 *
 * @param string $update_content Formatted latest update for current member.
 *
 * @return string empty markup
 */
function bmf_hide_member_latest_update( $update_content ) {
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

add_filter( 'bp_get_member_latest_update', 'bmf_hide_member_latest_update', 10, 1 );

/**
 * Return the mutual friends component slug.
 *
 * @since 1.6
 */
function bmf_get_mutual_friends_slug() {
	global $bp;

	/**
	 * Filters the mutual friends component slug.
	 *
	 * @since 1.6
	 *
	 * @param string $value Mutual Friends component slug.
	 */

	return apply_filters( 'bmf_get_mutual_friends_slug', $bp->mutual_friends->slug );
}
