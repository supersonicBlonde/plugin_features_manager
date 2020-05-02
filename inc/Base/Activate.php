<?php
/**
* @package NspAdhesion
 */
namespace Inc\Base;

class Activate
{
	public static function activate() {
		flush_rewrite_rules();

		$default = array();

		if ( ! get_option( 'nsp_subscription' ) ) {
			update_option( 'nsp_subscription', $default );
		}

		if ( ! get_option( 'nsp_plugin_cpt' ) ) {
			update_option( 'nsp_plugin_cpt', $default );
		}

		if ( ! get_option( 'alecaddd_plugin_tax' ) ) {
			update_option( 'alecaddd_plugin_tax', $default );
		}
	}
}