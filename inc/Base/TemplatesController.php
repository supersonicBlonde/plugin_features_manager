<?php
/**
* @package NspAdhesion
*/

namespace Inc\Base;

use Inc\Base\BaseController;


/**
* 
*/
class TemplatesController extends BaseController
{

	public $templates;


	public function register() 
	{	
		
		if ( ! $this->activated( 'templates_manager' ) ) return;

		$this->templates = array(
			'page-templates/two-columns-tpl.php' => 'Two Columns Layout'
		);

		add_filter('theme_page_templates' , array($this , 'custom_template'));

		add_filter('template_include' , array($this , 'load_template'));
	
	}


	public function load_template($template) {

		global $post;

		if(!$post) {
			return $template;
		}

		//if is the front page load a custom template
		if(is_front_page()) {

			$file = $this->plugin_path .'page-templates/front-page.php';
			if(file_exists($file)) {
				return $file;
			}

		}

		$template_name = get_post_meta($post->ID , '_wp_page_template' , true);

		//echo $template_name;
		if(!isset($this->templates[$template_name])) {
			return $template;
		}

		$file = $this->plugin_path.$template_name;

		if(file_exists($file)) {
			return $file;
		}



		return $template;
	}


	public function custom_template($templates)
	{
		$templates = array_merge($templates , $this->templates);

		return $templates;
	}

	
}

