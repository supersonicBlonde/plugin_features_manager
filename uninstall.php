<?php

/**
* Trigger this file on uninstall
*
* @package NspAdhesion
*/

defined('WP_UNINSTALL_PLUGIN') or die('Intrusion attempt');

// clear database stored data 

$members = get_posts( 'post_type' => 'members' , 'numberposts' => -1);

foreach ($members as $member) {
	wp_delete_post( $member, true );
}


/*global $wpdb;

$wpdb->query( "DELETE from wp_posts WHERE post_type ='member'"  );
$wpdb->query( "DELETE from wp_postmeta WHERE post_id NOT IN(SELECT id from wp_posts)"  );
$wpdb->query( "DELETE from wp_term_relationship WHERE post_id NOT IN(SELECT id from wp_posts)"  );*/