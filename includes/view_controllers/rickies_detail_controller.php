<?php

// Rickies _view_ controller, event details page

// Get and merge event and host data
include '../includes/data_controllers/merge_hosts_event_data_controller.php';

// Define the data for the leaderboard at the top of the page
$leaderboard_data = [];
foreach ($rickies_data['hosts'] as $host) {
	// Set a default title for each host
	$filler_titles = [
		'Federico' => 'Picker of Passion',
		'Myke' => 'Risk Taker',
		'Stephen' => 'Document Maintainer',
	];

	// Define array
	$added_host = [
		'name' => $host['details']['first_name'],
		'winner' => false,
		'title' => [],
		'string' =>
			'Score: ' .
			plural_points($host['rickies']['points']) .
			'<br />Flexing: ' .
			round_if_decimal($host['flexies']['percentage'] * 100) .
			'%',
		'img_array' => [
			'type' => 'avatar',
			'src' => $host['details']['memoji']['neutral'],
			'color' => $host['details']['color'],
		],
	];

	// Define rank and winner in array
	if ($host['rickies']['ranking'] !== false && $host['rickies']['ranking'] == 0) {
		$added_host['winner'] = true;
		$added_host['title'][] = str_replace('Rickies', 'Chairman', $rickies_data['type']);
		$added_host['img_array']['src'] = $host['details']['memoji']['happy'];
		$added_host['ranking'] = 0;

		// If there's a winner, have a custom sorting order, just like a podium:
		//        1
		//   2  ■■■■■
		// ■■■■■■■■■■  3
		// ■■■■■■■■■■■■■■■
		$leaderboard_order = [1, 0, 2];
	} else {
		$added_host['ranking'] = $host['rickies']['ranking'];
	}

	if ($host['flexies']['ranking'] !== false && $host['flexies']['ranking'] == 0) {
		$added_host['title'][] = 'Charity Chooser';
	} elseif ($host['flexies']['ranking'] !== false && $host['flexies']['ranking'] == 2) {
		$added_host['title'][] = 'Generous Donor';
		if ($host['rickies']['ranking'] !== false && $host['rickies']['ranking'] !== 0) {
			$added_host['img_array']['src'] = $host['details']['memoji']['sad'];
		}
	}

	// Fill title is default of empty
	if (empty($added_host['title'])) {
		$added_host['title'][] = $filler_titles[$added_host['name']];
	}

	// Create string from title array
	$added_host['title'] = implode('<br />', $added_host['title']);

	// Add to leaderboard array
	array_push($leaderboard_data, $added_host);
	unset($added_host);
}

if (isset($leaderboard_order)) {
	// If the custom order is set, sort the data by ranking
	usort($leaderboard_data, function ($a, $b) use ($leaderboard_order) {
		$pos_a = array_search($a['ranking'], $leaderboard_order);
		$pos_b = array_search($b['ranking'], $leaderboard_order);
		return $pos_a - $pos_b;
	});
}

// echo "<pre>", var_dump($leaderboard_data), "</pre>";

$head_custom = [
	'title' => $rickies_data['name'],
	// TODO: Make Rickies description
	// IDEA: Include scoring banner and Apple Event name
	'description' => 'The ' . $rickies_data['name'] . ', about Apple and stuff',
	'keywords' => ['wwdc', 'risky picks', 'flexies', 'charity'],
];
