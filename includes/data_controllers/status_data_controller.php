<?php

// Rickies picks _data_ controller

$status_data__params = [
	'filterByFormula' => 'AND( Published = TRUE() )',
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
		$status_data__array['Total'] = [
			'rickies' => 0,
			'pre-rickies' => 0,
			'specials' => 0,
		];

		foreach ($status_data__response['records'] as $array) {
			$id = json_decode(json_encode($array), true)['id'];
			$fields = json_decode(json_encode($array), true)['fields'];

			$status_data__array[check_key('Name', $fields)] = [
				'rickies' => check_key('Count Rickies', $fields, 0),
				'pre-rickies' => check_key('Count Pre-Rickies', $fields, 0),
				'specials' => check_key('Count specials', $fields, 0),
			];

			$status_data__array['Total'] = [
				'rickies' =>
					$status_data__array['Total']['rickies'] +
					$status_data__array[check_key('Name', $fields)]['rickies'],
				'pre-rickies' =>
					$status_data__array['Total']['pre-rickies'] +
					$status_data__array[check_key('Name', $fields)]['pre-rickies'],
				'specials' =>
					$status_data__array['Total']['specials'] +
					$status_data__array[check_key('Name', $fields)]['specials'],
			];
		}
	} else {
		// Response from Airtable is not countable, so it's probably an error instead of an empty array
		include $incl_path . 'airtable_error.php';
	}
} while ($status_data__request = $status_data__response->next());

// echo '<pre>', var_dump($status_data__array), '</pre>';
