<?php

// Search controller

// Define search query
if (isset($_GET['search']) && $_GET['search'] !== '') {
	$search_string = trim($_GET['search']);
	$search_query = "
	OR(
		SEARCH(LOWER('$search_string'),LOWER(Pick)),
		SEARCH(LOWER('$search_string'),LOWER({Special remark})),
		SEARCH(LOWER('$search_string'),LOWER({Came true string})),
		SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Related search terms}))),
		SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Category name},','))),
		SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Category group},','))),
		SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Rickies name},',')))
	),";

	/*
SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN(Host,','))),
SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN(Type,','))),
SEARCH(LOWER('$search_string'),LOWER(ARRAYJOIN({Type group},',')))
*/
} else {
	$search_string = $search_query = false;
}

// Define filters in query
$search_filters = [];
if (isset($_GET['reuse']) && $_GET['reuse'] === 'on') {
	$search_filters[] = '{Eligible for reuse}=TRUE()';
}

if (isset($_GET['buzzkill']) && $_GET['buzzkill'] === 'on') {
	$search_filters[] = '{Negative pick}';
}

if (isset($_GET['eventually']) && $_GET['eventually'] === 'on') {
	$search_filters[] = '{Came true date}';
}

// Get the pick types filter as array
if (isset($_GET['type']) && is_array($_GET['type'])) {
	// let's iterate thru the array
	foreach ($_GET['type'] as $type) {
		// do some super-magic here
		$types_filter[] = 'Type="' . ucfirst($type) . '"';
	}
	if (!empty($types_filter)) {
		$search_filters[] = 'OR(' . implode(',', $types_filter) . ')';
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
		$search_filters[] = 'OR(' . implode(',', $hosts_filter) . ')';
	}
}

if (!empty($search_filters)) {
	$search_filters = implode(',', $search_filters) . ',';
} else {
	$search_filters = '';
}

$filterByFormula =
	"
AND(
	" .
	$search_query .
	$search_filters .
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
echo '<pre>' . $filterByFormula . '</pre>';

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
