<?php
/**
 * @package crc-graduate-nyc-survey-map
 * @version 0.1
 * @author Carson Research Consulting (CRC)
 */
/*
Plugin Name: Graduate NYC - Program Survey Map
Plugin URI: http://www.carsonresearch.com
Description: Custom plugin for Graduate NYC program survey map.
Version: 0.1
Author: Carson Research Consulting (CRC)
Author URI: http://www.carsonresearch.com

Graduate NYC - Program Survey Map is licensed exclusively to Graduate NYC and cannot be used, redistributed or sold  except with their permission.
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function crc_gnsm_post_type_setup() {
	// Register post type for listings
	$gnsm_listing_labels = array(
		'name'                  => _x( 'Program Survey Listings', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Program Survey Listing', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Program Survey Listings', 'text_domain' ),
		'name_admin_bar'        => __( 'Program Survey Listing', 'text_domain' ),
		'all_items'             => __( 'All Listings', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add Listing', 'text_domain' ),
		'new_item'              => __( 'New Listing', 'text_domain' ),
		'edit_item'             => __( 'Edit Listing', 'text_domain' ),
		'update_item'           => __( 'Update Listing', 'text_domain' ),
		'view_item'             => __( 'View Listing', 'text_domain' ),
		'search_items'          => __( 'Search Listing', 'text_domain' ),
	);

	$gnsm_listing_args = array(
		'label'                 => __( 'Program Survey Listing', 'text_domain' ),
		'description'           => __( 'Program Survey Listings', 'text_domain' ),
		'labels'                => $gnsm_listing_labels,
		'supports'              => array( 'title', 'editor', 'custom-fields', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);

	register_post_type( 'gnsm_listing', $gnsm_listing_args );
}
add_action('init', 'crc_gnsm_post_type_setup');

function crc_gnsm_activate() {
	// Register custom post types
	crc_gnsm_post_type_setup();

	// Clear permalinks after post type registered
	flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'crc_gnsm_activate');

function crc_gnsm_deactivate() {
	// Clear permalinks to remove post type rules
	flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'crc_gnsm_deactivate');

?>
