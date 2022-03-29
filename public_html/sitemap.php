<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions.php';
$airtable_sorting = [['field' => 'Last edit date', 'direction' => 'desc']];

function sitemap_date($timestamp)
{
	return date('c', strtotime($timestamp));
}

function sitemap_url($url, $date, $priority = '0.5', $frequency = 'monthly')
{
	$output =
		'
	<url>
		<loc>' .
		domain_url() .
		$url .
		'</loc>
		<lastmod>' .
		sitemap_date($date) .
		'</lastmod>
		<changefreq>' .
		$frequency .
		'</changefreq>
		<priority>' .
		$priority .
		'</priority>
	</url>';

	return $output;
}

header('Content-type: application/xml');
echo '<' . '?' . 'xml version="1.0" encoding="UTF-8"' . '?' . '>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Data for home, Rickies and filtered Rickies
$rickies_events__params = [
	'sort' => $airtable_sorting,
];
include '../includes/data_controllers/event_data_controller.php';
$home = $latest = $latest_keynote = $latest_annual = $ungraded_filter = $wwdc_filter = $keynote_filter = $annual_filter = $pickies_filter = $charities = $apple_events = true;

foreach ($rickies_events__array as $event) {
	if (isset($home)) {
		echo sitemap_url('/', $event['last_edited'], '0.8');
		unset($home);
	}

	if (isset($latest)) {
		echo sitemap_url('/latest', $event['last_edited'], '0.7');
		unset($latest);
	}
	if (isset($charities)) {
		echo sitemap_url('/charities', $event['last_edited'], '0.7');
		unset($charities);
	}
	if ($event['type'] == 'keynote' && isset($latest_keynote)) {
		echo sitemap_url('/latest-keynote', $event['last_edited']);
		unset($latest_keynote);
	}
	if ($event['type'] == 'keynote' && isset($apple_events)) {
		echo sitemap_url('/apple-event', $event['last_edited']);
		unset($apple_events);
	}
	if ($event['type'] == 'keynote' && isset($keynote_filter)) {
		echo sitemap_url('/keynote', $event['last_edited'], '0.3');
		unset($keynote_filter);
	}
	if ($event['type'] == 'annual' && isset($annual_filter)) {
		echo sitemap_url('/annual', $event['last_edited'], '0.3');
		unset($annual_filter);
	}
	if ($event['type'] == 'annual' && isset($latest_annual)) {
		echo sitemap_url('/latest-annual', $event['last_edited']);
		unset($latest_annual);
	}
	if ($event['event_type'] == 'WWDC' && isset($wwdc_filter)) {
		echo sitemap_url('/wwdc', $event['last_edited'], '0.3');
		unset($wwdc_filter);
	}
	if ($event['status'] == 'Ungraded' && isset($ungraded_filter)) {
		echo sitemap_url('/ungraded', $event['last_edited'], '0.4');
		unset($ungraded_filter);
	}
	if ($event['special'] == 'Pickies' && isset($pickies_filter)) {
		echo sitemap_url('/pickies', $event['last_edited'], '0.2', 'yearly');
		echo sitemap_url('/charter', $event['last_edited_rules'], '0.2', 'yearly');
		unset($pickies_filter);
	}
	if ($event['status'] == 'Ungraded' || $event['status'] == 'Live') {
		echo sitemap_url('/' . $event['url_name'], $event['last_edited']);
	} else {
		echo sitemap_url('/' . $event['url_name'], $event['last_edited'], '0.4', 'never');
	}
}

// Rules data for /billof
$rules__params = [
	'maxRecords' => 1,
	'sort' => $airtable_sorting,
];
include '../includes/data_controllers/rules_data_controller.php';
echo sitemap_url('/billof', $rules__array[array_key_first($rules__array)][0]['last_edited'], '0.7');
echo sitemap_url('/charter', $rules__array[array_key_first($rules__array)][0]['last_edited'], '0.7');

// Host data for /leaderboard
$hosts_data__params = [
	'fields' => ['First name', 'Full name', 'Last edit date'],
	'filterByFormula' => 'AND( {Host type} = "Official" )',
	'sort' => $airtable_sorting,
	'maxRecords' => 1,
];
include '../includes/data_controllers/hosts_data_controller.php';
echo sitemap_url(
	'/leaderboard',
	$hosts_data__array[array_key_first($hosts_data__array)]['last_edited'],
	'0.7',
	'always'
);

// Host data for /3j-leaderboard
$hosts_data__params = [
	'fields' => ['First name', 'Full name', 'Last edit date'],
	'filterByFormula' => 'AND( {Host type} = "Triple J" )',
	'sort' => $airtable_sorting,
	'maxRecords' => 1,
];
include '../includes/data_controllers/hosts_data_controller.php';
echo sitemap_url(
	'/3j-leaderboard',
	$hosts_data__array[array_key_first($hosts_data__array)]['last_edited'],
	'0.2',
	'always'
);

// Picks data for /archive
$picks_data__params = [
	'filterByFormula' => 'AND(
			Pick,
			{Host name},
			Type,
			{Round set},
			Published = TRUE(),
			OR(
				Special="Rickies",
				Special="Pre-Rickies"
			)
		)',
	'sort' => $airtable_sorting,
	'maxRecords' => 1,
];
include '../includes/data_controllers/picks_data_controller.php';

foreach ($picks_data__array[array_key_first($picks_data__array)] as $host => $picks) {
	if (!empty($picks_data__array[array_key_first($picks_data__array)][$host])) {
		$pick = $picks_data__array[array_key_first($picks_data__array)][$host][0];
		break;
	}
}
echo sitemap_url('/archive', $pick['last_edited'], '0.5', 'weekly');
echo sitemap_url('/3j-archive', $pick['last_edited'], '0.2', 'monthly');

// Date for /about
$about = max([filemtime('../includes/view_controllers/about_controller.php'), filemtime('../includes/about.html')]);
echo sitemap_url('/about', date('c', $about), '0.5', 'yearly');
echo '</urlset>';
