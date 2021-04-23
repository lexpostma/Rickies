<?php

// Rickies event details view
$rickies_events_params = array(
	"filterByFormula" => "AND( Published, Picks )",
	"maxRecords" => 1,
	"sort" => array(array('field' => 'Episode date', 'direction' => "desc")),
	// "pageSize" => 50,
);
$all_event_details = true;

include("../includes/controllers/rickies/event_data_controller.php");
include("../includes/controllers/rickies/picks_data_controller.php");
