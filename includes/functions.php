<?php

$incl_path = $_SERVER['DOCUMENT_ROOT'] . '/../includes/';

// Define Airtable integration
include $incl_path . 'airtable/Airtable.php';
include $incl_path . 'airtable/Request.php';
include $incl_path . 'airtable/Response.php';

use TANIOS\Airtable\Airtable;
$airtable = new Airtable([
	'api_key' => getenv('AIRTABLE_API'),
	'base' => getenv('AIRTABLE_BASE'),
]);

// Include other functions
include_once $incl_path . 'Parsedown.php';
include_once $incl_path . 'variables.php';
include_once $incl_path . 'search_functions.php';
include_once $incl_path . 'chart_functions.php';

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
// Custom is 'false' by default -> so it returns the actual full URL
// If 'true' -> return bare URL
function current_url($custom = false)
{
	if (!$custom) {
		return domain_url() . $_SERVER['REQUEST_URI'];
	} else {
		return domain_url() . '/';
	}
}

function filter_url($query = '')
{
	return current_url(true) . '?search=' . $query . '#results';
}

function navigation_bar($active = false, $triple_j = false)
{
	$output =
		'

<nav class="nav_content multicolor" style="animation-delay: ' .
		rand(-50, 0) .
		's;">
	<div class="nav_content--items">';
	if (!$triple_j) {
		$output .= '
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
		if ($active == 'archive' || $active == '3j-archive') {
			$output .= 'class="active" ';
		}
		$output .= 'href="/archive">Archive';
		if ($active == 'search') {
			$output .= '<span> &#8634;</span>';
		}
		$output .= '</a>
		<a ';
		if ($active == 'about') {
			$output .= 'class="active" ';
		}
		$output .= 'href="/about">About</a>';
	} else {
		$output .= '
		<a ';
		if (!$active) {
			$output .= 'class="active" ';
		}
		$output .= 'href="';
		if (!$active) {
			$output .= '/pickies#list';
		} else {
			$output .= '/pickies';
		}
		$output .= '"><span class="need_space--sm">The </span>Pickies</a>
		<a ';
		if ($active == 'bill') {
			$output .= 'class="active" ';
		}
		$output .= 'href="/charter"><span class="need_space--sm">The </span>Pickies Charter</a>
		<a ';
		if ($active == 'leaderboard') {
			$output .= 'class="active" ';
		}
		$output .= 'href="/3j-leaderboard"><span class="need_space--sm">Triple J </span>Leaderboard<span class="less_space--sm"><sup>3J</sup></span></a>
		<a ';
		if ($active == 'archive' || $active == '3j-archive') {
			$output .= 'class="active" ';
		}
		$output .= 'href="/3j-archive">Archive<sup>3J</sup>';
		if ($active == 'search') {
			$output .= '<span> &#8634;</span>';
		}
		$output .= '</a>
		<a href="';
		switch ($active) {
			case '3j-archive':
			case 'archive':
				$output .= '/archive';
				break;
			case '3j-leaderboard':
			case 'leaderboard':
				$output .= '/leaderboard';
				break;
			default:
				$output .= '/archive';
				break;
		}
		$output .= '" title="Back to the Rickies"><span class="emoji">🏆</span></a>';
	}
	$output .= '
	</div>
</nav>

	';

	return $output;
}

function back_button()
{
	$location = '/';
	$middle = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-back.svg');
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
		'" onclick="open_share_sheet()">' .
		file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-share.svg') .
		'</button>

		<div id="custom_share_sheet" class="">
			<form class="filters" id="share_sheet_form">
				<div id="share_field_combo" class="input_button_combo">
					<input id="share_input" class="clean" type="text" name="text" title="Current URL" placeholder="Current URL" value="' .
		current_url() .
		'" />
					<button class="clean top_button" title="Copy current URL" form="share_sheet_form" type="button" onclick="copyTextToClipboard()">' .
		file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-copy.svg') .
		file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-clipboard.svg') .
		'</button>
				</div>
				<p><span>URL copied to clipboard</span></p>
			</form>
		</div>';
	return $output;
}

function music_button()
{
	$output =
		'<button id="music_button" class="top_button clean" type="button" data-goatcounter-click="Theme music" title="Play theme music for The Bill of Rickies" data-goatcounter-referrer="' .
		current_url() .
		'">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-play.svg');
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-pause.svg');
	$output .= '</button>';

	return $output;
}

function close_button()
{
	$output =
		'<button id="close_button" class="top_button clean" type="button" data-goatcounter-click="Hide history slider" title="Hide the history slider" data-goatcounter-title="Toggle Bill of Rickies slider" data-goatcounter-referrer="' .
		current_url() .
		'">';
	$output .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-close.svg');
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
function random($array, $disallowed_indeces = false)
{
	if ($disallowed_indeces !== false) {
		// Define the initial index
		$index = false;

		// Check if index is allowed to be used
		// If not, draw another random index
		while (in_array($index, $disallowed_indeces)) {
			$index = array_rand($array);
		}

		// Return an array with
		// 0. value of the array on random index
		// 1. and the chosen index
		return [$array[$index], $index];
	} else {
		// Return the value of the array on random index
		return $array[array_rand($array)];
	}
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
