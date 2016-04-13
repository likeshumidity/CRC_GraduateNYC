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
		'supports'              => array( 'title', 'editor', ),
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
				'label' => 'Burroughs',
				'name' => 'burroughs',
				'type' => 'checkbox',
				'instructions' => 'Select all that apply.',
				'required' => 1,
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
					'Brooklyn - Bay Ridge' => 'Brooklyn - Bay Ridge',
					'Brooklyn - Bedford Stuyvesant' => 'Brooklyn - Bedford Stuyvesant',
					'Brooklyn - Bensonhurst' => 'Brooklyn - Bensonhurst',
					'Brooklyn - Borough Park' => 'Brooklyn - Borough Park',
					'Brooklyn - Brownsville' => 'Brooklyn - Brownsville',
					'Brooklyn - Bushwick' => 'Brooklyn - Bushwick',
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
				'type' => 'select',
				'choices' => array (
					'Open Application' => 'Open Application',
					'Selective Application' => 'Selective Application',
					'Closed Program' => 'Closed Program',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_57058d1a453c5',
				'label' => 'Population Served',
				'name' => 'population_served',
				'type' => 'checkbox',
				'instructions' => 'Select all that apply.',
				'choices' => array (
					'Academic Performance' => 'Academic Performance',
					'Academic Performance - High' => 'Academic Performance - High',
					'Academic Performance - Average to High' => 'Academic Performance - Average to High',
					'Academic Performance - Low to Average' => 'Academic Performance - Low to Average',
					'Academic Performance - Low' => 'Academic Performance - Low',
					'English language learners' => 'English language learners',
					'Disconnected youth/Out of school youth' => 'Disconnected youth/Out of school youth',
					'Students with IEP or other learning challenges' => 'Students with IEP or other learning challenges',
					'High school equivalency' => 'High school equivalency',
					'Poverty guidelines/socioeconomic status' => 'Poverty guidelines/socioeconomic status',
					'Justice involved youth' => 'Justice involved youth',
					'First generation college students' => 'First generation college students',
					'Racial or ethnic minorities' => 'Racial or ethnic minorities',
					'Race or ethnicity: African American' => 'Race or ethnicity: African American',
					'Race or ethnicity: Latin/Hispanic' => 'Race or ethnicity: Latin/Hispanic',
					'Race or ethnicity: Middle Eastern/Arab' => 'Race or ethnicity: Middle Eastern/Arab',
					'Race or ethnicity: Asian' => 'Race or ethnicity: Asian',
					'Male' => 'Male',
					'Female' => 'Female',
					'Transgender' => 'Transgender',
					'High School Equivalency/GED' => 'High School Equivalency/GED',
					'LGBTQ' => 'LGBTQ',
					'Adults' => 'Adults',
					'Refugees/Asylees' => 'Refugees/Asylees',
					'Other' => 'Other',
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
					'Elementary' => 'Elementary',
					'Middle School' => 'Middle School',
					'High School' => 'High School',
					'Non-Traditional/Adults' => 'Non-Traditional/Adults',
					'College Freshmen' => 'College Freshmen',
					'College Sophomore' => 'College Sophomore',
					'College Junior' => 'College Junior',
					'College Senior' => 'College Senior',
					'Graduate Students' => 'Graduate Students',
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
					'Network for convening CBOs' => 'Network for convening CBOs',
					'Academic behaviors' => 'Academic behaviors',
					'Academic/degree planning' => 'Academic/degree planning',
					'ACT/SAT/PSAT preparation' => 'ACT/SAT/PSAT preparation',
					'Advocacy on behalf of the sector or segments of it' => 'Advocacy on behalf of the sector or segments of it',
					'Career Counseling (e.g., identifying internship/work opportunities)' => 'Career Counseling (e.g., identifying internship/work opportunities)',
					'Career Preparation' => 'Career Preparation',
					'College application help' => 'College application help',
					'College campus visits' => 'College campus visits',
					'College exploration' => 'College exploration',
					'College Matriculation' => 'College Matriculation',
					'College Readiness' => 'College Readiness',
					'College Retention' => 'College Retention',
					'Connecting students to campus resources (e.g. bursar, tutoring, writing center)' => 'Connecting students to campus resources (e.g. bursar, tutoring, writing center)',
					'Connecting to off-campus resources (e.g. day care, job opportunities, social services support)' => 'Connecting to off-campus resources (e.g. day care, job opportunities, social services support)',
					'Course registration' => 'Course registration',
					'Financial Aid (FAFSA filing/refiling, financial aid appeals, etc.)' => 'Financial Aid (FAFSA filing/refiling, financial aid appeals, etc.)',
					'Financial Aid reapplication' => 'Financial Aid reapplication',
					'Financial support/incentives' => 'Financial support/incentives',
					'Financial support/incentives text' => 'Financial support/incentives text',
					'Major selection' => 'Major selection',
					'Mentoring' => 'Mentoring',
					'Non-academic skills (e.g. soft skills)' => 'Non-academic skills (e.g. soft skills)',
					'Online resources for students and/or staff' => 'Online resources for students and/or staff',
					'Placement test prep (e.g. CUNY Assessment Tests)' => 'Placement test prep (e.g. CUNY Assessment Tests)',
					'Professional development for college access and success staff' => 'Professional development for college access and success staff',
					'Research connected to this field for practitioner use' => 'Research connected to this field for practitioner use',
					'Resume and interview skills' => 'Resume and interview skills',
					'Support services related to college retention' => 'Support services related to college retention',
					'Technical assistance to community based organizations' => 'Technical assistance to community based organizations',
					'Training or awareness for students' => 'Training or awareness for students',
					'Tutoring' => 'Tutoring',
					'Tutoring/academic support' => 'Tutoring/academic support',
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
				'label' => 'Display name for organization',
				'name' => 'name',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => 'display name',
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
				'formatting' => 'html',
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
				'type' => 'number',
				'instructions' => 'Include area code and phone number without any punctuation. (917) 335-5555 would be 9173355555.',
				'default_value' => '',
				'placeholder' => 'contact phone number',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => 99999999999,
				'step' => '',
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

function crc_gnsm_survey_results() {
	add_rewrite_tag('%crc-json%', '([^&]+)');
	add_rewrite_rule('json/([^&]+)/?', 'index.php?crc-json=$1', 'top');
}
add_action('init', 'crc_gnsm_survey_results');

function crc_gnsm_survey_results_data() {
	global $wp_query;

	$gnsm_tag = $wp_query->get('crc-json');

	if (!$gnsm_tag) {
		return;
	}

	$results = array();

	$args = array(
		'post_type' => 'gnsm_listing',
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
// print_r(get_post());
		$thispost = get_post();
//		$thispostmeta = get_post_meta($thispost->ID);
		$program_name = get_post_meta($thispost->ID, 'name');
		$burroughs = get_post_meta($thispost->ID, 'burroughs');
		$neighborhoods = get_post_meta($thispost->ID, 'neighborhoods');
		$grades_served = get_post_meta($thispost->ID, 'grades_served');
		$target_population = get_post_meta($thispost->ID, 'population_served');
		$services = get_post_meta($thispost->ID, 'services');
		$accepting_students = get_post_meta($thispost->ID, 'accepting_students');
		$results[] = array(
//			'post' => $thispost,
			'post_id' => $thispost->ID,
//			'meta' => $thispostmeta,
			'program_name' => $program_name,
			'burroughs' => $burroughs,
			'neighborhoods' => $neighborhoods,
			'grades' => $grades_served,
			'target_population' => $target_population,
			'services' => $services,
			'accepting_students' => $accepting_students,
		);
	endwhile; wp_reset_postdata(); endif;

	wp_send_json($results);
}
add_action('template_redirect', 'crc_gnsm_survey_results_data');

function crc_gnsm_activate() {
	// Register custom post types
	crc_gnsm_post_type_setup();

	// Register custom fields (Depends on plugin: Advanced Custom Fields)
	crc_gnsm_acf_field_setup_filters();
	crc_gnsm_acf_field_setup_listing_details();

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
