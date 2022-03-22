<?php

// Trophies controller

$trickies = file_get_contents($incl_path . 'trickies.html');
$magtrickies = file_get_contents($incl_path . 'magtrickies.html');

$head_custom = [
	'title' => 'Trickies, the Rickies trophies',
	'description' => 'The official explanation of the different Rickies trophhies of the Connected podcasts.',
	'image' => domain_url() . '/images/seo/hero-trophies.jpg',
	'keywords' => ['tricky', 'magtricky', 'trophies', 'medals'],
];
