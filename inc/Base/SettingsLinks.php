<?php
/**
* @package NspAdhesion
*/

namespace Inc\Base;

use \Inc\Base\BaseController;

class SettingsLinks extends BaseController {
	
	public function register() {

		add_filter( 'plugin_action_links_' . $this->plugin_basename , array( $this , 'settings_link') );
	}

	public function settings_link( $links ) 
	{
		$settings_link = '<a href="admin.php?page=nsp_adhesion">Settings</a>';
		array_push( $links, $settings_link );
		return $links;
	}
}