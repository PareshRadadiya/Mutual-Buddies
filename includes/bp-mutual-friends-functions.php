<?php

/**
 * Fetch an array of users mutual friends.
 * @param $retval
 * @return mixed
 */
function bp_mutual_friends_user_filter( $retval ) {

    if( bp_is_mutual_friends_component() ) {
        $retval['exclude'] = bp_uncommon_friends();
    }

    return $retval;
}
add_filter( 'bp_after_core_get_users_parse_args', 'bp_mutual_friends_user_filter' );


function bp_uncommon_friends() {

    $current_user_friends = friends_get_friend_user_ids( get_current_user_id() );
    $displayed_user_friends = friends_get_friend_user_ids( bp_displayed_user_id() );

    $result = array_merge(array_diff($current_user_friends, $displayed_user_friends), array_diff($displayed_user_friends, $current_user_friends));

    return $result;
}

