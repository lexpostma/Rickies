<?php

// The Bill of Rickies _view_ controller

// Get Rules data
include '../includes/data_controllers/rules_data_controller.php';
// echo '<pre>', var_dump($rules__array), '</pre>';

// Get Event data
$rickies_events__params = [
	'sort' => [['field' => 'Predictions episode date', 'direction' => 'asc']],
];

include '../includes/data_controllers/event_data_controller.php';
// echo '<pre>', var_dump($rickies_events__array), '</pre>';

// Define the data for the event slider
$event_slider_js_array = [];
$index = 0;
foreach ($rickies_events__array as $event) {
	$event_slider_js_array['date'][] = $event['date'];
	$event_slider_js_array['url'][] = $event['url_name'];
	$event_slider_js_array['name'][] = '<a href="' . '/' . $event['url_name'] . '">' . $event['name'] . '</a>';
	$event_slider_js_array['date_string'][] =
		'<a href="' . '/' . $event['url_name'] . '">' . $event['date_html'] . '</a>';

	// If the URL has an event param, check which event
	if ($url_view !== 'main' && $event['url_name'] == $url_view) {
		// echo 'event found: ' . $event['url_name'];
		$current_selection = [
			'index' => $index,
			'name' => $event['name'],
			'date' => $event['date'],
			'date_string' => $event['date_html'],
		];
		$description = 'As of the ' . $event['name'] . '. ';
	}
	$index++;
}

if ($url_view !== 'main' && $url_view !== 'billof' && !isset($current_selection)) {
	// URL query is given, but no events have match.
	// That's a 404
	header('HTTP/1.0 404 Not Found', true, 404);
	$error = banner(
		'<b>404:</b> No rules were found for the requested Rickies. Here’s the <a href="/">latest Bill of Rickies</a>.',
		'red'
	);
}

$event_slider_js_vars =
	'
	var rickies_event_values = [\'' .
	implode('\', \'', $event_slider_js_array['date']) .
	'\'];
	var rickies_event_names = [\'' .
	implode('\', \'', $event_slider_js_array['name']) .
	'\'];
	var rickies_event_dates = [\'' .
	implode('\', \'', $event_slider_js_array['date_string']) .
	'\'];
	var rickies_event_urls = [\'' .
	implode('\', \'', $event_slider_js_array['url']) .
	'\'];
	';
$event_slider_steps = count($rickies_events__array) - 1;

// If there's no current selection from the URL, select the last event in the arrays
if (!isset($current_selection)) {
	$current_selection = [
		'index' => $event_slider_steps,
		'name' => end($event_slider_js_array['name']),
		'date' => end($event_slider_js_array['date']),
		'date_string' => end($event_slider_js_array['date_string']),
	];
	$description = '';
}
// echo '<pre>', var_dump($current_selection), '</pre>';

$include_body = $incl_path . 'views/billofrickies.php';

$description .=
	'The rules that keep the Rickies straight since 2017. With the full history of the document just a slide away.';

$head_custom = [
	'title' => 'The Bill of Rickies',
	'favicon' => '/favicon-bill.png',
	'description' => $description,
	'image' => domain_url() . '/images/seo/hero-billofrickies.jpg',
	'canonical' => current_url(true) . 'billof',
	'theme-color' => '#0d87ca',
	'theme-color-dark' => '#333f48',
];

// This is the same logic that's also dynamic in JS, and in Event details
if ($current_selection['date'] < $rickies_start && $current_selection['date'] < $bill_start) {
	$head_custom['title'] = 'Drafting Rules';
} elseif ($current_selection['date'] < $bill_start) {
	$head_custom['title'] = 'Rickies Rules';
} else {
	$parchment = true;
}
