<?php

// Search controller

// Define search query
if (isset($_GET['search']) && $_GET['search'] !== '') {
	$search_string = trim($_GET['search']);
	$search_query_formula = "
	OR(
		SEARCH(LOWER('$search_string'),LOWER(Pick)),
		SEARCH(LOWER('$search_string'),LOWER({Special remark})),
		SEARCH(LOWER('$search_string'),LOWER({Came true string})),
		SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Related search terms}))),
		SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Category name},','))),
		SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Category group},','))),
		SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Rickies},',')))
	),";

	/*
SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN(Host,','))),
SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN(Type,','))),
SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Type group},',')))
*/
} else {
	$search_string = $search_query_formula = false;
}

// Define filters in query
$search_filters = [];
if (isset($_GET['reuse']) && $_GET['reuse'] === 'on') {
	$search_filters['reuse'] = '{Eligible for reuse}=TRUE()';
}

if (isset($_GET['buzzkill']) && $_GET['buzzkill'] === 'on') {
	$search_filters['buzzkill'] = '{Negative pick}';
}

if (isset($_GET['eventually']) && $_GET['eventually'] === 'on') {
	$search_filters['eventually'] = '{Came true date}';
}

if (isset($_GET['adjudicated']) && $_GET['adjudicated'] === 'on') {
	$search_filters['adjudicated'] = '{Adjudicated}';
}

if (isset($_GET['half_points']) && $_GET['half_points'] === 'on') {
	$search_filters['half_points'] = 'OR(Factor<1, {Half correct})';
}

if (isset($_GET['event'])) {
	switch ($_GET['event']) {
		case 'annual':
			$search_filters['event'] = '{Rickies type}="annual"';
			break;
		case 'keynote':
			$search_filters['event'] = '{Rickies type}="keynote"';
			break;
		case 'wwdc':
			$search_filters['event'] = '{Event type}="WWDC"';
			break;
		case 'ungraded':
			$search_filters['event'] = 'OR({Rickies status} = "Ungraded", {Rickies status} = "Live")';
			break;
		default:
			break;
	}
}

// Get the pick types filter as array
if (isset($_GET['type']) && is_array($_GET['type'])) {
	// Let's iterate through the array
	foreach ($_GET['type'] as $type) {
		// Add a part to the formula for each type
		$types_filter[] = 'Type="' . ucfirst($type) . '"';
	}
	if (!empty($types_filter)) {
		// Combine the parts into the formula
		$search_filters['type'] = 'OR(' . implode(',', $types_filter) . ')';
	}
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
		$search_filters['status'] = 'OR(' . implode(',', $status_filter) . ')';
	}
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
		$search_filters['host'] = 'OR(' . implode(',', $hosts_filter) . ')';
	}
}

if (!empty($search_filters)) {
	$search_filters_formula = implode(',', $search_filters) . ',';
} else {
	$search_filters_formula = '';
}

$filterByFormula =
	"
AND(
	" .
	$search_query_formula .
	$search_filters_formula .
	"
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
		$categories_filter[] = $category;
	}
	if (!empty($categories_filter)) {
		// echo '<pre>', var_dump($categories_filter), '</pre>';

		// Category are filtered server-side, not in Airtable,
		// due to difficulty to the formula and the different levels
		// This removes the picks from the array when they don't match any of the category filters
		foreach ($picks_data__array as $pick_type => $host_picks) {
			foreach ($host_picks as $host => $picks) {
				foreach ($picks as $pick => $pick_data) {
					// Compare 2 arrays to see if pick category array have any in common with category filter
					// Via https://stackoverflow.com/a/8736291
					$cat_found = count(array_intersect($categories_filter, $pick_data['categories_compare']))
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
	} else {
		$categories_filter = false;
	}
} else {
	$categories_filter = false;
}

// If no search string and no filters, redirect to /archive
if ($url_view !== 'archive' && !$search_string && empty($search_filters) && !$categories_filter) {
	header('Location: ' . domain_url() . '/archive');
	die();
}

// echo '<pre>', var_dump($picks_data__array), '</pre>';

// Define SEO for search/archive page
if ($url_view == 'archive') {
	$head_custom = [
		'title' => 'Rickies archive',
		'description' => 'Archive of all Rickies predictions.',
	];

	$h1 = 'Rickies archive';
} elseif ($search_string) {
	$head_custom['title'] = 'Search Rickies for ‘' . $search_string . '’';
	$head_custom['description'] = 'Search and filter results for ‘' . $search_string . '’ on Rickies.co.';
} else {
	$head_custom['title'] = 'Search for Rickies';
	$head_custom['description'] = 'Search and filter results on Rickies.co.';
}

$head_custom['canonical'] = domain_url() . '/archive';
$head_custom['keywords'] = ['archive', 'history', 'search', 'filters'];
