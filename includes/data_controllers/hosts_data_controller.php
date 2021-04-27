<?php

// Host _data_ controller

$hosts_data__params = [
	// "filterByFormula" => "AND( URL = '$url_view' )",
	// "sort" => [["field" => "Order", "direction" => "asc"]],
	// 	"fields" => ["Artwork", "Name", "URL", "Winner (manual)", "Episode date"],
];

$hosts_data__array = [
	// "Rickies" => ["Myke" => [], "Federico" => [], "Stephen" => []],
];
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
				"annual_rickies_wins" => check_key("Annual wins", $fields),
				"keynote_rickies_wins" => check_key("Keynote wins", $fields),
				"flexies_wins" => check_key("Flexy win count", $fields),
				"flexies_lost" => check_key("Flexy loss count", $fields),
			],
			"stats" => [
				"picks" => [
					"regular" => [
						"correct" => check_key("Correct regular count", $fields),
						"unknown" => check_key("Unknown Risky count", $fields),
						"wrong" => check_key("Wrong regular count", $fields),
					],
					"risky" => [
						"correct" => check_key("Correct Risky count", $fields),
						"unknown" => check_key("Unknown Risky count", $fields),
						"wrong" => check_key("Wrong Risky count", $fields),
					],
					"flexy" => [
						"correct" => check_key("Correct Flexy count", $fields),
						"unknown" => check_key("Unknown Flexy count", $fields),
						"wrong" => check_key("Wrong Flexy count", $fields),
					],
				],
				"other" => [
					"total_points" => check_key("Total points", $fields),
					"ricky_win_rate" => check_key("Ricky win rate", $fields),
					"flexy_win_rate" => check_key("Flexy win rate", $fields),
					"flexy_loss_rate" => check_key("Flexy loss rate", $fields),
					"ricky_coin_flips_won" => check_key("Ricky coin flip wins", $fields),
					"flexy_coin_flips_won" => check_key("Flexy coin flip wins", $fields),
					"donations" => check_key("Flexy donations", $fields),
				],
			],
		];
	}
} while ($hosts_data__request = $hosts_data__response->next());

// echo "<pre>", var_dump($hosts_data__array), "</pre>";
