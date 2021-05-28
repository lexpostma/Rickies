<?php

// Rickies _data_ controller, general

$rickies_events__array = [];
$rickies_events__request = $airtable->getContent('Rickies', $rickies_events__params);
do {
	$rickies_events__response = $rickies_events__request->getResponse();

	// echo '<pre>', var_dump($rickies_events__response), '</pre>';

	// Does event exist?
	if (count($rickies_events__response['records']) > 0) {
		foreach ($rickies_events__response['records'] as $array) {
			$id = json_decode(json_encode($array), true)['id'];
			$fields = json_decode(json_encode($array), true)['fields'];

			// Main details, required for the list overview
			$rickies_events__array[$id] = [
				'name' => check_key('Name', $fields),
				'status' => check_key('Status', $fields, false, 0),
				'type' => check_key('Rickies type', $fields),
				'type_string' => check_key('Rickies type string', $fields),
				'url_name' => check_key('URL', $fields),
				'episode_number' => check_key('Predictions episode number', $fields, '?', 0),
				'date_string' => date_to_string_label(check_key('Predictions episode date', $fields, false, 0)),
				'date_html' => date_to_string_label(
					check_key('Predictions episode date', $fields, false, 0),
					false,
					true,
					true
				),
				'date' => strtotime(check_key('Predictions episode date', $fields, false, 0)),
				'artwork' => [
					'rickies' => airtable_image_url(check_key('Rickies artwork', $fields, false, 0)),
					'event' => airtable_image_url(check_key('Event artwork', $fields, false, 0)),
					'predictions_ep' => airtable_image_url(check_key('Predictions episode artwork', $fields, false, 0)),
					'results_ep' => airtable_image_url(check_key('Results episode artwork', $fields, false, 0)),
					'seo' => airtable_image_url(check_key('Rickies SEO image', $fields, false, 0)),
				],
				'artwork_background_color' => check_key('Artwork background color', $fields),
				'winner' => check_key('Rickies 1st (manual)', $fields),
			];

			// Set large thumbnail URL as the value of the main event artwork.
			// The first one that's not-false will be set,
			// excluding episode artwork and SEO images
			foreach ($rickies_events__array[$id]['artwork'] as $source => $artwork) {
				if (
					$artwork !== false &&
					!isset($rickies_events__array[$id]['img_url']) &&
					$source !== 'results_ep' &&
					$source !== 'predictions_ep' &&
					$source !== 'seo'
				) {
					$rickies_events__array[$id]['img_url'] = $artwork;
					break;
				}
			}

			if (!$all_event_details) {
				// Only the details needed for the Rickies overview
				$rickies_events__array[$id]['label1'] = $rickies_events__array[$id]['name'];
				$rickies_events__array[$id]['label3'] =
					$rickies_events__array[$id]['date_html'] .
					' • Episode&nbsp;#' .
					$rickies_events__array[$id]['episode_number'];
				$rickies_events__array[$id]['url'] = '/' . $rickies_events__array[$id]['url_name'];
			} else {
				// Add more details from Airtable to array, to build the detail page
				include 'event_extra_details_data_controller.php';
			}

			// If the status not Completed, add tag/banner
			if ($rickies_events__array[$id]['status'] == 'Ungraded') {
				$rickies_events__array[$id]['tag'] = 'Interactive';
				$rickies_events__array[$id]['tag_color'] = 'orange';
				$rickies_events__array[$id]['tag_banner'] =
					'<b>Interactive scorecard</b><br /><span>Grade the Rickies and Flexies yourself until the official results are in. Tap the picks to cycles through unknown, correct, and wrong states.</span>';
			} elseif ($rickies_events__array[$id]['status'] == 'Pending') {
				$rickies_events__array[$id]['tag'] = 'Awaiting show';
				$rickies_events__array[$id]['tag_color'] = 'grey';
				$rickies_events__array[$id]['tag_banner'] = 'Waiting for the predictions episode…';
			} elseif ($rickies_events__array[$id]['status'] == 'Pre-Rickies') {
				$rickies_events__array[$id]['tag'] = $rickies_events__array[$id]['status'];
				$rickies_events__array[$id]['tag_color'] = 'yellow';
				$rickies_events__array[$id]['tag_banner'] =
					'These predictions predate The Rickies and are not officially graded as such';
			}
		}
	} elseif (isset($filter)) {
		// No Rickies, but filter is set
		$filter_error = 'No ' . $filter . ' Rickies were found. <a href="/#list">Show all Rickies</a>.';
	} else {
		// No Rickies/events (1 or more) found
		// Continue with 404
		$error_code = 404;
		include $incl_path . 'error.php';
		die();
	}
} while ($rickies_events__request = $rickies_events__response->next());

// echo '<pre>', var_dump($rickies_events__array), '</pre>';
