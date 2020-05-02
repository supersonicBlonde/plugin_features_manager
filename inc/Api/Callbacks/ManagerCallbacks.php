<?php
/**
* @package NspAdhesion
*/

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class ManagerCallbacks extends BaseController
{
	

	public function checkboxSanitize( $input )
	{
		$output = array();
		foreach ($this->managers as $key => $value) {
			$output[$key] = isset($input[$key])?true:false;
		}
		return $output;
	}

	public function adminSectionManager( $input )
	{
		echo "Manage the sections and Features of this Plugin by activating the checkboxes in the list";
	}

	public function checkboxField($args)
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checkbox = get_option($option_name);
		$checked = isset($checkbox[$name])?( $checkbox[$name]?true:false ):false;
		echo '<div class="'.$classes.'"><input type="checkbox" name="'.$option_name.'['.$name.']'.'" id="'.$name.'" value="1" '.($checked?'checked':'').'><label for="'.$name.'"><div></div></label></div>';
	}

}