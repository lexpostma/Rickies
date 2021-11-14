<?php

// Rickies _data_ controller, general
if (!isset($all_event_details)) {
	$all_event_details = false;
}

if (!isset($rickies_events__params['fields']) && !$all_event_details) {
	$rickies_events__params['fields'] = [
		'Name',
		'Rickies type',
		'Event type',
		'URL',
		'Status',
		'Rickies 1st (manual)',
		'Predictions episode date',
		'Predictions episode number',
		'Predictions episode artwork',
		'Rickies artwork',
		'Event artwork',
		'Artwork background color',
		'Interactive',
		'Last edit date',
	];
}

if (!isset($rickies_events__params['filterByFormula'])) {
	$rickies_events__params['filterByFormula'] = 'AND( Published = TRUE() )';
}

$rickies_events__array = [];
$rickies_events__request = $airtable->getContent('Rickies', $rickies_events__params);
do {
	$rickies_events__response = $rickies_events__request->getResponse();

	// echo '<pre>', var_dump($rickies_events__response), '</pre>';

	// Does event exist?
	if (is_countable($rickies_events__response['records'])) {
		// Response from Airtable is countable, even if 0, so move forward

		if (count($rickies_events__response['records']) > 0) {
			foreach ($rickies_events__response['records'] as $array) {
				$id = json_decode(json_encode($array), true)['id'];
				$fields = json_decode(json_encode($array), true)['fields'];

				// Main details, required for the list overview
				$rickies_events__array[$id] = [
					'name' => check_key('Name', $fields),
					'status' => check_key('Status', $fields, false, 0),
					'type' => check_key('Rickies type', $fields),
					'event_type' => check_key('Event type', $fields, false, 0),
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
					'interactive' => check_key('Interactive', $fields, false, 0),
					'artwork' => [
						'rickies' => airtable_image_url(check_key('Rickies artwork', $fields, false, 0)),
						'event' => airtable_image_url(check_key('Event artwork', $fields, false, 0)),
						'predictions_ep' => airtable_image_url(
							check_key('Predictions episode artwork', $fields, false, 0)
						),
						'results_ep' => airtable_image_url(check_key('Results episode artwork', $fields, false, 0)),
						'seo' => airtable_image_url(check_key('Rickies SEO image', $fields, false, 0)),
					],
					'artwork_background_color' => check_key('Artwork background color', $fields),
					'winner' => check_key('Rickies 1st (manual)', $fields),
					'last_edited' => check_key('Last edit date', $fields),
				];

				// If not TRUE, set to FALSE. Otherwise it's NULL
				if ($rickies_events__array[$id]['interactive'] !== true) {
					$rickies_events__array[$id]['interactive'] = false;
				}

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
					// Ungraded Rickies
					$rickies_events__array[$id]['tag'] = 'Interactive';
					$rickies_events__array[$id]['tag_color'] = 'orange';
					$rickies_events__array[$id]['tag_banner'] =
						'<b>Interactive scorecard</b><br /><span>Grade the Rickies and Flexies yourself until the official results are in. Tap the picks to cycles through unknown, correct, and wrong states. <a class="clean js_link nowrap" onclick="clear_manual_score(this)" data-goatcounter-click="Clear interactive picks" title="Clear manual scores" data-goatcounter-referrer=' .
						current_url() .
						'>Clear manual scores</a></span>';
				} elseif ($rickies_events__array[$id]['status'] == 'Pending') {
					// Pending Rickies
					$rickies_events__array[$id]['tag'] = 'Awaiting show';
					$rickies_events__array[$id]['tag_color'] = 'grey';
					$rickies_events__array[$id]['tag_banner'] = 'Waiting for the predictions episode…';
				} elseif ($rickies_events__array[$id]['status'] == 'Live') {
					// Live Rickies
					$rickies_events__array[$id]['tag'] = 'Live';
					$rickies_events__array[$id]['tag_color'] = 'red';
					$rickies_events__array[$id]['tag_banner'] =
						'Updating now…<br /><a href="https://relay.fm/live" data-goatcounter-click="Relay live" title="Listen live" data-goatcounter-referrer="' .
						current_url() .
						'" >Listen live to the episode</a>';
				} elseif ($rickies_events__array[$id]['status'] == 'Pre-Rickies') {
					// Pre-Rickies
					$rickies_events__array[$id]['tag'] = $rickies_events__array[$id]['status'];
					$rickies_events__array[$id]['tag_color'] = 'yellow';
					$rickies_events__array[$id]['tag_banner'] =
						'These predictions predate The Rickies and are not officially graded as such';
				}
			}
		} elseif (isset($rickies_filter)) {
			// Countable, but no Rickies (0 results), but filter is set
			if ($rickies_filter == 'Ungraded') {
				$rickies_title_string = 'ungraded';
			} else {
				$rickies_title_string = $rickies_filter;
			}
			$rickies_filter_empty =
				'No ' . $rickies_title_string . ' Rickies were found. <a href="/#list">Show all Rickies</a>.';
		} else {
			// Countable, but no Rickies (0 results) and no filter
			// Continue with 404 error
			$error_code = 404;
			include $incl_path . 'error.php';
			die();
		}
	} else {
		// Response from Airtable is not countable, so it's probably an error instead of an empty array
		// Continue with 503 error
		$error_code = 503;
		include $incl_path . 'error.php';
		die();
	}
} while ($rickies_events__request = $rickies_events__response->next());

// echo '<pre>', var_dump($rickies_events__array), '</pre>';
