<?php

// Get Rules data
include '../includes/data_controllers/rules_data_controller.php';
// echo '<pre>', var_dump($rules__array), '</pre>';

// Get Event data
$rickies_events__params = [
	'fields' => [
		'Name',
		'Rickies type',
		'URL',
		'Status',
		'Rickies 1st (manual)',
		'Predictions episode date',
		'Predictions episode artwork',
		'Rickies artwork',
		'Event artwork',
		'Rules',
	],
	'filterByFormula' => "AND( Status, Status != 'Hidden', Picks, Rules )",
	'sort' => [['field' => 'Predictions episode date', 'direction' => 'desc']],
];

$all_event_details = false;
include '../includes/data_controllers/event_data_controller.php';
// echo '<pre>', var_dump($rickies_events__array), '</pre>';

// Merge the Event array data into the Rules array
// Repeat for each type of rule (Rickies/Flexies)
foreach ($rules__array as $type => $rules) {
	// Repeat for each rule
	foreach ($rules as $rule_index => $rule_data) {
		// Repeat for each event in the rule
		foreach ($rule_data['events'] as $record_id) {
			$rules__array[$type][$rule_index]['applies_to'][] = [
				'name' => $rickies_events__array[$record_id]['name'],
				'url' => $rickies_events__array[$record_id]['url_name'],
				// 'date' => $rickies_events__array[$record_id]['date'],
			];
		}
		unset($rules__array[$type][$rule_index]['events']);
	}
}
// echo '<pre>', var_dump($rules__array), '</pre>';
