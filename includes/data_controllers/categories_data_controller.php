<?php

// Rickies pick categories _data_ controller

$categories__params = [
	'fields' => ['Name', 'Name (web)', 'Group L1', 'Group L1 emoji', 'Group L2', 'Group L2 (web)'],
	'filterByFormula' => 'AND( {Picks} )',
	'sort' => [
		['field' => 'Group L1', 'direction' => 'asc'],
		['field' => 'Order', 'direction' => 'asc'],
		['field' => 'Pick count', 'direction' => 'desc'],
	],
];

$categories__array = [];
$categories__request = $airtable->getContent('Pick categories', $categories__params);
do {
	$categories__response = $categories__request->getResponse();
	if (is_countable($categories__response['records'])) {
		// Response from Airtable is countable, even if 0, so move forward
		foreach ($categories__response['records'] as $array) {
			// $id = json_decode(json_encode($array), true)["id"];
			$fields = json_decode(json_encode($array), true)['fields'];

			$group = check_key('Group L1', $fields);

			if (check_key('Group L2', $fields)) {
				$categories__array[$group]['categories'][check_key('Group L2', $fields)]['value'] = check_key(
					'Group L2 (web)',
					$fields
				);
				$categories__array[$group]['categories'][check_key('Group L2', $fields)]['categories'][
					check_key('Name', $fields)
				]['value'] = check_key('Name (web)', $fields);
			} else {
				$categories__array[$group]['categories'][check_key('Name', $fields)]['value'] = check_key(
					'Name (web)',
					$fields
				);
			}

			// $categories__array[$group] = [
			$categories__array[$group]['value'] = strtolower(check_key('Group L1', $fields));
			$categories__array[$group]['emoji'] = check_key('Group L1 emoji', $fields);
			// ];
		}
	} else {
		// Response from Airtable is not countable, so it's probably an error instead of an empty array
		include $incl_path . 'airtable_error.php';
	}
} while ($categories__request = $categories__response->next());

// echo '<pre>', var_dump($categories__array), '</pre>';
