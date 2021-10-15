<?php

// Define currently running environment
if (getenv('ENVIRONMENT') !== false) {
	$environment = getenv('ENVIRONMENT');
} else {
	$environment = 'debug';
}

// What view is requested?
if (isset($_GET['view'])) {
	$url_view = $_GET['view'];
} elseif (isset($_GET['search'])) {
	$url_view = 'search';
} else {
	$url_view = 'main';
}

$head_defaults = [
	'title' => 'The Rickies',
	'name' => 'The Rickies',
	'favicon' => '/favicon.png',
	'image' => domain_url() . '/images/hero-rickies.jpg',
	'canonical' => current_url(),
	'author' => 'Lex Postma',
	'company' => 'Relay FM',
	'description' => 'Apple predictions show with risk, flexing, and passion.
On Connected at Relay FM.',
	'keywords' => [
		'Apple',
		'podcast',
		'Relay FM',
		'Connected',
		'Rickies',
		'episode',
		'fan site',
		'predictions',
		'awards',
	],
	'site_relay' => 'https://relay.fm/',
	'site_relay_goat' =>
		' data-goatcounter-click="relay.fm" title="Visit Relay FM" data-goatcounter-referrer="' . current_url() . '" ',
	'site_connected' => 'https://relay.fm/connected',
	'site_connected_goat' =>
		' data-goatcounter-click="relay.fm/connected" title="Visit Connected" data-goatcounter-referrer="' .
		current_url() .
		'" ',
	'site_lex' => 'https://lexpostma.me',
	'site_lex_goat' =>
		' data-goatcounter-click="lexpostma.me" title="Visit Lex’ website" data-goatcounter-referrer="' .
		current_url() .
		'" ',
	'twitter_author' => '@lexpostma',
	'twitter_connected' => '@_connectedfm',
	'theme-color' => '#333f48',
];

if ($environment == 'production') {
	$head_defaults['site_goatcounter'] = 'https://rickies.goatcounter.com';
	$github = 'main';
	// NOTE: update for new releases
	$refresh = 'v1.5.10';
} else {
	$head_defaults['site_goatcounter'] = 'https://rickies-test.goatcounter.com';
	$github = 'development';
	$refresh = date('s');
}

// Term "Rickies" was coined on episode #245, officially branded in #259
$rickies_start = strtotime('2019-09-04');

// Term "Flexies" was coined on episode #275
$flexies_start = strtotime('2020-01-01');

// Term "Bill of Rickies" was coined on episode #300
$bill_start = strtotime('2020-06-17');

$connected_colors = ['green', 'yellow', 'orange', 'red', 'purple', 'blue'];
