<?php

/********************************************************************************
 * Screen Functions
 *
 * Screen functions are the controllers of BuddyPress. They will execute when their
 * specific URL is caught. They will first save or manipulate data using business
 * functions, then pass on the user to a template file.
 */

/**
 * If your component uses a top-level directory, this function will catch the requests and load
 * the index page.
 *
 * @package BuddyPress_Template_Pack
 * @since 1.0
 */

/**
 * If your component uses a top-level directory, this function will catch the requests and load
 * the index page.
 *
 * @package BuddyPress_Template_Pack
 * @since 1.0
 */
function bp_mutual_friends_directory_setup() {
    if ( bp_is_mutual_friends_component() && !bp_current_action() && !bp_current_item() ) {
        // This wrapper function sets the $bp->is_directory flag to true, which help other
        // content to display content properly on your directory.
        bp_update_is_directory( true, 'mutual-friends' );
        // Add an action so that plugins can add content or modify behavior
        do_action( 'bp_mutual_friends_directory_setup' );
        bp_core_load_template( apply_filters( 'mutual_friends_directory_template', 'members/single/plugins' ) );
    }
}
add_action( 'bp_screens', 'bp_mutual_friends_directory_setup' );



/**
 *
 * Sets up and displays the screen output for the sub nav item Mutual Friends
 */
function bp_mutual_friends_screen() {
    bp_get_template_part( 'members/members-loop' );
}
