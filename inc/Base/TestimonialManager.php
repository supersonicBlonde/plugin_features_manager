<?php
/**
* @package NspAdhesion
*/

namespace Inc\Base;


use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\TestimonialCallbacks;



/**
* 
*/
class TestimonialManager extends BaseController
{

	public $settings;
	public $callbacks;




	public function register() 
	{	
		$option = get_option('nsp_adhesion');
		
		if ( ! $this->activated( 'testimonial_manager' ) ) return;

		$this->settings = new SettingsApi();

		$this->callbacks = new TestimonialCallbacks();

		add_action('init' , array($this , 'testimonialCpt'));

		add_action('add_meta_boxes' , array($this , 'addMetaBoxes'));

		add_action('save_post' , array($this, 'saveMetaBox'));

		add_action( 'manage_testimonial_posts_columns', array( $this, 'set_custom_columns' ) );

		add_action('manage_testimonial_posts_custom_column' , array($this , 'setCustomColumnsData') , 10 , 2);

		add_filter('manage_edit-testimonial_sortable_columns' , array($this , 'setColumnsSortable'));

		$this->setShortcodePage();

		add_shortcode( 'testimonial-form', array($this , 'testimonialForm') );

		add_shortcode( 'testimonial-slider', array($this , 'testimonialSlider') );

		add_action('wp_ajax_submit_testimonial' , array($this, 'submit_testimonial' ));

		add_action('wp_ajax_nopriv_submit_testimonial' , array($this, 'submit_testimonial' ));
		
	}

	public function returnJson($status) 
	{
		$return = array(
				'status' => $status
			);

			wp_send_json( $return);
			
			wp_die();
	}


	public function submit_testimonial() 
	{



		if(!DOING_AJAX || !check_ajax_referer( 'testimonial_nonce', 'nonce' )) {
			return $this->returnJson('error');
		}


		$name = sanitize_text_field($_POST['name']);
		$email = sanitize_email($_POST['name']);
		$message = sanitize_textarea_field($_POST['message']);

		$data = array(
			'name' => $name,
			'email' => $email,
			'approved' => 0,
			'featured' => 0
		);

		$args = array(
			'post_title' => 'Testimonial from ' . $name,
			'post_content' => $message,
			'post_author' => 1,
			'post_status' => 'publish',
			'post_type' => 'testimonial',
			'meta_input' => array(
				'_nsp_testimonial_options_key' => $data
				)
		);

		$postID = wp_insert_post($args);

		if($postID) {
			return $this->returnJson('success');
		}

		return $this->returnJson('error');

	}

	public function testimonialForm()
	{


		ob_start();
		echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/dist/css/form.min.css\" type=\"text/css\" media=\"all\" />";
		require_once( "$this->plugin_path/templates/contact-form.php" );
		echo "<script src=\"$this->plugin_url/dist/js/form.min.js\"></script>";
		return ob_get_clean();

	}

	public function testimonialSlider()
	{

		ob_start();
		echo "<link rel=\"stylesheet\" href=\"$this->plugin_url/dist/css/slider.min.css\" type=\"text/css\" media=\"all\" />";
		require_once( "$this->plugin_path/templates/slider.php" );
		echo "<script src=\"$this->plugin_url/dist/js/slider.min.js\"></script>";
		return ob_get_clean();

	}



	public function setShortcodePage()
	{
		$subpage = array(
			array(
				'parent_slug' => 'edit.php?post_type=testimonial',
				'page_title' => 'Shortcodes',
				'menu_title' => 'Shortcodes',
				'capability' => 'manage_options',
				'menu_slug' => 'nsp_testimonial_shortcode',
				'callback' => array($this->callbacks , 'shortcodePage')

			)
		);

		$this->settings->addSubPages($subpage)->register();
	}



	public function testimonialCpt()
	{



		$labels = array(
			'name' => 'Testimonials',
			'single_name' => 'Testimonial'
		);


		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-testimonial',
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'supports' => array('title' , 'editor' ),
			'show_in_rest' => true
		);

