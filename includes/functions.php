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
function current_url($filter = false)
{
	if ($filter) {
		return domain_url() . '/';
	} else {
		return domain_url() . $_SERVER['REQUEST_URI'];
	}
}

function navigation_bar($active = false)
{
	$output =
		'

<nav id="nav_content" class="home" style="animation-delay: ' .
		rand(-50, 0) .
		's;">
	<div class="nav_content--items">
		<a ';
	if (!$active) {
		$output .= 'class="active" ';
	}
	$output .= 'href="';
	if (!$active) {
		$output .= '#list';
	} else {
		$output .= '/';
	}
	$output .= '"><span class="need_space--sm">The </span>Rickies</a>
		<a ';
	if ($active == 'bill') {
		$output .= 'class="active" ';
	}
	$output .= 'href="/billof"><span class="need_space--sm">The </span>Bill of Rickies</a>
		<a ';
	if ($active == 'leaderboard') {
		$output .= 'class="active" ';
	}
	$output .= 'href="/leaderboard"><span class="need_space--sm">Host </span>Leaderboard</a>
		<a ';
	if ($active == 'archive') {
		$output .= 'class="active" ';
	}
	$output .= 'href="/archive">Archive</a>
		<a ';
	if ($active == 'about') {
		$output .= 'class="active" ';
	}
	$output .= 'href="/about">About</a>
	</div>
</nav>

	';

	return $output;
}

function back_button()
{
	$location = '/';
	$middle = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-back.svg');
	$link =
		'<a href="' .
		$location .
		'" title="Go back to Rickies overview" class="back_button top_button">' .
		$middle .
		'</a>';

	if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'rickies.co/') !== false) {
		// Referrer is this website, so back should go back in history to referrer
		$button =
			'<button onclick="window.history.go(-1); return false;" title="Go back to previous page" class="back_button clean top_button">' .
			$middle .
			'</button>';
		$button .= '<noscript>' . $link . '</noscript>';
		return $button;
	} else {
		// Referrer is another website, so back should go to Rickies homepage
		return $link;
	}
}

function share_button()
{
	$output =
		'<button id="share_button" class="top_button clean" type="button" data-goatcounter-click="Open share sheet" title="Share this page" data-goatcounter-referrer="' .
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

function close_button()
{
	$output =
		'<button id="close_button" class="top_button clean" type="button" data-goatcounter-click="Hide history slider" title="Hide the history slider" data-goatcounter-title="Toggle Bill of Rickies slider" data-goatcounter-referrer="' .
		current_url() .
		'">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-close.svg');
	$output .= '</button>';

	return $output;
}

function search_button()
{
	$output = search_field(false, true);
	$output .= '<button id="search_button" class="top_button clean" type="button" onclick="toggle_search()">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-search.svg');
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-close2.svg');
	$output .= '</button>';

	// NOTE: Remember to add the search.js script to the footer separately
	return $output;
}

function search_field($query = false, $fixed = false)
{
	$output = '';
	if ($fixed) {
		$output .= '<div id="fixed_search" class="">';
	}

	$output .= '
	<form method="get" action="/" class="filters" id="search_form">
		<div id="inline_search">
			<input id="search_input" class="clean" type="text" name="search" placeholder="Search for predictions" ';
	if ($query) {
		$output .= ' value="' . $query . '" ';
	}
	$output .= '/>
			<button class="clean top_button" title="Search" form="search_form" type="submit">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-search.svg');
	$output .= '</button>
		</div>
	</form>';

	if ($fixed) {
		$output .= '</div>';
	}

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
function date_to_string_label($date, $context = false, $date_needs_conversion = true, $html_time = false)
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
		$date_output = 'today';
	} elseif ($difference == -1) {
		// Yesterday
		$air_string = 'Aired ';
		$on = '';
		$date_output = 'yesterday';
	} elseif ($difference == 1) {
		// Tomorrow
		$air_string = 'Airs ';
		$on = '';
		$date_output = 'tomorrow';
	} elseif ($difference > 1) {
		// Future after tomorrow
		$on = 'on ';
		$air_string = 'Airs ' . $on;
		$date_output = strftime(date_string_format(), $date);
	} else {
		// Past before yesterday
		$on = 'on ';
		$air_string = 'Aired ' . $on;
		$date_output = strftime(date_string_format(), $date);
	}

	if ($html_time) {
		$output = '<time datetime="' . strftime('%Y-%m-%d', $date) . '">';
	} else {
		$output = '';
	}

	if ($context === 'air') {
		$output = $air_string . $output . $date_output;
	} elseif ($context) {
		$output = $on . $output . $date_output;
	} else {
		$output .= ucfirst($date_output);
	}

	if ($html_time) {
		$output .= '</time>';
	}

	return $output;
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

function digit_placement($digit)
{
	$text = [
		1 => '1st',
		2 => '2nd',
		3 => '3rd',
	];

	if (array_key_exists($digit, $text)) {
		return $text[$digit];
	} else {
		return $digit . 'th';
	}
}
