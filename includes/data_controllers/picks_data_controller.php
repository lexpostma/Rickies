<?php

// Rickies picks _data_ controller

if (!isset($triple_j)) {
	$picks_data__array = $picks_data__empty = [
		'Rickies' => ['Myke' => [], 'Federico' => [], 'Stephen' => []],
		'Flexies' => ['Myke' => [], 'Federico' => [], 'Stephen' => []],
		'EUies' => ['Federico' => [], 'Myke' => [], 'Stephen' => []],
	];
} else {
	$picks_data__array = $picks_data__empty = [
		'Pickies' => ['Jason' => [], 'John' => [], 'James' => []],
		'Lightning Round' => ['Jason' => [], 'John' => [], 'James' => []],
	];
}

$picks_data__request = $airtable->getContent('Picks', $picks_data__params);
do {
	$picks_data__response = $picks_data__request->getResponse();
	if (is_countable($picks_data__response['records'])) {
		// Response from Airtable is countable, even if 0, so move forward
		foreach ($picks_data__response['records'] as $array) {
			$id = json_decode(json_encode($array), true)['id'];
			$fields = json_decode(json_encode($array), true)['fields'];

			$picks_data__array_temp = [
				'id' => check_key('id', $fields),
				'anchor' => check_key('URL anchor of pick', $fields),
				'pick' => check_key('Pick', $fields),
				'type' => check_key('Type', $fields),
				'type_group' => check_key('Type group', $fields),
				'host' => check_key('Host name', $fields, false, 0),
				'status' => check_key('Status', $fields),
				'round' => check_key('Round', $fields),
				'round_number' => check_key('Round set', $fields),
				'score_points' => check_key('Scoring points', $fields),
				'brag_points' => check_key('Bragging points', $fields),
				'risky_conditions' => check_key('Risky conditions correct', $fields),
				'points' => check_key('Points', $fields),
				'factor' => check_key('Factor', $fields),
				'note' => check_key('Special remark', $fields),
				'regrade_note' => check_key('3J regrading note', $fields),
				'url' => check_key('URL', $fields, false, 0),
				'rickies' => check_key('Rickies name', $fields, false, 0),
				'status_later' => check_key('Came true string', $fields),
				'reusability' => check_key('Reusability string', $fields),
				'buzzkill' => check_key('Buzzkill string', $fields),
				'amendment' => check_key('Amendment string', $fields),
				'last_edited' => check_key('Last edit date', $fields),
				'categories' => check_key('Category', $fields),
			];

			if ($picks_data__array_temp['categories']) {
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

				$picks_data__array_temp['categories'] = $pick_categories;
				unset($pick_categories);

				$picks_data__array_temp['categories_compare'] = $pick_categories_compare;
				unset($pick_categories_compare);
			}
			// Add pick to array
			array_push(
				$picks_data__array[check_key('Type group', $fields)][check_key('Host name', $fields, false, 0)],
				$picks_data__array_temp
			);
			unset($picks_data__array_temp);
		}
	} else {
		// Response from Airtable is not countable, so it's probably an error instead of an empty array
		include $incl_path . 'airtable_error.php';
	}
} while ($picks_data__request = $picks_data__response->next());

foreach ($picks_data__array as $type => $host_picks) {
	if ($picks_data__array[$type] == $picks_data__empty[$type]) {
		unset($picks_data__array[$type]);
	}
}

// echo '<pre>', var_dump($picks_data__array), '</pre>';
