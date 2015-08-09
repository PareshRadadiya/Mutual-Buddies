<?php
/**
 * Plugin Name: Mutual Buddies
 * Description: Display a list of mutual friends on a buddypress member’s profile and member list page similar to facebook
 * Author: Paresh Radadiya
 * Author URI: https://about.me/paresh.radadiya
 * Version: 1.4
 * Text Domain: bmf
 * Domain Path: languages
 * Requires at least: 4.1
 */

// Define a constant that can be checked to see if the component is installed or not.
define( 'BP_MUTUAL_FRIENDS_IS_INSTALLED', 1 );
// Define a constant that will hold the current version number of the component
// This can be useful if you need to run update scripts or do compatibility checks in the future
define( 'BP_MUTUAL_FRIENDS_VERSION', '1.4' );
// Define a constant that we can use to construct file paths throughout the component
define( 'BP_MUTUAL_FRIENDS_PLUGIN_DIR', dirname( __FILE__ ) );
// Define a constant that we can use to construct file paths throughout the component
define( 'BP_MUTUAL_FRIENDS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/* Only load the component if BuddyPress is loaded and initialized. */
function bp_mutual_friends_init() {
	// Because our loader file uses BP_Component, it requires BP 1.5 or greater.
	if ( version_compare( BP_VERSION, '1.3', '>' ) && bp_is_active( 'friends' ) ) {
		require( BP_MUTUAL_FRIENDS_PLUGIN_DIR . '/includes/bp-mutual-friends-loader.php' );
	}
}

add_action( 'bp_include', 'bp_mutual_friends_init' );
/* Put setup procedures to be run when the plugin is activated in the following function */
function bp_mutual_friends_activate() {
}

register_activation_hook( __FILE__, 'bp_mutual_friends_activate' );
/* On deacativation, clean up anything your component has added. */
function bp_mutual_friends_deactivate() {
	/* You might want to delete any options or tables that your component created. */
}

register_deactivation_hook( __FILE__, 'bp_mutual_friends_deactivate' );