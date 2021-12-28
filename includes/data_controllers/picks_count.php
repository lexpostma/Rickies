<?php
if (!isset($triple_j)) {
	$hosts_data__array[$id]['stats']['picks'] = [
		'Regular' => [
			'Correct' => check_key('Picks Regular Correct Count', $fields, 0),
			'Wrong' =>
				check_key('Picks Regular Wrong Count', $fields, 0) -
				check_key('Picks Regular Eventually Count', $fields, 0),
			'Eventually' => check_key('Picks Regular Eventually Count', $fields, 0),
			'Unknown' => check_key('Picks Regular Unknown Count', $fields, 0),
			'Total' => check_key('Picks Regular Total Count', $fields, 0),
		],
		'Risky' => [
			'Correct' => check_key('Picks Risky Correct Count', $fields, 0),
			'Wrong' =>
				check_key('Picks Risky Wrong Count', $fields, 0) -
				check_key('Picks Risky Eventually Count', $fields, 0),
			'Eventually' => check_key('Picks Risky Eventually Count', $fields, 0),
			'Unknown' => check_key('Picks Risky Unknown Count', $fields, 0),
			'Total' => check_key('Picks Risky Total Count', $fields, 0),
		],
		'Flexy' => [
			'Correct' => check_key('Picks Flexy Correct Count', $fields, 0),
			'Wrong' =>
				check_key('Picks Flexy Wrong Count', $fields, 0) -
				check_key('Picks Flexy Eventually Count', $fields, 0),
			'Eventually' => check_key('Picks Flexy Eventually Count', $fields, 0),
			'Unknown' => check_key('Picks Flexy Unknown Count', $fields, 0),
			'Total' => check_key('Picks Flexy Total Count', $fields, 0),
		],
	];

	// Calculate the scored/graded picks
	$hosts_data__array[$id]['stats']['picks']['Scored'] = [
		'Correct' =>
			$hosts_data__array[$id]['stats']['picks']['Regular']['Correct'] +
			$hosts_data__array[$id]['stats']['picks']['Risky']['Correct'],
		'Wrong' =>
			$hosts_data__array[$id]['stats']['picks']['Regular']['Wrong'] +
			$hosts_data__array[$id]['stats']['picks']['Risky']['Wrong'],

		'Unknown' =>
			$hosts_data__array[$id]['stats']['picks']['Regular']['Unknown'] +
			$hosts_data__array[$id]['stats']['picks']['Risky']['Unknown'],

		'Total' =>
			$hosts_data__array[$id]['stats']['picks']['Regular']['Total'] +
			$hosts_data__array[$id]['stats']['picks']['Risky']['Total'],
	];

	// Calculate the overall pick counts
	$hosts_data__array[$id]['stats']['picks']['Overall'] = [
		'Correct' =>
			$hosts_data__array[$id]['stats']['picks']['Scored']['Correct'] +
			$hosts_data__array[$id]['stats']['picks']['Flexy']['Correct'],
		'Wrong' =>
			$hosts_data__array[$id]['stats']['picks']['Scored']['Wrong'] +
			$hosts_data__array[$id]['stats']['picks']['Flexy']['Wrong'],

		'Unknown' =>
			$hosts_data__array[$id]['stats']['picks']['Scored']['Unknown'] +
			$hosts_data__array[$id]['stats']['picks']['Flexy']['Unknown'],

		'Total' =>
			$hosts_data__array[$id]['stats']['picks']['Scored']['Total'] +
			$hosts_data__array[$id]['stats']['picks']['Flexy']['Total'],
	];
} else {
	$hosts_data__array[$id]['stats']['picks'] = [
		'Regular' => [
			'Correct' => check_key('Picks Regular Correct Count', $fields, 0),
			'Wrong' =>
				check_key('Picks Regular Wrong Count', $fields, 0) -
				check_key('Picks Regular Eventually Count', $fields, 0),
			'Eventually' => check_key('Picks Regular Eventually Count', $fields, 0),
			'Unknown' => check_key('Picks Regular Unknown Count', $fields, 0),
			'Total' => check_key('Picks Regular Total Count', $fields, 0),
		],

		'Lightning' => [
			'Correct' => check_key('Picks Flexy Correct Count', $fields, 0),
			'Wrong' =>
				check_key('Picks Flexy Wrong Count', $fields, 0) -
				check_key('Picks Flexy Eventually Count', $fields, 0),
			'Eventually' => check_key('Picks Flexy Eventually Count', $fields, 0),
			'Unknown' => check_key('Picks Flexy Unknown Count', $fields, 0),
			'Total' => check_key('Picks Flexy Total Count', $fields, 0),
		],
	];

	// Calculate the scored/graded/overall pick count
	$hosts_data__array[$id]['stats']['picks']['Overall'] = $hosts_data__array[$id]['stats']['picks']['Scored'] = [
		'Correct' =>
			$hosts_data__array[$id]['stats']['picks']['Regular']['Correct'] +
			$hosts_data__array[$id]['stats']['picks']['Lightning']['Correct'],
		'Wrong' =>
			$hosts_data__array[$id]['stats']['picks']['Regular']['Wrong'] +
			$hosts_data__array[$id]['stats']['picks']['Lightning']['Wrong'],

		'Unknown' =>
			$hosts_data__array[$id]['stats']['picks']['Regular']['Unknown'] +
			$hosts_data__array[$id]['stats']['picks']['Lightning']['Unknown'],

		'Total' =>
			$hosts_data__array[$id]['stats']['picks']['Regular']['Total'] +
			$hosts_data__array[$id]['stats']['picks']['Lightning']['Total'],
	];
}

// Calculate the rate of correctness per pick type
foreach ($hosts_data__array[$id]['stats']['picks'] as $pick_type => $pick_values) {
	if ($pick_values['Total'] - $pick_values['Unknown'] !== 0) {
		$hosts_data__array[$id]['stats']['picks'][$pick_type]['Rate'] = round_if_decimal(
			($pick_values['Correct'] / ($pick_values['Total'] - $pick_values['Unknown'])) * 100
		);
	} else {
		$hosts_data__array[$id]['stats']['picks'][$pick_type]['Rate'] = 0;
	}
}
