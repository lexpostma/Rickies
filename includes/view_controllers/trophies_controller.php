<?php

// Trophies controller

$trickies = file_get_contents($incl_path . 'trickies.html');
$magtrickies = file_get_contents($incl_path . 'magtrickies.html');

$head_custom = [
	'title' => 'Trickies, the Rickies trophies',
];
