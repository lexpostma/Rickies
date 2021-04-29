<?php

// Is the current URL accessed via http or https?
function url_protocol()
{
	return strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, strpos($_SERVER["SERVER_PROTOCOL"], "/"))) . "://";
}

// https://example.com
function base_url()
{
	return url_protocol() . $_SERVER["SERVER_NAME"];
}

// https://example.com/something
function current_url()
{
	return base_url() . $_SERVER["REQUEST_URI"];
}

function back_button($location = "/")
{
	$output = "<a id='back_button' href='$location'>";
	$output .= file_get_contents("../public_html/images/back-button.svg");
	// $output .= include "../public_html/images/back-button.svg";
	$output .= "</a>";

	return $output;
}

function billofrickies_url($goto = true)
{
	if ($goto) {
		// goto = true
		// You want to go to The Bill of Rickies
		// Therefore we need to add subdomain to the URL
		$urlarray = explode(".", $_SERVER["SERVER_NAME"]);
		array_splice($urlarray, -2, 0, "thebillof");
		return url_protocol() . implode(".", $urlarray);
	} else {
		// goto = false
		// You want to go back home, away from The Bill of Rickies
		// Therefore we need to remove the subdomain from the URL
		return str_replace("thebillof.", "", base_url());
	}
}

// Does the key exists in the array or subarray,
// and what to return if it is or it not?
function check_key($key, $array, $default = false, $sub_array = false)
{
	if (array_key_exists($key, $array)) {
		// Key exists
		if ($sub_array !== false) {
			// Sub array is requested
			return $array[$key][$sub_array];
		} else {
			// Return the value of the existing key
			return $array[$key];
		}
	} else {
		// Return the default value because the key does not exist
		return $default;
	}
}

function markdown($markdown)
{
	return Parsedown::instance()
		->setBreaksEnabled(true)
		->text($markdown);
}

// Return random value from an array
function random($array)
{
	return $array[array_rand($array)];
}

// Round the percentage to 1 decimal if it has decimals
// Otherwise, don't show decimals at all
// Via https://stackoverflow.com/q/4113200
function round_if_decimal($value)
{
	return str_replace(".0", "", (string) number_format($value, 1, ".", ""));
}

function plural_points($value)
{
	if ($value == 1 || $value == -1) {
		return $value . " point";
	} else {
		return $value . " points";
	}
}

// Replace last occurence of a string in a string
// Via https://stackoverflow.com/a/3835653
function str_lreplace($search, $replace, $subject)
{
	$pos = strrpos($subject, $search);

	if ($pos !== false) {
		$subject = substr_replace($subject, $replace, $pos, strlen($search));
	}

	return $subject;
}
