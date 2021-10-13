<?php

// Search controller

if (isset($_GET['search'])) {
	$query = trim($_GET['search']);
} else {
	$query = '';
}

if ($url_view == 'archive') {
	$head_custom = [
		'title' => 'Rickies archive',
		'description' => 'Archive of all Rickies predictions.',
	];

	$h1 = 'Rickies archive';
} else {
	$head_custom = [
		'title' => 'Search for Rickies',
		'description' => 'Search results for ‘' . $query . '’ on Rickies.co.',
	];
}

$picks_data__params = [
	'filterByFormula' => "AND(
		OR(
			SEARCH(LOWER('$query'),LOWER(Pick)),
			SEARCH(LOWER('$query'),LOWER({Special remark})),
			SEARCH(LOWER('$query'),LOWER(ARRAYJOIN({Category name},','))),
			SEARCH(LOWER('$query'),LOWER(ARRAYJOIN({Category group},','))),
			SEARCH(LOWER('$query'),LOWER(ARRAYJOIN({Rickies name},','))),
			SEARCH(LOWER('$query'),LOWER(ARRAYJOIN(Host,','))),
			SEARCH(LOWER('$query'),LOWER(ARRAYJOIN(Type,','))),
			SEARCH(LOWER('$query'),LOWER(ARRAYJOIN({Type group},',')))
		),
		Pick,
		{Host name} ,
		Type,
		{Round set}
	)",
	'sort' => [['field' => 'Pick date', 'direction' => 'desc']],
];
include '../includes/data_controllers/picks_data_controller.php';
