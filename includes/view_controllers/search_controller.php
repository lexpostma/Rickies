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
	// let's iterate thru the array
	foreach ($_GET['type'] as $type) {
		// do some super-magic here
		$types_filter[] = 'Type="' . ucfirst($type) . '"';
	}
	if (!empty($types_filter)) {
		$search_filters['type'] = 'OR(' . implode(',', $types_filter) . ')';
	}
}

// Get the hosts filter as array
if (isset($_GET['host']) && is_array($_GET['host'])) {
	// let's iterate thru the array
	foreach ($_GET['host'] as $type) {
		// do some super-magic here
		$hosts_filter[] = 'Host="' . ucfirst($type) . '"';
	}
	if (!empty($hosts_filter)) {
		$search_filters['host'] = 'OR(' . implode(',', $hosts_filter) . ')';
	}
}

// Get the categories filter as array
if (isset($_GET['category']) && is_array($_GET['category'])) {
	// let's iterate thru the array
	foreach ($_GET['category'] as $category) {
		// do some super-magic here
		$categories_filter[] = '{Category name}="' . ucfirst($category) . '"';
	}
	if (!empty($categories_filter)) {
		$search_filters['category'] = 'OR(' . implode(',', $categories_filter) . ')';
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

// Define SEO for search/archive page
if ($url_view == 'archive') {
	$head_custom = [
		'title' => 'Rickies archive',
		'description' => 'Archive of all Rickies predictions.',
	];

	$h1 = 'Rickies archive';
} else {
	$head_custom['title'] = 'Search for Rickies';
	if ($search_string) {
		$head_custom['description'] = 'Search and filter results for ‘' . $search_string . '’ on Rickies.co.';
	} else {
		$head_custom['description'] = 'Search and filter results on Rickies.co.';
	}
}

$head_custom['canonical'] = domain_url() . '/archive';
$head_custom['keywords'] = ['archive', 'history', 'search', 'filters'];
