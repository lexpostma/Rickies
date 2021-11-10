<?php

// Search controller

// Define the filtering array
$pick_filter = $pick_filter_empty = [
	'search' => [],
	'filter_other' => [],
	'filter_categories' => [],
	'display' => [],
];

// Define search query
if (isset($_GET['search']) && $_GET['search'] !== '') {
	$search_string = trim($_GET['search']);

	$pick_filter['search'] = [
		'string' => $search_string,
		'formula' => "
	OR(
		SEARCH(LOWER('$search_string'),LOWER(Pick)),
		SEARCH(LOWER('$search_string'),LOWER({Special remark})),
		SEARCH(LOWER('$search_string'),LOWER({Came true string})),
		SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Related search terms}))),
		SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Category name},','))),
		SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Category group},','))),
		SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Rickies},',')))
	),",
	];
	unset($search_string);
}

// Define how picks are displayed
if (isset($_GET['display'])) {
	$pick_filter['display'] = $_GET['display'];
	switch ($pick_filter['display']) {
		case 'categories':
			$pick_display = ['search', 'ahead_of_its_time', 'categories'];
			break;
		case 'age':
			$pick_display = ['search', 'ahead_of_its_time', 'age'];
			break;
		// case 'became_true':
		// 	$pick_display = ['search', 'ahead_of_its_time'];
		// 	break;
		case 'clean':
			$pick_display = ['search'];
			break;
		default:
			$pick_display = ['search', 'ahead_of_its_time', 'categories', 'buzzkill', 'age'];
			break;
	}
}

// Define filters in query
if (isset($_GET['reusable']) && $_GET['reusable'] === 'on') {
	$pick_filter['filter_other']['reusable'] = '{Eligible for reuse}=TRUE()';
}

if (isset($_GET['buzzkiller']) && $_GET['buzzkiller'] === 'on') {
	$pick_filter['filter_other']['buzzkiller'] = '{Negative pick}';
}

if (isset($_GET['ahead_of_its_time']) && $_GET['ahead_of_its_time'] === 'on') {
	$pick_filter['filter_other']['ahead_of_its_time'] = '{Came true date}';
}

if (isset($_GET['adjudicated']) && $_GET['adjudicated'] === 'on') {
	$pick_filter['filter_other']['adjudicated'] = '{Adjudicated}';
}

if (isset($_GET['half_points']) && $_GET['half_points'] === 'on') {
	$pick_filter['filter_other']['half_points'] = 'OR(Factor<1, {Half correct})';
}

if (isset($_GET['event_type'])) {
	switch ($_GET['event_type']) {
		case 'annual':
			$pick_filter['filter_other']['event_type'] = '{Rickies type}="annual"';
			break;
		case 'keynote':
			$pick_filter['filter_other']['event_type'] = '{Rickies type}="keynote"';
			break;
		case 'wwdc':
			$pick_filter['filter_other']['event_type'] = '{Event type}="WWDC"';
			break;
		case 'ungraded':
			$pick_filter['filter_other']['event_type'] = 'OR({Rickies status} = "Ungraded", {Rickies status} = "Live")';
			break;
		default:
			break;
	}
}

// Get the pick types filter as array
if (isset($_GET['pick_type']) && is_array($_GET['pick_type'])) {
	// Let's iterate through the array
	foreach ($_GET['pick_type'] as $type) {
		// Add a part to the formula for each type
		$types_filter[] = 'Type="' . ucfirst($type) . '"';
	}
	if (!empty($types_filter)) {
		// Combine the parts into the formula
		$pick_filter['filter_other']['pick_type'] = 'OR(' . implode(',', $types_filter) . ')';
	}
	unset($types_filter);
}

// Get the pick types filter as array
if (isset($_GET['status']) && is_array($_GET['status'])) {
	// Let's iterate through the array
	foreach ($_GET['status'] as $status) {
		// Add a part to the formula for each status
		if ($status == 'unknown') {
			$status_filter[] = 'Status=""';
		} else {
			$status_filter[] = 'Status="' . ucfirst($status) . '"';
		}
	}
	if (!empty($status_filter)) {
		// Combine the parts into the formula
		$pick_filter['filter_other']['status'] = 'OR(' . implode(',', $status_filter) . ')';
	}
	unset($status_filter);
}

