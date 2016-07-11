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

	$headerCheckboxMap = array();

	if (($fh = fopen($importFile, 'r')) !== False) {
		while (($data = fgetcsv($fh, 0, ',', '"')) !== False) {
			if ($row == 0) {
				// initialize for header row
				for ($i = 0; $i < count($data); $i++) {
					$headers[$data[$i]] = $i;
				}
	$matchingIndices = array();

	// get field values for each row with header prefix matching $fieldLabel
	foreach ($rowHeaderData as $key => $val) {
		$matchingIndices[] = $key;
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
			'name' => 'Organization name',
			'field_5783219899626' => 'Survey number',
			'field_578321e099627' => 'Organization number',
			'field_5783221099628' => 'Response ID',
			'field_5783222899629' => 'Phone',
			'field_5783223b9962a' => 'Email',
			'field_578322669962c' => 'Program description',
			'field_578322769962d' => 'Address - Line 1',
			'field_578322809962e' => 'Address - Line 2',
			'field_578322869962f' => 'Address - City',
			'field_5783229199630' => 'Address - State',
			'field_5783229a99631' => 'Address - Postal code',
		),
		'checkbox' => array(
			'field_57832f5dad1dd' => 'Borough',
			'field_578322d199633' => 'Neighborhoods',
			'field_578324cf99634' => 'Education Levels Served',
			'field_5783256c99635' => 'Targeted Populations Served',
			'field_5783258799636' => 'Services Provided',
			'field_578325c499637' => 'Services Provided2',
			'field_5783261999638' => 'Eligibility Criteria',
			'field_5783264b99639' => 'Eligibility Criteria2',
			'field_578326e99963a' => 'Enrollment Type',
		),
	);

	// iterate through field map and assign values to $postData
	foreach ($fieldMap as $fieldType => $fieldList) {
		foreach($fieldList as $fieldKey => $fieldLabel) {
			if ($fieldType == 'text') {
				$postData[$fieldKey] = $rowPostData[$rowHeaderData[$fieldLabel]];
			} else if ($fieldType == 'checkbox') {
				$postData[$fieldKey] = crc_gnsm_translate_field_checkbox($fieldLabel, $rowHeaderData, $rowPostData);
			}
		}
	}

	return $postData;
}

function crc_gnsm_translate_field_checkbox($fieldLabel, $rowHeaderData, $rowPostData) {
	$matchingIndices = array();

	// get field values for each row with header prefix matching $fieldLabel
	foreach ($rowHeaderData as $key => $val) {
		$matchingIndices[] = $key;
	}
	// if field value = 1, add row header suffix to value array
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
