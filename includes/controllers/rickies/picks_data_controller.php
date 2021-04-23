<?php

// Ricky picks

// $picks_data__params = array(
// 	"fields" => ["Artwork", "Name", "URL", "Winner (manual)", "Episode date"],
// );

// $picks_data__array = array();
// $picks_data__request = $airtable->getContent( 'Picks', $picks_data__params);
// do {
// 	$picks_data__response = $picks_data__request->getResponse();
// 	foreach($picks_data__response[ 'records' ] as $array) {
// 		$id = json_decode(json_encode($array), true)["id"];
// 		$fields = json_decode(json_encode($array), true)["fields"];
//
//
// 		$picks_data__array[$id] = array(
// 			"label1"		=> check_key("Name",$fields),
// 			"url"			=> "/".check_key("URL",$fields),
// 			"date" 			=> strtotime(check_key("Episode date",$fields,false,0)),
// 			"artwork"		=> check_key("Artwork",$fields,false,0),
// 			"tag" 			=> check_key("Winner (manual)",$fields),
// 		);
//
// 		// Format the date to a readable string
// 		$picks_data__array[$id]["label3"] = strftime("%e %B %Y", $picks_data__array[$id]["date"]);
//
// 		// If there's a manual winner, that means that Ricky is officially scored
// 		if ($picks_data__array[$id]["tag"] == false) {
// 			$picks_data__array[$id]["tag"] = "Unscored";
// 			$picks_data__array[$id]["tag_color"] = "orange";
// 		} else {
// 			unset($picks_data__array[$id]["tag"]);
// 		}
//
//
// 		if ($picks_data__array[$id]["artwork"] !== false) {
// 			$picks_data__array[$id]["img_url"] = $picks_data__array[$id]["artwork"]["thumbnails"]["large"]["url"];
// 		}
//
// 	}
// }
// while( $picks_data__request = $picks_data__response->next() );
//
// // usort($picks_data__array["rickies"], function($a, $b) {
// // 	return $a['order'] <=> $b['order'];
// // });
//
// usort($picks_data__array, function($a, $b) {
// 	return $a['date'] <=> $b['date'];
// });
//
// echo '<pre>' , var_dump($picks_data__array) , '</pre>';
