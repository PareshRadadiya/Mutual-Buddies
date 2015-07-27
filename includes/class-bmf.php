<?php

/**
 * Class that handle all Buddypress hooks
 *
 * @since      2.5.0
 * @package    Wsi
 * @subpackage Wsi/includes
 * @author     Damian Logghe <info@timersys.com>
 */

class BMF {

	/**
	 * Hook in methods.
	 */
	public static function init() {

		add_action( 'bp_friends_setup_nav', array( __CLASS__, 'my_test_setup_nav' )  );

	}


	/**
	 * Bp Navs
	 * @Since v2.1
	 * @returns void
	 */
	public static function my_test_setup_nav() {
		global $bp;

		if( bp_displayed_user_id() === 0 )
			return;

		// Determine user to use
		if ( bp_displayed_user_domain() ) {
			$user_domain = bp_displayed_user_domain();
		}

		$slug         = bp_get_friends_slug();
		$friends_link = trailingslashit( $user_domain . $slug );

		/* Add 'Send Social Invites' to the main user profile navigation */
		bp_core_new_subnav_item( array(
			'name' => __( 'Mutual Friends', 'bmf' ),
			'slug' => 'mutual-friends',
			'parent_url' => $friends_link,
			'parent_slug' => $slug,
			'screen_function' => array( __CLASS__, 'bmf_screen_one' ),
		) );

	}
	/**
	 * Bp access test check wheter to show or not bp screen
	 * @Since v2.1
	 * @returns bool
	 */
	public static function access_test() {

		if ( !is_user_logged_in() )
			return false;

		// The site admin can see all
		if ( current_user_can( 'bp_moderate' ) ) {
			return true;
		}

		if ( bp_displayed_user_id() && !bp_is_my_profile() )
			return false;

		return true;

	}

	/**
	 * Bp Screen one function to load screen content
	 * @Since v2.1
	 * @returns void
	 */
	public static function bmf_screen_one() {

		/* Add a do action here, so your component can be extended by others. */
		do_action( 'bmf/bp/screen_one' );

		add_action( 'bp_template_content', array( __CLASS__, 'screen_one_content' ) );

		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	/**
	 * Bp screen content
	 * @Since v2.1
	 * @returns void
	 */
	public static  function screen_one_content() {
		bp_get_template_part( 'members/members-loop' );
	}
}

BMF::init();


function my_profile( $my_profile ) {

	if( bp_is_current_component( 'friends' ) ) {
		$my_profile = true;
	}

	return $my_profile;
}
add_filter('bp_is_my_profile', 'my_profile');

function bmf_get_unmutual_friends() {

	$current_user_friends = friends_get_friend_user_ids( get_current_user_id() );
	$displayed_user_friends = friends_get_friend_user_ids( bp_displayed_user_id() );

	$result = array_merge(array_diff($current_user_friends, $displayed_user_friends), array_diff($displayed_user_friends, $current_user_friends));

	return $result;
}
