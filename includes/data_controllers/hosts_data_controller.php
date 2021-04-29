<?php

// Host _data_ controller

$hosts_data__params = [
	// "filterByFormula" => "AND( URL = '$url_view' )",
	// "sort" => [["field" => "Order", "direction" => "asc"]],
	// 	"fields" => ["Artwork", "Name", "URL", "Winner (manual)", "Episode date"],
];

$connected_colors = ["green", "yellow", "orange", "red", "purple", "blue"];
$hosts_data__array = [];
$hosts_data__request = $airtable->getContent("Hosts", $hosts_data__params);
do {
	$hosts_data__response = $hosts_data__request->getResponse();
	foreach ($hosts_data__response["records"] as $array) {
		$id = json_decode(json_encode($array), true)["id"];
		$fields = json_decode(json_encode($array), true)["fields"];

		$hosts_data__array[$id] = [
			"personal" => [
				"first_name" => check_key("First name", $fields),
				"full_name" => check_key("Full name", $fields),
				"location" => check_key("Location", $fields),
				"website_url" => check_key("Website URL", $fields),
				"website_name" => check_key("Website name", $fields),
				"twitter" => check_key("Twitter handle", $fields),
				"twitter_url" => check_key("Twitter", $fields),
			],
			"images" => [
				"photo" => airtable_image_url(check_key("Photo", $fields, false, 0)),
				"memoji" => [
					"neutral" => check_key("Memoji neutral", $fields),
					"happy" => check_key("Memoji happy", $fields),
					"sad" => check_key("Memoji sad", $fields),
				],
			],
			"titles" => check_key("Titles HTML", $fields),
			"achievements" => [
				"annual_rickies_wins" => [
					"value" => check_key("Rickies Wins Annual Count", $fields),
					"label" => "time Annual Chairman",
					"0hide" => true,
				],
				"keynote_rickies_wins" => [
					"value" => check_key("Rickies Wins Keynote Count", $fields),
					"label" => "time Keynote Chairman",
					"0hide" => true,
				],
				"rickies_wins" => [
					"value" => check_key("Rickies Wins Total Count", $fields),
					"label" => "time Rickies winner",
					"0hide" => true,
				],

				"flexies_wins" => [
					"value" => check_key("Flexies Wins Total Count", $fields),
					"label" => "time Flexies winner",
					"0hide" => true,
				],
				"flexies_lost" => [
					"value" => check_key("Flexies Donation Count", $fields),
					"label" => "time charity donor",
					"0hide" => true,
				],
			],
			"stats" => [
				"picks" => [
					"Regular" => [
						"Correct" => check_key("Picks Regular Correct Count", $fields, 0),
						"Wrong" => check_key("Picks Regular Wrong Count", $fields, 0),
						"Unknown" => check_key("Picks Regular Unknown Count", $fields, 0),
						"Total" => check_key("Picks Regular Total Count", $fields, 0),
					],
					"Risky" => [
						"Correct" => check_key("Picks Risky Correct Count", $fields, 0),
						"Wrong" => check_key("Picks Risky Wrong Count", $fields, 0),
						"Unknown" => check_key("Picks Risky Unknown Count", $fields, 0),
						"Total" => check_key("Picks Risky Total Count", $fields, 0),
					],
					"Flexy" => [
						"Correct" => check_key("Picks Flexy Correct Count", $fields, 0),
						"Wrong" => check_key("Picks Flexy Wrong Count", $fields, 0),
						"Unknown" => check_key("Picks Flexy Unknown Count", $fields, 0),
						"Total" => check_key("Picks Flexy Total Count", $fields, 0),
					],
				],
				"other" => [
					"scored_points" => [
						"value" => check_key("Points Scored Total", $fields, 0),
						"label" => "Ricky points scored overall",
						"label1" => "Ricky point scored overall",
					],
					"correct_flexies" => [
						"value" => check_key("Picks Flexy Total Count", $fields, 0),
						"label" => "Flexing Points overall",
						"label1" => "Flexing Point overall",
						"unit" => " FP",
					],
					"ricky_win_rate" => [
						"value" => round_if_decimal(check_key("Rickies Wins Rate", $fields, 0) * 100),
						"label" => "Ricky win rate",
						"unit" => "%",
					],
					"flexy_win_rate" => [
						"value" => round_if_decimal(check_key("Flexies Wins Rate", $fields, 0) * 100),
						"label" => "Flexy win rate",
						"unit" => "%",
					],
					"flexy_loss_rate" => [
						"value" => round_if_decimal(check_key("Flexies Lost Rate", $fields, 0) * 100),
						"label" => "Flexy lose rate",
						"unit" => "%",
					],
					"coin_flips_won" => [
						"value" => check_key("Coin Flip Wins Total", $fields),
						"label" => "coin flips won",
						"label1" => "coin flip won",
						"0hide" => true,
					],
					"donations" => [
						"value" => check_key("Flexy Donation Amount", $fields),
						"label" => "donated to charities",
						"unit" => "$",
						"0hide" => true,
					],
				],
			],
		];

		// Calculate the scored/graded picks
		$hosts_data__array[$id]["stats"]["picks"]["Scored"] = [
			"Correct" =>
				$hosts_data__array[$id]["stats"]["picks"]["Regular"]["Correct"] +
				$hosts_data__array[$id]["stats"]["picks"]["Risky"]["Correct"],
			"Wrong" =>
				$hosts_data__array[$id]["stats"]["picks"]["Regular"]["Wrong"] +
				$hosts_data__array[$id]["stats"]["picks"]["Risky"]["Wrong"],

			"Unknown" =>
				$hosts_data__array[$id]["stats"]["picks"]["Regular"]["Unknown"] +
				$hosts_data__array[$id]["stats"]["picks"]["Risky"]["Unknown"],

			"Total" =>
				$hosts_data__array[$id]["stats"]["picks"]["Regular"]["Total"] +
				$hosts_data__array[$id]["stats"]["picks"]["Risky"]["Total"],
		];

		// Calculate the overall pick counts
		$hosts_data__array[$id]["stats"]["picks"]["Overall"] = [
			"Correct" =>
				$hosts_data__array[$id]["stats"]["picks"]["Scored"]["Correct"] +
				$hosts_data__array[$id]["stats"]["picks"]["Flexy"]["Correct"],
			"Wrong" =>
				$hosts_data__array[$id]["stats"]["picks"]["Scored"]["Wrong"] +
				$hosts_data__array[$id]["stats"]["picks"]["Flexy"]["Wrong"],

			"Unknown" =>
				$hosts_data__array[$id]["stats"]["picks"]["Scored"]["Unknown"] +
				$hosts_data__array[$id]["stats"]["picks"]["Flexy"]["Unknown"],

			"Total" =>
				$hosts_data__array[$id]["stats"]["picks"]["Scored"]["Total"] +
				$hosts_data__array[$id]["stats"]["picks"]["Flexy"]["Total"],
		];

		// Calculate the rate of correctness per pick type
		foreach ($hosts_data__array[$id]["stats"]["picks"] as $pick_type => $pick_values) {
			// echo $pick_type;
			$hosts_data__array[$id]["stats"]["picks"][$pick_type]["Rate"] = round_if_decimal(
				($pick_values["Correct"] / ($pick_values["Total"] - $pick_values["Unknown"])) * 100
			);
		}

		foreach ($hosts_data__array[$id]["images"]["memoji"] as $mood => $images) {
			$hosts_data__array[$id]["images"]["memoji"][$mood] = airtable_image_url(random($images));
			// foreach ($images as $key => $array) {
			//
			// }
		}

		$hosts_data__array[$id]["personal"]["color"] = random($connected_colors);
		if (($key = array_search($hosts_data__array[$id]["personal"]["color"], $connected_colors)) !== false) {
			unset($connected_colors[$key]);
		}
	}
} while ($hosts_data__request = $hosts_data__response->next());

// echo "<pre>", var_dump($hosts_data__array), "</pre>";
