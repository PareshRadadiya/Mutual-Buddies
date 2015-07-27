<?php
/**
 * Plugin Name: Buddypress Mutual Friends
 * Description:
 * Author: Paresh
 * Version: 1.0
 * Text Domain: bmf
 * Domain Path: languages
 */

// Define a constant that can be checked to see if the component is installed or not.
define( 'BP_MUTUAL_FRIENDS_IS_INSTALLED', 1 );
// Define a constant that will hold the current version number of the component
// This can be useful if you need to run update scripts or do compatibility checks in the future
define( 'BP_MUTUAL_FRIENDS_VERSION', '1.0' );
// Define a constant that we can use to construct file paths throughout the component
define( 'BP_MUTUAL_FRIENDS_PLUGIN_DIR', dirname( __FILE__ ) );
/* Define a constant that will hold the database version number that can be used for upgrading the DB
 *
 * NOTE: When table defintions change and you need to upgrade,
 * make sure that you increment this constant so that it runs the install function again.
 *
 * Also, if you have errors when testing the component for the first time, make sure that you check to
 * see if the table(s) got created. If not, you'll most likely need to increment this constant as
 * BP_MUTUAL_FRIENDS_DB_VERSION was written to the wp_usermeta table and the install function will not be
 * triggered again unless you increment the version to a number higher than stored in the meta data.
 */
define ( 'BP_MUTUAL_FRIENDS_DB_VERSION', '1' );
/* Only load the component if BuddyPress is loaded and initialized. */
function bp_mutual_friends_init() {
    // Because our loader file uses BP_Component, it requires BP 1.5 or greater.
    if ( version_compare( BP_VERSION, '1.3', '>' ) )
        require( BP_MUTUAL_FRIENDS_PLUGIN_DIR . '/includes/bp-mutual-friends-loader.php' );
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