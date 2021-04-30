<?php

// echo '<pre>', var_dump($rickies_events__array), '</pre>';
// echo '<pre>', var_dump($hosts_data__array), '</pre>';

$rickies_data = reset($rickies_events__array);
foreach ($rickies_data['hosts'] as $first_name => $host_data) {
	$rickies_data['hosts'][$first_name]['details']['full_name'] =
		$hosts_data__array[$first_name]['personal']['full_name'];
	$rickies_data['hosts'][$first_name]['details']['color'] = $hosts_data__array[$first_name]['personal']['color'];
	$rickies_data['hosts'][$first_name]['details']['memoji'] = $hosts_data__array[$first_name]['images']['memoji'];
}

// echo '<pre>', var_dump($rickies_data), '</pre>';
