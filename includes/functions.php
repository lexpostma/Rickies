<?php

	// function base_url(){
	// 	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
	// 	return $protocol.$_SERVER['SERVER_NAME'];
	// }
	
	// function current_url(){
	// 	return base_url().$_SERVER["REQUEST_URI"];
	// }
	
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

	// function fancy_implode($arr){
	// 	global $locale;
	// 	array_push($arr, implode($locale["paintings"]["and"], array_splice($arr, -2)));
	// 	return implode(', ', $arr);
	// }
	
	// function check_key($key, $array, $default="",$sub_array=false){
	// 	if(array_key_exists($key, $array)){
	// 		if($sub_array !== false){
	// 			return $array[$key][$sub_array];
	// 		} else {
	// 			return $array[$key];
	// 		}
	// 	} else {
	// 		return $default;
	// 	}
	// }
	
	// function markdown($markdown){
	// 	return Parsedown::instance()
	// 		->setBreaksEnabled(true)
	// 		->text( $markdown );
	// }
	
	// $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
	// 						'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
	// 						'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
	// 						'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
	// 						'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

?>