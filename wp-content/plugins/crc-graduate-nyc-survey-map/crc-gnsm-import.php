<?php
/**
 * @package crc-graduate-nyc-survey-map
 * @version 0.1
 * @author Carson Research Consulting (CRC)
 */
/*
Graduate NYC - Program Survey Map is licensed exclusively to Graduate NYC and cannot be used, redistributed or sold  except with their permission.
*/

function crc_gnsm_import_data($importFile) {

	$headers = array();
	$row = 0;
	if (($fh = fopen($importFile, 'r')) !== FALSE) {
		while (($data = fgetcsv($fh, 0, ',', '"')) !== FALSE) {
			if ($row == 0) {
				// initialize for header row
				$len = count($data);

				for ($i = 0; $i < $len; $i++) {
					$headers[$data[i]] = $i;
				}
			} else {
				// translate and create post
				$postData = crc_gnsm_translate_row($row, $headers);
				crc_gnsm_create_post($postData);
			}
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
			'target population' => 'target population',
			'grades served' => 'grades served',
			'services offered' => 'services offered',
		),
	);

	// iterate through field map and assign values to $postData
	foreach ($fieldMap as $fieldType => $fieldList) {
		foreach($fieldList as $fieldName => $fieldTranslation) {
			if ($fieldType == 'text') {
				$postData[$fieldName] = $rowPostData[$rowHeaderData[$fieldTranslation]];
			} else if ($fieldType == 'boolean') {
				$postData[$fieldName] = crc_gnsm_translate_field_text($fieldTranslation, $rowPostData, $rowHeaderData);
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
		if ($rawPostData[$rowHeaderData[$reference]] == 'TRUE') {
			$valueArray[] = $title;
		}
	}

	return $valueArray();
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

function crc_gnsm_create_post($postData) {
// Create post object and assign meta data
	print_r($postData);
	pritn('<br />');
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


crc_gnsm_import_data('sampleDataGNYC20160425a.csv');
