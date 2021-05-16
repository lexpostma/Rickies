<?php

// Rickies rules _data_ controller

$rules__params = [
	'fields' => ['Rule styled', 'Start date', 'End date', 'Order', 'id', 'Rule type', 'Applied to Rickies'],
	'filterByFormula' => 'AND( {Applied to Rickies} )',
	'sort' => [['field' => 'Type', 'direction' => 'asc'], ['field' => 'Order', 'direction' => 'asc']],
];

$rules__array = [];
$rules__request = $airtable->getContent('Rules', $rules__params);
do {
	$rules__response = $rules__request->getResponse();
	foreach ($rules__response['records'] as $array) {
		// $id = json_decode(json_encode($array), true)["id"];
		$fields = json_decode(json_encode($array), true)['fields'];

		// if (check_key('Rule type', $fields) == 'Rickies') {
		// 	$type = 'rickies';
		// } elseif (check_key('Rule type', $fields) == 'Flexies') {
		// 	$type = 'rickies';
		// }else {
		// 	$type = 'flexies';
		// }
		$rules__array[check_key('Rule type', $fields, '')][] = [
			'id' => check_key('id', $fields),
			'rule' => a_blank(markdown(check_key('Rule styled', $fields))),
			'date_start' => strtotime(check_key('Start date', $fields)),
			'date_end' => strtotime(check_key('End date', $fields)),
			'events' => check_key('Applied to Rickies', $fields),
			'order' => check_key('Order', $fields),
		];
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
