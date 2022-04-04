<?php

// MagTricky _data_ controller

$magtricky__params = $api__array = [];
$magtricky__array = [
	'Myke' => 0,
	'Federico' => 0,
	'Stephen' => 0,
];

$magtricky__request = $airtable->getContent('MagTricky titles', $magtricky__params);
do {
	$magtricky__response = $magtricky__request->getResponse();
	if (is_countable($magtricky__response['records'])) {
		// Response from Airtable is countable, even if 0, so move forward
		foreach ($magtricky__response['records'] as $array) {
			// $id = json_decode(json_encode($array), true)["id"];
			$fields = json_decode(json_encode($array), true)['fields'];
			$magtricky__array[check_key('Title holder', $fields)]++;

			$api__array[str_replace(' ', '_', strtolower(check_key('Chairman', $fields)))]['name'] = check_key(
				'Title holder',
				$fields
			);
		}
	} else {
		// Response from Airtable is not countable, so it's probably an error instead of an empty array
		include $incl_path . 'airtable_error.php';
	}
} while ($magtricky__request = $magtricky__response->next());

// echo '<pre>', var_dump($magtricky__array), '</pre>';
// echo '<pre>', var_dump($api__array), '</pre>';
