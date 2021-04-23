<?php

// The Bill of Rickies

$rules_array = array();
$rules_params = array(
	"fields" => ["Rule styled", "Start date", "End date", "Order", "id", "Rule type"],
);
$rules_request = $airtable->getContent( 'Rules', $rules_params);
do {
	$rules_response = $rules_request->getResponse();
	foreach($rules_response[ 'records' ] as $array) {
		// $id = json_decode(json_encode($array), true)["id"];
		$fields = json_decode(json_encode($array), true)["fields"];

		if (check_key("Rule type",$fields) == "Rickies") {
			$rules_array["rickies"][] = array(
				"id"			=> check_key("id",$fields),
				"rule"			=> markdown(check_key("Rule styled",$fields)),
				"date_start" 	=> strtotime(check_key("Start date",$fields)),
				"date_end" 		=> strtotime(check_key("End date",$fields)),
				"order" 		=> check_key("Order",$fields),
			);
		} else {
			$rules_array["flexies"][] = array(
				"id"			=> check_key("id",$fields),
				"rule"			=> markdown(check_key("Rule styled",$fields)),
				"date_start" 	=> strtotime(check_key("Start date",$fields)),
				"date_end" 		=> strtotime(check_key("End date",$fields)),
				"order" 		=> check_key("Order",$fields),
			);
		}
	}
}
while( $rules_request = $rules_response->next() );

usort($rules_array["rickies"], function($a, $b) {
	return $a['order'] <=> $b['order'];
});

usort($rules_array["flexies"], function($a, $b) {
	return $a['order'] <=> $b['order'];
});

// echo '<pre>' , var_dump($rules_array) , '</pre>';

$include_body = "../includes/views/billofrickies.php";