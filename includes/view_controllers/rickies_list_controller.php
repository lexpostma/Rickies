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
		'Interactive',
	],
	'filterByFormula' => 'AND( Published = TRUE() )',
	'sort' => [['field' => 'Predictions episode date', 'direction' => 'desc']],
	// "maxRecords" => 150,
	// "pageSize" => 50,
];

$head_custom = [
	'theme-color' => '#ffffff',
	'theme-color-dark' => '#333f48',
];

if (isset($rickies_filter)) {
	if ($rickies_filter == 'Annual') {
		$head_custom['title'] = 'Annual Rickies';
		$rickies_events__params['filterByFormula'] = "AND( Published = TRUE(), {Rickies type} = 'annual' )";
	} elseif ($rickies_filter == 'Keynote') {
		$head_custom['title'] = 'Keynote Rickies';
		$rickies_events__params['filterByFormula'] = "AND( Published = TRUE(), {Rickies type} = 'keynote' )";
	} elseif ($rickies_filter == 'WWDC') {
		$head_custom['title'] = 'WWDC Rickies';
		$rickies_events__params['filterByFormula'] = "AND( Published = TRUE(), {Event type} = 'WWDC' )";
	} elseif ($rickies_filter == 'Ungraded') {
		$head_custom['title'] = 'Ungraded Rickies';
		$rickies_events__params['filterByFormula'] =
			"AND( Published = TRUE(), OR(Status = 'Ungraded', Status = 'Live'))";
	}
	$head_custom['canonical'] = current_url(true);
}

if (isset($auto_select_rickies)) {
	if ($auto_select_rickies == 'latest') {
		$rickies_events__params['maxRecords'] = 1;
	} elseif ($auto_select_rickies == 'keynote') {
		$rickies_events__params['filterByFormula'] = "AND( Published = TRUE(), {Rickies type} = 'keynote' )";
		$rickies_events__params['maxRecords'] = 1;
	} elseif ($auto_select_rickies == 'annual') {
		$rickies_events__params['filterByFormula'] = "AND( Published = TRUE(), {Rickies type} = 'annual' )";
		$rickies_events__params['maxRecords'] = 1;
	}
}

$hero_tag = '<p>Predictions with risk, flexing, and passion. <br />On Connected at Relay FM.</p>';
$introduction =
	'<p>The Rickies are the prediction draft episodes of the <a target="_blank" href="' .
	$head_defaults['site_connected'] .
	'" ' .
	$head_defaults['site_connected_goat'] .
	'>Connected</a> podcast on <a target="_blank" href="' .
	$head_defaults['site_relay'] .
	'" ' .
	$head_defaults['site_relay_goat'] .
	'>Relay FM</a>. Every year and every Apple event, Myke Hurley, Stephen Hackett, and Federico Viticci try to predict what Apple will announce next. Over the course of the show, the hosts have relied on <a href="/billof">The Bill of Rickies</a> to keep the record straight. Some predictions are risky, some are just to flex, most are formed with passion.</p>';

include '../includes/data_controllers/event_data_controller.php';

if (isset($auto_select_rickies)) {
	// echo $rickies_events__array[array_key_first($rickies_events__array)]['url'];
	header('Location: ' . domain_url() . $rickies_events__array[array_key_first($rickies_events__array)]['url']);
	die();
}
