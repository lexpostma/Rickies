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
		'icon-maskable-' .
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
	"name": "' .
	$head_defaults['short_name'] .
	'",
	"short_name": "' .
	$head_defaults['short_name'] .
	'",
	"start_url": "/",
	"lang": "en",
	"orientation": "any",
	"background_color": "#333f48",
	"theme_color": "#0d87ca",
	"display": "standalone",
	"scope": "/",
	"shortcuts": [
		{
			"name": "Latest Rickies",
			"url": "/latest",
			"icons": [{
				"src": "/images/shortcut-latest.svg",
				"sizes": "96x96",
				"type": "image/svg"
			}]
		},
		{
			"name": "The Bill of Rickies",
			"url": "/billof",
			"icons": [{
				"src": "/images/shortcut-bill.svg",
				"sizes": "96x96",
				"type": "image/svg"
			}]
		},
		{
			"name": "Host Leaderboard",
			"url": "/leaderboard",
			"icons": [{
				"src": "/images/shortcut-leaderboard.svg",
				"sizes": "96x96",
				"type": "image/svg"
			}]
		},
		{
			"name": "Rickies archive and search",
			"url": "/archive",
			"icons": [{
				"src": "/images/shortcut-archive.svg",
				"sizes": "96x96",
				"type": "image/svg"
			}]
		},
		{
			"name": "About Rickies.co",
			"url": "/about",
			"icons": [{
				"src": "/images/shortcut-about.svg",
				"sizes": "96x96",
				"type": "image/svg"
			}]
		}
	],
	"icons": [' .
	implode(',', $icons) .
	'
	]
}';
