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
				"photo" => check_key("Photo", $fields),
				"memoji" => 0,
			],
			"titles" => ["test", "temp"],
			"achievements" => [
				"annual_rickies_wins" => [
					"value" => check_key("Annual wins", $fields),
					"label" => "time Annual Rickies winner",
					"0hide" => true,
				],
				"keynote_rickies_wins" => [
					"value" => check_key("Keynote wins", $fields),
					"label" => "time Keynote Rickies winner",
					"0hide" => true,
				],
				"flexies_wins" => [
					"value" => check_key("Flexy win count", $fields),
					"label" => "time Flexies winner",
					"0hide" => true,
				],
				"flexies_lost" => [
					"value" => check_key("Flexy loss count", $fields),
					"label" => "time Flexies loser",
					"0hide" => true,
				],
			],
			"stats" => [
				"picks" => [
					"Regular" => [
						"Correct" => check_key("Correct regular count", $fields),
						"Wrong" => check_key("Wrong regular count", $fields),
						"Unknown" => check_key("Unknown Risky count", $fields),
					],
					"Risky" => [
						"Correct" => check_key("Correct Risky count", $fields),
						"Wrong" => check_key("Wrong Risky count", $fields),
						"Unknown" => check_key("Unknown Risky count", $fields),
					],
					"Flexy" => [
						"Correct" => check_key("Correct Flexy count", $fields),
						"Wrong" => check_key("Wrong Flexy count", $fields),
						"Unknown" => check_key("Unknown Flexy count", $fields),
					],
				],
				"other" => [
					"scored_points" => [
						"value" => check_key("Total points", $fields),
						"label" => "points scored in total",
					],
					"correct_flexies" => [
						"value" => check_key("Correct Flexy count", $fields),
						"label" => "Flexing Power (correct Flexies)",
						"unit" => "FP",
					],

					"ricky_win_rate" => [
						"value" => check_key("Rickies win rate", $fields),
						"label" => "Ricky win rate",
						"unit" => "%",
					],
					"flexy_win_rate" => [
						"value" => check_key("Flexy win rate", $fields),
						"label" => "Flexy win rate",
						"unit" => "%",
					],
					"flexy_loss_rate" => [
						"value" => check_key("Flexy loss rate", $fields),
						"label" => "Flexy lose rate",
						"unit" => "%",
					],
					"ricky_coin_flips_won" => [
						"value" => check_key("Ricky coin flip wins", $fields),
						"label" => "Ricky coin flips won",
						"0hide" => true,
					],
					"flexy_coin_flips_won" => [
						"value" => check_key("Flexy coin flip wins", $fields),
						"label" => "Flexy coin flips won",
						"0hide" => true,
					],
					"donations" => [
						"value" => check_key("Flexy donations", $fields),
						"label" => "donated to charities",
						"unit" => "$",
						"0hide" => true,
					],
				],
			],
		];

		$hosts_data__array[$id]["personal"]["color"] = random($connected_colors);
		if (($key = array_search($hosts_data__array[$id]["personal"]["color"], $connected_colors)) !== false) {
			unset($connected_colors[$key]);
		}
	}
} while ($hosts_data__request = $hosts_data__response->next());

// echo "<pre>", var_dump($hosts_data__array), "</pre>";
