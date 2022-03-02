<?php

// Rickies _data_ controller, extra details

$rickies_events__array[$id]['custom_css'] = check_key('Custom hero CSS', $fields);

$rickies_events__array[$id]['ranking'] = [
	'rickies' => check_key('Rickies ranking', $fields),
	'flexies' => check_key('Flexies ranking', $fields),
	'robin' => check_key('Round Robin order', $fields),
];

// Convert ranking strings to arrays
foreach ($rickies_events__array[$id]['ranking'] as $type => $ranking) {
	if ($ranking) {
		$rickies_events__array[$id]['ranking'][$type] = explode(', ', $ranking);
	} else {
		$rickies_events__array[$id]['ranking'][$type] = [];
	}
}

$rickies_events__array[$id]['coin_toss'] = [
	'rickies_win' => check_key('Rickies coin flip (flat)', $fields, false, 0),
	'flexies_win' => check_key('Flexies coin flip (flat)', $fields, false, 0),
	'rickies_loss' => check_key('Rickies coin flip lost by', $fields),
	'flexies_loss' => check_key('Flexies coin flip lost by', $fields),
];

// Add more details from Airtable to array, to build the detail page
if ($rickies_events__array[$id]['ranking']['rickies'] !== []) {
	// Order by Rickies ranking
	// Convert ranking string to array
	$hosts = $rickies_events__array[$id]['ranking']['rickies'];
} elseif ($rickies_events__array[$id]['ranking']['flexies'] !== []) {
	// Order by Flexies ranking
	// Convert ranking string to array
	$hosts = $rickies_events__array[$id]['ranking']['flexies'];
} elseif ($rickies_events__array[$id]['ranking']['robin'] !== []) {
	// Order by Robin
	$hosts = $rickies_events__array[$id]['ranking']['robin'];
} else {
	// No Fallback to alphabetical order
	$hosts = ['Federico', 'Myke', 'Stephen'];
}

foreach ($hosts as $host) {
	$rickies_events__array[$id]['hosts'][$host] = [
		'details' => [
			'first_name' => $host,
			'round_robin' => array_search($host, $rickies_events__array[$id]['ranking']['robin']),
		],
		'rickies' => [
			'ranking' => array_search($host, $rickies_events__array[$id]['ranking']['rickies']),
			'count' => check_key($host . '’s Ricky count', $fields),
			'correct' => check_key($host . '’s correct Ricky count', $fields),
			'risky_correct' => check_key($host . '’s Risky Pick', $fields),
			'points' => check_key($host . '’s score', $fields),
			'coin_toss_winner' => false,
			'coin_toss_loser' => false,
		],
		'flexies' => [
			'ranking' => array_search($host, $rickies_events__array[$id]['ranking']['flexies']),
			'count' => check_key($host . '’s Flexy count', $fields),
			'correct' => check_key($host . '’s correct Flexy count', $fields),
			'percentage' => check_key($host . '’s Flexy percentage', $fields),
			'points' => check_key($host . '’s Flexy score', $fields),
			'coin_toss_winner' => false,
			'coin_toss_loser' => false,
		],
	];

	if ($rickies_events__array[$id]['coin_toss']['rickies_win'] == $host) {
		$rickies_events__array[$id]['hosts'][$host]['rickies']['coin_toss_winner'] = true;
	}

	if ($rickies_events__array[$id]['coin_toss']['flexies_win'] == $host) {
		$rickies_events__array[$id]['hosts'][$host]['flexies']['coin_toss_winner'] = true;
	}

	if ($rickies_events__array[$id]['coin_toss']['rickies_loss'] == $host) {
		$rickies_events__array[$id]['hosts'][$host]['rickies']['coin_toss_loser'] = true;
	}

	if ($rickies_events__array[$id]['coin_toss']['flexies_loss'] == $host) {
		$rickies_events__array[$id]['hosts'][$host]['flexies']['coin_toss_loser'] = true;
	}
}

