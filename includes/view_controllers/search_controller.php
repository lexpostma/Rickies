<?php

// Search controller

// Define the filtering array
$pick_filter = $pick_filter_empty = $pick_filter_empty_3j = [
	'search' => [],
	'filter_other' => [],
	'filter_categories' => [],
	'display' => [],
];
// Define the 3J filter, for when everything but 3J is empty
// Value is also used in the final search query
$pick_filter_empty_3j['filter_other']['3j'] = 'Special="Pickies"';

// Define how picks are displayed
if (isset($_GET['display']) && $_GET['display'] !== '') {
	$pick_filter['display'] = $_GET['display'];
}
switch ($pick_filter['display']) {
	case 'categories':
		$pick_display = ['search', 'ahead_of_its_time', 'categories'];
		break;
	case 'age':
	// 'age' is here of historical compatibility
	case 'reusability':
		$pick_display = ['search', 'ahead_of_its_time', 'reusability'];
		break;
	case 'clean':
		$pick_display = ['search'];
		break;
	default:
		$pick_display = ['search', 'ahead_of_its_time', 'categories', 'buzzkill', 'reusability', 'amendment'];
		break;
}

// Define the full query
include '../includes/search_query.php';

// Get all (within the formula) picks from Airtable
$picks_data__params = [
	'filterByFormula' => $filterByFormula,
	'sort' => [['field' => 'Pick date', 'direction' => 'desc']],
];
include '../includes/data_controllers/picks_data_controller.php';

// Get all Rickies events from Airtable
$rickies_events__params = [
	'filterByFormula' => 'AND( Published = TRUE(), Picks)',
	'sort' => [['field' => 'Predictions episode date', 'direction' => 'desc']],
];
include '../includes/data_controllers/event_data_controller.php';

// Define Rickies events for the select
$rickies_events_options = [];
foreach ($rickies_events__array as $event) {
	if ($event['special'] == 'Pickies') {
		$emoji = '🎄';
	} elseif ($event['special'] == 'EUies') {
		$emoji = '🇪🇺';
	} elseif ($event['status'] == 'Live') {
		$emoji = '🔴';
	} elseif ($event['status'] == 'Ungraded') {
		$emoji = '🟠';
	} elseif ($event['type'] == 'annual') {
		$emoji = '📆';
	} elseif ($event['event_type'] == 'WWDC') {
		$emoji = '💻';
	} else {
		$emoji = '📽';
	}
	$rickies_events_options[$event['url_name']] =
		emoji_select_spacing($emoji) .
		str_replace(
			'Keynote WWDC',
			'WWDC',
			str_replace(['Rickies ', 'Rickies, ', 'Predictions ', 'Predictions, '], '', $event['name'])
		);
	unset($emoji);
}
// echo '<pre>', var_dump($rickies_events_options), '</pre>';

// Get all categories from Airtable
include '../includes/data_controllers/categories_data_controller.php';

