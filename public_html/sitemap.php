<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions.php';
$airtable_sorting = [['field' => 'Last edit date', 'direction' => 'desc']];

function sitemap_date($timestamp)
{
	return date('c', strtotime($timestamp));
}

function sitemap_url($url, $date, $frequency = 'monthly', $priority = '0.5')
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
$home = $latest = $latest_keynote = $latest_annual = $ungraded_filter = $wwdc_filter = $keynote_filter = $annual_filter = true;

foreach ($rickies_events__array as $event) {
	if (isset($home)) {
		echo sitemap_url('/', $event['last_edited'], 'monthly', '0.8');
		unset($home);
	}

	if (isset($latest)) {
		echo sitemap_url('/latest', $event['last_edited']);
		unset($latest);
	}
	if ($event['type'] == 'keynote' && isset($latest_keynote)) {
		echo sitemap_url('/latest-keynote', $event['last_edited']);
		unset($latest_keynote);
	}
	if ($event['type'] == 'keynote' && isset($keynote_filter)) {
		echo sitemap_url('/keynote', $event['last_edited']);
		unset($keynote_filter);
	}
	if ($event['type'] == 'annual' && isset($annual_filter)) {
		echo sitemap_url('/annual', $event['last_edited']);
		unset($annual_filter);
	}
	if ($event['type'] == 'annual' && isset($latest_annual)) {
		echo sitemap_url('/latest-annual', $event['last_edited']);
		unset($latest_annual);
	}
	if ($event['event_type'] == 'WWDC' && isset($wwdc_filter)) {
		echo sitemap_url('/wwdc', $event['last_edited']);
		unset($wwdc_filter);
	}
	if ($event['status'] == 'Ungraded' && isset($ungraded_filter)) {
		echo sitemap_url('/ungraded', $event['last_edited']);
		unset($ungraded_filter);
	}
	echo sitemap_url('/' . $event['url_name'], $event['last_edited']);
	echo sitemap_url('/billof/' . $event['url_name'], $event['last_edited_rules'], 'monthly', '0.1');
}

// Rules data for /billof
$rules__params = [
	'maxRecords' => 1,
	'sort' => $airtable_sorting,
];
include '../includes/data_controllers/rules_data_controller.php';
echo sitemap_url('/billof', $rules__array[array_key_first($rules__array)][0]['last_edited']);

// Host data for /leaderboard
$hosts_data__params = [
	'fields' => ['First name', 'Full name', 'Last edit date'],
	'sort' => $airtable_sorting,
	'maxRecords' => 1,
];
include '../includes/data_controllers/hosts_data_controller.php';
echo sitemap_url('/leaderboard', $hosts_data__array[array_key_first($hosts_data__array)]['last_edited'], 'always');

// Picks data for /archive
$picks_data__params = [
	'filterByFormula' => 'AND( Pick, {Host name}, Type, {Round set} )',
	'sort' => $airtable_sorting,
	'maxRecords' => 1,
];
include '../includes/data_controllers/picks_data_controller.php';

foreach ($picks_data__array[array_key_first($picks_data__array)] as $host => $picks) {
	if (!empty($picks_data__array[array_key_first($picks_data__array)][$host])) {
		$pick = $picks_data__array[array_key_first($picks_data__array)][$host][0];
	}
}
echo sitemap_url('/archive', $pick['last_edited'], 'weekly');

// Date for /about
$about = max([filemtime('../includes/view_controllers/about_controller.php'), filemtime('../includes/about.html')]);
echo sitemap_url('/about', date('c', $about), 'yearly', '0.3');
echo '</urlset>';