$rickies_events__array[$id]['details'] = [
	// Episode data
	'episode_title' => 'Podcast episodes',
	'episode_data_predictions' => [
		'url' => check_key('Predictions episode URL', $fields, false, 0),
		'img_url' => $rickies_events__array[$id]['artwork']['predictions_ep'],
		'label1' => check_key('Predictions episode title', $fields, false, 0),
		'label2' => check_key('Predictions episode alt title', $fields, false, 0),
		'label3' => date_to_string_label(check_key('Predictions episode date', $fields, false, 0), 'air', true, true),
		'number' => check_key('Predictions episode number', $fields, false, 0),
		'tag' => [['label' => 'Predictions', 'color' => 'blue']],
		'date' => check_key('Predictions episode date', $fields, false, 0),
	],
	'episode_data_results' => [
		'url' => check_key('Results episode URL', $fields, false, 0),
		'img_url' => $rickies_events__array[$id]['artwork']['results_ep'],
		'label1' => check_key('Results episode title', $fields, false, 0),
		'label2' => check_key('Results episode alt title', $fields, false, 0),
		'label3' => date_to_string_label(check_key('Results episode date', $fields, false, 0), 'air', true, true),
		'number' => check_key('Results episode number', $fields, false, 0),
		'tag' => [['label' => 'Results', 'color' => 'green']],
		'date' => check_key('Results episode date', $fields, false, 0),
	],

	// Apple Event and Charity data
	'link_title' => 'Apple event and Charity',
	'link_data_apple' => [
		'url' => check_key('Event URL', $fields, false, 0),
		'img_url' => $rickies_events__array[$id]['artwork']['event'],
		'label1' => check_key('Event name', $fields),
		'label2' => check_key('Event tagline', $fields, false, 0),
		'label3' => date_to_string_label(check_key('Event date', $fields, false, 0), 'air', true, true),
		'date' => check_key('Event date', $fields, false, 0),
		'type' => check_key('Event type', $fields, false, 0),
	],
	'link_data_charity' => [
		'url' => check_key('Charity URL', $fields, false, 0),
		'img_url' => check_key('Charity logo', $fields, false, 0),
		'label1' => check_key('Charity name', $fields, false, 0),
		'label2' => '$' . check_key('Flexy donation', $fields) . ' donated by ' . check_key('Flexies 3rd', $fields),
		'label3' => check_key('Flexies 1st', $fields) . '’s choice',
	],
	// More data
	'more_title' => 'More',
];

if (!isset($triple_j)) {
	$rickies_events__array[$id]['details']['more_data_rules'] = [
		'url' => '/billof/' . $rickies_events__array[$id]['url_name'],
		'url_internal' => true,
		'img_url' => '/images/bill-of-rickies-avatar.png',
		'label1' => 'The Bill of Rickies',
		'label3' => 'As of these ' . $rickies_events__array[$id]['type_string'],
	];
	$rickies_events__array[$id]['details']['more_data_archive'] = [
		'url' => filter_url('&rickies_event=' . $rickies_events__array[$id]['url_name']),
		'url_internal' => true,
		'img_url' => '/images/archive-avatar.png',
		'label1' => 'Show picks in archive',
		'label3' => 'Complete with metadata and filter options',
	];
} else {
	$rickies_events__array[$id]['details']['more_data_rules'] = [
		'url' => '/charter/' . $rickies_events__array[$id]['url_name'],
		'url_internal' => true,
		'img_url' => '/images/pickies-charter-avatar.png',
		'label1' => 'The Pickies Charter',
		'label3' => 'As of these ' . $rickies_events__array[$id]['type_string'],
	];
	$rickies_events__array[$id]['details']['more_data_archive'] = [
		'url' => filter_url('&3j=on&rickies_event=' . $rickies_events__array[$id]['url_name']),
		'url_internal' => true,
		'img_url' => '/images/archive-avatar.png',
		'label1' => 'Show picks in archive',
		'label3' => 'Complete with metadata and filter options',
	];
}

