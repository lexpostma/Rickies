<?php

// Ricky picks _data_ controller

$picks_data__params = [
	'filterByFormula' => "AND( URL = '$url_view' )",
	'sort' => [['field' => 'Order', 'direction' => 'asc']],
	// 	"fields" => ["Artwork", "Name", "URL", "Winner (manual)", "Episode date"],
];

$picks_data__array = [
	'Rickies' => ['Myke' => [], 'Federico' => [], 'Stephen' => []],
	'Flexies' => ['Myke' => [], 'Federico' => [], 'Stephen' => []],
];
$picks_data__request = $airtable->getContent('Picks', $picks_data__params);
do {
	$picks_data__response = $picks_data__request->getResponse();
	foreach ($picks_data__response['records'] as $array) {
		$id = json_decode(json_encode($array), true)['id'];
		$fields = json_decode(json_encode($array), true)['fields'];

		$picks_data__array_temp = [
			'pick' => check_key('Pick', $fields),
			'type' => check_key('Type', $fields),
			'type_group' => check_key('Type group', $fields),
			'host' => check_key('Host name', $fields, false, 0),
			'status' => check_key('Status', $fields),
			'round' => check_key('Round', $fields),
			'score_points' => check_key('Scoring points', $fields),
			'brag_points' => check_key('Bragging points', $fields),
			'points' => check_key('Points', $fields),
			'note' => check_key('Special remark', $fields),
		];

		array_push(
			$picks_data__array[check_key('Type group', $fields)][check_key('Host name', $fields, false, 0)],
			$picks_data__array_temp
		);
	}
} while ($picks_data__request = $picks_data__response->next());

// echo "<pre>", var_dump($picks_data__array), "</pre>";
