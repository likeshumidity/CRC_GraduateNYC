<?php

$crc_gnsm_listing_attributes = array(
	'borroughs' => array(
		'select-multiple',
		array(
			'Brooklyn',
			'Bronx',
			'Manhattan',
			'Queens',
			'Staten Island',
		),
	),
	'open-status' => array(
		'select',
		array(
			'Open',
			'Limited',
			'Closed',
		),
	),
	'target-population' => array(
		'select',
		array(
			'Academic Performance',
			'English language learners',
			'Disconnected youth/Out of school youth',
			'Students with IEP or other learning challenges',
			'High school equivalency',
			'Poverty guidelines/socioeconomic status',
			'Justice involved youth',
			'First generation college students',
			'Racial or ethnic minorities',
			'Gender',
		),
	),
	'grades-served' => array(
		'select-multiple',
		array(
			'Elementary school (K-5)',
			'Middle school (6-8)',
			'High School (9-12)',
			'College',
		),
	),
	'services' => array(
		'select-multiple',
		array(
			'College Readiness',
			'College Matriculation',
			'College Retention',
			'Career Preparation',
			'Technical assistance to community based organizations',
			'A network for convening CBOs or programs that work on similar issues or work with overlapping sets of students',
			'Professional development for college access and success staff',
			'Training or awareness for students',
			'Research connected to this field for practitioner use',
			'Advocacy on behalf of the sector or segments of it',
			'Online resources for students and/or staff',
		),
	),
);

?>