		register_post_type( 'testimonial', $args);
	}

	public function addMetaBoxes()
	{
		add_meta_box( 
			'testimonial_options', 
			'Options',
			array($this , 'renderBox'),
			'testimonial',
			'side',
			'default'
		);
	}

	public function renderBox($post)
	{
		
		wp_nonce_field('nsp_testimonial_options' , 'nsp_testimonial_options_nonce');

		$data = get_post_meta($post->ID , '_nsp_testimonial_options_key' , true);

		$name = isset($data['name'])?$data['name']:'';
		$email = isset($data['email'])?$data['email']:'';
		$approved = isset($data['approved'])?$data['approved']:false;
		$featured = isset($data['featured'])?$data['featured']:false;

?>
		<p>
			<label class="meta-label" for="nsp_testimonial_author">Author Name</label>
			<input type="text" id="nsp_testimonial_author" name="nsp_testimonial_author" class="widefat" value="<?php echo esc_attr( $name ); ?>">
		</p>
		<p>
			<label class="meta-label" for="nsp_testimonial_email">Author Email</label>
			<input type="email" id="nsp_testimonial_email" name="nsp_testimonial_email" class="widefat" value="<?php echo esc_attr( $email ); ?>">
		</p>
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="nsp_testimonial_approved">Approved</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="nsp_testimonial_approved" name="nsp_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
					<label for="nsp_testimonial_approved"><div></div></label>
				</div>
			</div>
		</div>
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="nsp_testimonial_featured">Featured</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="nsp_testimonial_featured" name="nsp_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
					<label for="nsp_testimonial_featured"><div></div></label>
				</div>
			</div>
		</div>
		<?php  
	}


	public function saveMetaBox($post_id)
	{

		if( !isset($_POST['nsp_testimonial_options_nonce'])) {
			return $post_id;
		}

		$nonce = $_POST['nsp_testimonial_options_nonce'];

		if(!wp_verify_nonce( $nonce, 'nsp_testimonial_options' )) {
			return $post_id;
		}

		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		if(!current_user_can('edit_post' , $post_id)) {
			return $post_id;
		}

		$data = array(
			'name' => sanitize_text_field( $_POST['nsp_testimonial_author'] ),
			'email' => sanitize_email( $_POST['nsp_testimonial_email'] ),
			'approved' => isset($_POST['nsp_testimonial_approved']) ? 1 : 0,
			'featured' => isset($_POST['nsp_testimonial_featured']) ? 1 : 0,
		);

	
		update_post_meta( $post_id, '_nsp_testimonial_options_key', $data );

	}

	public function set_custom_columns($columns)
	{
		$title = $columns['title'];
		$date = $columns['date'];
		unset( $columns['title'], $columns['date'] );

		$columns['name'] = 'Author Name';
		$columns['title'] = $title;
		$columns['approved'] = 'Approved';
		$columns['featured'] = 'Featured';
		$columns['date'] = $date;

		return $columns;
	}

	public function setCustomColumnsData($columns , $post_id) 
	{

		$data = get_post_meta($post_id, '_nsp_testimonial_options_key' , true);

		$name = isset($data['name'])?$data['name']:'';
		$email = isset($data['email'])?$data['email']:'';
		$approved = isset($data['approved']) && $data['approved'] === 1 ?'<strong>YES</strong>':"NO";
		$featured = isset($data['featured']) && $data['featured'] === 1 ?'<strong>YES</strong>':"NO";

		switch($columns) {
			case 'name':
				echo '<strong>'.$name.'</strong><br><a href="mailto:'.$email.'">'.$email.'</a>';
				break;

			case 'approved':
				echo $approved;
				break;

			case 'featured':
				echo $featured;
				break;	
		}


		return $columns;

	}

	public function setColumnsSortable($column)
	{
		$columns['name'] = 'name';
		$columns['approved'] = 'approved';
		$columns['featured'] = 'featured';

		return $columns;
	}

}

