<?php
/**
 * Plugin Name: Buddypress Mutual Friends
 * Description:
 * Author: Paresh
 * Version: 1.0
 * Text Domain: bmf
 * Domain Path: languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Buddypress_Mutual_Friends' ) ) :

/**
 * Main Buddypress_Mutual_Friends Class
 *
 * @since 1.0
 */
final class Buddypress_Mutual_Friends {

    /** Singleton *************************************************************/

    /**
     * @var Buddypress_Mutual_Friends The one true Buddypress_Mutual_Friends
     * @since 1.0
     */
    private static $instance;

    /**
     * Main Easy_Digital_Downloads Instance
     *
     * Insures that only one instance of Budddypress_Grid_Wall exists in memory at any one
     * time. Also prevents needing to define globals all over the place.
     *
     * @since 1.0
     * @static
     * @staticvar array $instance
     * @see BMF()
     * @return The one true Budddypress_Grid_Wall
     */
    public static function instance() {
        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Buddypress_Mutual_Friends ) ) {
            self::$instance = new Buddypress_Mutual_Friends;
            self::$instance->setup_constants();

            self::$instance->includes();
        }
        return self::$instance;
    }


    /**
     * Setup plugin constants
     *
     * @access private
     * @since 1.0
     * @return void
     */
    private function setup_constants() {

        // Plugin version
        if ( ! defined( 'BMF_VERSION' ) ) {
            define( 'BMF_VERSION', '1.0' );
        }

        // Plugin Folder Path
        if ( ! defined( 'BMF_PLUGIN_DIR' ) ) {
            define( 'BMF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        }

        // Plugin Folder URL
        if ( ! defined( 'BMF_PLUGIN_URL' ) ) {
            define( 'BMF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
        }

        // Plugin Root File
        if ( ! defined( 'BMF_PLUGIN_FILE' ) ) {
            define( 'BMF_PLUGIN_FILE', __FILE__ );
        }
    }

    /**
     * Include required files
     *
     * @access private
     * @since 1.0
     * @return void
     */
    private function includes() {

        include_once( 'includes/class-bmf.php' );

        if ( $this->is_request( 'frontend' ) ) {
            $this->frontend_includes();
        }

    }

    /**
     * What type of request is this?
     * string $type ajax, frontend or admin
     * @return bool
     */
    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();
            case 'ajax' :
                return defined( 'DOING_AJAX' );
            case 'cron' :
                return defined( 'DOING_CRON' );
            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }

    /**
     * Include required frontend files.
     */
    public function frontend_includes() {
       // include_once( 'includes/class-bmf-frontend-scripts.php' );
    }
}

endif;

/**
 * The main function responsible for returning the one true Buddypress_Mutual_Friends
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $bmf = BMF(); ?>
 *
 * @since 1.0
 * @return object The one true Buddypress_Mutual_Friends Instance
 */
function BMF() {
    return Buddypress_Mutual_Friends::instance();
}

// Get EDD Running
BMF();
