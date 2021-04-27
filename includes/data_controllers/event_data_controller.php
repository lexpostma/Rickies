<?php

// Rickies event

$rickies_events_array = [];
$rickies_events_request = $airtable->getContent("Rickies", $rickies_events_params);
do {
	$rickies_events_response = $rickies_events_request->getResponse();

	// echo "<pre>", var_dump($rickies_events_response), "</pre>";

	// Does event exist?
	if (count($rickies_events_response["records"]) > 0) {
		foreach ($rickies_events_response["records"] as $array) {
			$id = json_decode(json_encode($array), true)["id"];
			$fields = json_decode(json_encode($array), true)["fields"];

			// Main details, required for the list overview
			$rickies_events_array[$id] = [
				"name" => check_key("Name", $fields),
				"type" => check_key("Rickies type", $fields),
				"url_name" => check_key("URL", $fields),
				"date" => date_to_string_label(check_key("Predictions episode date", $fields, false, 0)),
				"artwork" => [
					"rickies" => check_key("Rickies artwork", $fields, false, 0),
					"predictions_ep" => check_key("Predictions episode artwork", $fields, false, 0),
					"event" => check_key("Event artwork", $fields, false, 0),
					"results_ep" => check_key("Results episode artwork", $fields, false, 0),
				],
				"winner" => check_key("Ricky winner (manual)", $fields),
			];

			// Assign the correct artwork URLs from array
			foreach ($rickies_events_array[$id]["artwork"] as $source => $artwork) {
				// Set large thumbnail URL as the value of the artwork array
				if ($artwork !== false) {
					$rickies_events_array[$id]["artwork"][$source] = $artwork["thumbnails"]["large"]["url"];
				}

				// Set large thumbnail URL as the value of the main event artwork,
				// but only the first not-false
				if ($artwork !== false && !isset($rickies_events_array[$id]["img_url"]) && $source !== "results_ep") {
					$rickies_events_array[$id]["img_url"] = $artwork["thumbnails"]["large"]["url"];
				}
			}

			if (!$all_event_details) {
				// Only the details needed for the Rickies overview
				$rickies_events_array[$id]["label1"] = $rickies_events_array[$id]["name"];
				unset($rickies_events_array[$id]["name"]);

				$rickies_events_array[$id]["label3"] = $rickies_events_array[$id]["date"];

				$rickies_events_array[$id]["url"] = "/" . $rickies_events_array[$id]["url_name"];
				unset($rickies_events_array[$id]["url_name"]);
			} else {
				// Add more details from Airtable to array, to build the detail page
				include "event_data_details_controller.php";
			}

			// If there's a manual winner, that means that Ricky is officially scored
			if ($rickies_events_array[$id]["winner"] == false) {
				$rickies_events_array[$id]["tag"] = "Unscored";
				$rickies_events_array[$id]["tag_color"] = "orange";
				$rickies_events_array[$id]["tag_banner"] = "These Rickies are not officially scored yet";
			}
		}
	} else {
		// No event (1 or more) found
		header("HTTP/1.0 404 Not Found", true, 404);
		echo "404: Rickies not found :( ";
	}
} while ($rickies_events_request = $rickies_events_response->next());

// echo "<pre>", var_dump($rickies_events_array), "</pre>";
