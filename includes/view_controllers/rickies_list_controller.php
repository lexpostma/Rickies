<?php

// Rickies _view_ controller, main overview

$rickies_events__params = [
	'sort' => [['field' => 'Predictions episode date', 'direction' => 'desc']],
	// "maxRecords" => 150,
	// "pageSize" => 50,
];

$head_custom = [
	'theme-color' => '#ffffff',
	'theme-color-dark' => '#333f48',
];

if (isset($rickies_filter)) {
	switch ($rickies_filter) {
		case 'Annual':
			$head_custom['title'] = 'Annual Rickies';
			$rickies_events__params['filterByFormula'] = "AND( Published = TRUE(), {Rickies type} = 'annual' )";
			break;
		case 'Keynote':
			$head_custom['title'] = 'Keynote Rickies';
			$rickies_events__params['filterByFormula'] = "AND( Published = TRUE(), {Rickies type} = 'keynote' )";
			break;
		case 'WWDC':
			$head_custom['title'] = 'WWDC Rickies';
			$rickies_events__params['filterByFormula'] = "AND( Published = TRUE(), {Event type} = 'WWDC' )";
			break;
		case 'Ungraded':
			$head_custom['title'] = 'Ungraded Rickies';
			$rickies_events__params['filterByFormula'] =
				"AND( Published = TRUE(), OR(Status = 'Ungraded', Status = 'Live'))";
			break;
		case 'Preview':
			$head_custom['title'] = 'Preview Rickies';
			$rickies_events__params['filterByFormula'] = "AND( OR( Published = TRUE(), Status = 'Preview' ) )";
			break;
		case 'Pickies':
			$head_custom['title'] = 'The Pickies';
			$head_custom['description'] = 'Apple predictions special with fractions, lightning, and bravery.
Sometimes on Connected with the Triple J at Relay FM.';
			$head_custom['image'] = domain_url() . '/images/seo/hero-pickies.jpg';
			$rickies_events__params['filterByFormula'] = "AND( Published = TRUE(), Special = 'Pickies' )";
			break;
	}
	$head_custom['canonical'] = current_url(true);
}

if (isset($auto_select_rickies)) {
	switch ($auto_select_rickies) {
		case 'latest':
			$rickies_events__params['maxRecords'] = 1;
			break;
		case 'keynote':
			$rickies_events__params['filterByFormula'] = "AND( Published = TRUE(), {Rickies type} = 'keynote' )";
			$rickies_events__params['maxRecords'] = 1;
			break;
		case 'annual':
			$rickies_events__params['filterByFormula'] = "AND( Published = TRUE(), {Rickies type} = 'annual' )";
			$rickies_events__params['maxRecords'] = 1;
			break;
	}
}
if (!isset($triple_j)) {
	$trophy_asset = 'rickies';
	$hero_title = '<h1>The Rickies</h1>';
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
} else {
	$trophy_asset = 'pickies';
	$hero_title = '<h1>The Pickies</h1>';
	$hero_tag = '<p>Predictions with fractions, lightning, and bravery. <br />Sometimes on Connected at Relay FM.</p>';
	$introduction =
		'<p>The Pickies are the holiday special prediction draft episodes of the <a target="_blank" href="' .
		$head_defaults['site_connected'] .
		'/377" ' .
		$head_defaults['site_connected_goat'] .
		'>Connected</a> podcast on <a target="_blank" href="' .
		$head_defaults['site_relay'] .
		'" ' .
		$head_defaults['site_relay_goat'] .
		'>Relay FM</a>. Some years and some WWDCs, Jason Snell, John Voorhees, and James Thomson take over and try to predict what Apple will announce next. The Triple J have relied on <a href="/charter">The Pickies Charter</a> to keep the record straight. Some predictions are almost correct, some are lightning fast, most are formed with bravery.</p>';
}
include '../includes/data_controllers/event_data_controller.php';

if (isset($auto_select_rickies)) {
	// Redirect to the first key (Rickies) in the array
	header('Location: ' . domain_url() . $rickies_events__array[array_key_first($rickies_events__array)]['url']);
	die();
}
