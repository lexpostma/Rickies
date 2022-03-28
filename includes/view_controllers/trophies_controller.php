<?php

// Trophies controller

$trophy_content = [
	'tricky' => file_get_contents($incl_path . 'trophies-tricky.html'),
	'magtricky' => file_get_contents($incl_path . 'trophies-magtricky.html'),
	'ricky' => file_get_contents($incl_path . 'trophies-ricky.html'),
	'other' => file_get_contents($incl_path . 'trophies-others.html'),
];

$introduction = '<p>The Rickies have known an increasing variety of trophies to award the prediction champion. One of the challenges is
	that the hosts span three countries over two continents, and shipping a challenge cup across oceans is a costly
	no-go. Below are some of the Chairman trophies and awards that have come into existence.</p>';

$head_custom = [
	'title' => 'The Rickies trophies',
	'description' => 'The different Rickies trophies explained, from Ricky to Tricky.',
	'image' => domain_url() . '/images/seo/hero-trophies.jpg',
	'keywords' => ['tricky', 'magtricky', 'trophies', 'medals'],
];