// Link data
if (
	$rickies_events__array[$id]['details']['link_data_apple']['label1'] == false &&
	$rickies_events__array[$id]['details']['link_data_charity']['label1'] == false
) {
	// No data linked, clear details from array
	unset(
		$rickies_events__array[$id]['details']['link_title'],
		$rickies_events__array[$id]['details']['link_data_apple'],
		$rickies_events__array[$id]['details']['link_data_charity']
	);
} else {
	if ($rickies_events__array[$id]['details']['link_data_apple']['label1'] == false) {
		// No Apple Event data linked, clear details from array
		$rickies_events__array[$id]['details']['link_title'] = 'Charity';
		unset($rickies_events__array[$id]['details']['link_data_apple']);
	}
	if ($rickies_events__array[$id]['details']['link_data_charity']['label1'] == false) {
		// No charity, clear details from array
		$rickies_events__array[$id]['details']['link_title'] = 'Apple event';
		unset($rickies_events__array[$id]['details']['link_data_charity']);
	} else {
		// Charity is set, if image is also set, define the right URL
		if ($rickies_events__array[$id]['details']['link_data_charity']['img_url'] !== false) {
			$rickies_events__array[$id]['details']['link_data_charity']['img_url'] =
				$rickies_events__array[$id]['details']['link_data_charity']['img_url']['thumbnails']['large']['url'];
		}
	}
}

// Episode states
if (
	$rickies_events__array[$id]['status'] == 'Live' &&
	strtotime($rickies_events__array[$id]['details']['link_data_apple']['date']) > strtotime('today')
) {
	// Rickies status == live && Event date > (bigger=before) today
	$predictions_state = 'live';
	$results_state = false;
} elseif (
	$rickies_events__array[$id]['status'] == 'Live' &&
	strtotime($rickies_events__array[$id]['details']['link_data_apple']['date']) < strtotime('today')
) {
	// Rickies status == live && Event date < (smaller=after) today
	$predictions_state = false;
	$results_state = 'live';
} elseif (
	$rickies_events__array[$id]['details']['episode_data_predictions']['label1'] == false &&
	$rickies_events__array[$id]['details']['episode_data_results']['label1'] == false
) {
	// Prediction episode title == '' && Results episode title == ''
	$predictions_state = 'future';
	$results_state = false;
} elseif (
	$rickies_events__array[$id]['details']['episode_data_results']['label1'] == false &&
	$rickies_events__array[$id]['details']['episode_data_results']['date'] !== false
) {
	// Results episode title == '' && Results episode has a date
	$predictions_state = false;
	$results_state = 'future';
} else {
	$predictions_state = false;
	$results_state = false;
}

// Episode data
$rickies_events__array[$id]['details']['episode_data_predictions'] = episode_data(
	$rickies_events__array[$id]['details']['episode_data_predictions'],
	$predictions_state
);
$rickies_events__array[$id]['details']['episode_data_results'] = episode_data(
	$rickies_events__array[$id]['details']['episode_data_results'],
	$results_state
);

if ($rickies_events__array[$id]['details']['episode_data_predictions'] == false) {
	// No predictions episode
	unset(
		$rickies_events__array[$id]['details']['episode_title'],
		$rickies_events__array[$id]['details']['episode_data_predictions'],
		$rickies_events__array[$id]['details']['episode_data_results']
	);
} elseif ($rickies_events__array[$id]['details']['episode_data_results'] == false) {
	// No results episode, clear details from array
	unset($rickies_events__array[$id]['details']['episode_data_results']);
}

// Bill of Rickies data
if ($rickies_events__array[$id]['date'] < $rickies_start && $rickies_events__array[$id]['date'] < $bill_start) {
	$rickies_events__array[$id]['details']['more_data_rules']['label1'] = 'Drafting Rules';
	$rickies_events__array[$id]['details']['more_data_rules']['img_url'] = '/images/rickies-rules-avatar.png';
} elseif ($rickies_events__array[$id]['date'] < $bill_start) {
	$rickies_events__array[$id]['details']['more_data_rules']['label1'] = 'Rickies Rules';
	$rickies_events__array[$id]['details']['more_data_rules']['img_url'] = '/images/rickies-rules-avatar.png';
}
