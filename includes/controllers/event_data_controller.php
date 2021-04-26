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
				"url_name" => check_key("URL", $fields),
				"date" => date_to_string_label(check_key("Predictions episode date", $fields, false, 0)),
				"artwork" => [
					"rickies" => check_key("Rickies artwork", $fields, false, 0),
					"predictions_ep" => check_key("Predictions episode artwork", $fields, false, 0),
					"event" => check_key("Event artwork", $fields, false, 0),
					"results_ep" => check_key("Results episode artwork", $fields, false, 0),
				],
				"winner" => check_key("Winner (manual)", $fields),
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
						"label3" => date_to_string_label(
							check_key("Predictions episode date", $fields, false, 0),
							true
						),
						"number" => check_key("Predictions episode number", $fields, false, 0),
						"tag" => "Prediction",
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
							$rickies_events_array[$id]["details"]["more_data_charity"]["img_url"]["thumbnails"][
								"large"
							]["url"];
					}
				}
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
