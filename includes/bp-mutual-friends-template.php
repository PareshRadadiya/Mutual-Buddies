<?php
/**
 * Is this page part of the Example component?
 *
 * Having a special function just for this purpose makes our code more readable elsewhere, and also
 * allows us to place filter 'bp_is_example_component' for other components to interact with.
 *
 * @package BuddyPress_Mutual_Friends_Component
 * @since 1.0
 *
 * @uses bp_is_current_component()
 * @uses apply_filters() to allow this value to be filtered
 * @return bool True if it's the example component, false otherwise
 */
function bp_is_mutual_friends_component() {
	$is_mutual_friends_component = bp_is_current_component( BP_MUTUAL_FRIENDS_SLUG );

	return apply_filters( 'bp_is_mutual_friends_component', $is_mutual_friends_component );
}