// Get the hosts filter as array
if (isset($_GET['host']) && is_array($_GET['host'])) {
	// Let's iterate through the array
	foreach ($_GET['host'] as $type) {
		// Add a part to the formula for each host
		$hosts_filter[] = 'Host="' . ucfirst($type) . '"';
	}
	if (!empty($hosts_filter)) {
		// Combine the parts into the formula
		$pick_filter['filter_other']['host'] = 'OR(' . implode(',', $hosts_filter) . ')';
	}
	unset($hosts_filter);
}

$filterByFormula = "
AND(
	";
if (!empty($pick_filter['search'])) {
	$filterByFormula .= $pick_filter['search']['formula'];
}
if (!empty($pick_filter['filter_other'])) {
	$filterByFormula .= implode(',', $pick_filter['filter_other']) . ',';
}
$filterByFormula .= "
	Pick,
	{Host name} ,
	Type,
	{Round set}
)";

$picks_data__params = [
	'filterByFormula' => $filterByFormula,
	'sort' => [['field' => 'Pick date', 'direction' => 'desc']],
];

include '../includes/data_controllers/picks_data_controller.php';
include '../includes/data_controllers/categories_data_controller.php';

// echo '<pre>' . $filterByFormula . '</pre>';

// Get the categories filter as array
if (isset($_GET['category']) && is_array($_GET['category'])) {
	// let's iterate thru the array
	foreach ($_GET['category'] as $category) {
		// do some super-magic here
		$pick_filter['filter_categories'][] = $category;
	}
	if (!empty($pick_filter['filter_categories'])) {
		// Category are filtered server-side, not in Airtable,
		// due to difficulty to the formula and the different levels
		// This removes the picks from the array when they don't match any of the category filters
		foreach ($picks_data__array as $pick_type => $host_picks) {
			foreach ($host_picks as $host => $picks) {
				foreach ($picks as $pick => $pick_data) {
					// Compare 2 arrays to see if pick category array have any in common with category filter
					// Via https://stackoverflow.com/a/8736291
					$cat_found = count(
						array_intersect($pick_filter['filter_categories'], $pick_data['categories_compare'])
					)
						? true
						: false;
					if (!$cat_found) {
						unset($picks_data__array[$pick_type][$host][$pick]);
					}
				}
			}
		}

		foreach ($picks_data__array as $type => $host_picks) {
			if ($picks_data__array[$type] == $picks_data__empty[$type]) {
				unset($picks_data__array[$type]);
			}
		}
	}
}
// echo '<pre>', var_dump($picks_data__array), '</pre>';
// echo '<pre>', var_dump($pick_filter), '</pre>';

// If no search string and no filters, redirect to /archive
if ($url_view !== 'archive' && $pick_filter_empty === $pick_filter) {
	header('Location: ' . domain_url() . '/archive');
	die();
}

// Define counters and chart data
// Has to happens separate from getting pick data from Airtable,
// because the category filtering is also separate
$picks_type_count = [
	'Rickies' => 0,
	'Flexies' => 0,
];

$picks_chart__array = [
	'Myke' => [
		'Correct' => 0,
		'Wrong' => 0,
		'Eventually' => 0,
		'Unknown' => 0,
	],
	'Federico' => [
		'Correct' => 0,
		'Wrong' => 0,
		'Eventually' => 0,
		'Unknown' => 0,
	],
	'Stephen' => [
		'Correct' => 0,
		'Wrong' => 0,
		'Eventually' => 0,
		'Unknown' => 0,
	],
	'All' => [
		'Correct' => 0,
		'Wrong' => 0,
		'Eventually' => 0,
		'Unknown' => 0,
	],
];

