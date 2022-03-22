<?php

// Trophies controller

$trickies = file_get_contents($incl_path . 'trickies.html');
$magtrickies = file_get_contents($incl_path . 'magtrickies.html');

$head_custom = [
	'title' => 'Trickies, the Rickies trophies',
	'description' => 'The different Rickies trophies explained, from Tricky to MagTricky.',
	'image' => domain_url() . '/images/seo/hero-trophies.jpg',
	'keywords' => ['tricky', 'magtricky', 'trophies', 'medals'],
];
