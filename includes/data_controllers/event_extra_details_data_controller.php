<?php

// Rickies _data_ controller, extra details

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
	// Apple Event data
	'event_title' => 'Apple event',
	'event_data' => [
		'url' => check_key('Event URL', $fields, false, 0),
		'img_url' => $rickies_events__array[$id]['artwork']['event'],
		'label1' => check_key('Event name', $fields),
		'label2' => check_key('Event tagline', $fields, false, 0),
		'label3' => date_to_string_label(check_key('Event date', $fields, false, 0), true),
	],

	// Episode data
	'episode_title' => 'Podcast episodes',
	'episode_data_predictions' => [
		'url' => check_key('Predictions episode URL', $fields, false, 0),
		'img_url' => $rickies_events__array[$id]['artwork']['predictions_ep'],
		'label1' => check_key('Predictions episode title', $fields, false, 0),
		'label2' => check_key('Predictions episode alt title', $fields, false, 0),
		'label3' => date_to_string_label(check_key('Predictions episode date', $fields, false, 0), true),
		'number' => check_key('Predictions episode number', $fields, false, 0),
		'tag' => 'Predictions',
		'tag_color' => 'purple',
	],
	'episode_data_results' => [
		'url' => check_key('Results episode URL', $fields, false, 0),
		'img_url' => $rickies_events__array[$id]['artwork']['results_ep'],
		'label1' => check_key('Results episode title', $fields, false, 0),
		'label2' => check_key('Results episode alt title', $fields, false, 0),
		'label3' => date_to_string_label(check_key('Results episode date', $fields, false, 0), true),
		'number' => check_key('Results episode number', $fields, false, 0),
		'tag' => 'Results',
		'tag_color' => 'blue',
	],

	// More data
	'more_title' => 'More',
	'more_data_rules' => [
		'url' => billofrickies_url() . '/' . $rickies_events__array[$id]['url_name'],
		'url_internal' => true,
		'img_url' => '/images/bill-of-rickies-avatar.png',
		'label1' => 'The Bill of Rickies',
		'label3' => 'As of these ' . $rickies_events__array[$id]['type'],
	],
	'more_data_charity' => [
		'url' => check_key('Charity URL', $fields, false, 0),
		'img_url' => check_key('Charity logo', $fields, false, 0),
		'label1' => check_key('Charity name', $fields, false, 0),
		'label2' => '$' . check_key('Flexy donation', $fields) . ' donated by ' . check_key('Flexies 3rd', $fields),
		'label3' => check_key('Flexies 1st', $fields) . '’s choice',
	],
];

// Event data
if ($rickies_events__array[$id]['details']['event_data']['label1'] == false) {
	// No event linked, clear details from array
	unset($rickies_events__array[$id]['details']['event_title']);
	unset($rickies_events__array[$id]['details']['event_data']);
} else {
}

// Episode data
$rickies_events__array[$id]['details']['episode_data_predictions'] = episode_data(
	$rickies_events__array[$id]['details']['episode_data_predictions']
);
$rickies_events__array[$id]['details']['episode_data_results'] = episode_data(
	$rickies_events__array[$id]['details']['episode_data_results']
);

if ($rickies_events__array[$id]['details']['episode_data_results']['label1'] == false) {
	// No episode, clear details from array
	unset($rickies_events__array[$id]['details']['episode_data_results']);
}

// Charity data
if ($rickies_events__array[$id]['details']['more_data_charity']['label1'] == false) {
	// No charity, clear details from array
	unset($rickies_events__array[$id]['details']['more_data_charity']);
} else {
	// Charity is set, if image is also set, define the right URL
	if ($rickies_events__array[$id]['details']['more_data_charity']['img_url'] !== false) {
		$rickies_events__array[$id]['details']['more_data_charity']['img_url'] =
			$rickies_events__array[$id]['details']['more_data_charity']['img_url']['thumbnails']['large']['url'];
	}
}
