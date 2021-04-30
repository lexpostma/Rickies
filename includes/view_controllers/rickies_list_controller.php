<?php

// Rickies _view_ controller, main overview

$rickies_events_params = [
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
	],
	'filterByFormula' => "AND( Status, Status != 'Hidden', Picks )",
	'sort' => [['field' => 'Predictions episode date', 'direction' => 'desc']],
	// "maxRecords" => 150,
	// "pageSize" => 50,
];
$all_event_details = false;

include '../includes/data_controllers/event_data_controller.php';
