<?php
/**
* @package NspAdhesion
*/
/*
Plugin Name: NSP Adhesion
Plugin URI: http://ninapresoyyo.com
Description: Dev Plugin
Version: 1.0
Author: Nina Presotto
Author URI: http://ninapresotto.com
License: GPLv2 or later
Text Domain: nsp-adhesion
*/


// If this file is called firectly, abort!!!
defined('ABSPATH') or die('Intrusion attempt');


// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}




/**
 * The code that runs during plugin activation
 */
function activate_nsp_plugin() {
	Inc\Base\Activate::activate();
}

/**
 * The code that runs during plugin deactivation
 */
function deactivate_nsp_plugin() {
	Inc\Base\Deactivate::deactivate();
}

register_activation_hook( __FILE__, 'activate_nsp_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_nsp_plugin' );


if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::register_services();
}