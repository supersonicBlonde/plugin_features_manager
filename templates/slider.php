<?php

$args = array(
	'post_type' => 'testimonial',
	'post_status' => 'publish',
	'posts_per_page' => 5,
	'meta_query' => array(
		array(
			'key' => '_nsp_testimonial_options_key',
			'value' => 's:8:"approved";i:1;s:8:"featured";i:1;',
			'compare' => 'LIKE'
		)
	)
);

$query = new WP_Query($args);

if($query->have_posts()):

	$i = 1;

	echo '<div class="nsp-slider--wrapper"><div class="nsp-slider--container"><div class="nsp-slider--view"><ul>';

	while($query->have_posts()) : $query->the_post();

		$name = get_post_meta(get_the_ID() , '_nsp_testimonial_options_key' , true)['name'] ?? '';

		echo '<li class="nsp-slider--view__slides '.($i===1 ?'is-active' : '').'"><p class="testimonial-quote">"'.get_the_content().'"</p><p class="testimonial-author">- '.$name.' -</p></li>';

	$i++;
		
	endwhile;

	echo '</ul></div><div class="nsp-slider--arrows"><span class="nsp-slider--arrows__left">&#60;</span><span class="nsp-slider--arrows__right">&#62;</span></div></div></div>';
endif;

wp_reset_postdata();