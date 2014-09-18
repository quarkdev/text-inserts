<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Text_Inserts
 * @author    Roosdoring Inc <roosdoring@hotmail.com>
 * @license   GPL-2.0+
 * @link      http://www.thephysicalaffiliate.com/
 * @copyright 2014 Roosdoring Inc
 *
 * @wordpress-plugin
 * Plugin Name:       Text Inserts
 * Plugin URI:       
 * Description:       Simplifies ad-code or text insertions by making it possible to add content/hook text inserts via the plugin settings panel.
 * Version:           1.0.0
 * Author:            Roosdoring Inc
 * Author URI:        http://www.thephysicalaffiliate.com/
 * Text Domain:       text-inserts
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/quarkdev/text-inserts
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-text-inserts.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-text-inserts.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace Text_Inserts with the name of the class defined in
 *   `class-text-inserts.php`
 */
register_activation_hook( __FILE__, array( 'Text_Inserts', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Text_Inserts', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace Text_Inserts with the name of the class defined in
 *   `class-text-inserts.php`
 */
add_action( 'plugins_loaded', array( 'Text_Inserts', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-text-inserts-admin.php` with the name of the plugin's admin file
 * - replace Text_Inserts_Admin with the name of the class defined in
 *   `class-text-inserts-admin.php`
 *
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