// Get the categories filter as array
if (isset($_GET['category']) && is_array($_GET['category'])) {
	// let's iterate through the array
	foreach ($_GET['category'] as $category) {
		// do some super-magic here
		$pick_filter['filter_categories'][] = $category;
	}
	if (!empty($pick_filter['filter_categories'])) {
		// Category are filtered server-side, not in Airtable,
		// due to difficulty to the formula and the different group levels
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
if ($url_view !== 'archive' && $url_view !== '3j-archive') {
	if ($pick_filter === $pick_filter_empty) {
		header('Location: ' . domain_url() . '/archive');
		die();
	} elseif ($pick_filter === $pick_filter_empty_3j) {
		header('Location: ' . domain_url() . '/3j-archive');
		die();
	}
}

// Define counters and chart data
// Has to happen separate from getting pick data from Airtable,
// because the category filtering is also separate
if (!isset($triple_j)) {
	$picks_type_count = [
		'Rickies' => 0,
		'Flexies' => 0,
		'EUies' => 0,
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
	];
} else {
	$picks_type_count = [
		'Pickies' => 0,
		'Lightning Round' => 0,
	];

	$picks_chart__array = [
		'Jason' => [
			'Correct' => 0,
			'Wrong' => 0,
			'Eventually' => 0,
			'Unknown' => 0,
		],
		'John' => [
			'Correct' => 0,
			'Wrong' => 0,
			'Eventually' => 0,
			'Unknown' => 0,
		],
		'James' => [
			'Correct' => 0,
			'Wrong' => 0,
			'Eventually' => 0,
			'Unknown' => 0,
		],
	];
}
$picks_chart__array['All'] = [
	'Correct' => 0,
	'Wrong' => 0,
	'Eventually' => 0,
	'Unknown' => 0,
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
	if (!in_array('ahead_of_its_time', $pick_display)) {
		$picks_chart__array[$host]['Wrong'] =
			$picks_chart__array[$host]['Wrong'] + $picks_chart__array[$host]['Eventually'];
		$picks_chart__array[$host]['Eventually'] = 0;
	}
}

// Format the total picks per type
if (!isset($triple_j)) {
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
} else {
	if ($picks_type_count['Pickies'] === 0) {
		unset($picks_type_count['Pickies']);
	} elseif ($picks_type_count['Pickies'] === 1) {
		$picks_type_count['Pickies'] = '1 Picky';
	} else {
		$picks_type_count['Pickies'] = $picks_type_count['Pickies'] . ' Pickies';
	}

	if ($picks_type_count['Lightning Round'] === 0) {
		unset($picks_type_count['Lightning Round']);
	} elseif ($picks_type_count['Lightning Round'] === 1) {
		$picks_type_count['Lightning Round'] = '1 Lightning pick';
	} else {
		$picks_type_count['Lightning Round'] = $picks_type_count['Lightning Round'] . ' Lightning picks';
	}
}

// Define SEO for search/archive page
if (!isset($triple_j)) {
	$rickies = 'Rickies';
	$hero = 'hero';
} else {
	$rickies = 'Pickies';
	$hero = 'hero-3j';
}

if ($url_view == 'archive' || $url_view == '3j-archive') {
	$head_custom = [
		'title' => $rickies . ' archive',
		'description' => 'Archive of all ' . $rickies . ' predictions.',
		'image' => domain_url() . '/images/seo/' . $hero . '-archive.jpg',
	];

	$h1 = $rickies . ' archive';
} elseif (!empty($pick_filter['search'])) {
	if (strlen($pick_filter['search']['string']) < 20) {
		// If string is less than 20 characters, show full string in title
		$head_custom['title'] =
			'Search ' . $rickies . ' for ‘' . htmlentities($pick_filter['search']['string'], ENT_QUOTES, 'UTF-8') . '’';
	} else {
		// Else, truncate the string at 16 characters
		$head_custom['title'] =
			'Search ' .
			$rickies .
			' for ‘' .
			htmlentities(substr($pick_filter['search']['string'], 0, 16), ENT_QUOTES, 'UTF-8') .
			'…’';
	}
	$head_custom['description'] =
		$picks_chart__array['All']['Total'] .
		' picks were found while searching for ‘' .
		$pick_filter['search']['string'] .
		'’ on Rickies.co.';
	$head_custom['image'] = domain_url() . '/images/seo/' . $hero . '-search.jpg';
} else {
	$head_custom['title'] = 'Search for ' . $rickies;
	$head_custom['description'] =
		$picks_chart__array['All']['Total'] . ' picks were found while searching and filtering on Rickies.co.';
	$head_custom['image'] = domain_url() . '/images/seo/' . $hero . '-search.jpg';
}
unset($rickies);
unset($hero);

// Add the enabled filters to the SEO description
if (!empty($pick_filter['filter_other']) || !empty($pick_filter['filter_categories'])) {
	if (!empty($pick_filter['search'])) {
		$seo_description_add[] = 'Search';
	}
	$seo_description_add[] = ucwords(implode(', ', array_keys($pick_filter['filter_other'])));
	if (!empty($pick_filter['filter_categories'])) {
		$seo_description_add[] = 'Categories';
	}

	$seo_description_add = implode(', ', $seo_description_add);
	$head_custom['description'] =
		$head_custom['description'] . ' Enabled filters are: ' . str_replace('_', ' ', $seo_description_add) . '.';
}

$head_custom['keywords'] = ['archive', 'history', 'search', 'filters', 'categories', 'charts'];

if (!isset($triple_j)) {
	$head_custom['canonical'] = current_url(true) . 'archive';
} else {
	$head_custom['canonical'] = current_url(true) . '3j-archive';

	// Rewrite the "All hosts" chart count
	$picks_chart__array['Triple J'] = $picks_chart__array['All'];
	unset($picks_chart__array['All']);
}
