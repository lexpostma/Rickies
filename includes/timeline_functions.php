<?php

function chairman_timeline($host_data = [], $event_data = [])
{
	$first_date = strtotime('2018-12-26 00:00');
	$today = time();

	$datediff = $today - $first_date;
	$datediff = round($datediff / (60 * 60 * 24));

	$months = [
		'January' => 31,
		'February' => 28,
		'March' => 31,
		'April' => 30,
		'May' => 31,
		'June' => 30,
		'July' => 31,
		'August' => 31,
		'September' => 30,
		'October' => 31,
		'November' => 30,
		'December' => 31,
	];
	$start = 1;
	$output =
		'
<section class="large_columns navigate_with_mobile_menu leaderboard" id="timeline" >
	<div class="timeline--container">
		<h2>Chairman Timeline</h2>
		<div class="timeline--content">
			<div class="timeline--host-track legend" style="width: calc(' .
		$datediff .
		' * var(--day-width));">';
	foreach ($months as $month_name => $days) {
		$output .=
			'<div class="month" style="left: calc(' .
			$start .
			' * var(--day-width)); width: calc(' .
			$days .
			' * var(--day-width));">' .
			$month_name .
			'</div>';
		$start = $start + $days;
	}
	$output .= '</div>';

	foreach ($event_data as $host => $types) {
		$output .= '<div class="timeline--host-track host_' . strtolower($host) . '">';

		$img_array = [
			'type' => 'avatar',
			'name' => $host_data[$host]['personal']['first_name'],
			'src' => $host_data[$host]['images']['memoji']['neutral'],
			'color' => $host_data[$host]['personal']['color'],
		];

		$output .= '<div class="timeline--host-avatar">' . list_item_graphic($img_array) . '</div>';
		unset($img_array);

		foreach ($types as $type => $events) {
			$output .= '<div class="timeline--chairman ' . $type . '">';
			foreach ($events as $event) {
				$output .=
					'<div class="chairman" style="left: calc(' .
					$event['timeline_start'] .
					' * var(--day-width)); width: calc(' .
					$event['timeline_duration'] .
					' * var(--day-width));"><a href="' .
					$event['url_name'] .
					'" title="' .
					$event['name'] .
					'">' .
					$event['name'] .
					'</a></div>';
			}
			$output .= '</div>';
		}
		$output .= '</div>';
	}
	$output .= '
		</div>
	</div>
</section>';
	return $output;
}

$rickies_events__params = [
	'filterByFormula' => 'AND(
			Published = TRUE(),
			{Results episode date},
			{Days from first Rickies} >=0,
			{Rickies 1st (manual)})',
	'sort' => [['field' => 'Predictions episode date', 'direction' => 'desc']],
];
$rickies_event_data_set = 'timeline';
include '../includes/data_controllers/event_data_controller.php';
// echo '<pre>', var_dump($rickies_events__array), '</pre>';

$timeline_array = [
	'Myke' => [
		'annual' => [],
		'keynote' => [],
	],
	'Federico' => [
		'annual' => [],
		'keynote' => [],
	],
	'Stephen' => [
		'annual' => [],
		'keynote' => [],
	],
];

foreach ($rickies_events__array as $event) {
	$timeline_array[$event['winner']][$event['type']][] = $event;
}
// echo '<pre>', var_dump($timeline_array), '</pre>';
