<?php
/**
* @package NspAdhesion
*/

namespace Inc\Base;

use \Inc\Base\Basecontroller;

class Enqueue extends BaseController {
	
	public function register() {
		add_action( 'admin_enqueue_scripts' , [ $this , 'enqueue' ] );
	}

	public function enqueue() {

		wp_enqueue_script('media_upload');
		wp_enqueue_media();
 		wp_enqueue_style( 'mainstyle', $this->plugin_url . 'dist/css/style.min.css' );
		wp_enqueue_script( 'mainscript', $this->plugin_url . 'dist/js/script.min.js' );
	
	}
}