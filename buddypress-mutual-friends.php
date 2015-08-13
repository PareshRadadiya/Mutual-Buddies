<?php
/**
 * Plugin Name: Mutual Buddies
 * Description: Display a list of mutual friends on a buddypress member’s profile and member list page similar to facebook
 * Author: Paresh Radadiya
 * Author URI: https://about.me/paresh.radadiya
 * Version: 1.6
 * Text Domain: bmf
 * Domain Path: /i18n/languages/
 * Requires at least: 4.1
 */

// Define a constant that can be checked to see if the component is installed or not.
define( 'BP_MUTUAL_FRIENDS_IS_INSTALLED', 1 );
// Define a constant that will hold the current version number of the component
// This can be useful if you need to run update scripts or do compatibility checks in the future
define( 'BP_MUTUAL_FRIENDS_VERSION', '1.6' );
// Define a constant that we can use to construct file paths throughout the component
define( 'BP_MUTUAL_FRIENDS_PLUGIN_DIR', dirname( __FILE__ ) );
// Define a constant that we can use to construct file paths throughout the component
define( 'BP_MUTUAL_FRIENDS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Plugin Root File
if ( ! defined( 'BP_MUTUAL_FRIENDS_PLUGIN_FILE' ) ) {
	define( 'BP_MUTUAL_FRIENDS_PLUGIN_FILE', __FILE__ );
}

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


/**
 * Loads the plugin language files
 *
 * @since 1.6
 * @return void
 */
function bmf_load_textdomain() {

	// Set filter for plugin's languages directory
	$bmf_lang_dir = dirname( plugin_basename( BP_MUTUAL_FRIENDS_PLUGIN_FILE ) ) . '/i18n/languages/';
	$bmf_lang_dir = apply_filters( 'bmf_languages_directory', $bmf_lang_dir );

	// Traditional WordPress plugin locale filter
	$locale = apply_filters( 'plugin_locale', get_locale(), 'bmf' );
	$mofile = sprintf( '%1$s-%2$s.mo', 'bmf', $locale );

	// Setup paths to current locale file
	$mofile_local  = $bmf_lang_dir . $mofile;
	$mofile_global = WP_LANG_DIR . '/bmf/' . $mofile;

	if ( file_exists( $mofile_global ) ) {
		// Look in global /wp-content/languages/bmf folder
		load_textdomain( 'bmf', $mofile_global );
	} elseif ( file_exists( $mofile_local ) ) {
		// Look in local /wp-content/plugins/mutual-buddies/i18n/languages/ folder
		load_textdomain( 'bmf', $mofile_local );
	} else {
		// Load the default language files
		load_plugin_textdomain( 'bmf', false, $bmf_lang_dir );
	}
}

add_action( 'plugins_loaded', 'bmf_load_textdomain' );