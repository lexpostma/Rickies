<?php

// Apple Events _data_ controller, general
$apple_events__params = [
	// 'fields' => ['Name', 'Name (web)', 'Group L1', 'Group L1 emoji', 'Group L2', 'Group L2 (web)'],
	'filterByFormula' => 'AND( {Rickies}, Published )',
	'sort' => [
		['field' => 'Keynote date', 'direction' => 'desc'],
		// ['field' => 'Order', 'direction' => 'asc'],
		// ['field' => 'Pick count', 'direction' => 'desc'],
	],
];

$apple_events__array = [];
$apple_events__request = $airtable->getContent('Apple Events', $apple_events__params);
do {
	$apple_events__response = $apple_events__request->getResponse();

	// echo '<pre>', var_dump($apple_events__response), '</pre>';

	// Does event exist?
	if (is_countable($apple_events__response['records'])) {
		// Response from Airtable is countable, even if 0, so move forward

		if (count($apple_events__response['records']) > 0) {
			foreach ($apple_events__response['records'] as $array) {
				$id = json_decode(json_encode($array), true)['id'];
				$fields = json_decode(json_encode($array), true)['fields'];

				// Main details, required for the list overview
				$apple_events__array[$id] = [
					'name' => check_key('Event', $fields),
					'tagline' => check_key('Tagline', $fields),
					'type' => check_key('Event type', $fields),
					'label3' =>
						date_to_string_label(check_key('Keynote date', $fields), false, true, false, '%A %B %e, %Y') .
						'<br>' .
						check_key('Rickies name', $fields, false, 0),
					'url' => '/' . check_key('Rickies URL', $fields, false, 0),
					'img_url' => airtable_image_url(check_key('Graphic', $fields, false, 0)),
					'last_edited' => check_key('Last edit date', $fields),
				];

				if (isset($apple_events__array[$id]['tagline'])) {
					$apple_events__array[$id]['label1'] = $apple_events__array[$id]['tagline'];
				} else {
					$apple_events__array[$id]['label1'] = $apple_events__array[$id]['name'];
				}

				if ($apple_events__array[$id]['type'] === 'WWDC') {
					$apple_events__array[$id]['tag'] = [['label' => 'WWDC', 'color' => 'orange']];
				}
			}
		} else {
			// Countable, but no charities (0 results)
			// Continue with 404 error
			$error_code = 404;
			include $incl_path . 'error.php';
			die();
		}
	} else {
		// Response from Airtable is not countable, so it's probably an error instead of an empty array
		include $incl_path . 'airtable_error.php';
	}
} while ($apple_events__request = $apple_events__response->next());

// echo '<pre>', var_dump($apple_events__array), '</pre>';
