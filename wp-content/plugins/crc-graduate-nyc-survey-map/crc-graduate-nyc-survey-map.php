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
		'has_archive'           => false,		
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
		'id' => 'acf_graduate-nyc-college-readiness-maplisting-details',
		'title' => 'Graduate NYC - College Readiness Map/Listing Details',
		'fields' => array (
			array (
				'key' => 'field_5783219899626',
				'label' => 'Survey number',
				'name' => 'survey_number',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_578321e099627',
				'label' => 'Organization number',
				'name' => 'organization_number',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5783221099628',
				'label' => 'Response ID',
				'name' => 'response_id',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5783222899629',
				'label' => 'Phone',
				'name' => 'phone',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5783223b9962a',
				'label' => 'Email',
				'name' => 'email',
				'type' => 'email',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array (
				'key' => 'field_578322669962c',
				'label' => 'Program description',
				'name' => 'program_description',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_578322769962d',
				'label' => 'Address - Line 1',
				'name' => 'address_-_line_1',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_578322809962e',
				'label' => 'Address - Line 2',
				'name' => 'address_-_line_2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_578322869962f',
				'label' => 'Address - City',
				'name' => 'address_-_city',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5783229199630',
				'label' => 'Address - State',
				'name' => 'address_-_state',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5783229a99631',
				'label' => 'Address - Postal code',
				'name' => 'address_-_postal_code',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_57832f5dad1dd',
				'label' => 'Borough',
				'name' => 'borough',
				'type' => 'checkbox',
				'choices' => array (
					'Brooklyn' => 'Brooklyn',
					'Bronx' => 'Bronx',
					'Manhattan' => 'Manhattan',
					'Queens' => 'Queens',
					'Staten Island' => 'Staten Island',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_578322d199633',
				'label' => 'Neighborhoods',
				'name' => 'neighborhoods',
				'type' => 'checkbox',
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
				'key' => 'field_578324cf99634',
				'label' => 'Education Levels Served',
				'name' => 'education_levels_served',
				'type' => 'checkbox',
				'choices' => array (
					'Elementary (K-5)' => 'Elementary (K-5)',
					'Middle school (6-8)' => 'Middle school (6-8)',
					'High school (9-12)' => 'High school (9-12)',
					'Post-secondary school' => 'Post-secondary school',
					'Adult learners and high school equivalency' => 'Adult learners and high school equivalency',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_5783256c99635',
				'label' => 'Targeted Populations Served',
				'name' => 'targeted_populations_served',
				'type' => 'checkbox',
				'choices' => array (
					'Academic performance level' => 'Academic performance level',
					'English language learners' => 'English language learners',
					'Disconnected youth/Out of school youth' => 'Disconnected youth/Out of school youth',
					'Students with IEP or other learning challenges' => 'Students with IEP or other learning challenges',
					'High school equivalency (HSE)' => 'High school equivalency (HSE)',
					'Poverty guidelines/Socioeconomic status' => 'Poverty guidelines/Socioeconomic status',
					'Justice involved youth' => 'Justice involved youth',
					'Gender' => 'Gender',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_5783258799636',
				'label' => 'Services Provided',
				'name' => 'services_provided',
				'type' => 'checkbox',
				'instructions' => 'filter for map only',
				'choices' => array (
					'College readiness' => 'College readiness',
					'College matriculation' => 'College matriculation',
					'College retention' => 'College retention',
					'Career preparation' => 'Career preparation',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_578325c499637',
				'label' => 'Services Provided2',
				'name' => 'services_provided2',
				'type' => 'checkbox',
				'instructions' => 'filter for listings only',
				'choices' => array (
					'College readiness (Academic behaviors)' => 'College readiness (Academic behaviors)',
					'College readiness (ACT/SAT/PSAT preparation)' => 'College readiness (ACT/SAT/PSAT preparation)',
					'College readiness (College campus visits)' => 'College readiness (College campus visits)',
					'College readiness (College exploration)' => 'College readiness (College exploration)',
					'College readiness (Tutoring/Academic support)' => 'College readiness (Tutoring/Academic support)',
					'College readiness (Any)' => 'College readiness (Any)',
					'College matriculation (College application help)' => 'College matriculation (College application help)',
					'College matriculation (Financial Aid)' => 'College matriculation (Financial Aid)',
					'College matriculation (Placement test prep)' => 'College matriculation (Placement test prep)',
					'College matriculation (Any)' => 'College matriculation (Any)',
					'College retention (Academic/Degree planning)' => 'College retention (Academic/Degree planning)',
					'College retention (Connecting students to campus resources)' => 'College retention (Connecting students to campus resources)',
					'College retention (Connecting students to off-campus resources)' => 'College retention (Connecting students to off-campus resources)',
					'College retention (Course registration)' => 'College retention (Course registration)',
					'College retention (Major selection)' => 'College retention (Major selection)',
					'College retention (Mentoring)' => 'College retention (Mentoring)',
					'College retention (Support services related to college retention)' => 'College retention (Support services related to college retention)',
					'College retention (Tutoring)' => 'College retention (Tutoring)',
					'College retention (Non-academic skills)' => 'College retention (Non-academic skills)',
					'College retention (Financial support/incentives)' => 'College retention (Financial support/incentives)',
					'College retention (Financial Aid reapplication)' => 'College retention (Financial Aid reapplication)',
					'College retention (Any)' => 'College retention (Any)',
					'Career preparation (Career counseling)' => 'Career preparation (Career counseling)',
					'Career preparation (Resume and interview skills)' => 'Career preparation (Resume and interview skills)',
					'Career preparation (Any)' => 'Career preparation (Any)',
				),
				'default_value' => '',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_5783261999638',
				'label' => 'Eligibility Criteria',
				'name' => 'eligibility_criteria',
				'type' => 'checkbox',
				'instructions' => 'filter for map only',
				'choices' => array (
					'Enrolled in school (K-12)' => 'Enrolled in school (K-12)',
					'Enrolled in college' => 'Enrolled in college',
					'Resident of a particular geography' => 'Resident of a particular geography',
					'Grade level' => 'Grade level',
					'Special populations (or targeted population)' => 'Special populations (or targeted population)',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_5783264b99639',
				'label' => 'Eligibility Criteria2',
				'name' => 'eligibility_criteria2',
				'type' => 'checkbox',
				'instructions' => 'filter for listings only',
				'choices' => array (
					'Enrolled in school (K-12)' => 'Enrolled in school (K-12)',
					'Enrolled in college' => 'Enrolled in college',
					'Resident of a particular geography (Borough)' => 'Resident of a particular geography (Borough)',
					'Resident of a particular geography (Neighborhood)' => 'Resident of a particular geography (Neighborhood)',
					'Resident of a particular geography (Any)' => 'Resident of a particular geography (Any)',
					'Grade level' => 'Grade level',
					'Special populations (or targeted population)' => 'Special populations (or targeted population)',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_578326e99963a',
				'label' => 'Enrollment Type',
				'name' => 'enrollment_type',
				'type' => 'checkbox',
				'choices' => array (
					'Open enrollment' => 'Open enrollment',
					'Limited enrollment' => 'Limited enrollment',
					'Closed program' => 'Closed program',
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
add_action('init', 'crc_gnsm_acf_field_setup_listing_details');

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
			$boroughs = get_post_meta($thispost->ID, 'borough');
			$neighborhoods = get_post_meta($thispost->ID, 'neighborhoods');
			$grades_served = get_post_meta($thispost->ID, 'education_levels_served');
			$target_population = get_post_meta($thispost->ID, 'targeted_populations_served');
			$eligibility_criteria = get_post_meta($thispost->ID, 'eligibility_criteria');
			$services = get_post_meta($thispost->ID, 'services_provided');
			$accepting_students = get_post_meta($thispost->ID, 'enrollment_type');
			$program_description = get_post_meta($thispost->ID, 'program_description');
                        $contact_phone = get_post_meta($thispost->ID, 'phone');
			$address_postal_code = get_post_meta($thispost->ID, 'address_-_postal_code');
			$address_state = get_post_meta($thispost->ID, 'address_-_state');
			$address_city = get_post_meta($thispost->ID, 'address_-_city');
			$address_line_2 = get_post_meta($thispost->ID, 'address_-_line_2');
			$address_line_1 = get_post_meta($thispost->ID, 'address_-_line_1');

			$results[$program_name] = array(
				'post_id' => $thispost->ID,
				'program_name' => $program_name,
				'boroughs' => $boroughs[0],
				'neighborhoods' => $neighborhoods[0],
				'grades' => $grades_served[0],
				'target_population' => $target_population[0],
				'eligibility_criteria' => $eligibility_criteria[0],
				'services' => $services[0],
				'accepting_students' => $accepting_students[0],
				'program_description' => $program_description,
                        	'contact_phone' => $contact_phone,
				'address_postal_code' => $address_postal_code,
				'address_state' => $address_state,
				'address_city' => $address_city,
				'address_line_2' => $address_line_2,
				'address_line_1' => $address_line_1,
			);
			wp_reset_postdata();
		}
	}

	wp_send_json($results);
}


function crc_gnsm_activate() {
	// Register custom post types
	crc_gnsm_post_type_setup();

	// Register custom fields (Depends on plugin: Advanced Custom Fields)
	crc_gnsm_acf_field_setup_listing_details();

	// Load posts
	crc_gnsm_import_data('GNYC_SurveyData_PreppedForUpload20160723b.csv');

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
	wp_enqueue_style('font-awesome', '/wp-content/plugins/crc-graduate-nyc-survey-map/includes/styles/font-awesome.css');
	wp_enqueue_style('awesome-bootstrap-checkbox', '/wp-content/plugins/crc-graduate-nyc-survey-map/includes/styles/awesome-bootstrap-checkbox.css');
	wp_enqueue_style('crc-gnyc-main', '/wp-content/plugins/crc-graduate-nyc-survey-map/includes/styles/crc-gnyc-main.css');
}
add_action('wp_enqueue_scripts', 'crc_styles_enqueue');

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

?>
