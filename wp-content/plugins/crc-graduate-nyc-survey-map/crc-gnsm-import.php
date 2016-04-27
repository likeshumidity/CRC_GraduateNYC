<?php
/**
 * @package crc-graduate-nyc-survey-map
 * @version 0.1
 * @author Carson Research Consulting (CRC)
 */
/*
Graduate NYC - Program Survey Map is licensed exclusively to Graduate NYC and cannot be used, redistributed or sold  except with their permission.
*/

function crc_gnsm_import_data() {
	$CRCimportFileName = 'sampleDataGNYC20160425a.csv';

	$headers = array();
	$row = 0;
	$CRCimportFile = 
	if (($fh = fopen($CRCimportFileName, 'r')) !== FALSE) {
		while (($data = fgetcsv($fh, 0, ',', '"')) !== FALSE) {
			if ($row == 0) {
				// initialize for header row
				$len = count($data);

				for ($i = 0; $i < $len; $i++) {
					$headers[$data[i]] = $i;
				}
			} else {
				// create post
				crc_gnsm_create_post($row, $headers);
			}
		}
	}
}

function crc_gnsm_create_post($rowPostData, $rowHeaderData) {
	// Create post
	$fieldsTextOnly = array(
		'org name' => 'org name',
		'response id' => 'response id',
		'orgphone' => 'orgphone',
		'addressone' => 'addressone',
		'addresstwo' => 'addresstwo',
		'city' => 'city',
		'state' => 'state',
		'zip' => 'zip',
		'program description' => 'program description',
	);

	$fieldsBoolean = array(
		'brooklyn' => 'brooklyn',
		'bronx' => 'bronx',
		'manhattan' => 'manhattan',
		'queens' => 'queens',
		'statenisland' => 'statenisland',
		'accepting - open' => 'accepting - open',
		'accepting - limited' => 'accepting - limited',
		'accepting - closed' => 'accepting - closed',
	);

	$fieldsArray = array(
		'brooklyn neighborhoods' => 'brooklyn neighborhoods',
		'bronx neighborhoods' => 'bronx neighborhoods',
		'manhattan neighborhoods' => 'manhattan neighborhoods',
		'queens neighborhoods' => 'queens neighborhoods',
		'staten island neighborhoods' => 'staten island neighborhoods',
		'target population' => 'target population',
		'grades served' => 'grades served',
		'services offered' => 'services offered',
	);
}

