<?php
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

// Define filters in query
if (isset($_GET['reusable'])) {
	switch ($_GET['reusable']) {
		case 'on':
		case 'yes':
			$pick_filter['filter_other']['reusable'] = '{Eligible for reuse}=TRUE()';
			break;
		case 'no':
			$pick_filter['filter_other']['reusable'] = '{Eligible for reuse}=FALSE()';
			break;
		case 'keynote':
			$pick_filter['filter_other']['reusable'] = "SEARCH('♻️',{Age string})";
			break;
	}
}

if ((isset($_GET['3j']) && $_GET['3j'] === 'on') || isset($triple_j)) {
	$triple_j = true;
	$pick_filter['filter_other']['3j'] = $pick_filter_empty_3j['filter_other']['3j'];
}

if (isset($_GET['buzzkiller']) && $_GET['buzzkiller'] === 'on') {
	$pick_filter['filter_other']['buzzkiller'] = '{Negative pick}';
}

if (isset($_GET['ahead_of_its_time']) && $_GET['ahead_of_its_time'] === 'on') {
	$pick_filter['filter_other']['ahead_of_its_time'] = 'AND({Came true date},Status="Wrong")';
}

if (isset($_GET['adjudicated']) && $_GET['adjudicated'] === 'on') {
	$pick_filter['filter_other']['adjudicated'] = '{Adjudicated}';
}

if (isset($_GET['half_points']) && $_GET['half_points'] === 'on') {
	$pick_filter['filter_other']['half_points'] = 'OR(Factor<1, {Half correct})';
}

if (isset($_GET['amendment']) && $_GET['amendment'] === 'on') {
	$pick_filter['filter_other']['amendment'] = 'Amendments';
}

if (isset($_GET['complex_min']) && is_numeric($_GET['complex_min'])) {
	$pick_filter['filter_other']['complex_min'] = 'Conditions >= ' . $_GET['complex_min'];
}

if (isset($_GET['complex_max']) && is_numeric($_GET['complex_max'])) {
	$pick_filter['filter_other']['complex_max'] = 'Conditions <= ' . $_GET['complex_max'];
}

if (isset($_GET['double_points']) && $_GET['double_points'] === 'on') {
	$pick_filter['filter_other']['double_points'] = '{3J doubler}=2';
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

// Get the status filter as array
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

// Get the Rickies event filter
if (isset($_GET['rickies_event'])) {
	switch ($_GET['rickies_event']) {
		case '':
			break;
		case 'annual':
			$pick_filter['filter_other']['rickies_event'] = '{Rickies type}="annual"';
			break;
		case 'keynote':
			$pick_filter['filter_other']['rickies_event'] = '{Rickies type}="keynote"';
			break;
		case 'wwdc':
			$pick_filter['filter_other']['rickies_event'] = '{Event type}="WWDC"';
			break;
		case 'ungraded':
			$pick_filter['filter_other']['rickies_event'] =
				'OR({Rickies status} = "Ungraded", {Rickies status} = "Live")';
			break;
		default:
			$pick_filter['filter_other']['rickies_event'] = 'URL="' . $_GET['rickies_event'] . '"';
			break;
	}
}

// Define Airtable search query and filter formula
$filterByFormula = "
AND(
	";
if (!empty($pick_filter['search'])) {
	$filterByFormula .= $pick_filter['search']['formula'];
}
if (!empty($pick_filter['filter_other'])) {
	$filterByFormula .= implode(',', $pick_filter['filter_other']) . ',';
}

// Here the Pickies are in/excluded
if (!isset($triple_j)) {
	$filterByFormula .= "
	OR(Special='Rickies', Special='Pre-Rickies'),";
}

// Finishing up the formula with the default pick requirements
$filterByFormula .= "
	Pick,
	{Host name} ,
	Type,
	Published = TRUE(),
	{Round set}
)";
