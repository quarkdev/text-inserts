<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Text_Inserts
 * @author    Roosdoring Inc <roosdoring@hotmail.com>
 * @license   GPL-2.0+
 * @link      http://www.thephysicalaffiliate.com/
 * @copyright 2014 Roosdoring Inc
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// 1. remove database entries
delete_option( 'txtins_hook_boxes' );
delete_option( 'txtins_content_boxes' );
delete_option( 'txi_vc_cached' );

// for multisite
delete_site_option( 'txtins_hook_boxes' );
delete_site_option( 'txtins_content_boxes' );
delete_site_option( 'txi_vc_cached' );
