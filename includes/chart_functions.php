<?php

function define_score_chart_id($host, $type)
{
	return 'chart_' . strtolower($host) . '_' . strtolower($type);
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
				'
				<div class="chart_pick_type">
					<span class="chart_emoji">' .
				$emoji[$pick_type] .
				'</span>
					<div class="chart-container">
						<canvas id="' .
				$chart_id .
				'"></canvas>
					</div>
					<span class="chart_label">' .
				$pick_type .
				'</span>
				</div>';
		}
	}

	$output .= '</div>';
	return $output;
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
					switch ($key) {
						case 'Correct':
							$tooltip = '🟢';
							break;
						case 'Wrong':
							$tooltip = '🔴';
							break;
						case 'Eventually':
							$tooltip = '🔮';
							break;
						default:
							$tooltip = '🟡';
					}
					$labels[$key] = "'" . $tooltip . "'";
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
				'rgba(157, 52, 137,0.7)',
				'rgba(252, 194, 0, 0.7)',
			],
			borderColor: [
				'rgba(68, 153, 52, 0.7)',
				'rgba(229, 31, 46, 0.7)',
				'rgba(157, 52, 137,0.7)',
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
