<?php
/**
* @package NspAdhesion
*/

namespace Inc\Base;

use Inc\Base\BaseController;
use Inc\Api\Widgets\MediaWidget;


/**
* 
*/
class WidgetController extends BaseController
{

	public $subpages = array();
	public $callbacks;

	public function register() 
	{	
		$option = get_option('nsp_adhesion');
		
		if ( ! $this->activated( 'media_widget' ) ) return;

		$media_widget = new MediaWidget();

		$media_widget->register();
	
	}


}

