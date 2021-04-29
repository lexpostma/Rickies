<?php

// Rickies _view_ controller, event details page

$rickies_events_params = [
	"filterByFormula" => "AND( Published, Picks, URL = '$url_view' )",
	"maxRecords" => 1,
	"sort" => [["field" => "Predictions episode date", "direction" => "desc"]],
	// "pageSize" => 50,
];
$all_event_details = true;

include "../includes/data_controllers/event_data_controller.php";
include "../includes/data_controllers/picks_data_controller.php";
$rickies_data = reset($rickies_events_array);

// Define the data for the leaderboard at the top of the page
$leaderboard_data = [];
foreach ($rickies_data["hosts"] as $host) {
	$added_host = [
		"name" => $host["details"]["first_name"],
		"winner" => false,
		"title" => "To be determined",
		"string" =>
			plural_points($host["rickies"]["points"]) .
			"<br />Flexing " .
			round_if_decimal($host["flexies"]["percentage"] * 100) .
			"%",
		"img_array" => [],
	];

	// Define rank and winner in array
	if ($host["rickies"]["ranking"] !== false && $host["rickies"]["ranking"] == 0) {
		$added_host["winner"] = true;
		$added_host["ranking"] = 0;

		// If there's a winner, have a custom sorting order, just like a podium:
		//        1
		//   2  ■■■■■
		// ■■■■■■■■■■  3
		// ■■■■■■■■■■■■■■■
		$leaderboard_order = [1, 0, 2];
	} else {
		$added_host["ranking"] = $host["rickies"]["ranking"];
	}

	// Add to leaderboard array
	array_push($leaderboard_data, $added_host);
}

if (isset($leaderboard_order)) {
	// If the custom order is set, sort the data by ranking
	usort($leaderboard_data, function ($a, $b) use ($leaderboard_order) {
		$pos_a = array_search($a["ranking"], $leaderboard_order);
		$pos_b = array_search($b["ranking"], $leaderboard_order);
		return $pos_a - $pos_b;
	});
}

// echo "<pre>", var_dump($leaderboard_data), "</pre>";

$head_custom = [
	"title" => $rickies_data["name"],
	// TODO: Make Rickies description
	// IDEA: Include scoring banner and Apple Event name
	"description" => "The " . $rickies_data["name"] . ", about Apple and stuff",
	"keywords" => ["wwdc", "risky picks", "flexies", "charity"],
];
