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
	'short_name' => 'Rickies',
	'favicon' => '/favicon.png',
	'image' => domain_url() . '/images/seo/hero-rickies.jpg',
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
	$appIconDirectory = '/images/app-icons/';
	$head_defaults['site_goatcounter'] = 'https://rickies.goatcounter.com';
	$github = 'main';
	// NOTE: Update for new releases
	$refresh = 'v2.1.4';
} else {
	$appIconDirectory = '/images/app-icons/' . $environment . '/';
	$head_defaults['site_goatcounter'] = 'https://rickies-test.goatcounter.com';
	$github = 'development';
	$refresh = date('s');
}

// App icon sizes
$appIconSizes = [
	'iPhone @1x' => '60x60',
	'iPhone @2x' => '120x120',
	'iPhone @3x' => '180x180',
	'iPad @1x' => '76x76',
	'iPad @2x' => '152x152',
	'iPad Pro @2x' => '167x167',
	'Spotlight iPhone @2x' => '80x80',
	'Settings iPhone @1x' => '29x29',
	'Settings iPhone @2x' => '58x58',
	'Settings iPhone @3x' => '87x87',
	'App Store @1x' => '512x512',
	'App Store @2x' => '1024x1024',
	'Generic 1' => '128x128',
	'Generic 2' => '144x144',
	'Generic 3' => '196x196',
];

// Term "Rickies" was coined on episode #245, officially branded in #259
$rickies_start = strtotime('2019-09-04');

// Term "Flexies" was coined on episode #275
$flexies_start = strtotime('2020-01-01');

// Term "Bill of Rickies" was coined on episode #300
$bill_start = strtotime('2020-06-17');

$connected_colors = ['green', 'yellow', 'orange', 'red', 'purple', 'blue'];
