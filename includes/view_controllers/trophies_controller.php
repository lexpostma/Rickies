<?php

// Trophies controller
include '../includes/data_controllers/magtricky_data_controller.php';

$interactive_magtricky =
	'
<div id="interactive_magtricky">
	<img src="/images/magtricky-sticker.png" />
	<button
		title="Myke, London"
		id="magnet_myke"
		onclick="update_magtricky(this)"
		data-chairman="' .
	$magtricky__array['Myke'] .
	'"
		class="clean"
	></button>
	<button
		title="Federico, Rome"
		id="magnet_federico"
		onclick="update_magtricky(this)"
		data-chairman="' .
	$magtricky__array['Federico'] .
	'"
		class="clean"
	></button>
	<button
		title="Stephen, Memphis"
		id="magnet_stephen"
		onclick="update_magtricky(this)"
		data-chairman="' .
	$magtricky__array['Stephen'] .
	'"
		class="clean"
	></button>
</div>
';

// Store PHP file into variable
// Via https://stackoverflow.com/a/7052882
ob_start();
include '../includes/trophies-magtricky.php';
$magtricky_content = ob_get_clean();

$trophy_content = [
	'tricky' => file_get_contents($incl_path . 'trophies-tricky.html'),
	'magtricky' => $magtricky_content,
	'ricky' => file_get_contents($incl_path . 'trophies-ricky.html'),
	'other' => file_get_contents($incl_path . 'trophies-others.html'),
];
unset($interactive_magtricky, $magtricky_content);

$introduction = '<p>The Rickies have known an increasing variety of trophies to award the prediction champion. One of the challenges is
	that the hosts span three countries over two continents, and shipping a challenge cup across oceans is a costly
	no-go. Below are some of the Chairman trophies and awards that have come into existence.</p>';

$head_custom = [
	'title' => 'The Rickies trophies',
	'description' => 'The different Rickies trophies explained, from Ricky to Tricky.',
	'image' => domain_url() . '/images/seo/hero-trophies.jpg',
	'keywords' => ['tricky', 'magtricky', 'trophies', 'medals'],
];
