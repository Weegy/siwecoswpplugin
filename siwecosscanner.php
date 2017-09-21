<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              byte5.de
 * @since             0.0.1
 * @package           Scanner
 *
 * @wordpress-plugin
 * Plugin Name:       SIWECOS CMS Connector
 * Plugin URI:        siwecos.de
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           0.1.2
 * Author:            SIWECOS
 * Author URI:        byte5.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       scanner
 * Domain Path:       /languages
 */

const VERSION_OPTION = 'siwecos_plugin_version';
const VERSION        = '0.1';

const USER_TOKEN = 'siwecos_user_token';
const USER_NAME = 'siwecos_user_name';

define( 'API_URL', 'https://staging.siwecos.de' ); // Can be changed to loc (Internal Purpose)

require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';

// API Controller
require_once plugin_dir_path( __FILE__ ) . 'includes/apiConnector.php';

// Widgets
require_once plugin_dir_path( __FILE__ ) . 'widgets/dashboard.php';

// Dashboard widget
add_action( 'wp_dashboard_setup', 'siewecos_dasboard' );

// API
require_once plugin_dir_path( __FILE__ ) . 'api/communication.php';


// Scripts Loading
function wptuts_scripts_with_jquery() {
	// Register the script like this for a plugin:
	wp_register_script( 'custom-script', plugins_url( '/js/siwecos_script.js', __FILE__ ), array( 'jquery' ) );
	wp_register_style( 'custom_wp_admin_css', plugins_url('/css/siwecosscanner.css', __FILE__ ), false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );

	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'custom-script' );
}

add_action( 'admin_enqueue_scripts', 'wptuts_scripts_with_jquery' );



add_action( 'rest_api_init', function () {
	$communicator = new Communication();
	$communicator->register_routes();
});