<?php

// Rickies _view_ controller, main overview

$rickies_events__params = [
	'fields' => [
		'Name',
		'Rickies type',
		'URL',
		'Status',
		'Rickies 1st (manual)',
		'Predictions episode date',
		'Predictions episode number',
		'Predictions episode artwork',
		'Rickies artwork',
		'Event artwork',
		'Artwork background color',
	],
	'filterByFormula' => "AND( OR(Status = 'Completed', Status = 'Ungraded', Status = 'Pre-Rickies'), Picks )",
	'sort' => [['field' => 'Predictions episode date', 'direction' => 'desc']],
	// "maxRecords" => 150,
	// "pageSize" => 50,
];

$head_custom = [];

if (isset($filter)) {
	if ($filter == 'Annual') {
		$head_custom['title'] = 'Annual Rickies';
		$rickies_events__params['filterByFormula'] =
			"AND( OR(Status = 'Completed', Status = 'Ungraded', Status = 'Pre-Rickies'), {Rickies type} = 'annual', Picks )";
	} elseif ($filter == 'Keynote') {
		$head_custom['title'] = 'Keynote Rickies';
		$rickies_events__params['filterByFormula'] =
			"AND( OR(Status = 'Completed', Status = 'Ungraded', Status = 'Pre-Rickies'), {Rickies type} = 'keynote', Picks )";
	} elseif ($filter == 'WWDC') {
		$head_custom['title'] = 'WWDC Rickies';
		$rickies_events__params['filterByFormula'] =
			"AND( OR(Status = 'Completed', Status = 'Ungraded', Status = 'Pre-Rickies'), {Event type} = 'WWDC', Picks )";
	} elseif ($filter == 'Ungraded') {
		$head_custom['title'] = 'Ungraded Rickies';
		$rickies_events__params['filterByFormula'] = "AND( Status = 'Ungraded', Picks )";
	}
	$head_custom['canonical'] = current_url(true);
}

$all_event_details = false;

$hero_tag = '<p>Predictions with risk, flexing, and passion. <br />On Connected at Relay FM.</p>';
$introduction =
	'<p>The Rickies are a prediction show on the <a target="_blank" href="' .
	$head_defaults['site_connected'] .
	'" ' .
	$head_defaults['site_connected_goat'] .
	'>Connected</a> podcast at <a target="_blank" href="' .
	$head_defaults['site_relay'] .
	'" ' .
	$head_defaults['site_relay_goat'] .
	'>Relay FM</a>. Every year and every Apple event, Myke Hurley, Stephen Hackett, and Federico Viticci try to predict what Apple will announce next. Over the course of the show, the hosts have relied on <a href="/billof">The Bill of Rickies</a> to keep the record straight. Some predictions are risky, some are just to flex, most are formed with passion.</p>';

include '../includes/data_controllers/event_data_controller.php';
