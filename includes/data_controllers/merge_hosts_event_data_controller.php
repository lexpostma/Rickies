<?php

// Get Rickies event data
$rickies_events__params = [
	'filterByFormula' => "AND( Published = TRUE(), URL = '$url_view' )",
	'maxRecords' => 1,
	'sort' => [['field' => 'Predictions episode date', 'direction' => 'desc']],
];

// Function to check if string ends with a substring
function endsWith($haystack, $needle)
{
	$length = strlen($needle);
	if (!$length) {
		return true;
	}
	return substr($haystack, -$length) === $needle;
}

// Allow previewing event pages when not published yet
if (endsWith($url_view, '-preview')) {
	$previewing_content = true;
	$rickies_events__params['filterByFormula'] = "AND( Status = 'Preview', URL = '$url_view' )";
}

$rickies_event_data_set = 'details';

include '../includes/data_controllers/event_data_controller.php';
// echo '<pre>', var_dump($rickies_events__array), '</pre>';

// Get host personal data
$hosts_data__params['fields'] = [
	'First name',
	'Full name',
	'Memoji neutral',
	'Memoji happy',
	'Memoji sad',
	'Flexy winner title (flat)',
];

if (!isset($triple_j)) {
	$hosts_data__params['filterByFormula'] = 'AND( {Host type} = "Official" )';
} else {
	$hosts_data__params['filterByFormula'] = 'AND( {Host type} = "Triple J" )';
}

include '../includes/data_controllers/hosts_data_controller.php';
// echo '<pre>', var_dump($hosts_data__array), '</pre>';

$rickies_data = reset($rickies_events__array);

// Merge the Event array and the Host array
foreach ($rickies_data['hosts'] as $first_name => $host_data) {
	$rickies_data['hosts'][$first_name]['details']['full_name'] =
		$hosts_data__array[$first_name]['personal']['full_name'];
	$rickies_data['hosts'][$first_name]['details']['color'] = $hosts_data__array[$first_name]['personal']['color'];
	$rickies_data['hosts'][$first_name]['details']['memoji'] = $hosts_data__array[$first_name]['images']['memoji'];
	$rickies_data['hosts'][$first_name]['details']['flexy_title'] =
		$hosts_data__array[$first_name]['personal']['flexy_title'];
}

// echo '<pre>', var_dump($rickies_data), '</pre>';

// Get picks data
$picks_data__params = [
	'filterByFormula' => "AND( URL = '$url_view', Pick, {Host name} , Type, {Round set} )",
	'sort' => [['field' => 'Picking order', 'direction' => 'asc']],
];
include '../includes/data_controllers/picks_data_controller.php';

// Sort picks data by ranking
foreach ($picks_data__array as $type => $host_picks) {
	$picks_data__array[$type] = array_merge(array_flip($hosts), $picks_data__array[$type]);
}

// echo '<pre>', var_dump($picks_data__array), '</pre>';
