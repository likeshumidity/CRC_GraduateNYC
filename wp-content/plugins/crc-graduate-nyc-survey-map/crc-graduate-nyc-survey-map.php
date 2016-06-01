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

define( 'CRC__GNSM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( CRC__GNSM_PLUGIN_DIR . 'crc-gnsm-import.php' );
require_once( CRC__GNSM_PLUGIN_DIR . 'crc-gnsm-listing-attributes.php' );

// used for debugging
function console_log($data) {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ');';
        echo '</script>';
}

function crc_gnsm_post_type_setup() {
	$labels = array(
		'name'                  => 'GNYC Survey Listings',
		'singular_name'         => 'GNYC Survey Listing',
		'menu_name'             => 'Program Survey Listings',
		'name_admin_bar'        => 'Survey Listings',
		'archives'              => 'Graduate NYC Program Survey Listings',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Listings',
		'add_new_item'          => 'Add New Listing',
		'add_new'               => 'Add New Listing',
		'new_item'              => 'New Listing',
		'edit_item'             => 'Edit Listing',
		'update_item'           => 'Update Listing',
		'view_item'             => 'View Listing',
		'search_items'          => 'Search Listings',
		'not_found'             => 'Listing Not Found',
		'not_found_in_trash'    => 'Listing Not found in Trash',
		'insert_into_item'      => 'Insert into listing',
		'uploaded_to_this_item' => 'Uploaded to this listing',
		'items_list'            => 'Listings list',
		'items_list_navigation' => 'Listings list navigation',
		'filter_items_list'     => 'Filter Listings list',
	);
	$args = array(
		'label'                 => 'GNYC Program Survey Listing',
		'description'           => 'GNYC Program Survey Listings',
		'labels'                => $labels,
		'supports'              => array( 'title', ),
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
		'capability_type'       => 'post',
	);
	register_post_type( 'gnsm_listing', $args );
}
add_action('init', 'crc_gnsm_post_type_setup');

function crc_gnsm_acf_field_setup_listing_details() {
	// Adds custom fields for listing details
	// Requires plugin: Advanced Custom Fields
	if(function_exists("register_field_group")) {
	register_field_group(array (
		'id' => 'acf_graduate-nyc-college-readiness-map-listing-details',
		'title' => 'Graduate NYC - College Readiness Map Listing Details',
		'fields' => array (
			array (
				'key' => 'field_5706dda975f1c',
				'label' => 'Response ID',
				'name' => 'response_id',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => 'response ID',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5706dddf75f1d',
				'label' => 'Address - Line 1',
				'name' => 'address_line_1',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => 'address line one',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5706de0275f1e',
				'label' => 'Address - Line 2',
				'name' => 'address_line_2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => 'address line two',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5706de2575f1f',
				'label' => 'Address - City',
				'name' => 'address_city',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => 'address city',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5706de4675f20',
				'label' => 'Address - State',
				'name' => 'address_state',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => 'address state',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5706deca75f22',
				'label' => 'Address - Postal Code/Zipcode',
				'name' => 'address_postal_code',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => 'address postal code or zipcode',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5706de6175f21',
				'label' => 'Contact Phone',
				'name' => 'contact_phone',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => 'contact phone number',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5706df2275f23',
				'label' => 'Program Description',
				'name' => 'program_description',
				'type' => 'textarea',
				'instructions' => 'Describe the type of program and the services provided.',
				'default_value' => '',
				'placeholder' => 'program description',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'gnsm_listing',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	}
}
add_action('init', 'crc_gnsm_acf_field_setup_listing_details');

function crc_gnsm_acf_field_setup_filters() {
	// Adds custom fields for filtering
	// Requires plugin: Advanced Custom Fields
	if(function_exists("register_field_group")) {
	register_field_group(array (
		'id' => 'acf_graduate-nyc-college-readiness-map-filters',
		'title' => 'Graduate NYC - College Readiness Map Filters',
		'fields' => array (
			array (
				'key' => 'field_570d7e356b64e',
				'label' => 'Boroughs',
				'name' => 'boroughs',
				'type' => 'checkbox',
				'instructions' => 'Select all that apply.',
				'choices' => array (
					'Brooklyn' => 'Brooklyn',
					'Bronx' => 'Bronx',
					'Manhattan' => 'Manhattan',
					'Queens' => 'Queens',
					'Staten Island' => 'Staten Island',
				),
				'default_value' => '',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_570d7e766b64f',
				'label' => 'Neighborhoods',
				'name' => 'neighborhoods',
				'type' => 'checkbox',
				'instructions' => 'Select all that apply.',
				'choices' => array (
					'Brooklyn - Bay Ridge ' => 'Brooklyn - Bay Ridge ',
					'Brooklyn - Bedford Stuyvesant ' => 'Brooklyn - Bedford Stuyvesant ',
					'Brooklyn - Bensonhurst ' => 'Brooklyn - Bensonhurst ',
					'Brooklyn - Borough Park ' => 'Brooklyn - Borough Park ',
					'Brooklyn - Brownsville ' => 'Brooklyn - Brownsville ',
					'Brooklyn - Bushwick ' => 'Brooklyn - Bushwick ',
					'Brooklyn - Canarsie' => 'Brooklyn - Canarsie',
					'Brooklyn - Coney Island' => 'Brooklyn - Coney Island',
					'Brooklyn - Crown Heights North' => 'Brooklyn - Crown Heights North',
					'Brooklyn - Crown Heights South' => 'Brooklyn - Crown Heights South',
					'Brooklyn - East Flatbush' => 'Brooklyn - East Flatbush',
					'Brooklyn - East New York' => 'Brooklyn - East New York',
					'Brooklyn - Flatbush/Midwood' => 'Brooklyn - Flatbush/Midwood',
					'Brooklyn - Fort Greene/Brooklyn Heights' => 'Brooklyn - Fort Greene/Brooklyn Heights',
					'Brooklyn - Park Slope' => 'Brooklyn - Park Slope',
					'Brooklyn - Sheepshead Bay' => 'Brooklyn - Sheepshead Bay',
					'Brooklyn - Sunset Park' => 'Brooklyn - Sunset Park',
					'Brooklyn - Williamsburg/Greenpoint' => 'Brooklyn - Williamsburg/Greenpoint',
					'Bronx - Bedford Park' => 'Bronx - Bedford Park',
					'Bronx - Concourse/Highbridge' => 'Bronx - Concourse/Highbridge',
					'Bronx - East Tremont' => 'Bronx - East Tremont',
					'Bronx - Hunts Point' => 'Bronx - Hunts Point',
					'Bronx - Morrisania' => 'Bronx - Morrisania',
					'Bronx - Mott Haven' => 'Bronx - Mott Haven',
					'Bronx - Pelham Parkway' => 'Bronx - Pelham Parkway',
					'Bronx - Riverdale' => 'Bronx - Riverdale',
					'Bronx - Throgs Neck' => 'Bronx - Throgs Neck',
					'Bronx - Unionport/Soundview' => 'Bronx - Unionport/Soundview',
					'Bronx - University Heights' => 'Bronx - University Heights',
					'Bronx - Williamsbridge' => 'Bronx - Williamsbridge',
					'Manhattan - Battery Park/Tribeca' => 'Manhattan - Battery Park/Tribeca',
					'Manhattan - Central Harlem' => 'Manhattan - Central Harlem',
					'Manhattan - Chelsea/Clinton' => 'Manhattan - Chelsea/Clinton',
					'Manhattan - East Harlem' => 'Manhattan - East Harlem',
					'Manhattan - Greenwich Village' => 'Manhattan - Greenwich Village',
					'Manhattan - Lower East Side' => 'Manhattan - Lower East Side',
					'Manhattan - Manhattanville' => 'Manhattan - Manhattanville',
					'Manhattan - Midtown Business District' => 'Manhattan - Midtown Business District',
					'Manhattan - Murray Hill/Stuyvesant' => 'Manhattan - Murray Hill/Stuyvesant',
					'Manhattan - Upper East Side' => 'Manhattan - Upper East Side',
					'Manhattan - Upper West Side' => 'Manhattan - Upper West Side',
					'Manhattan - Washington Heights' => 'Manhattan - Washington Heights',
					'Queens - Astoria' => 'Queens - Astoria',
					'Queens - Bayside' => 'Queens - Bayside',
					'Queens - Elmhurst/Corona' => 'Queens - Elmhurst/Corona',
					'Queens - Flushing' => 'Queens - Flushing',
					'Queens - Fresh Meadows/Briarwood' => 'Queens - Fresh Meadows/Briarwood',
					'Queens - Howard Beach' => 'Queens - Howard Beach',
					'Queens - Jackson Heights' => 'Queens - Jackson Heights',
					'Queens - Jamaica/St. Albans' => 'Queens - Jamaica/St. Albans',
					'Queens - Queens Village' => 'Queens - Queens Village',
					'Queens - Rego Park/Forest Hills' => 'Queens - Rego Park/Forest Hills',
					'Queens - Ridgewood/Glendale' => 'Queens - Ridgewood/Glendale',
					'Queens - Sunnyside/Woodside' => 'Queens - Sunnyside/Woodside',
					'Queens - The Rockaways' => 'Queens - The Rockaways',
					'Queens - Woodhaven' => 'Queens - Woodhaven',
					'Staten Island - South Beach' => 'Staten Island - South Beach',
					'Staten Island - St. George' => 'Staten Island - St. George',
					'Staten Island - Tottenville' => 'Staten Island - Tottenville',
				),
				'default_value' => '',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_57058bf68c3b6',
				'label' => 'Accepting Students',
				'name' => 'accepting_students',
				'type' => 'checkbox',
				'instructions' => 'Select all that apply.',
				'choices' => array (
					'Open' => 'Open',
					'Limited' => 'Limited',
					'Closed' => 'Closed',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_57058d1a453c5',
				'label' => 'Target Population',
				'name' => 'target_population',
				'type' => 'checkbox',
				'instructions' => 'Select all that apply.',
				'choices' => array (
					'Academic Performance' => 'Academic Performance',
					'English language learners' => 'English language learners',
					'Disconnected youth/Out of school youth' => 'Disconnected youth/Out of school youth',
					'Students with IEP or other learning challenges' => 'Students with IEP or other learning challenges',
					'High school equivalency' => 'High school equivalency',
					'Poverty guidelines/socioeconomic status' => 'Poverty guidelines/socioeconomic status',
					'Justice involved youth' => 'Justice involved youth',
					'First generation college students' => 'First generation college students',
					'Racial or ethnic minorities' => 'Racial or ethnic minorities',
					'Gender' => 'Gender',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_570592ca24d14',
				'label' => 'Grades Served',
				'name' => 'grades_served',
				'type' => 'checkbox',
				'choices' => array (
					'Elementary school (K-5)' => 'Elementary school (K-5)',
					'Middle school (6-8)' => 'Middle school (6-8)',
					'High School (9-12)' => 'High School (9-12)',
					'College' => 'College',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_570593872b93a',
				'label' => 'Services',
				'name' => 'services',
				'type' => 'checkbox',
				'choices' => array (
					'College Readiness' => 'College Readiness',
					'College Matriculation' => 'College Matriculation',
					'College Retention' => 'College Retention',
					'Career Preparation' => 'Career Preparation',
					'Technical assistance to community based organizations' => 'Technical assistance to community based organizations',
					'A network for convening CBOs or programs that work on similar issues or work with overlapping sets of students' => 'A network for convening CBOs or programs that work on similar issues or work with overlapping sets of students',
					'Professional development for college access and success staff' => 'Professional development for college access and success staff',
					'Training or awareness for students' => 'Training or awareness for students',
					'Research connected to this field for practitioner use' => 'Research connected to this field for practitioner use',
					'Advocacy on behalf of the sector or segments of it' => 'Advocacy on behalf of the sector or segments of it',
					'Online resources for students and/or staff' => 'Online resources for students and/or staff',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'gnsm_listing',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	}
}
add_action('init', 'crc_gnsm_acf_field_setup_filters');

function crc_gnsm_survey_results() {
	add_rewrite_tag('%crc-json%', '([^&]+)');
	add_rewrite_rule('json/([^&]+)/?', 'index.php?crc-json=$1', 'top');
}
add_action('init', 'crc_gnsm_survey_results');

function crc_gnsm_survey_results_data() {
	global $wp_query;

	$gnsm_tag = $wp_query->get('crc-json');

	switch($gnsm_tag) {
		case 'all_listings':
			crc_gnsm_survey_results_listings_all();
			break;
/*		case 'page_listings_filter':
			crc_gnsm_survey_results_page_listings_filter();
			break;
*/
		default:
			return;
	}
}
add_action('template_redirect', 'crc_gnsm_survey_results_data');

function crc_gnsm_survey_results_listings_all() {
	$results = array();

	$args = array(
		'post_type' => array(
			'gnsm_listing',
			),
		'posts_per_page' => -1,
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$thispost = get_post();
			$program_name = get_the_title($thispost->ID);
			$boroughs = get_post_meta($thispost->ID, 'boroughs');
			$neighborhoods = get_post_meta($thispost->ID, 'neighborhoods');
			$grades_served = get_post_meta($thispost->ID, 'grades_served');
			$target_population = get_post_meta($thispost->ID, 'target_population');
			$services = get_post_meta($thispost->ID, 'services');
			$accepting_students = get_post_meta($thispost->ID, 'accepting_students');
			$results[$program_name] = array(
				'post_id' => $thispost->ID,
				'program_name' => $program_name,
				'boroughs' => $boroughs[0],
				'neighborhoods' => $neighborhoods[0],
				'grades' => $grades_served[0],
				'target_population' => $target_population[0],
				'services' => $services[0],
				'accepting_students' => $accepting_students[0],
			);
			wp_reset_postdata();
		}
	}

	wp_send_json($results);
}

function crc_gnsm_archive_template($archive_template) {
	global $post;

	if (is_post_type_archive('gnsm_listing')) {
		$archive_template = dirname(__FILE__) . '/archive-gnsm_listing.php';
	}

	return $archive_template;
}
add_filter('archive_template', 'crc_gnsm_archive_template');

function crc_gnsm_archive_filter($query) {
	global $crc_gnsm_listing_attributes;
	if (!is_admin() && is_post_type_archive('gnsm_listing') && $query->is_main_query()) {
		$query->set('posts_per_page', -1);
		$query->set('post_type', 'gnsm_listing');

		$meta_query = array();

		foreach($crc_gnsm_listing_attributes as $att => $attDetails) {
			$attSelected = array();

			foreach($attDetails[1] as $attValue) {
				if (isset($_GET[$att])) {
                        		if (gettype($_GET[$att]) == 'array') {
		                                if (in_array($attValue, $_GET[$att])) {
							$meta_query[] = array(
								'key' => $attDetails[2],
								'value' => $attValue,
								'compare' => 'LIKE',
							);
		                                }
		                        } else {
		                                if ($_GET[$att] == $attValue) {
							$meta_query[] = array(
								'key' => $attDetails[2],
								'value' => $attValue,
								'compare' => 'LIKE',
							);
		                                }
		                        }
				}
			}
		}

		if (!empty($meta_query)) {
			$meta_query['relation'] = 'AND';
			$query->set('meta_query', $meta_query);
		}
	} else {
		return $query;
	}
}
add_action('pre_get_posts', 'crc_gnsm_archive_filter');

// Add shortcode to display filters for map
function crc_gnyc_map_filters_display() {
	return 'x';
}
add_shortcode('crc-gnsm-map-filters', 'crc_gnyc_map_filters_display');

// Add shortcode to display map
function crc_gnyc_map_display() {
	return 'x';
}
add_shortcode('crc-gnsm-map', 'crc_gnyc_map_display');

function crc_gnsm_activate() {
	// Register custom post types
	crc_gnsm_post_type_setup();

	// Register custom fields (Depends on plugin: Advanced Custom Fields)
	crc_gnsm_acf_field_setup_filters();
	crc_gnsm_acf_field_setup_listing_details();

	// Load posts
	crc_gnsm_import_data('sampleDataGNYC20160425a.csv');

	// Clear permalinks after post type registered
	flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'crc_gnsm_activate');

function crc_gnsm_deactivate() {
	// Clear permalinks to remove post type rules
	flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'crc_gnsm_deactivate');

function crc_styles_enqueue() {
	wp_enqueue_style('bootstrap-crc', '/wp-content/plugins/crc-graduate-nyc-survey-map/includes/styles/bootstrap.css');
	wp_enqueue_style('crc-gnyc-main', '/wp-content/plugins/crc-graduate-nyc-survey-map/includes/styles/crc-gnyc-main.css');
	wp_enqueue_style('modernizr-crc', '/wp-content/plugins/crc-graduate-nyc-survey-map/includes/js/modernizr.js');
}
add_action('wp_enqueue_scripts', 'crc_styles_enqueue');

?>
