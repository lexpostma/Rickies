<?php

// Rickies overview
$rickies_events_params = array(
	"filterByFormula" => "AND( Published, Picks )",
	"sort" => array(array('field' => 'Episode date', 'direction' => "desc")),
	// "maxRecords" => 150,
	// "pageSize" => 50,
);
$all_event_details = false;

include("../includes/controllers/rickies/event_data_controller.php");
