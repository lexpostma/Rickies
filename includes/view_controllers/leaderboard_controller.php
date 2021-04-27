<?php

// Host Leaderboard _view_ controller

include "../includes/data_controllers/hosts_data_controller.php";

function leaderboard_item($host_data)
{
	$output = "";
	// Open section and add avatar
	$output .=
		'<div class="section_group--list">
		<div class="item_graphic avatar placeholder" style="animation-delay: ' .
		rand(-50, 0) .
		's;"></div>';
	// Name and personal details
	$output .=
		'<h3 id="' .
		strtolower($host_data["personal"]["first_name"]) .
		'">' .
		$host_data["personal"]["full_name"] .
		"</h3><span>" .
		$host_data["personal"]["location"] .
		' • <a target="_blank" href="' .
		$host_data["personal"]["twitter_url"] .
		'">@' .
		$host_data["personal"]["twitter"] .
		"</a>" .
		' • <a target="_blank" href="' .
		$host_data["personal"]["website_url"] .
		'">' .
		$host_data["personal"]["website_name"] .
		"</a></span>";
	// Title

	$output .= "<h4>Current titles</h4>";
	foreach ($host_data["titles"] as $key => $value) {
		$output .= $key . "<br />";
	}

	// Achievements
	$output .= "<h4>Achievements</h4>";
	foreach ($host_data["achievements"] as $key => $value) {
		$output .= $key . "<br />";
	}

	// Statistics
	$output .= "<h4>Stats</h4>";
	foreach ($host_data["stats"] as $key => $value) {
		$output .= $key . "<br />";
	}

	$output .= "</div>";

	return $output;
}
// echo "<pre>", var_dump($hosts_data), "</pre>";

$avatar_leaderboard_array = [
	[
		"name" => "Stephen",
		"winner" => false,
		"title" => "Document Maintainer",
		"string" => "3 points<br />Flexing 23%",
	],
	[
		"name" => "Myke",
		"winner" => false,
		"title" => "Keynote Chairman",
		"string" => "3 points<br />Flexing 23%",
	],
	[
		"name" => "Federico",
		"winner" => false,
		"title" => "Picker of Passion",
		"string" => "3 points<br />Flexing 23%",
	],
];

$seo_title = "Host Leaderboard • The Rickies";
