<?php

// Rickies rules _data_ controller

if (!isset($rules__params['filterByFormula'])) {
	$rules__params['filterByFormula'] = 'AND( {Applied to Rickies}, {Rules set} = "Rickies", {Section within type} )';
}

if (!isset($rules__params['fields'])) {
	$rules__params['fields'] = [
		'Rule styled',
		'Start date',
		'End date',
		'Order',
		'id',
		'Rule type',
		'Applied to Rickies',
		'Last edit date',
		'Section within type',
	];
}
if (!isset($rules__params['sort'])) {
	$rules__params['sort'] = [['field' => 'Type', 'direction' => 'asc'], ['field' => 'Order', 'direction' => 'asc']];
}

$rules__array = [];
$rules__request = $airtable->getContent('Rules', $rules__params);
do {
	$rules__response = $rules__request->getResponse();
	if (is_countable($rules__response['records'])) {
		// Response from Airtable is countable, even if 0, so move forward
		foreach ($rules__response['records'] as $array) {
			// $id = json_decode(json_encode($array), true)["id"];
			$fields = json_decode(json_encode($array), true)['fields'];

			$rules__array[check_key('Rule type', $fields, '')][] = [
				'id' => check_key('id', $fields),
				'rule' => a_blank(markdown(check_key('Rule styled', $fields))),
				'date_start' => strtotime(check_key('Start date', $fields)),
				'date_end' => strtotime(check_key('End date', $fields)),
				'events' => check_key('Applied to Rickies', $fields),
				'order' => check_key('Order', $fields),
				'section' => check_key('Section within type', $fields),
				'last_edited' => check_key('Last edit date', $fields),
			];
		}
	} else {
		// Response from Airtable is not countable, so it's probably an error instead of an empty array
		include $incl_path . 'airtable_error.php';
	}
} while ($rules__request = $rules__response->next());

// Add target="_blank" to external links;
function a_blank($input)
{
	$output = str_replace(
		'<a href="http',
		'<a
			target="_blank"
			href="http',
		$input
	);

	return $output;
}

// echo '<pre>', var_dump($rules__array), '</pre>';
