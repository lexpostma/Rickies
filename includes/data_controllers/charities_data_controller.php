<?php

// Charities _data_ controller, general
$charities__params = [
	// 'fields' => ['Name', 'Name (web)', 'Group L1', 'Group L1 emoji', 'Group L2', 'Group L2 (web)'],
	'filterByFormula' => 'AND( {Donated at Rickies}, Donated > 0 )',
	'sort' => [
		['field' => 'Donated', 'direction' => 'desc'],
		['field' => 'Donation date', 'direction' => 'asc'],
		// ['field' => 'Pick count', 'direction' => 'desc'],
	],
];

$charities__array = [];
$total_donated = 0;
$charities__request = $airtable->getContent('Charities', $charities__params);
do {
	$charities__response = $charities__request->getResponse();

	// echo '<pre>', var_dump($charities__response), '</pre>';

	// Does event exist?
	if (is_countable($charities__response['records'])) {
		// Response from Airtable is countable, even if 0, so move forward

		if (count($charities__response['records']) > 0) {
			foreach ($charities__response['records'] as $array) {
				$id = json_decode(json_encode($array), true)['id'];
				$fields = json_decode(json_encode($array), true)['fields'];

				// Main details, required for the list overview
				$charities__array[$id] = [
					'label1' => check_key('Name', $fields),
					'donation_amount' => check_key('Donated', $fields, '0'),
					'donation_date' => date_to_string_label(check_key('Donation date', $fields)),
					'donating_host' => check_key('Donating host', $fields, false, 0),
					'choosing_host' => check_key('Charity chosen by host', $fields, false, 0),
					'label2' => check_key('Label 2', $fields, false, 0),
					'label3' => check_key('Label 3', $fields, false, 0),
					'url' => check_key('Website', $fields),
					'img_url' => airtable_image_url(check_key('Logo', $fields, false, 0)),
					'last_edited' => check_key('Last edit date', $fields),
				];

				$total_donated = $total_donated + $charities__array[$id]['donation_amount'];
				$charities__array[$id]['label3'] .= '<br />' . $charities__array[$id]['donation_date'];
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
} while ($charities__request = $charities__response->next());

// echo '<pre>', var_dump($charities__array), '</pre>';
