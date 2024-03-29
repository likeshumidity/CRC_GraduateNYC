<?php
/**
 * @package crc-graduate-nyc-survey-map
 * @version 1.0
 * @author Carson Research Consulting (CRC)
 */
/*
Plugin Name: Graduate NYC - Program Survey Map
Plugin URI: http://www.carsonresearch.com
Description: Custom plugin for Graduate NYC program survey map.
Version: 1.0
Author: Carson Research Consulting (CRC)
Author URI: http://www.carsonresearch.com

Graduate NYC - Program Survey Map is licensed exclusively to Graduate NYC and cannot be used, redistributed or sold  except with their permission.
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'CRC__GNSM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( CRC__GNSM_PLUGIN_DIR . 'crc-gnsm-import.php' );

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
				'label' => 'Boroughs',
				'name' => 'boroughs',
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
					'Elementary school (K-5)' => 'Elementary school (K-5)',
					'Middle school (6-8)' => 'Middle school (6-8)',
					'High school (9-12)' => 'High school (9-12)',
					'Post-secondary school' => 'Post-secondary school',
					'Adult learners and High School Equivalency' => 'Adult learners and High School Equivalency',
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
					'Academic performance level-Low' => 'Academic performance level-Low',
					'Academic performance level-Average' => 'Academic performance level-Average',
					'Academic performance level-High' => 'Academic performance level-High',
					'English language learners' => 'English language learners',
					'Disconnected youth/Out of school youth' => 'Disconnected youth/Out of school youth',
					'Students with IEP or other learning challenges' => 'Students with IEP or other learning challenges',
					'High school equivalency (HSE)' => 'High school equivalency (HSE)',
					'Justice involved youth' => 'Justice involved youth',
					'Immigrants/Refugees' => 'Immigrants/Refugees',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_5783258799636',
				'label' => 'Services Provided',
				'name' => 'services_provided',
				'type' => 'checkbox',
				'choices' => array (
					'College Readiness' => 'College Readiness',
					'College Matriculation' => 'College Matriculation',
					'College Persistence' => 'College Persistence',
					'Career Preparation' => 'Career Preparation',
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
					'College Readiness (Academic behaviors)' => 'College Readiness (Academic behaviors)',
					'College Readiness (ACT/SAT/PSAT preparation)' => 'College Readiness (ACT/SAT/PSAT preparation)',
					'College Readiness (College campus visits)' => 'College Readiness (College campus visits)',
					'College Readiness (College exploration)' => 'College Readiness (College exploration)',
					'College Readiness (Tutoring/Academic support)' => 'College Readiness (Tutoring/Academic support)',
					'College Readiness (Any)' => 'College Readiness (Any)',
					'College Matriculation (College application help)' => 'College Matriculation (College application help)',
					'College Matriculation (Financial Aid)' => 'College Matriculation (Financial Aid)',
					'College Matriculation (Placement test prep)' => 'College Matriculation (Placement test prep)',
					'College Matriculation (Any)' => 'College Matriculation (Any)',
					'College Persistence (Academic/Degree planning)' => 'College Persistence (Academic/Degree planning)',
					'College Persistence (Connecting students to campus resources)' => 'College Persistence (Connecting students to campus resources)',
					'College Persistence (Connecting students to off-campus resources)' => 'College Persistence (Connecting students to off-campus resources)',
					'College Persistence (Course registration)' => 'College Persistence (Course registration)',
					'College Persistence (Major selection)' => 'College Persistence (Major selection)',
					'College Persistence (Mentoring)' => 'College Persistence (Mentoring)',
					'College Persistence (Support services related to college retention)' => 'College Persistence (Support services related to college retention)',
					'College Persistence (Tutoring)' => 'College Persistence (Tutoring)',
					'College Persistence (Non-academic skills)' => 'College Persistence (Non-academic skills)',
					'College Persistence (Financial support/incentives)' => 'College Persistence (Financial support/incentives)',
					'College Persistence (Financial Aid reapplication)' => 'College Persistence (Financial Aid reapplication)',
					'College Persistence (Any)' => 'College Persistence (Any)',
					'Career Preparation (Career counseling)' => 'Career Preparation (Career counseling)',
					'Career Preparation (Resume and interview skills)' => 'Career Preparation (Resume and interview skills)',
					'Career Preparation (Any)' => 'Career Preparation (Any)',
				),
				'default_value' => '',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_5783261999638',
				'label' => 'Eligibility Criteria',
				'name' => 'eligibility_criteria',
				'type' => 'checkbox',
				'choices' => array (
					'K-12 enrollment' => 'K-12 enrollment',
					'College enrollment' => 'College enrollment',
					'Education level' => 'Education level',
					'Geographic residence' => 'Geographic residence',
					'Member of a targeted population' => 'Member of a targeted population',
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
					'Open Enrollment' => 'Open Enrollment',
					'Limited Enrollment' => 'Limited Enrollment',
					'Closed Program' => 'Closed Program',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_57985cff9881b',
                                'label' => 'Organization Type',
                                'name' => 'organization_type',
				'type' => 'checkbox',
				'instructions' => 'filter for listings only',
				'choices' => array (
					'Direct service' => 'Direct service',
					'Supports the college access and success sector' => 'Supports the college access and success sector',
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_57b0e4149c862',
				'label' => 'School Partnerships',
				'name' => 'school_partnerships',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_57b0e43f1e248',
				'label' => 'CBO Latitude',
				'name' => 'cbo_latitude',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_57b0e47bffd4a',
				'label' => 'CBO Longitude',
				'name' => 'cbo_longitude',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
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
	add_rewrite_tag('%crc-data%', '([^&]+)');
	add_rewrite_rule('data/([^&]+)/?', 'index.php?crc-data=$1', 'top');
}
add_action('init', 'crc_gnsm_survey_results');

function crc_gnsm_survey_results_data() {
	global $wp_query;

	$gnsm_tag = $wp_query->get('crc-data');

	switch($gnsm_tag) {
		case 'JSON':
			crc_gnsm_survey_results_JSON();
			break;
		case 'CSV':
			crc_gnsm_survey_results_CSV();
			break;
		default:
			return;
	}
}
add_action('template_redirect', 'crc_gnsm_survey_results_data');

function crc_gnsm_survey_results_JSON() {
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
			$grades_served = get_post_meta($thispost->ID, 'education_levels_served');
			$target_population = get_post_meta($thispost->ID, 'targeted_populations_served');
			$eligibility_criteria = get_post_meta($thispost->ID, 'eligibility_criteria');
			$services = get_post_meta($thispost->ID, 'services_provided');
			$services2 = get_post_meta($thispost->ID, 'services_provided2');
			$accepting_students = get_post_meta($thispost->ID, 'enrollment_type');
			$organization_type = get_post_meta($thispost->ID, 'organization_type');
			$program_description = get_post_meta($thispost->ID, 'program_description');
                        $contact_phone = get_post_meta($thispost->ID, 'phone');
			$address_postal_code = get_post_meta($thispost->ID, 'address_-_postal_code');
			$address_state = get_post_meta($thispost->ID, 'address_-_state');
			$address_city = get_post_meta($thispost->ID, 'address_-_city');
			$address_line_2 = get_post_meta($thispost->ID, 'address_-_line_2');
			$address_line_1 = get_post_meta($thispost->ID, 'address_-_line_1');
			$school_partnerships = get_post_meta($thispost->ID, 'school_partnerships');
			$cbo_latitude = get_post_meta($thispost->ID, 'cbo_latitude');
			$cbo_longitude = get_post_meta($thispost->ID, 'cbo_longitude');

			$results[$program_name] = array(
				'post_id' => $thispost->ID,
				'program_name' => $program_name,
				'boroughs' => $boroughs[0],
				'neighborhoods' => $neighborhoods[0],
				'grades' => $grades_served[0],
				'target_population' => $target_population[0],
				'eligibility_criteria' => $eligibility_criteria[0],
				'services' => $services[0],
				'services2' => $services2[0],
				'accepting_students' => $accepting_students[0],
				'organization_type' => $organization_type[0],
				'program_description' => $program_description,
                        	'contact_phone' => $contact_phone,
				'address_postal_code' => $address_postal_code,
				'address_state' => $address_state,
				'address_city' => $address_city,
				'address_line_2' => $address_line_2,
				'address_line_1' => $address_line_1,
				'school_partnerships' => $school_partnerships,
                                'cbo_latitude' => $cbo_latitude,
                                'cbo_longitude' => $cbo_longitude,
			);
			wp_reset_postdata();
		}
	}

	wp_send_json($results);
}

function crc_gnsm_survey_results_CSV() {
	$results = array();

	$results[] = array(
		'post_id',
		'program_name',
		'boroughs',
		'neighborhoods',
		'grades',
		'target_population',
		'eligibility_criteria',
		'services',
		'services2',
		'accepting_students',
		'organization_type',
		'program_description',
		'contact_phone',
		'address_postal_code',
		'address_state',
		'address_city',
		'address_line_2',
		'address_line_1',
		'school_partnerships',
		'cbo_latitude',
		'cbo_longitude',
		);

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
			$grades_served = get_post_meta($thispost->ID, 'education_levels_served');
			$target_population = get_post_meta($thispost->ID, 'targeted_populations_served');
			$eligibility_criteria = get_post_meta($thispost->ID, 'eligibility_criteria');
			$services = get_post_meta($thispost->ID, 'services_provided');
			$services2 = get_post_meta($thispost->ID, 'services_provided2');
			$accepting_students = get_post_meta($thispost->ID, 'enrollment_type');
			$organization_type = get_post_meta($thispost->ID, 'organization_type');
			$program_description = get_post_meta($thispost->ID, 'program_description');
                        $contact_phone = get_post_meta($thispost->ID, 'phone');
			$address_postal_code = get_post_meta($thispost->ID, 'address_-_postal_code');
			$address_state = get_post_meta($thispost->ID, 'address_-_state');
			$address_city = get_post_meta($thispost->ID, 'address_-_city');
			$address_line_2 = get_post_meta($thispost->ID, 'address_-_line_2');
			$address_line_1 = get_post_meta($thispost->ID, 'address_-_line_1');
			$school_partnerships = get_post_meta($thispost->ID, 'school_partnerships');
			$cbo_latitude = get_post_meta($thispost->ID, 'cbo_latitude');
			$cbo_longitude = get_post_meta($thispost->ID, 'cbo_longitude');

			$results[] = array(
				$thispost->ID,
				$program_name,
				$boroughs[0],
				$neighborhoods[0],
				$grades_served[0],
				$target_population[0],
				$eligibility_criteria[0],
				$services[0],
				$services2[0],
				$accepting_students[0],
				$organization_type[0],
				$program_description,
                        	$contact_phone,
				$address_postal_code,
				$address_state,
				$address_city,
				$address_line_2,
				$address_line_1,
				$school_partnerships,
                                $cbo_latitude,
                                $cbo_longitude,
			);
			wp_reset_postdata();
		}
	}

	crc_send_csv($results);
}


function crc_send_csv($dataset) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=GraduateNYCSurveyData.csv');

    $output = fopen('php://output', 'w');

    for ($i = 0; $i < count($dataset); $i++) {
	foreach($dataset[$i] as $key => $val) {
		if (gettype($val) == 'array') {
			$dataset[$i][$key] = implode(';', $dataset[$i][$key]);
		}
	}

        fputcsv($output, $dataset[$i]);
    }
}


function crc_change_post_status($post_id, $status) {
        $thisPost = get_post($post_id, 'ARRAY_A');
        $thisPost['post_status'] = $status;

        wp_update_post($thisPost);
}


function crc_gnsm_post_published_to_draft() {
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
			$postID = $thispost->ID;

			crc_change_post_status($postID, 'Draft');
		}
	}
}


function crc_gnsm_activate() {
	// Register custom post types
	crc_gnsm_post_type_setup();

	// Register custom fields (Depends on plugin: Advanced Custom Fields)
	crc_gnsm_acf_field_setup_listing_details();

	// Load posts
	crc_gnsm_import_data('GNYC_SurveyData_PreppedForUpload20160810b.csv');

	// Create listing and map pages TODO

	// Clear permalinks after post type registered
	flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'crc_gnsm_activate');

function crc_gnsm_deactivate() {
        // Change existings post status from Publish to Draft
        crc_gnsm_post_published_to_draft();

	// Clear permalinks to remove post type rules
	flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'crc_gnsm_deactivate');

function crc_styles_enqueue() {
	wp_enqueue_style('bootstrap-crc', '/wp-content/plugins/crc-graduate-nyc-survey-map/includes/styles/bootstrap.css');
	wp_enqueue_style('font-awesome', '/wp-content/plugins/crc-graduate-nyc-survey-map/includes/styles/font-awesome.css');
	wp_enqueue_style('awesome-bootstrap-checkbox', '/wp-content/plugins/crc-graduate-nyc-survey-map/includes/styles/awesome-bootstrap-checkbox.css');
	wp_enqueue_style('fontello', '/wp-content/plugins/crc-graduate-nyc-survey-map/includes/styles/fontello.css');
	wp_enqueue_style('crc-gnyc-main', '/wp-content/plugins/crc-graduate-nyc-survey-map/includes/styles/crc-gnyc-main.css');
}
add_action('wp_enqueue_scripts', 'crc_styles_enqueue');

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

?>
