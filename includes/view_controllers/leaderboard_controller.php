<?php

// Host Leaderboard _view_ controller

$hosts_data__params = [];
$all_host_details = true;

include '../includes/data_controllers/hosts_data_controller.php';
include '../includes/data_controllers/status_data_controller.php';

function leaderboard_item_bundle($input)
{
	$output = '<section class="large_columns"><div class="section_group">';
	$chart_script = '<script>';
	foreach ($input as $host_data) {
		$output .= leaderboard_item($host_data);
		$chart_script .= score_chart_script($host_data['stats']['picks'], $host_data['personal']['first_name']);
	}
	$chart_script .= '</script>';
	$output .= '</div></section>';
	return $output . $chart_script;
}

function leaderboard_item($host_data)
{
	// Open section
	$output = '<div class="section_group--list host_stats">';

	// Add avatar
	$img_array = [
		'type' => 'avatar',
		'src' => $host_data['images']['memoji']['neutral'],
		'color' => $host_data['personal']['color'],
	];
	$output .= list_item_graphic($img_array, true);

	// Name and personal details
	$output .=
		'<div class="host_item_content">
		<h3 id="' .
		strtolower($host_data['personal']['first_name']) .
		'">' .
		$host_data['personal']['full_name'] .
		'</h3><p>' .
		$host_data['personal']['location'] .
		' • <a target="_blank" href="' .
		$host_data['personal']['twitter_url'] .
		'"
		data-goatcounter-click="' .
		$host_data['personal']['twitter_url'] .
		'"
		title="Go to @' .
		$host_data['personal']['twitter'] .
		'"
		data-goatcounter-referrer="' .
		current_url() .
		'">@' .
		$host_data['personal']['twitter'] .
		'</a>' .
		' • <a target="_blank" class="nowrap" href="' .
		$host_data['personal']['website_url'] .
		'"
		data-goatcounter-click="' .
		$host_data['personal']['website_url'] .
		'"
		title="Visit ' .
		$host_data['personal']['website_name'] .
		'"
		data-goatcounter-referrer="' .
		current_url() .
		'">' .
		$host_data['personal']['website_name'] .
		'</a></p>';

	// Title
	$output .= '<h4>Current titles</h4><ul>';
	$output .= '<li>' . $host_data['titles'][0] . '</li><li>' . $host_data['titles'][1] . '</li>';
	unset($host_data['titles'][0]);
	unset($host_data['titles'][1]);
	$output .= '<li>' . random($host_data['titles']) . '</li>';
	// foreach ($host_data['titles'] as $key => $value) {
	// $output .= '<li>' . $value . '</li>';
	// }
	$output .= '</ul>';

	// Achievements
	$output .= '<h4>Achievements</h4>';
	$output .= score_label_item($host_data['achievements'], $host_data['personal']['color']);

	// Statistics
	$output .= '<h4>Stats</h4>';
	$output .= score_chart_item($host_data['stats']['picks'], strtolower($host_data['personal']['first_name']));
	$output .= score_label_item($host_data['stats']['other'], $host_data['personal']['color']);

	// Close host and content
	$output .= '</div></div>';

	return $output;
}
// echo "<pre>", var_dump($hosts_data), "</pre>";

function score_label_item($array, $color)
{
	$output = "<table class='full_stats'>";
	foreach ($array as $stat) {
		if ($stat['value'] !== false && !($stat['value'] == 0 && array_key_exists('0hide', $stat))) {
			if ($stat['value'] == 1 && array_key_exists('label1', $stat)) {
				$stat['label'] = $stat['label1'];
			}
			if (array_key_exists('unit', $stat)) {
				if ($stat['unit'] == '%') {
					$stat['value'] = $stat['value'] . '%';
				} elseif ($stat['unit'] == '$') {
					$stat['value'] = '$' . $stat['value'];
				} else {
					$stat['value'] = $stat['value'] . $stat['unit'];
				}
			}
			$output .=
				"<tr>
				<td class='value' style='color: var(--connected-$color);'>" .
				$stat['value'] .
				"</td>
				<td>" .
				$stat['label'] .
				"</td>
				</tr>";
		}
	}
	$output .= '</table>';
	return $output;
}

function define_score_chart_id($host, $type)
{
	return 'chart_' . strtolower($host) . '_' . strtolower($type);
}

