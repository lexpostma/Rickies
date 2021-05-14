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
} else {
	$url_view = 'main';
}

$head_defaults = [
	'title' => 'The Rickies',
	'name' => 'The Rickies',
	'favicon' => '/favicon.png',
	'author' => 'Lex Postma',
	'company' => 'Relay FM',
	'description' => 'Apple predictions show with risk, flexing, and passion. On Connected at Relay FM.',
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
];
