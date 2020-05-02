<?php
/**
* @package NspAdhesion
*/

namespace Inc\Api\Callbacks;

class CptCallbacks
{

	public function cptSectionManager()
	{
		echo 'Create as many Custom Post Types as you want.';
	}


	public function cptSanitize( $input )
	{	
	
		$output = get_option('nsp_plugin_cpt');

		if(isset($_POST['remove'])) {
			unset($output[$_POST['remove']]);
			return $output;
		}


		if ( count($output) == 0) {
			$output[$input['post_type']]  = $input;
			return $output;
		}

		foreach ($output as $key => $value) {
			if($input['post_type'] === $key) {

				$output[$key]  = $input;
			}
			else {
				$output[$input['post_type']]  = $input;
			}
		}
		
		
		return $output;
	}

	public function textField( $args )
	{
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$value= "";
		$readonly = "";

		if(isset($_POST['edit'])) {
			$input = get_option( $option_name );
			$value = $input[$_POST['edit']][$name];
			$readonly = ($name!= 'post_type')?:'readonly';
		}

		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="'.$value.'" placeholder="' . $args['placeholder'] . '" required '.$readonly.'>';
	}

	public function checkboxField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checked = false;
		

		if(isset($_POST['edit'])) {
			$checkbox = get_option( $option_name );
			$checked = isset($checkbox[$_POST['edit']][$name]) ? : false;

		}

		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" '.($checked ? 'checked' : '').'><label for="' . $name . '"><div></div></label></div>';
	}
}