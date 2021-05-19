<?php

$incl_path = $_SERVER['DOCUMENT_ROOT'] . '/../includes/';
include_once $incl_path . 'Parsedown.php';
include_once $incl_path . 'variables.php';

// Is the current URL accessed via http or https?
function url_protocol()
{
	return strtolower(substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/'))) . '://';
}

// https://example.com
function domain_url()
{
	$url = url_protocol() . $_SERVER['SERVER_NAME'];
	$url = str_replace('www.', '', $url);
	$url = str_replace('thebillof.', '', $url);

	return $url;
}

// https://example.com/something
function current_url()
{
	return domain_url() . $_SERVER['REQUEST_URI'];
}

function back_button($location = '/')
{
	$output = '<a id="back_button" title="Go back to Rickies overview" class="top_button" href="' . $location . '">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-back.svg');
	$output .= '</a>';

	return $output;
}

function share_button()
{
	$output =
		'<button id="share_button" class="top_button clean offer_sheet" type="button" data-goatcounter-click="Open share sheet" title="Share this page" data-goatcounter-referrer="' .
		current_url() .
		'" onclick="open_share_sheet()">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-share.svg');
	$output .= '</button>';

	return $output;
}

function music_button()
{
	$output =
		'<button id="music_button" class="top_button clean" type="button" data-goatcounter-click="Theme music" title="Play theme music for The Bill of Rickies" data-goatcounter-referrer="' .
		current_url() .
		'">';
	$output .=
		'<div class="play">' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-play.svg') . '</div>';
	$output .=
		'<div class="pause">' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-pause.svg') . '</div>';
	$output .= '</button>';

	return $output;
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
	return str_replace('.0', '', (string) number_format($value, 1, '.', ''));
}

function plural_points($value)
{
	if ($value == 1 || $value == -1) {
		return $value . '&nbsp;point';
	} else {
		return $value . '&nbsp;points';
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

function banner($string, $color = 'orange')
{
	$output = '<div class="banner';
	if ($color == 'yellow') {
		$output .= ' contrast ';
	}

	$output .= '" style="background-color: var(--connected-' . $color . ');"><p>' . $string . '</p></div>';
	return $output;
}

function no_script_banner($string = false)
{
	$color = 'red';
	$output = '<noscript>';
	if ($string) {
		$output .= banner($string, $color);
	} else {
		$output .= banner('This page works better with Javascript enabled', $color);
	}
	$output .= '</noscript>';
	return $output;
}

// Format the date to a readable string
// Via https://stackoverflow.com/a/25623057
function date_string_format()
{
	return '%B %e, %Y';
}
function date_to_string_label($date, $context = false, $date_needs_conversion = true)
{
	$current = strtotime(date('Y-m-d'));

	// Is date still a string that needs to be converted?
	// Default = true, false means no conversion
	if ($date_needs_conversion) {
		$date = strtotime($date);
	}

	$datediff = $date - $current;

	// Get the difference in days (diff in seconds / (60s * 60m * 24h))
	$difference = floor($datediff / (60 * 60 * 24));

	if ($difference == 0) {
		// Today
		$air_string = 'Airs ';
		$on = '';
		$output = 'today';
	} elseif ($difference == -1) {
		// Yesterday
		$air_string = 'Aired ';
		$on = '';
		$output = 'yesterday';
	} elseif ($difference == 1) {
		// Tomorrow
		$air_string = 'Airs ';
		$on = '';
		$output = 'tomorrow';
	} elseif ($difference > 1) {
		// Future after tomorrow
		$on = 'on ';
		$air_string = 'Airs ' . $on;
		$output = strftime(date_string_format(), $date);
	} else {
		// Past before yesterday
		$on = 'on ';
		$air_string = 'Aired ' . $on;
		$output = strftime(date_string_format(), $date);
	}

	if ($context === 'air') {
		return $air_string . $output;
	} elseif ($context) {
		return $on . $output;
	} else {
		return ucfirst($output);
	}
}

// Assign the correct artwork URLs from array
// Set large thumbnail URL as the value of the artwork array
function airtable_image_url($input)
{
	// Sizes from Airtable are
	// [ full | large | small ]
	// [  ??  |  512  |  36   ]
	if (is_array($input)) {
		return $input['thumbnails']['full']['url'];
	} elseif ($input == false) {
		return false;
	} else {
		return $input;
	}
}

function goat_referral($input)
{
	return str_replace('<a ', '<a data-goatcounter-referrer="' . current_url() . '" ', $input);
}

function chairman_url($event_type)
{
	$twitter = 'https://twitter.com/' . $event_type . 'chairman';
	$label = ucfirst($event_type) . ' Chairman';

	$chairman_link =
		'<a
		class="nowrap"
		target="_blank"
		href="' .
		$twitter .
		'"
		data-goatcounter-click="' .
		$twitter .
		'"
		title="' .
		$label .
		'"
		data-goatcounter-referrer="' .
		current_url() .
		'" >' .
		$label .
		'</a>';

	return $chairman_link;
}

function digit_text($digit)
{
	$text = [
		1 => 'one',
		2 => 'two',
		3 => 'three',
		4 => 'four',
		5 => 'five',
		6 => 'six',
		7 => 'seven',
		8 => 'eight',
		9 => 'nine',
		10 => 'ten',
		11 => 'eleven',
		12 => 'twelve',
		13 => 'thirteen',
		14 => 'fourteen',
		15 => 'fifteen',
	];

	if (array_key_exists($digit, $text)) {
		return $text[$digit];
	} else {
		return $digit;
	}
}
