<?php

// Rickies overview
$rickies_events_params = [
	"filterByFormula" => "AND( Published, Picks )",
	"sort" => [["field" => "Episode date", "direction" => "desc"]],
	// "maxRecords" => 150,
	// "pageSize" => 50,
];
$all_event_details = false;

include "../includes/controllers/event_data_controller.php";
