<div class="wrap">
	<h1>Taxonomy Manager</h1>
	<?php settings_errors(); ?>



	<ul class="nav nav-tabs">
		<li class="<?php echo !isset($_POST['edit_taxonomy'])?'active':''; ?>">
			<a href="#tab-1">Your Taxonomies</a>
		</li>
		<li class="<?php echo isset($_POST['edit_taxonomy'])?'active':''; ?>">
			<a href="#tab-2"><?php echo isset($_POST['edit_taxonomy'])?'Edit':'Add'; ?> Taxonomy</a>
		</li>
		<li><a href="#tab-3">Export</a></li>
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane <?php echo !isset($_POST['edit_taxonomy'])?'active':''; ?>">
			<h3>Manage your Taxonomies</h3>
			<?php

			$options = get_option('nsp_plugin_tax')?:array();
			

		    echo '<table class="cpt-table"><tr><th>Id</th><th>Singular Name</th><th>Post Types</th><th>Hierarchical</th><th class="text-center">Actions</th></tr>';
			
			foreach ($options as $option) {
			
				$hierarchical = isset($option['hierarchical'])? "TRUE" : "FALSE";

				$attached_posts = "";

				foreach($option['objects'] as $key => $value) {
					$attached_posts .= ucfirst($key)." ";
				}
				

				echo "<tr><td>{$option['taxonomy']}</td><td>{$option['singular_name']}</td><td class=\"text-center\">{$attached_posts}</td><td class=\"text-center\">{$hierarchical}</td><td class=\"text-center\">";

			echo '<form method="post" action="" class="inline-block">';

					echo '<input type="hidden" name="edit_taxonomy" value="'.$option['taxonomy'].'">';

					
					submit_button( 'Edit' , 'primary small' , 'submit' , false);

			echo '</form>';

			echo "&nbsp;";

			echo '<form method="post" action="options.php" class="inline-block">';
					echo '<input type="hidden" name="remove" value="'.$option['taxonomy'].'">';

					settings_fields( 'nsp_plugin_tax_settings' );
					submit_button( 'Delete' , 'delete small' , 'submit' , false, array(
						'onclick' => 'return confirm("Are you sure you want to delete this Taxonomy ? The Datas associated will be no longer_available.")'));

			echo '</form>';

			echo '</td></tr>';	
			}

			

			echo '</table>';
			?>
		</div>

		<div id="tab-2" class="tab-pane <?php echo isset($_POST['edit_taxonomy'])?'active':''; ?>">
			
			<form method="post" action="options.php">
				<?php 
					settings_fields( 'nsp_plugin_tax_settings' );

					do_settings_sections( 'nsp_adhesion_taxonomy' );
					submit_button();
				?>
			</form>
		</div>

		<div id="tab-3" class="tab-pane">
			<h3>Export your Taxonomies</h3>

			<?php foreach ($options as $option): 

				$attached_posts = [];

				foreach($option['objects'] as $key => $value) {
					$attached_posts[] = "'".$key."'";
				} 

				$attached_posts = implode("," , $attached_posts);

				?>


				<h3><?php echo $option['singular_name']; ?></h3>
			
			<pre class="prettyprint">
// Register Custom Taxonomy
function custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Taxonomies', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( '<?php echo $option['singular_name']; ?>', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( '<?php echo $option['singular_name']; ?>', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => <?php echo isset($option['hierarchical'])? "true" : "false"; ?>,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( <?php echo $option['taxonomy']; ?>, array( <?php echo $attached_posts; ?> ), $args );
			</pre>
		<?php endforeach; ?>
			
		</div>
</div>