<?php

// Rickies event
if ($all_event_details) {
	$required_event_fields = [
		"Name",
		"URL",
		"Winner (manual)",
		"Episode date",
		"Rickies artwork",
		"Event artwork",
		"Episode artwork",
		"Ricky winner",
	];
} else {
	$required_event_fields = [
		"Name",
		"URL",
		"Winner (manual)",
		"Episode date",
		"Rickies artwork",
		"Event artwork",
		"Episode artwork",
	];
}

if (
	isset($rickies_events_params) &&
	!array_key_exists("fields", $rickies_events_params)
) {
	// If parameter variable exists, only add the required fields
	$rickies_events_params["fields"] = $required_event_fields;
} else {
	$rickies_events_params = [
		"fields" => $required_event_fields,
	];
}

$rickies_events_array = [];
$rickies_events_request = $airtable->getContent(
	"Rickies",
	$rickies_events_params
);
do {
	$rickies_events_response = $rickies_events_request->getResponse();

	// Does event exist?
	if (count($rickies_events_response["records"]) > 0) {
		foreach ($rickies_events_response["records"] as $array) {
			$id = json_decode(json_encode($array), true)["id"];
			$fields = json_decode(json_encode($array), true)["fields"];

			$rickies_events_array[$id] = [
				"name" => check_key("Name", $fields),
				"url" => "/" . check_key("URL", $fields),
				"date" => strtotime(
					check_key("Episode date", $fields, false, 0)
				),
				"artwork" => [
					"0" => check_key("Rickies artwork", $fields, false, 0),
					"1" => check_key("Episode artwork", $fields, false, 0),
					"2" => check_key("Event artwork", $fields, false, 0),
				],
				"winner" => check_key("Winner (manual)", $fields),
			];

			// Format the date to a readable string
			$rickies_events_array[$id]["date_string"] = strftime(
				"%e %B %Y",
				$rickies_events_array[$id]["date"]
			);

			if ($all_event_details) {
				// Add more details from Airtable to array, to build the detail page
			} else {
				// Only the details needed for the Rickies overview
				$rickies_events_array[$id]["label1"] =
					$rickies_events_array[$id]["name"];
				$rickies_events_array[$id]["label3"] =
					$rickies_events_array[$id]["date_string"];
			}

			// If there's a manual winner, that means that Ricky is officially scored
			if ($rickies_events_array[$id]["winner"] == false) {
				$rickies_events_array[$id]["tag"] = "Unscored";
				$rickies_events_array[$id]["tag_color"] = "orange";
				$rickies_events_array[$id]["tag_banner"] =
					"These Rickies are not officially scored yet";
			}

			foreach (
				$rickies_events_array[$id]["artwork"]
				as $source => $artwork
			) {
				if (
					$artwork !== false &&
					!isset($rickies_events_array[$id]["img_url"])
				) {
					$rickies_events_array[$id]["img_url"] =
						$artwork["thumbnails"]["large"]["url"];
					break;
				}
			}
		}
	} else {
		// No event (1 or more) found
		echo "404: Rickies not found :( ";
	}
} while ($rickies_events_request = $rickies_events_response->next());

// echo '<pre>' , var_dump($rickies_events_array) , '</pre>';
