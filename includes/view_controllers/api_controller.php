<?php

// API controller

if (isset($_GET['api']) && $_GET['api'] == 'chairmen') {
	include '../includes/api/chairmen.php';
	die();
}

include $_SERVER['DOCUMENT_ROOT'] . '/../includes/data_controllers/magtricky_data_controller.php';

$api_consumers = [
	'API uses',
	[
		'label1' => 'The Tricky in 3D/AR',
		'label2' =>
			'Get the Tricky trophy in AR, updated with the right location markers. In Dice by PCalc → Settings → The Rickies.',
		'label3' => 'By James Thomson',
		'url' => 'https://apps.apple.com/app/dice-by-pcalc/id1468680083',
		'img_url' => [
			'src' => '/images/about/dice-by-pcalc.png',
			'type' => 'app',
		],
	],
	[
		'label1' => 'Rickies chairmen widget',
		'label2' => 'See the current chairmen on your iOS homescreen. Works with Scriptable.',
		'label3' => 'By Raymond Velasquez',
		'url' => 'https://gist.github.com/supermamon/f663c97a86eda3899c9880d1d1032843',
		'img_url' => [
			// 'src' => '/images/about/scriptable.png',
			'src' => '/images/about/chairmen-widget.png',
			'type' => 'app',
		],
	],
];

$head_custom = [
	'title' => 'Rickies API',
	'description' => 'The JSON API to fetch the current Rickies chairmen.',
	'image' => domain_url() . '/images/seo/hero-api.jpg',
	'keywords' => ['API', 'JSON'],
];
