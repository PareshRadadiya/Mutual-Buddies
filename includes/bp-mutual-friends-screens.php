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
function bp_mutual_friends_screen() {

    if( bp_is_mutual_friends_component() ) {
        /**
         * Fires before the loading of template for the My Friends page.
         *
         * @since BuddyPress (1.0.0)
         */

        do_action('friends_screen_my_friends');

        /**
         * Filters the template used to display the My Friends page.
         *
         * @since BuddyPress (1.0.0)
         *
         * @param string $template Path to the my friends template to load.
         */
        bp_core_load_template(apply_filters('friends_template_my_friends', 'members/single/home'));
    }
}

add_action( 'bp_screens', 'bp_mutual_friends_screen'  );
/**
 *
 * Sets up and displays the screen output for the sub nav item Mutual Friends
 */
function bp_my_mutual_friends_screen() {

    add_action( 'bp_template_content',   'bp_mutual_friends_template_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/friends' ) );
}

function bp_mutual_friends_template_content() {
    include_once('templates/mutual-friends/mutual-friends-loop.php');
}