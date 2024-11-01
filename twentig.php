<?php
/**
 * Plugin Name: Twentig
 * Plugin URI: https://twentig.com
 * Description: With its powerful tools, Twentig makes it easy to create and customize your own website.
 * Author: Twentig.com
 * Author URI: https://twentig.com
 * Version: 1.8.3
 * Text Domain: twentig
 * License: GPLv3 or later
 *
 * @package twentig
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup plugin constants.
 */
define( 'TWENTIG_VERSION', '1.8.3' );
define( 'TWENTIG_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'TWENTIG_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'TWENTIG_ASSETS_URI', TWENTIG_URI . 'dist' );
define( 'TWENTIG_PLUGIN_BASE', plugin_basename( __FILE__ ) );

/**
 * Load the Twentig plugin.
 */
require_once TWENTIG_PATH . 'inc/init.php';

/**
 * Adds a redirect transient during plugin activation.
 *
 * @param bool $network_wide Whether or not the plugin is being network activated.
 */
function twentig_do_activate( $network_wide = false ) {
	// Add transient to trigger redirect to the Welcome screen.
	set_transient( '_twentig_activation_redirect', true, 30 );
}
register_activation_hook( __FILE__, 'twentig_do_activate' );
