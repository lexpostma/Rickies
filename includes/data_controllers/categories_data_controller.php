<?php

// Rickies pick categories _data_ controller

$categories__params = [
	'fields' => ['Name', 'Web safe name', 'Group L1', 'Group L1 emoji', 'Group L2', 'Web safe group L2'],
	'filterByFormula' => 'AND( {Picks} )',
	'sort' => [['field' => 'Group L1', 'direction' => 'asc'], ['field' => 'Order', 'direction' => 'asc']],
];

$categories__array = [];
$categories__request = $airtable->getContent('Pick categories', $categories__params);
do {
	$categories__response = $categories__request->getResponse();
	foreach ($categories__response['records'] as $array) {
		// $id = json_decode(json_encode($array), true)["id"];
		$fields = json_decode(json_encode($array), true)['fields'];

		$group = check_key('Group L1', $fields);

		if (check_key('Group L2', $fields)) {
			$categories__array[$group]['categories'][check_key('Group L2', $fields)] = check_key(
				'Web safe group L2',
				$fields
			);
		} else {
			$categories__array[$group]['categories'][check_key('Name', $fields)] = check_key('Web safe name', $fields);
		}

		// $categories__array[$group] = [
		$categories__array[$group]['value'] = strtolower(check_key('Group L1', $fields));
		$categories__array[$group]['emoji'] = check_key('Group L1 emoji', $fields);
		// ];
	}
} while ($categories__request = $categories__response->next());

// echo '<pre>', var_dump($categories__array), '</pre>';
