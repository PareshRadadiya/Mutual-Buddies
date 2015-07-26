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

		add_action( 'bp_setup_nav', array( __CLASS__, 'my_test_setup_nav' ) );
	}


	/**
	 * Bp Navs
	 * @Since v2.1
	 * @returns void
	 */
	public static function my_test_setup_nav() {
		global $bp;

		// Determine user to use
		if ( bp_displayed_user_domain() ) {
			$user_domain = bp_displayed_user_domain();
		} elseif ( bp_loggedin_user_domain() ) {
			$user_domain = bp_loggedin_user_domain();
		} else {
			return;
		}

		$slug         = bp_get_friends_slug();
		$friends_link = trailingslashit( $user_domain . $slug );

		/* Add 'Send Social Invites' to the main user profile navigation */
		bp_core_new_subnav_item( array(
			'name' => __( 'Mutual Friends', 'bmf' ),
			'slug' => 'mutual-friends',
			'parent_slug' => $slug,
			'parent_url' => $friends_link,
			'screen_function' => array( __CLASS__, 'bmf_screen_one' ),
			'show_for_displayed_user' => self::access_test()
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
	public static  function screen_one_content() { ?>

	<?php
	}
}

BMF::init();
