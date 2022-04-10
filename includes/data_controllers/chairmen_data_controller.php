<?php

// Chairmen _data_ controller

$magtricky__array = [
	'Myke' => 0,
	'Federico' => 0,
	'Stephen' => 0,
];
$api__array = [
	'keynote_chairman' => [],
	'annual_chairman' => [],
];

$chairmen__params = [
	'fields' => ['First name', 'Last name', 'Twitter', 'Which chairman', 'Location'],
	'filterByFormula' => 'AND( {Host type} = "Official", {Which chairman} )',
];

$chairmen__request = $airtable->getContent('Hosts', $chairmen__params);
do {
	$chairmen__response = $chairmen__request->getResponse();

	// echo '<pre>', var_dump($chairmen__response), '</pre>';

	if (is_countable($chairmen__response['records'])) {
		// Response from Airtable is countable, even if 0, so move forward

		if (count($chairmen__response['records']) === 1) {
			// Both titles are on 1 host, the consolidated chairman
			foreach ($chairmen__response['records'] as $array) {
				$fields = json_decode(json_encode($array), true)['fields'];

				$magtricky__array[check_key('First name', $fields)] = 2;

				$api__array['keynote_chairman'] = $api__array['annual_chairman'] = [
					'name' => check_key('First name', $fields),
					'last_name' => check_key('Last name', $fields),
					'location' => check_key('Location', $fields),
					// 'memoji' =>
					// 	domain_url() .
					// 	'/images/memoji/memoji-' .
					// 	strtolower(check_key('First name', $fields)) .
					// 	'-default.png',
					// 'twitter' => check_key('Twitter', $fields),
				];
			}
		} else {
			// Multiple different chairmen
			foreach ($chairmen__response['records'] as $array) {
				$fields = json_decode(json_encode($array), true)['fields'];

				$magtricky__array[check_key('First name', $fields)]++;

				$api__array[str_replace(' ', '_', strtolower(check_key('Which chairman', $fields)))] = [
					'name' => check_key('First name', $fields),
					'last_name' => check_key('Last name', $fields),
					'location' => check_key('Location', $fields),
					// 'memoji' =>
					// 	domain_url() .
					// 	'/images/memoji/memoji-' .
					// 	strtolower(check_key('First name', $fields)) .
					// 	'-default.png',
					// 'twitter' => check_key('Twitter', $fields),
				];
			}
		}
	} else {
		// Response from Airtable is not countable, so it's probably an error instead of an empty array
		include $incl_path . 'airtable_error.php';
	}
} while ($chairmen__request = $chairmen__response->next());

// echo '<pre>', var_dump($magtricky__array), '</pre>';
// echo '<pre>', var_dump($api__array), '</pre>';
