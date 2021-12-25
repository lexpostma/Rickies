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
	if (is_countable($status_data__response['records'])) {
		// Response from Airtable is countable, even if 0, so move forward
		foreach ($status_data__response['records'] as $array) {
			$id = json_decode(json_encode($array), true)['id'];
			$fields = json_decode(json_encode($array), true)['fields'];

			$status_data__array[check_key('Name', $fields)] =
				// 'name' => check_key('Pick', $fields),
				// 'count' => check_key('Count', $fields),
				check_key('Count', $fields);
		}
	} else {
		// Response from Airtable is not countable, so it's probably an error instead of an empty array
		include $incl_path . 'airtable_error.php';
	}
} while ($status_data__request = $status_data__response->next());

// echo '<pre>', var_dump($status_data__array), '</pre>';
