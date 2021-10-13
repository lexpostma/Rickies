<?php

// Search controller

if (isset($_GET['search'])) {
	$query = trim($_GET['search']);
} else {
	$query = '';
}

$picks_data__params = [
	'filterByFormula' => "AND(
		OR(
			SEARCH(LOWER('$query'),LOWER(Pick)),
			SEARCH(LOWER('$query'),LOWER({Special remark})),
			SEARCH(LOWER('$query'),LOWER(ARRAYJOIN({Category name},','))),
			SEARCH(LOWER('$query'),LOWER(ARRAYJOIN({Category group},','))),
			SEARCH(LOWER('$query'),LOWER(ARRAYJOIN(Host,','))),
			SEARCH(LOWER('$query'),LOWER(ARRAYJOIN(Type,','))),
			SEARCH(LOWER('$query'),LOWER(ARRAYJOIN({Type group},',')))
		),
		Pick,
		{Host name} ,
		Type,
		{Round set}
	)",
	'sort' => [['field' => 'Pick date', 'direction' => 'asc']],
];
include '../includes/data_controllers/picks_data_controller.php';

$head_custom = [
	'title' => 'Searching Rickies.co',
	'description' => 'Search results for \'TODO: SEARCH TERM\' on Rickies.co.',
];

/*
Larger search query

SEARCH(LOWER('$query'),LOWER(Pick)),
SEARCH(LOWER('$query'),LOWER({Special remark})),
SEARCH(LOWER('$query'),LOWER(ARRAYJOIN({Category name},','))),
SEARCH(LOWER('$query'),LOWER(ARRAYJOIN({Category group},','))),
SEARCH(LOWER('$query'),LOWER(ARRAYJOIN(Host,','))),
SEARCH(LOWER('$query'),LOWER(ARRAYJOIN(Type,','))),
SEARCH(LOWER('$query'),LOWER(ARRAYJOIN({Type group},',')))

*/
