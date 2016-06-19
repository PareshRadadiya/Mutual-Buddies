<?php
/**
 * Plugin Name: Mutual Buddies
 * Description: Display a list of mutual friends on a buddypress member’s profile and member list page similar to facebook
 * Author: Paresh Radadiya
 * Author URI: https://about.me/paresh.radadiya
 * Version: 2.0
 * Text Domain: mutual-buddies
 * Domain Path: /i18n/languages/
 * Requires at least: 4.1
 */

// Define a constant that can be checked to see if the component is installed or not.
define( 'BP_MUTUAL_FRIENDS_IS_INSTALLED', 1 );
// Define a constant that will hold the current version number of the component
// This can be useful if you need to run update scripts or do compatibility checks in the future
define( 'BP_MUTUAL_FRIENDS_VERSION', '2.0' );
// Define a constant that we can use to construct file paths throughout the component
define( 'BP_MUTUAL_FRIENDS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
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

	/*
	 * Due to the introduction of language packs through translate.wordpress.org, loading our textdomain is complex.
	 *
	 * In v1.7, our textdomain changed from "bmf" to "mutual-buddies".
	 *
	 * To support existing translation files from before the change, we must look for translation files in several places and under several names.
	 *
	 * - wp-content/languages/plugins/mutual-buddies (introduced with language packs)
	 * - wp-content/languages/bmf/ (custom folder we have supported since 1.4)
	 * - wp-content/plugins/mutual-buddies/languages/
	 *
	 * In wp-content/languages/bmf/ we must look for "mutual-buddies-{lang}_{country}.mo"
	 * In wp-content/languages/bmf/ we must look for "bmf-{lang}_{country}.mo" as that was the old file naming convention
	 * In wp-content/languages/plugins/mutual-buddies/ we only need to look for "mutual-buddies-{lang}_{country}.mo" as that is the new structure
	 * In wp-content/plugins/mutual-buddies/languages/, we must look for both naming conventions. This is done by filtering "load_textdomain_mofile"
	 *
	 */

	add_filter( 'load_textdomain_mofile',  'load_old_textdomain', 10, 2 );

	// Set filter for plugin's languages directory.
	$bmf_lang_dir  = dirname( plugin_basename( BP_MUTUAL_FRIENDS_PLUGIN_FILE ) ) . '/i18n/languages/';
	$bmf_lang_dir  = apply_filters( 'bmf_languages_directory', $bmf_lang_dir );

	// Traditional WordPress plugin lo/members/admin/friends/cale filter.
	$locale        = apply_filters( 'plugin_locale',  get_locale(), 'mutual-buddies' );
	$mofile        = sprintf( '%1$s-%2$s.mo', 'mutual-buddies', $locale );

	// Look for wp-content/languages/bmf/mutual-buddies-{lang}_{country}.mo
	$mofile_global1 = WP_LANG_DIR . '/bmf/mutual-buddies-' . $locale . '.mo';

	// Look for wp-content/languages/bmf/bmf-{lang}_{country}.mo
	$mofile_global2 = WP_LANG_DIR . '/bmf/bmf-' . $locale . '.mo';

	// Look in wp-content/languages/plugins/mutual-buddies
	$mofile_global3 = WP_LANG_DIR . '/plugins/mutual-buddies/' . $mofile;

	if ( file_exists( $mofile_global1 ) ) {

		load_textdomain( 'mutual-buddies', $mofile_global1 );

	} elseif ( file_exists( $mofile_global2 ) ) {

		load_textdomain( 'mutual-buddies', $mofile_global2 );

	} elseif ( file_exists( $mofile_global3 ) ) {

		load_textdomain( 'mutual-buddies', $mofile_global3 );

	} else {

		// Load the default language files.
		load_plugin_textdomain( 'mutual-buddies', false, $bmf_lang_dir );
	}
}

add_action( 'plugins_loaded', 'bmf_load_textdomain' );

/**
 * Load a .mo file for the old textdomain if one exists.
 *
 * h/t: https://github.com/10up/grunt-wp-plugin/issues/21#issuecomment-62003284
 */
function load_old_textdomain( $mofile, $textdomain ) {

	if ( $textdomain === 'mutual-buddies' && ! file_exists( $mofile ) ) {
		$mofile = dirname( $mofile ) . DIRECTORY_SEPARATOR . str_replace( $textdomain, 'bmf', basename( $mofile ) );
	}

	return $mofile;
}
