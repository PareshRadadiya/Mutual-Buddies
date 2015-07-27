<?php
/**
 * BuddyPress Friends Streams Loader
 *
 * The mutual-friends component is for users to create relationships with each other.
 *
 * @package BuddyPress
 * @subpackage Friends
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

class BP_Mutual_Friends_Component extends BP_Component {

	/**
	 * Start the mutual-friends component creation process.
	 *
	 * @since BuddyPress (1.0)
	 */
	public function __construct() {
		global $bp;

		parent::start(
			'mutual-friends',
			_x( 'Mutual Friend Connections', 'Friends screen page <title>', 'buddypress' ),
			BP_MUTUAL_FRIENDS_PLUGIN_DIR
		);

		/**
		 * BuddyPress-dependent plugins are loaded too late to depend on BP_Component's
		 * hooks, so we must call the function directly.
		 */
		$this->includes();

		/**
		 * Put your component into the active components array, so that
		 *   bp_is_active( 'example' );
		 * returns true when appropriate. We have to do this manually, because non-core
		 * components are not saved as active components in the database.
		 */
		$bp->active_components[$this->id] = '1';

	}

	/**
	 * Include bp-mutual-friends files.
	 *
	 * @see BP_Component::includes() for description of parameters.
	 *
	 * @param array $includes See {@link BP_Component::includes()}.
	 */
	public function includes( $includes = array() ) {
		$includes = array(
			'includes/bp-mutual-friends-screens.php',
			'includes/bp-mutual-friends-filters.php',
			'includes/bp-mutual-friends-template.php',
			'includes/bp-mutual-friends-functions.php',
		);

		parent::includes( $includes );
	}

	/**
	 * Set up bp-mutual-friends global settings.
	 *
	 * The BP_MUTUAL_FRIENDS constant is deprecated, and only used here for
	 * backwards compatibility.
	 *
	 * @since BuddyPress (1.5.0)
	 *
	 * @see BP_Component::setup_globals() for description of parameters.
	 *
	 * @param array $args See {@link BP_Component::setup_globals()}.
	 */
	public function setup_globals( $args = array() ) {

		// Define a slug, if necessary
		if ( ! defined( 'BP_MUTUAL_FRIENDS_SLUG' ) ) {
			define( 'BP_MUTUAL_FRIENDS_SLUG', $this->id );
		}

		parent::setup_globals( $args );
	}

	/**
	 * Set up component navigation.
	 *
	 * @since BuddyPress (1.5.0)
	 *
	 * @see BP_Component::setup_nav() for a description of arguments.
	 *
	 * @param array $main_nav Optional. See BP_Component::setup_nav() for
	 *        description.
	 * @param array $sub_nav Optional. See BP_Component::setup_nav() for
	 *        description.
	 */
	public function setup_nav( $main_nav = array(), $sub_nav = array() ) {

		if( bp_displayed_user_id() === 0 )
			return;

		// Determine user to use
		if ( bp_displayed_user_domain() ) {
			$user_domain = bp_displayed_user_domain();
		}

		$mutual_friends_link = trailingslashit( $user_domain . BP_MUTUAL_FRIENDS_SLUG );

		// Add 'Friends' to the main navigation
		$main_nav = array(
			'name'                => sprintf( __( 'Mutual Friends', 'buddypress' ) ),
			'slug'                => BP_MUTUAL_FRIENDS_SLUG,
			'position'            => 65,
			'screen_function'     => 'bp_mutual_friends_screen',
			'default_subnav_slug' => 'my-mutual-friends'
		);

		// Add the subnav items to the mutual-friends nav item
		$sub_nav[] = array(
			'name'            => _x( 'Mutual Friends', 'Friends screen sub nav', 'buddypress' ),
			'slug'            => 'my-mutual-friends',
			'parent_url'      => $mutual_friends_link,
			'parent_slug'     => BP_MUTUAL_FRIENDS_SLUG,
			'screen_function' => 'bp_my_mutual_friends_screen',
			'position'        => 10
		);

		parent::setup_nav( $main_nav, $sub_nav );
	}

}

/**
 * Set up the bp-forums component.
 */
function bp_mutual_friends_load_core_component() {
	global $bp;
	$bp->mutual_friends = new BP_Mutual_Friends_Component;
}
add_action( 'bp_loaded', 'bp_mutual_friends_load_core_component' );