// Define score chart script
function score_chart_script($chart_array, $host)
{
	$chart_script = '';
	foreach ($chart_array as $pick_type => $chart) {
		if ($pick_type !== 'Scored' && $pick_type !== 'Overall') {
			$chart_id = define_score_chart_id($host, $pick_type);
			$chart_el = $chart_id . '_el';
			$chart_var = $chart_id . '_var';

			// Add a ChartJS chart data
			$labels = [];
			$data = [];
			foreach ($chart as $key => $value) {
				if ($key !== 'Total' && $key !== 'Rate') {
					$labels[$key] = "'" . $key . "'";
					$data[$key] = $value;
				}
			}

			$chart_script .=
				"
var $chart_el = document.getElementById('$chart_id');
var $chart_var = new Chart($chart_el, {
	type: 'doughnut',
	data: {
		labels: [" .
				implode(',', $labels) .
				"],
		datasets: [{
			data: [" .
				implode(',', $data) .
				"],
			backgroundColor: [
				'rgba(68, 153, 52, 0.7)',
				'rgba(229, 31, 46, 0.7)',
				'rgba(252, 194, 0, 0.7)',
			],
			borderColor: [
				'rgba(68, 153, 52, 0.7)',
				'rgba(229, 31, 46, 0.7)',
				'rgba(252, 194, 0, 0.7)',
			],
			borderWidth: 1,
			borderAlign: 'inner',
		}]
	},
	options: {
		cutout: '66.7%',
		plugins: {
			tooltip: {
				displayColors: false
			},
			legend: {
				display: false
			}
		}
	}
});";
		}
	}
	return $chart_script;
}

// Define score charts
function score_chart_item($chart_array, $host)
{
	$output = '<div class="charts">';
	$emoji = [
		'Regular' => '🎯',
		'Risky' => '⚠️',
		'Flexy' => '💪',
	];

	foreach ($chart_array as $pick_type => $chart) {
		if ($pick_type !== 'Scored' && $pick_type !== 'Overall') {
			$chart_id = define_score_chart_id($host, $pick_type);
			// Add a ChartJS chart canvas
			$output .=
				'<div class="chart_pick_type"><div class="chart-container"><canvas id="' .
				$chart_id .
				'"></canvas></div>';
			$output .= '<span class="chart_emoji">' . $emoji[$pick_type] . '</span>';
			$output .= '<span class="chart_label">' . $pick_type . '</span></div>';
		}
	}

	$output .= '</div>';
	return $output;
}

// Define the data for the leaderboard at the top of the page
$leaderboard_data = [];
foreach ($hosts_data__array as $host) {
	$set = [
		'name' => $host['personal']['first_name'],
		'winner' => false,
		'title' => $host['titles'][0] . '<br />' . $host['titles'][1],
		'string' =>
			'Won ' .
			$host['achievements']['rickies_wins']['value'] .
			" Rickies<br />
		" .
			$host['stats']['picks']['Overall']['Rate'] .
			"% correct picks<br />
		" .
			$host['stats']['other']['scored_points']['value'] .
			'&nbsp;points • ' .
			$host['stats']['other']['correct_flexies']['value'] .
			'&nbsp;FP',
		'img_array' => [
			'type' => 'avatar',
			'src' => $host['images']['memoji']['happy'],
			'color' => $host['personal']['color'],
		],
	];
	array_push($leaderboard_data, $set);
}

// TODO: Rickies count as variable in the text
$introduction =
	'<p>With <b>' .
	$status_data__array['Completed'] .
	' graded</b> Rickies officially behind us, this is the leaderboard of overall wins, picks, and flexing power <span title="Pokémon 😉">(FP)</span> of the hosts of Connected.</p><p>The predictions charts and statistics also include picks from <b class="nowrap">' .
	digit_text($status_data__array['Ungraded']) .
	' ungraded</b> Rickies, and picks from ' .
	digit_text($status_data__array['Pre-Rickies']) .
	' earlier prediction episodes that predate the (<a href="/billof/keynote-sep-2018" title="The Bill of Rickies">Bill of</a>) Rickies as partial points had been awarded.</p>';

$head_custom = [
	'title' => 'Host Leaderboard • The Rickies',
	// TODO: Write SEO description
	'description' =>
		'Charts, statistics, flexing power and other wonderful insights into the Rickies achievements of the Connected hosts.',
	'keywords' => ['leaderboard', 'achievement', 'statistics', 'titles'],
];
