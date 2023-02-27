<?php

/**
 * The plugin bootstrap file
 *
 *
 *
 * Plugin Name:       DMN8 Location Geo
 * Plugin URI:        https://salvonow.com/
 * Description:       This is a Location plugin built by DMN8 Partners.
 * Version:           2.0.5
 * Author:            DMN8 Partners
 * Author URI:        https://salvonow.com/
 * License:           GPL-2.0
 * Text Domain:       location-geo
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( ! defined( 'WP_AUTO_UPDATE_CORE' ) ) {
    define( 'WP_AUTO_UPDATE_CORE', true );
}

/**
 *plugin version.
 */
define( 'LOCATION_GEO_VERSION', '2.0.5' );
/**
 * Plugin activator function
 */
function activate_LOCATION_GEO() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-location-geo-activator.php';
	LOCATION_GEO_Activator::activate();
}

/**
 *Plugin deactivator function
 */
function deactivate_LOCATION_GEO() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-location-geo-deactivator.php';
	LOCATION_GEO_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_LOCATION_GEO' );
register_deactivation_hook( __FILE__, 'deactivate_LOCATION_GEO' );

require plugin_dir_path( __FILE__ ) . 'includes/class-location-geo.php';
//require plugin_dir_path( __FILE__ ) . 'includes/class-location-geo-updater.php';

/**
 * Start plugin's execution.
 *
 */
function run_LOCATION_GEO_max() {

    $main = new LOCATION_GEO();
    $main->max_run();
}
run_LOCATION_GEO_max();
