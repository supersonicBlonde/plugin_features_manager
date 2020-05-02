<?php
/**
* @package NspAdhesion
*/

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;


/**
* 
*/
class ChatManager extends BaseController
{

	public $subpages = array();
	public $callbacks;

	public function register() 
	{	
		$option = get_option('nsp_adhesion');
		$activated = isset($option['chat_manager'])?( $option['chat_manager']?true:false ):false;
		if ( ! $this->activated( 'chat_manager' ) ) return;
	
		$this->settings = new SettingsApi();
		$this->callbacks = new AdminCallbacks();
	
		$this->setSubpages();
	
		$this->settings->addSubPages( $this->subpages )->register();
	
		add_action('init' , [ $this , 'activate' ]);
	}

	public function activate() {
		/*register_post_type( 'nsp_products', 
			array(
				'labels' => array(
					'name' => 'Products',
					'singular_name' => 'Product'
				),
				'public' => true,
				'has_archive' => true
			) 
		);*/
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'nsp_adhesion', 
				'page_title' => 'Chat Manager', 
				'menu_title' => 'Chat Manager', 
				'capability' => 'manage_options', 
				'menu_slug' => 'nsp_adhesion_chat', 
				'callback' => array( $this->callbacks, 'adminChat' )
			)
		);
	}
}

