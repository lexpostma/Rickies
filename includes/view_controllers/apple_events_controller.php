<?php

// Apple Events controller
include '../includes/data_controllers/apple_events_data_controller.php';

$introduction =
	'<p>Apple events and keynotes lay at the core of the Rickies. Each event since January 2017 marks the hosts’ predictions right or wrong. These are the ' .
	count($apple_events__array) .
	' events where Apple’s announcements were attempted to be predicted by Myke, Stephen and Federico.</p>';

$head_custom = [
	'title' => 'Apple Events • The Rickies',
	'description' => strip_tags($introduction),
];
