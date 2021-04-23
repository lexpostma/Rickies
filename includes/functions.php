<?php

function url_protocol(){
	return strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';

}

function base_url(){
	return url_protocol().$_SERVER['SERVER_NAME'];
}

function current_url(){
	return base_url().$_SERVER["REQUEST_URI"];
}

function billofrickies_url($goto=true){
	if ($goto) {
		// goto = true
		// You want to go to The Bill of Rickies
		// Therefore we need to add subdomain to the URL
		$urlarray = explode(".", $_SERVER['SERVER_NAME']);
		array_splice($urlarray, -2, 0, "thebillof");
		return url_protocol().implode(".", $urlarray);
	} else {
		// goto = false
		// You want to go back home, away from The Bill of Rickies
		// Therefore we need to remove the subdomain from the URL
		return str_replace("thebillof.","",base_url());
	}
}

// function relative_url($new_language=false){
// 	parse_str($_SERVER["QUERY_STRING"], $query);
// 	if($new_language){
// 		// return same URL, with the language replaced
//
// 		unset($query["lang"]); // delete old language;
// 		$new_query = ""; // build new query
// 		foreach($query as $key => $value) {
// 			$new_query .= "/".$value;
// 		}
//
// 		// return new URL
// 		if($new_language == "nl") {
// 			// nl is default, so not part of URL
// 			return $new_query;
// 		} else {
// 			return "/".$new_language.$new_query;
// 		}
//
// 	} else {
// 		// return a bare URL, with just the language parameter
//
// 		if(check_key("lang", $query, false)){
// 			return "/".$query["lang"];
// 		} else {
// 			return "";
// 		}
// 	}
// }

function check_key($key, $array, $default=false,$sub_array=false){
	if(array_key_exists($key, $array)){
		if($sub_array !== false){
			return $array[$key][$sub_array];
		} else {
			return $array[$key];
		}
	} else {
		return $default;
	}
}

function check_artwork_key($key, $array){
	if(array_key_exists($key, $array)){
		return true;
	} else {
		return false;
	}
}

function markdown($markdown){
	return Parsedown::instance()
		->setBreaksEnabled(true)
		->text( $markdown );
}

function random_from($array){
	return $array[array_rand($array)];
}

// function random_connected_color(){
// 	return random_from(array("green", "yellow", "orange", "red", "purple", "blue"));
// }