foreach ($picks_data__array as $type => $hosts) {
	foreach ($hosts as $host => $picks) {
		foreach ($picks as $pick) {
			// Increment the count of this type
			$picks_type_count[$type]++;

			// Increment the count of this status for this host
			if (!$pick['status']) {
				// Status is Unknown
				$picks_chart__array[$host]['Unknown']++;
				$picks_chart__array['All']['Unknown']++;
			} elseif ($pick['status_later']) {
				// Status is Wrong, but Came true later
				$picks_chart__array[$host]['Eventually']++;
				$picks_chart__array['All']['Eventually']++;
			} elseif ($pick['status'] == 'Correct' && $pick['factor'] == 1) {
				// Status is Correct, and full points
				$picks_chart__array[$host]['Correct']++;
				$picks_chart__array['All']['Correct']++;
			} elseif ($pick['status'] == 'Correct') {
				// Status is Correct, but not full points
				// Count partial points as Correct
				$picks_chart__array[$host]['Correct'] = $picks_chart__array[$host]['Correct'] + $pick['factor'];
				$picks_chart__array['All']['Correct'] = $picks_chart__array['All']['Correct'] + $pick['factor'];
				// Count remaining points as Wrong
				$picks_chart__array[$host]['Wrong'] = $picks_chart__array[$host]['Wrong'] + 1 - $pick['factor'];
				$picks_chart__array['All']['Wrong'] = $picks_chart__array['All']['Wrong'] + 1 - $pick['factor'];
			} else {
				// Status is Wrong
				$picks_chart__array[$host]['Wrong']++;
				$picks_chart__array['All']['Wrong']++;
			}
		}
	}
}

// Count the total picks per host
foreach ($picks_chart__array as $host => $chart_data) {
	$picks_chart__array[$host]['Total'] = array_sum($chart_data);
}
// echo '<pre>', var_dump($picks_chart__array), '</pre>';

// Format the total picks per type
if ($picks_type_count['Rickies'] === 0) {
	unset($picks_type_count['Rickies']);
} elseif ($picks_type_count['Rickies'] === 1) {
	$picks_type_count['Rickies'] = '1 Ricky';
} else {
	$picks_type_count['Rickies'] = $picks_type_count['Rickies'] . ' Rickies';
}

if ($picks_type_count['Flexies'] === 0) {
	unset($picks_type_count['Flexies']);
} elseif ($picks_type_count['Flexies'] === 1) {
	$picks_type_count['Flexies'] = '1 Flexy';
} else {
	$picks_type_count['Flexies'] = $picks_type_count['Flexies'] . ' Flexies';
}
// echo '<pre>', var_dump($picks_type_count), '</pre>';

// Define SEO for search/archive page
if ($url_view == 'archive') {
	$head_custom = [
		'title' => 'Rickies archive',
		'description' => 'Archive of all Rickies predictions.',
		'image' => domain_url() . '/images/hero-archive.jpg',
	];

	$h1 = 'Rickies archive';
} elseif (!empty($pick_filter['search'])) {
	if (strlen($pick_filter['search']['string']) < 20) {
		// If string is less than 20 characters, show full string in title
		$head_custom['title'] = 'Search Rickies for ‘' . $pick_filter['search']['string'] . '’';
	} else {
		// Else, truncate the string at 16 characters
		$head_custom['title'] = 'Search Rickies for ‘' . substr($pick_filter['search']['string'], 0, 16) . '…’';
	}
	$head_custom['description'] =
		$picks_chart__array['All']['Total'] .
		' picks were found while searching for ‘' .
		$pick_filter['search']['string'] .
		'’ on Rickies.co.';
	$head_custom['image'] = domain_url() . '/images/hero-search.jpg';
} else {
	$head_custom['title'] = 'Search for Rickies';
	$head_custom['description'] =
		$picks_chart__array['All']['Total'] . ' picks were found while searching and filtering on Rickies.co.';
	$head_custom['image'] = domain_url() . '/images/hero-search.jpg';
}

// Add the enabled filters to the SEO description
if (!empty($pick_filter['filter_other']) || !empty($pick_filter['filter_categories'])) {
	if (!empty($pick_filter['search'])) {
		$seo_description_add[] = 'search';
	}
	$seo_description_add[] = implode(', ', array_keys($pick_filter['filter_other']));
	if (!empty($pick_filter['filter_categories'])) {
		$seo_description_add[] = 'categories';
	}
	$seo_description_add = implode(', ', $seo_description_add);
	$head_custom['description'] =
		$head_custom['description'] . ' Enabled filters are: ' . str_replace('_', ' ', $seo_description_add) . '.';
}

$head_custom['canonical'] = current_url(true) . 'archive';
$head_custom['keywords'] = ['archive', 'history', 'search', 'filters', 'categories', 'charts'];
