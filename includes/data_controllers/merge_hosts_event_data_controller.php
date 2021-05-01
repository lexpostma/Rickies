<?php

// Get Rickies event data
$rickies_events__params = [
	'filterByFormula' => "AND( Status, Status != 'Hidden', Picks, URL = '$url_view' )",
	'maxRecords' => 1,
	'sort' => [['field' => 'Predictions episode date', 'direction' => 'desc']],
	// "pageSize" => 50,
];
$all_event_details = true;

include '../includes/data_controllers/event_data_controller.php';
include '../includes/data_controllers/picks_data_controller.php';

// Get host personal data
$hosts_data__params = [
	'fields' => ['First name', 'Full name', 'Memoji neutral', 'Memoji happy', 'Memoji sad'],
];
$all_host_details = false;
include '../includes/data_controllers/hosts_data_controller.php';

// echo '<pre>', var_dump($rickies_events__array), '</pre>';
// echo '<pre>', var_dump($hosts_data__array), '</pre>';

$rickies_data = reset($rickies_events__array);

// Merge the Event array and the Host array
foreach ($rickies_data['hosts'] as $first_name => $host_data) {
	$rickies_data['hosts'][$first_name]['details']['full_name'] =
		$hosts_data__array[$first_name]['personal']['full_name'];
	$rickies_data['hosts'][$first_name]['details']['color'] = $hosts_data__array[$first_name]['personal']['color'];
	$rickies_data['hosts'][$first_name]['details']['memoji'] = $hosts_data__array[$first_name]['images']['memoji'];
}

// echo '<pre>', var_dump($rickies_data), '</pre>';
