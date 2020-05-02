<?php
/**
* @package NspAdhesion
*/

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
	public function adminDashboard()
	{
		return require_once( "$this->plugin_path/templates/admin.php" );
	}

	public function adminCpt()
	{
		return require_once( "$this->plugin_path/templates/cpt.php" );
	}

	public function adminTaxonomy()
	{
		return require_once( "$this->plugin_path/templates/taxonomy.php" );
	}

	public function adminWidget()
	{
		return require_once( "$this->plugin_path/templates/widget.php" );
	}

	public function adminGallery()
	{
		return require_once( "$this->plugin_path/templates/gallery.php" );
	}

	public function adminTestimonial()
	{
		return require_once( "$this->plugin_path/templates/testimonial.php" );
	}

	public function adminTemplates()
	{
		return require_once( "$this->plugin_path/templates/templates.php" );
	}

	public function adminLogin()
	{
		return require_once( "$this->plugin_path/templates/login.php" );
	}

	public function adminMembership()
	{
		return require_once( "$this->plugin_path/templates/membership.php" );
	}

	public function adminChat()
	{
		return require_once( "$this->plugin_path/templates/chat.php" );
	}

}