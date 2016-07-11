<?php
error_reporting(E_ALL);
ini_set('display_errors', True);

/**
 * @package crc-graduate-nyc-survey-map
 * @version 0.1
 * @author Carson Research Consulting (CRC)
 */

function crc_gnsm_import_data($importFile) {
	$importFile = CRC__GNSM_PLUGIN_DIR . $importFile;

	$headers = array();
	$row = 0;

	if (($fh = fopen($importFile, 'r')) !== False) {
		while (($data = fgetcsv($fh, 0, ',', '"')) !== False) {
			if ($row == 0) {
				// initialize for header row
				for ($i = 0; $i < count($data); $i++) {
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

	// iterate through field map and assign values to $postData
	foreach ($fieldMap as $fieldType => $fieldList) {
		foreach($fieldList as $fieldName => $fieldTranslation) {
			if ($fieldType == 'text') {
				$postData[$fieldName] = $rowPostData[$rowHeaderData[$fieldTranslation]];
			} else if ($fieldType == 'boolean') {
				$postData[$fieldName] = crc_gnsm_translate_field_boolean($fieldTranslation, $rowPostData, $rowHeaderData);
			} else if ($fieldType == 'arrayMulti') {
				$postData[$fieldName] = crc_gnsm_translate_field_arrayMulti($fieldTranslation, $rowPostData, $rowHeaderData);
			} else if ($fieldType == 'array') {
				$postData[$fieldName] = crc_gnsm_translate_field_array($rowPostData[$rowHeaderData[$fieldTranslation]]);
			}
		}
	}

	return $postData;
}

function crc_gnsm_translate_field_boolean($fieldValue, $rowPostData, $rowHeaderData) {
	$valueArray = array();

	foreach($fieldValue as $title => $reference) {
		if ($rowPostData[$rowHeaderData[$reference]] == 'TRUE') {
			$valueArray[] = $title;
		}
	}

	return $valueArray;
}

function crc_gnsm_translate_field_arrayMulti($fieldValue, $rowPostData, $rowHeaderData) {
	$fullArray = array();

	foreach($fieldValue as $group => $reference) {
		$partialArray = crc_gnsm_array_from_string_no_empties($rowPostData[$rowHeaderData[$reference]]);
		foreach($partialArray as $value) {
			$fullArray[] = $group . ' - ' . $value;
		}
	}

	return $fullArray;
}

function crc_gnsm_translate_field_array($fieldValue) {
	$postDataField = crc_gnsm_array_from_string_no_empties($fieldValue);

	return $postDataField;
}

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

function crc_gnsm_create_post($postData) {
// Create post object and assign meta data
	$postArray = array();

	$postArray['post_title'] = $postData['name'];
	$postArray['post_type'] = 'gnsm_listing';

	if (get_page_by_title($postArray['post_title'], OBJECT, 'post') == null) {
		$postID = wp_insert_post($postArray, true);

		//Add Metadata
		foreach($postData as $key => $val) {
			if (substr($key, 0, 5) == 'field') {
				update_field($key, $val, $postID);
			}
		}

		wp_publish_post($postID);
	}
}

?>
