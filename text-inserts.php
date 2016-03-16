<?php
/**
 * @package   Text_Inserts
 * @author    Roosdoring Inc <roosdoring@hotmail.com>
 * @license   GPL-2.0+
 * @link      http://www.authoritysitesecrets.com/
 * @copyright 2014 Roosdoring Inc
 *
 * @wordpress-plugin
 * Plugin Name:       Text Inserts
 * Plugin URI:       
 * Description:       Simplifies ad-code or text insertions by making it possible to add content/hook text inserts via the plugin settings panel.
 * Version:           1.2.2
 * Author:            Roosdoring Inc
 * Author URI:        http://www.authoritysitesecrets.com/
 * Text Domain:       text-inserts
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * Bitbucket Plugin URI: https://bitbucket.org/sychrissan/text-inserts/
 * Requires WP: 3.5.1
 * Requires PHP: 5.4
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-text-inserts.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'Text_Inserts', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Text_Inserts', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Text_Inserts', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-text-inserts-admin.php' );
	add_action( 'plugins_loaded', array( 'Text_Inserts_Admin', 'get_instance' ) );

}
