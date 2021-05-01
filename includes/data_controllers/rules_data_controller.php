<?php

// Rickies rules _data_ controller

$rules__params = [
	'fields' => ['Rule styled', 'Start date', 'End date', 'Order', 'id', 'Rule type', 'Applied to Rickies'],
	'filterByFormula' => 'AND( {Applied to Rickies} )',
	'sort' => [['field' => 'Rule type', 'direction' => 'desc'], ['field' => 'Order', 'direction' => 'asc']],
];

$rules__array = [];
$rules__request = $airtable->getContent('Rules', $rules__params);
do {
	$rules__response = $rules__request->getResponse();
	foreach ($rules__response['records'] as $array) {
		// $id = json_decode(json_encode($array), true)["id"];
		$fields = json_decode(json_encode($array), true)['fields'];

		// $date_start = strtotime(check_key('Start date', $fields));
		// if (!in_array($date_start, $dates_array)) {
		// 	$dates_array[] = $date_start;
		// }

		// $date_end = strtotime(check_key('End date', $fields));
		// if (!in_array($date_end, $dates_array)) {
		// 	$dates_array[] = $date_end;
		// }

		if (check_key('Rule type', $fields) == 'Rickies') {
			$type = 'rickies';
		} else {
			$type = 'flexies';
		}
		$rules__array[$type][] = [
			'id' => check_key('id', $fields),
			'rule' => a_blank(markdown(check_key('Rule styled', $fields))),
			'events' => check_key('Applied to Rickies', $fields),
			// 'date_start' => $date_start,
			// 'date_end' => $date_end,
			'order' => check_key('Order', $fields),
		];
	}
} while ($rules__request = $rules__response->next());

// Add target="_blank" to links;
function a_blank($input)
{
	return str_replace('<a href="', '<a target="_blank" href="', $input);
}

// echo '<pre>', var_dump($rules__array), '</pre>';
