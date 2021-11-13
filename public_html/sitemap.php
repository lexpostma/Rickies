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
// TODO: define sorting, and the filters ungraded/keynote/annual/wwdc
// TODO: use different date field?
include '../includes/data_controllers/event_data_controller.php';
$home = $latest = $latest_keynote = $latest_annual = $ungraded_filter = $wwdc_filter = $keynote_filter = $annual_filter = false;

foreach ($rickies_events__array as $event) {
	if (!$home) {
		echo sitemap_url('/', $event['last_edited'], 'monthly', '0.8');
		$home = true;
	}

	if (!$latest) {
		echo sitemap_url('/latest', $event['last_edited']);
		$latest = true;
	}
	if ($event['type'] == 'keynote' && !$latest_keynote) {
		echo sitemap_url('/latest-keynote', $event['last_edited']);
		$latest_keynote = true;
	}
	if ($event['type'] == 'keynote' && !$keynote_filter) {
		echo sitemap_url('/keynote', $event['last_edited']);
		$keynote_filter = true;
	}
	if ($event['type'] == 'annual' && !$annual_filter) {
		echo sitemap_url('/annual', $event['last_edited']);
		$annual_filter = true;
	}
	if ($event['type'] == 'annual' && !$latest_annual) {
		echo sitemap_url('/latest-annual', $event['last_edited']);
		$latest_annual = true;
	}
	if ($event['event_type'] == 'WWDC' && !$wwdc_filter) {
		echo sitemap_url('/wwdc', $event['last_edited']);
		$wwdc_filter = true;
	}
	if ($event['status'] == 'Ungraded' && !$ungraded_filter) {
		echo sitemap_url('/ungraded', $event['last_edited']);
		$ungraded_filter = true;
	}
	echo sitemap_url('/' . $event['url_name'], $event['last_edited']);
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
echo sitemap_url('/leaderboard', $hosts_data__array[array_key_first($hosts_data__array)]['last_edited']);

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
