<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions.php';

header('Content-type: application/manifest+json');

$icons = [];
foreach ($appIconSizes as $device => $size) {
	$icons[] =
		'
	{
		"src": "' .
		$appIconDirectory .
		'icon-' .
		$size .
		'.png",
		"type": "image/png",
		"sizes": "' .
		$size .
		'",
		"purpose": "any"
	}';
	$icons[] =
		'
		{
			"src": "' .
		$appIconDirectory .
		'icon-' .
		$size .
		'.png",
			"type": "image/png",
			"sizes": "' .
		$size .
		'",
			"purpose": "maskable"
		}';
}

echo '{
	"short_name": "' .
	$head_defaults['short_name'] .
	'",
	"name": "' .
	$head_defaults['short_name'] .
	'",
	"start_url": "/",
	"background_color": "#333f48",
	"theme_color": "#0d87ca",
	"display": "standalone",
	"scope": "/",
	"shortcuts": [
		{
			"name": "The Bill of Rickies",
			"url": "/billof"
		},
		{
			"name": "Host Leaderboard",
			"url": "/leaderboard"
		},
		{
			"name": "Rickies archive and search",
			"url": "/archive"
		},
		{
			"name": "About Rickies.co",
			"url": "/about"
		}
	],
	"icons": [' .
	implode(',', $icons) .
	'
	]
}';
