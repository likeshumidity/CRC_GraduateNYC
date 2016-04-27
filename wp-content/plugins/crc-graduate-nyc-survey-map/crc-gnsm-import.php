<?php
// error_reporting(E_ALL);
// ini_set('display_errors', True);

/**
 * @package crc-graduate-nyc-survey-map
 * @version 0.1
 * @author Carson Research Consulting (CRC)
 */
/*
Graduate NYC - Program Survey Map is licensed exclusively to Graduate NYC and cannot be used, redistributed or sold  except with their permission.
*/

function console_log($data) {
	echo '<script>';
	echo 'console.log(' . json_encode($data) . ');';
	echo '</script>';
}

// console_log('01');

function crc_gnsm_import_data($importFile) {
//plugin_dir_path( __FILE__
	$importFile = CRC__GNSM_PLUGIN_DIR . $importFile;
// console_log($importFile);

	$headers = array();
	$row = 0;
	if (($fh = fopen($importFile, 'r')) !== FALSE) {
		while (($data = fgetcsv($fh, 0, ',', '"')) !== FALSE) {
			if ($row == 0) {
				// initialize for header row
				$len = count($data);
// console_log('09');

				for ($i = 0; $i < $len; $i++) {
					$headers[$data[$i]] = $i;
				}
			} else {
				// translate and create post
				$postData = crc_gnsm_translate_row($data, $headers);
				crc_gnsm_create_post($postData);
			}

			$row++;
		}
	}
}

// console_log('02');

function crc_gnsm_translate_row($rowPostData, $rowHeaderData) {
	$postData = array();
	$fieldMap = array(
		'text' => array(
			'name' => 'org name',
			'field_5706dda975f1c' => 'response id',
			'field_5706de6175f21' => 'orgphone',
			'field_5706dddf75f1d' => 'addressone',
			'field_5706de0275f1e' => 'addresstwo',
			'field_5706de2575f1f' => 'city',
			'field_5706de4675f20' => 'state',
			'field_5706deca75f22' => 'zip',
			'field_5706df2275f23' => 'program description',
		),
		'boolean' => array(
			'field_570d7e356b64e' => array(
				'Brooklyn' => 'brooklyn',
				'Bronx' => 'bronx',
				'Manhattan' => 'manhattan',
				'Queens' => 'queens',
				'Staten Island' => 'statenisland',
			),
			'field_57058bf68c3b6' => array(
				'Open' => 'accepting - open',
				'Limited' => 'accepting - limited',
				'Closed' => 'accepting - closed',
			),
		),
		'arrayMulti' => array(
			'field_570d7e766b64f' => array(
				'Brooklyn' => 'brooklyn neighborhoods',
				'Bronx' => 'bronx neighborhoods',
				'Manhattan' => 'manhattan neighborhoods',
				'Queens' => 'queens neighborhoods',
				'Staten Island' => 'staten island neighborhoods',
			),
		),
		'array' => array(
			'field_57058d1a453c5' => 'target population',
			'field_570592ca24d14' => 'grades served',
			'field_570593872b93a' => 'services offered',
		),
	);

// console_log('10');
	// iterate through field map and assign values to $postData
	foreach ($fieldMap as $fieldType => $fieldList) {
		foreach($fieldList as $fieldName => $fieldTranslation) {
			if ($fieldType == 'text') {
				$postData[$fieldName] = $rowPostData[$rowHeaderData[$fieldTranslation]];
// console_log($rowPostData);
// console_log($rowHeaderData);
// console_log($fieldTranslation);
			} else if ($fieldType == 'boolean') {
				$postData[$fieldName] = crc_gnsm_translate_field_boolean($fieldTranslation, $rowPostData, $rowHeaderData);
			} else if ($fieldType == 'arrayMulti') {
				$postData[$fieldName] = crc_gnsm_translate_field_arrayMulti($fieldTranslation, $rowPostData, $rowHeaderData);
			} else if ($fieldType == 'array') {
				$postData[$fieldName] = crc_gnsm_translate_field_array($rowPostData[$rowHeaderData[$fieldTranslation]]);
			}
// console_log('11');
		}
	}

	return $postData;
}

// console_log('03');

function crc_gnsm_translate_field_boolean($fieldValue, $rowPostData, $rowHeaderData) {
	$valueArray = array();

	foreach($fieldValue as $title => $reference) {
		if ($rowPostData[$rowHeaderData[$reference]] == 'TRUE') {
			$valueArray[] = $title;
		}
	}

// console_log('12');
	return $valueArray;
}

// console_log('04');

function crc_gnsm_translate_field_arrayMulti($fieldValue, $rowPostData, $rowHeaderData) {
	$fullArray = array();

	foreach($fieldValue as $group => $reference) {
		$partialArray = crc_gnsm_array_from_string_no_empties($rowPostData[$rowHeaderData[$reference]]);
		foreach($partialArray as $value) {
			$fullArray[] = $group . ' - ' . $value;
		}
	}

// console_log('13');
	return $fullArray;
}

// console_log('05');

function crc_gnsm_translate_field_array($fieldValue) {
	$postDataField = crc_gnsm_array_from_string_no_empties($fieldValue);

// console_log('14');
	return $postDataField;
}

// console_log('06');

function crc_gnsm_array_from_string_no_empties($stringValue, $delimiter = ',') {
	$newArray = array();

	$tempArray = explode($delimiter, $stringValue);

	foreach ($tempArray as $value) {
		if (!empty($value)) {
			$newArray[] = $value;
		}
	}

	return $newArray;
}

// console_log('07');

//crc_gnsm_import_data('sampleDataGNYC20160425a.csv');

// console_log('08');

function crc_gnsm_create_post($postData) {
// Create post object and assign meta data
	$postArray = array();
	$wpError = '';

	$postArray['post_title'] = $postData['name'];
	$postArray['post_type'] = 'gnsm_listing';

	if (get_page_by_title($postArray['post_title']) == null) {
		$postID = wp_insert_post($postArray, $wpError);

		if ($wpError != 1) {
			//Add Metadata
			foreach($postData as $key => $val) {
				if (substr($key, 0, 5) == 'field') {
					update_field($key, $val, $postID);
				}
			}
	
			wp_publish_post($postID);
		} else {
//			console_log($postData);
		}
	}
//	print_r($postData);
//	print('<br />');
// console_log('14');
}

// console_log('07');

?>
