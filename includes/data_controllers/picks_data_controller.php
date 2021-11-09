<?php

// Rickies picks _data_ controller

$picks_data__empty = $picks_data__array = [
	'Rickies' => ['Myke' => [], 'Federico' => [], 'Stephen' => []],
	'Flexies' => ['Myke' => [], 'Federico' => [], 'Stephen' => []],
];

$picks_chart__array = [
	'Myke' => [
		'Correct' => 0,
		'Wrong' => 0,
		'Eventually' => 0,
		'Unknown' => 0,
	],
	'Federico' => [
		'Correct' => 0,
		'Wrong' => 0,
		'Eventually' => 0,
		'Unknown' => 0,
	],
	'Stephen' => [
		'Correct' => 0,
		'Wrong' => 0,
		'Eventually' => 0,
		'Unknown' => 0,
	],
];

$picks_data__request = $airtable->getContent('Picks', $picks_data__params);
do {
	$picks_data__response = $picks_data__request->getResponse();
	foreach ($picks_data__response['records'] as $array) {
		$id = json_decode(json_encode($array), true)['id'];
		$fields = json_decode(json_encode($array), true)['fields'];

		$picks_data__array_temp = [
			'id' => check_key('id', $fields),
			'pick' => check_key('Pick', $fields),
			'type' => check_key('Type', $fields),
			'type_group' => check_key('Type group', $fields),
			'host' => check_key('Host name', $fields, false, 0),
			'status' => check_key('Status', $fields),
			'round' => check_key('Round', $fields),
			'score_points' => check_key('Scoring points', $fields),
			'brag_points' => check_key('Bragging points', $fields),
			'points' => check_key('Points', $fields),
			'factor' => check_key('Factor', $fields),
			'note' => check_key('Special remark', $fields),
			'url' => check_key('URL', $fields, false, 0),
			'rickies' => check_key('Rickies name', $fields, false, 0),
			'status_later' => check_key('Came true string', $fields),
			'age' => check_key('Age string', $fields),
			'buzzkill' => check_key('Buzzkill string', $fields),
		];

		if (!$picks_data__array_temp['status']) {
			$picks_chart__array[$picks_data__array_temp['host']]['Unknown']++;
		} elseif ($picks_data__array_temp['status_later']) {
			$picks_chart__array[$picks_data__array_temp['host']]['Eventually']++;
		} elseif ($picks_data__array_temp['status'] == 'Correct') {
			if ($picks_data__array_temp['factor'] == 1) {
				$picks_chart__array[$picks_data__array_temp['host']]['Correct']++;
			} else {
				$picks_chart__array[$picks_data__array_temp['host']]['Correct'] =
					$picks_chart__array[$picks_data__array_temp['host']]['Correct'] + $picks_data__array_temp['factor'];
				$picks_chart__array[$picks_data__array_temp['host']]['Wrong'] =
					$picks_chart__array[$picks_data__array_temp['host']]['Wrong'] +
					1 -
					$picks_data__array_temp['factor'];
			}
		} else {
			$picks_chart__array[$picks_data__array_temp['host']]['Wrong']++;
		}

		if (check_key('Category', $fields)) {
			$cat_strings = explode(';', check_key('Categories flat', $fields));
			$cat_keys = explode(';', check_key('Categories flat (web)', $fields));

			$pick_categories = [];
			$pick_categories_compare = [];
			foreach ($cat_strings as $index => $string) {
				// NOTE: This also automatically removes duplicates
				switch ($string) {
					case 'Hardware':
						$color = 'cat_hw';
						break;
					case 'Software':
						$color = 'cat_sw';
						break;
					case 'Services':
						$color = 'cat_cloud';
						break;
					case 'People':
						$color = 'cat_people';
						break;
				}
				$pick_categories[$cat_keys[$index]] = [
					'string' => $string,
					'value' => $cat_keys[$index],
					'color' => $color,
				];
				$pick_categories_compare[] = $cat_keys[$index];
			}
			unset($color);
		}
		$picks_data__array_temp['categories'] = $pick_categories;
		$picks_data__array_temp['categories_compare'] = $pick_categories_compare;

		array_push(
			$picks_data__array[check_key('Type group', $fields)][check_key('Host name', $fields, false, 0)],
			$picks_data__array_temp
		);
		unset($picks_data__array_temp);
		unset($pick_categories);
		unset($pick_categories_compare);
	}
} while ($picks_data__request = $picks_data__response->next());

foreach ($picks_data__array as $type => $host_picks) {
	if ($picks_data__array[$type] == $picks_data__empty[$type]) {
		unset($picks_data__array[$type]);
	}
}

// echo '<pre>', var_dump($picks_data__array), '</pre>';
// echo '<pre>', var_dump($picks_chart__array), '</pre>';
