<?php

$rickies_events_array[$id]["details"] = [
	// Apple Event data
	"event_title" => "Apple event",
	"event_data" => [
		"url" => check_key("Event URL", $fields, false, 0),
		"img_url" => $rickies_events_array[$id]["artwork"]["event"],
		"label1" => check_key("Event name", $fields),
		"label2" => check_key("Event tagline", $fields, false, 0),
		"label3" => date_to_string_label(check_key("Event date", $fields, false, 0), true),
	],

	// Episode data
	"episode_title" => "Podcast episodes",
	"episode_data_predictions" => [
		"url" => check_key("Predictions episode URL", $fields, false, 0),
		"img_url" => $rickies_events_array[$id]["artwork"]["predictions_ep"],
		"label1" => check_key("Predictions episode title", $fields, false, 0),
		"label2" => check_key("Predictions episode alt title", $fields, false, 0),
		"label3" => date_to_string_label(check_key("Predictions episode date", $fields, false, 0), true),
		"number" => check_key("Predictions episode number", $fields, false, 0),
		"tag" => "Predictions",
		"tag_color" => "purple",
	],
	"episode_data_results" => [
		"url" => check_key("Results episode URL", $fields, false, 0),
		"img_url" => $rickies_events_array[$id]["artwork"]["results_ep"],
		"label1" => check_key("Results episode title", $fields, false, 0),
		"label2" => check_key("Results episode alt title", $fields, false, 0),
		"label3" => date_to_string_label(check_key("Results episode date", $fields, false, 0), true),
		"number" => check_key("Results episode number", $fields, false, 0),
		"tag" => "Results",
		"tag_color" => "blue",
	],

	// More data
	"more_title" => "More",
	"more_data_rules" => [
		"url" => billofrickies_url(),
		"img_url" => "/images/bill-of-rickies-avatar.png",
		"label1" => "The Bill of Rickies",
	],
	"more_data_charity" => [
		"url" => check_key("Charity URL", $fields, false, 0),
		"img_url" => check_key("Charity logo", $fields, false, 0),
		"label1" => check_key("Charity name", $fields, false, 0),
		"label2" => "$125 donated by Stephen",
		"label3" => "Federico’s choice",
	],
];

// Event data
if ($rickies_events_array[$id]["details"]["event_data"]["label1"] == false) {
	// No event linked, clear details from array
	unset($rickies_events_array[$id]["details"]["event_title"]);
	unset($rickies_events_array[$id]["details"]["event_data"]);
} else {
}

// Episode data
$rickies_events_array[$id]["details"]["episode_data_predictions"] = episode_data(
	$rickies_events_array[$id]["details"]["episode_data_predictions"]
);
$rickies_events_array[$id]["details"]["episode_data_results"] = episode_data(
	$rickies_events_array[$id]["details"]["episode_data_results"]
);

if ($rickies_events_array[$id]["details"]["episode_data_results"]["label1"] == false) {
	// No episode, clear details from array
	unset($rickies_events_array[$id]["details"]["episode_data_results"]);
}

// Charity data
if ($rickies_events_array[$id]["details"]["more_data_charity"]["label1"] == false) {
	// No charity, clear details from array
	unset($rickies_events_array[$id]["details"]["more_data_charity"]);
} else {
	// Charity is set, if image is also set, define the right URL
	if ($rickies_events_array[$id]["details"]["more_data_charity"]["img_url"] !== false) {
		$rickies_events_array[$id]["details"]["more_data_charity"]["img_url"] =
			$rickies_events_array[$id]["details"]["more_data_charity"]["img_url"]["thumbnails"]["large"]["url"];
	}
}
