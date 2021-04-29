<?php

// Host Leaderboard _view_ controller

include "../includes/data_controllers/hosts_data_controller.php";

function leaderboard_item_bundle($input)
{
	$output = '<section><div class="section_group">';
	$chart_script = "<script>";
	foreach ($input as $host_data) {
		$output .= leaderboard_item($host_data);
		$chart_script .= score_graph_script($host_data["stats"]["picks"], $host_data["personal"]["first_name"]);
	}
	$chart_script .= "</script>";
	$output .= "</div></section>";
	return $output . $chart_script;
}

function leaderboard_item($host_data)
{
	// Open section
	$output = '<div class="section_group--list host_stats">';

	// Add avatar
	$output .=
		'
		<div class="item_graphic avatar" style="background-color: var(--connected-' .
		$host_data["personal"]["color"] .
		');"></div>';

	// Name and personal details
	$output .=
		'<h3 id="' .
		strtolower($host_data["personal"]["first_name"]) .
		'">' .
		$host_data["personal"]["full_name"] .
		"</h3><p>" .
		$host_data["personal"]["location"] .
		' • <a target="_blank" href="' .
		$host_data["personal"]["twitter_url"] .
		'">@' .
		$host_data["personal"]["twitter"] .
		"</a>" .
		' • <a target="_blank" href="' .
		$host_data["personal"]["website_url"] .
		'">' .
		$host_data["personal"]["website_name"] .
		"</a></p>";

	// Title
	$output .= "<h4>Current titles</h4>";
	foreach ($host_data["titles"] as $key => $value) {
		$output .= $value . "<br />";
	}

	// Achievements
	$output .= "<h4>Achievements</h4>";
	$output .= score_label_item($host_data["achievements"], $host_data["personal"]["color"]);

	// Statistics
	$output .= "<h4>Stats</h4>";
	$output .= score_graph_item($host_data["stats"]["picks"], strtolower($host_data["personal"]["first_name"]));
	$output .= score_label_item($host_data["stats"]["other"], $host_data["personal"]["color"]);

	$output .= "</div>";

	return $output;
}
// echo "<pre>", var_dump($hosts_data), "</pre>";

function score_label_item($array, $color)
{
	$output = "<table class='full_stats'>";
	foreach ($array as $stat) {
		if ($stat["value"] !== false && !($stat["value"] == 0 && array_key_exists("0hide", $stat))) {
			if (array_key_exists("unit", $stat)) {
				if ($stat["unit"] == "%") {
					$stat["value"] = $stat["value"] * 100 . "%";
				} elseif ($stat["unit"] == '$') {
					$stat["value"] = '$' . $stat["value"];
				} else {
					$stat["value"] = $stat["value"] . $stat["unit"];
				}
			}
			$output .=
				"<tr>
				<td class='value' style='color: var(--connected-$color);'>" .
				$stat["value"] .
				"</td>
				<td>" .
				$stat["label"] .
				"</td>
				</tr>";
		}
	}
	$output .= "</table>";
	return $output;
}
function define_score_graph_id($host, $type)
{
	return "chart_" . strtolower($host) . "_" . strtolower($type);
}
function score_graph_script($chart_array, $host)
{
	$chart_script = "";
	foreach ($chart_array as $pick_type => $graph) {
		$chart_id = define_score_graph_id($host, $pick_type);
		$chart_var = $chart_id;

		// Add a ChartJS chart data
		$labels = [];
		$data = [];
		foreach ($graph as $key => $value) {
			$labels[$key] = "'" . $key . "'";
			$data[$key] = $value;
			// $output .= $value . ": " . $key . "<br />";
		}

		$chart_script .=
			"
var $chart_var = document.getElementById('$chart_id');
var $chart_id = new Chart($chart_var, {
	type: 'doughnut',
	data: {
		labels: [" .
			implode(",", $labels) .
			"],
		datasets: [{
			data: [" .
			implode(",", $data) .
			"],
			backgroundColor: [
				'#449934',
				'#E51F2E',
				'#FCC200',
			],
			borderColor: [
				'rgba(0, 0, 0, 0.1)',
				'rgba(0, 0, 0, 0.1)',
				'rgba(0, 0, 0, 0.1)',
			],
			borderWidth: 1
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
	return $chart_script;
}
function score_graph_item($chart_array, $host)
{
	$output = '<div class="charts">';
	$emoji = [
		"Regular" => "🎯",
		"Risky" => "⚠️",
		"Flexy" => "💪",
	];
	// $chart_script = "<script>";
	foreach ($chart_array as $pick_type => $graph) {
		$chart_id = define_score_graph_id($host, $pick_type);
		// Add a ChartJS chart canvas
		$output .=
			'<div class="chart_pick_type"><div class="chart-container"><canvas id="' . $chart_id . '"></canvas></div>';
		$output .= '<span class="chart_emoji">' . $emoji[$pick_type] . "</span>";
		$output .= '<span class="chart_label">' . $pick_type . "</span></div>";
	}

	$output .= "</div>";
	return $output;
}

$avatar_leaderboard_array = [
	[
		"name" => "Stephen",
		"winner" => false,
		"title" => "Document Maintainer",
		"string" => "3 points<br />Flexing 23%",
	],
	[
		"name" => "Myke",
		"winner" => false,
		"title" => "Keynote Chairman",
		"string" => "3 points<br />Flexing 23%",
	],
	[
		"name" => "Federico",
		"winner" => false,
		"title" => "Picker of Passion",
		"string" => "3 points<br />Flexing 23%",
	],
];

$head_custom = [
	"title" => "Host Leaderboard • The Rickies",
	// TODO: Write SEO description
	"description" => "",
];
