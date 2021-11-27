<?php

function chairman_timeline($host_data = [], $event_data = [])
{
	// Define the timeline's scale
	$timeline_scale = '
<div class="timeline--scale">';

	// Define the start of the scale
	$start_of_scale = $day_count = new DateTimeImmutable('2018-11-01 00:00');
	$prev_month = $months_in_current_year = '';
	$year_position = $month_position = $full_width = 0;

	// Define the end of the scale
	$today = new DateTimeImmutable();
	$end_of_scale = $today->modify('+3 months');

	while ($day_count < $end_of_scale) {
		// Create a new month
		if ($day_count->format('m') !== $prev_month) {
			$months_in_current_year .=
				'
		<div class="month" style="width: calc(' .
				$day_count->format('t') .
				' * var(--day-width)); left: calc(' .
				$month_position .
				' * var(--day-width));"><span><span>' .
				substr($day_count->format('F'), 0, 1) .
				'</span><span>' .
				substr($day_count->format('F'), 1, 2) .
				'</span><span>' .
				substr($day_count->format('F'), 3) .
				'</span></span></div>';

			// Increase the monthly increments
			$prev_month = $day_count->format('m');
			$month_position = $month_position + $day_count->format('t');
			$year_size = $year_size + $day_count->format('t');
		}

		// Create a new year
		// IF tomorrow is a new year
		// OR IF tomorrow is the last day of the scale
		if (
			$day_count->format('Y') !== $day_count->modify('+1 day')->format('Y') ||
			$day_count->modify('+1 day') > $end_of_scale
		) {
			$timeline_scale .=
				'
	<div class="year" style="width: calc(' .
				$year_size .
				' * var(--day-width)); left: calc(' .
				$year_position .
				' * var(--day-width));"><span><span>' .
				substr($day_count->format('Y'), 0, 2) .
				'</span><span>' .
				substr($day_count->format('Y'), 2) .
				'</span></span>' .
				$months_in_current_year .
				'
	</div>';

			// Increase the yearly increments
			$year_position = $year_position + $year_size;
			$full_width = $full_width + $year_size;

			// Reset the yearly variables
			$year_size = $month_position = 0;
			$months_in_current_year = '';
		}

		// Add another day, to move forward in the while loop
		$day_count = $day_count->modify('+1 day');
	}
	// Close the final year, and the whole timeline's scale
	$timeline_scale .= '
</div>
';

	// Start the section
	$output =
		'
<section class="large_columns navigate_with_mobile_menu leaderboard" id="timeline" >
	<h2>Chairman Timeline</h2>
	<div class="timeline--container">
		<div class="timeline--content">' . $timeline_scale;

	// Create a track for each host
	foreach ($event_data as $host => $types) {
		$output .=
			'<div class="timeline--host-track host_' .
			strtolower($host) .
			'" style="width: calc(' .
			$full_width .
			' * var(--day-width)); background: rgba(var(--connected-' .
			$host_data[$host]['personal']['color'] .
			'-rgb), 0.1)">';
		// Define host's avatar
		$img_array = [
			'type' => 'avatar',
			'name' => $host_data[$host]['personal']['first_name'],
			'src' => $host_data[$host]['images']['memoji']['neutral'],
			'color' => $host_data[$host]['personal']['color'],
		];

		$output .=
			'<div class="timeline--host-avatar">' .
			list_item_graphic($img_array) .
			'<p>' .
			$host_data[$host]['personal']['first_name'] .
			'</p></div>';
		unset($img_array);

		// Create chairman track for each type of Rickies (annual and keynote)
		foreach ($types as $type => $events) {
			$output .= '<div class="timeline--chairman-track ' . $type . '">';
			foreach ($events as $event) {
				$output .= '<div class="chairman ';
				if (!$event['timeline_end']) {
					$output .= 'open_ended';
				}
				$output .=
					'" style="left: calc(' .
					$event['timeline_start'] .
					' * var(--day-width)); width: calc(' .
					$event['timeline_duration'] .
					' * var(--day-width));"><a href="' .
					$event['url_name'] .
					'" title="' .
					$event['name'] .
					'">' .
					$event['name_short'] .
					'</a></div>';
			}
			$output .= '</div>';
		}
		$output .= '</div>';
	}
	$output .=
		'
		</div>
		<div class="timeline--elements">
			<div class="timeline--gradient-start"></div>
			<div class="timeline--gradient-end"></div>
			<div class="timeline--zoom">
				<button title="Zoom in on timeline" class="clean" id="zoomin_button" onclick="timeline_zoom(\'in\');">' .
		file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-zoomin.svg') .
		'</button>
				<button title="Zoom out on timeline" class="clean" id="zoomout_button" onclick="timeline_zoom(\'out\');">' .
		file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-zoomout.svg') .
		'</button>
			</div>

		</div>
	</div>
	<ul class="timeline--legend">
		<li class="annual">Annual Chairman</li>
		<li class="keynote">Keynote Chairman</li>
	</ul>
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
