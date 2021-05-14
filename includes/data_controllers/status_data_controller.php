<?php

// Rickies picks _data_ controller

$status_data__params = [
	// 'filterByFormula' => "AND( URL = '$url_view' )",
	// 'sort' => [['field' => 'Order', 'direction' => 'asc']],
	// 	"fields" => ["Artwork", "Name", "URL", "Winner (manual)", "Episode date"],
];

$status_data__array = [];
$status_data__request = $airtable->getContent('Rickies states', $status_data__params);
do {
	$status_data__response = $status_data__request->getResponse();

	// echo '<pre>', var_dump($status_data__request), '</pre>';

	foreach ($status_data__response['records'] as $array) {
		$id = json_decode(json_encode($array), true)['id'];
		$fields = json_decode(json_encode($array), true)['fields'];

		$status_data__array[check_key('Name', $fields)] =
			// 'name' => check_key('Pick', $fields),
			// 'count' => check_key('Count', $fields),
			check_key('Count', $fields);
	}
} while ($status_data__request = $status_data__response->next());

// echo '<pre>', var_dump($status_data__array), '</pre>';
