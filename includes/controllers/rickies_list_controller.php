<?php

// Rickies overview
$rickies_events_params = [
	"fields" => [
		"Name",
		"Rickies type",
		"URL",
		"Ricky winner (manual)",
		"Predictions episode date",
		"Predictions episode artwork",
		"Rickies artwork",
		"Event artwork",
	],
	"filterByFormula" => "AND( Published, Picks )",
	"sort" => [["field" => "Predictions episode date", "direction" => "desc"]],
	// "maxRecords" => 150,
	// "pageSize" => 50,
];
$all_event_details = false;

include "../includes/controllers/event_data_controller.php";
