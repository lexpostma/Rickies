<?php

// The Bill of Rickies _view_ controller

// Get and merge event and rules data
include '../includes/data_controllers/merge_rules_event_data_controller.php';

// Define the data for the event slider
$event_slider_js_data = [];
foreach ($rickies_events__array as $event) {
	$event_slider_js_data['class'][] = $event['url_name'];
	$event_slider_js_data['name'][] = $event['name'];
	$event_slider_js_data['date'][] = $event['date'];
}
$event_slider_js_data =
	'
	var rickies_event_classes = [\'' .
	implode('\', \'', $event_slider_js_data['class']) .
	'\'];
	var rickies_event_names = [\'' .
	implode('\', \'', $event_slider_js_data['name']) .
	'\'];
	var rickies_event_dates = [\'' .
	implode('\', \'', $event_slider_js_data['date']) .
	'\'];
	';
$event_slider_steps = count($rickies_events__array) - 1;

$include_body = '../includes/views/billofrickies.php';

$head_custom = [
	'title' => 'The Bill of Rickies',
	'favicon' => 'favicon-bill.png',
	// TODO: Write SEO description
	'description' => '',
];
