<?php

// Rickies event details view
$rickies_events_params = [
	"filterByFormula" => "AND( Published, Picks )",
	"maxRecords" => 1,
	"sort" => [["field" => "Episode date", "direction" => "desc"]],
	// "pageSize" => 50,
];
$all_event_details = true;

include "../includes/controllers/event_data_controller.php";
include "../includes/controllers/picks_data_controller.php";
