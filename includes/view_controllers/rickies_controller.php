<?php

$include_body = "../includes/views/main.php";

switch ($url_view) {
	case "main":
		// No query is defined, so the main overview is shown
		include "../includes/view_controllers/rickies_list_controller.php";
		$include_subbody = "../includes/views/rickies.php";
		break;
	case "leaderboard":
		// Leaderboard query
		include "../includes/view_controllers/leaderboard_controller.php";
		$include_subbody = "../includes/views/leaderboard.php";
		$back_to_overview = true;
		break;
	default:
		// If non of the above, it's probably a Rickies event
		include "../includes/view_controllers/rickies_detail_controller.php";
		$include_subbody = "../includes/views/event.php";
		$back_to_overview = true;
}

/* Function to create a list_item component.
Example data:
$data = array(
	"url"		=> "/event",
	"img_url"	=> "/images/bill-of-rickies-avatar.png",
	"label1"	=> "Keynote Rickies, April 2020",
	"label2"	=> "Alt Title for Funsies",
	"label3"	=> "25 April 2020",
	"tag"		=> "Scored",
	"tag_color"	=> "green",
);
foreach (range(1, 10) as $i) {
	echo list_item($data);
};
*/
function list_item($data)
{
	// Is the list item clickable, yes/no?
	$output = "";
	if (isset($data["url"]) && $data["url"] !== false) {
		$output .= '<li class="list_item"><a class="list_item_content" href="' . $data["url"] . '">';
	} else {
		$output .= '<li class="list_item"><div class="list_item_content">';
	}

	// Is there an image, yes/no?
	if (isset($data["img_url"]) && $data["img_url"] !== false) {
		$output .= '<div class="item_graphic image" style="background-image: url(' . $data["img_url"] . ')"></div>';
	} else {
		$output .= '<div class="item_graphic placeholder" style="animation-delay: -' . rand(0, 50) . 's;"></div>';
	}

	$output .= '<div class="list_item_labels"><span class="label1">' . $data["label1"] . "</span>";

	// Is there an 2nd label, yes/no?
	if (isset($data["label2"])) {
		$output .= '<span class="label2">' . $data["label2"] . "</span>";
	}

	// Is there an 3nd label OR tag, yes/no?
	if (isset($data["tag"]) || isset($data["label3"])) {
		$output .= '<div class="secondary_string">';
		if (isset($data["tag"])) {
			// Does the tag have a color defined, yes/no?
			if (!isset($data["tag_color"])) {
				$data["tag_color"] = "red";
			}
			$output .=
				'<span class="tag" style="--tag-color: var(--connected-' .
				$data["tag_color"] .
				')">' .
				$data["tag"] .
				"</span>";
		}
		if (isset($data["label3"])) {
			$output .= '<span class="label3">' . $data["label3"] . "</span>";
		}
		$output .= "</div>";
	}
	$output .= "</div>";

	if (isset($data["url"])) {
		$output .= "</a>";
	} else {
		$output .= "</div>";
	}
	$output .= "</li>";
	return $output;
}

// Combine the list_item() with <ul> and <h3> to auto-build a list from an array
function list_item_bundle($data)
{
	$previous_value = null;
	$output = "";
	foreach ($data as $key => $value) {
		if (is_array($value)) {
			if (!is_array($previous_value)) {
				$output .= "<ul>";
			}
			$output .= list_item($value);
			if ($key == count($data) - 1) {
				$output .= "</ul></div>";
			}
		} else {
			if (is_array($previous_value)) {
				$output .= "</ul></div>";
			}
			$output .= "<div class='section_group--list'><h3>" . $value . "</h3>";
		}
		$previous_value = $value;
	}
	return $output;
}

// Tune the episode data
function episode_data($episode)
{
	// Add episode number to title
	$episode["label1"] = "#" . $episode["number"] . ": " . $episode["label1"];
	if ($episode["img_url"] == false) {
		// No custom image, fallback to local default
		if ($episode["number"] < 304) {
			// Old artwork
			$episode["img_url"] = "/images/connected-artwork-old.jpg";
		} else {
			// New artwork
			$episode["img_url"] = "/images/connected-artwork.jpg";
		}
	}

	return $episode;
}

// Function to create the side-by-side host leaderboard component with avatars
function avatar_leaderboard($host_array)
{
	$output = '<div class="avatar_leaderboard">';
	foreach ($host_array as &$host) {
		if ($host["winner"]) {
			$output .= '<div class="host winner">';
		} else {
			$output .= '<div class="host">';
		}
		$output .=
			'<div class="item_graphic avatar placeholder" style="animation-delay: ' .
			rand(-50, 0) .
			's;"></div>
			<span class="name">' .
			$host["name"] .
			'</span>
			<span class="title">' .
			$host["title"] .
			'</span>
			<span class="string">' .
			$host["string"] .
			'</span>
		</div>';
	}
	$output .= "</div>";
	return $output;
}

// Format the date to a readable string
// Via https://stackoverflow.com/a/25623057
function date_to_string_label($input, $air_date = false)
{
	$date_format = "%e %B %Y";

	$current = strtotime(date("Y-m-d"));
	$date = strtotime($input);

	$datediff = $date - $current;

	// Get the difference in days (diff in seconds / (60s * 60m * 24h))
	$difference = floor($datediff / (60 * 60 * 24));

	if ($difference == 0) {
		$air_string = "Airs ";
		$output = "today";
	} elseif ($difference == -1) {
		$air_string = "Aired ";
		$output = "yesterday";
	} elseif ($difference == 1) {
		$air_string = "Airs ";
		$output = "tomorrow";
	} elseif ($difference > 1) {
		$air_string = "Airs on ";
		$output = strftime($date_format, $date);
	} else {
		$air_string = "Aired on ";
		$output = strftime($date_format, $date);
	}

	if ($air_date) {
		return $air_string . $output;
	} else {
		return ucfirst($output);
	}
}

// Function to display picks
function pick_item($data)
{
	$output = "<li class='pick_item'>";
	if ($data["type"] !== "Flexy") {
		$output .= "<span class='round'>" . $data["round"] . "</span>";
	}
	$output .=
		"<p class='pick'><span class='label'>" .
		$data["pick"] .
		"</span><span class='points " .
		strtolower($data["type"]) .
		" " .
		strtolower($data["status"]) .
		"'>";
	if ($data["status"] == false) {
		$output .= "?";
	} elseif ($data["points"] > 0 && $data["type"] == "Flexy") {
		$output .= "💪";
	} elseif ($data["type"] == "Flexy") {
		$output .= "👎";
	} elseif ($data["points"] > 0) {
		$output .= "+" . $data["points"];
	} else {
		$output .= $data["points"];
	}
	$output .= "</span></p>";
	if ($data["note"]) {
		$output .= "<span class='note'>" . markdown($data["note"]) . "</span>";
	}
	$output .= "</li>";
	return $output;
}

function picks_bundle($data)
{
	$output = "";

	// Split the data by type (Rickies or Flexies)
	foreach ($data as $type => $hosts) {
		$output .=
			"<section class='navigate_with_mobile_menu' id='" .
			strtolower($type) .
			"'><h2>The $type</h2><div class='section_group'>";

		// Split the data by host
		foreach ($hosts as $host => $picks) {
			$pick_items = "";
			$score = [
				"count" => 0,
				"correct" => 0,
				"points" => 0,
			];

			// Get the picks for this host
			foreach ($picks as $key => $value) {
				// Count the scores of the picks for this host
				$score["count"]++;
				$score["points"] = $score["points"] + $value["points"];
				if ($value["status"] == "Correct") {
					$score["correct"]++;
				}
				$pick_items .= pick_item($value);
			}
			if ($score["count"] !== 0) {
				// Calculate the ratio of correct picks, if not 0 picks, and round it
				$score["percentage"] = round_if_decimal(($score["correct"] / $score["count"]) * 100);
			}

			// Output the gathered data
			$output .=
				"<div class='host_picks section_group--list' id='" .
				strtolower($type) .
				"_" .
				strtolower($host) .
				"'><h3>$host<span>";
			if ($type == "Rickies") {
				// Rickies have points
				$output .= plural_points($score["points"]) . " • " . $score["correct"] . "/" . $score["count"];
			} elseif ($score["count"] !== 0) {
				// Flexies have ratio, but only for more than 0 picks
				$output .= $score["percentage"] . "% • " . $score["correct"] . "/" . $score["count"];
			}

			$output .= "</span></h3><ul>$pick_items</ul></div>";
		}
		$output .= "</div></section>";
	}
	return $output;
}

function host_item_bundle($host_event_data)
{
	$output = "<div class='section_group--list'><h3>Hosts</h3><ul>";
	$html_strings = [];

	foreach ($host_event_data as $host_event_key => $event_details) {
		$html_strings["ranking"] = [];

		if ($event_details["rickies"]["ranking"] !== false && $event_details["rickies"]["ranking"] == 0) {
			array_push($html_strings["ranking"], "<b>Rickies winner</b>");
		} elseif ($event_details["rickies"]["ranking"] == 1) {
			array_push($html_strings["ranking"], "Rickies 2nd place");
		} elseif ($event_details["rickies"]["ranking"] == 2) {
			array_push($html_strings["ranking"], "Rickies 3rd place");
		}

		if ($event_details["flexies"]["ranking"] !== false && $event_details["flexies"]["ranking"] == 0) {
			array_push($html_strings["ranking"], "Flexies winner");
		} elseif ($event_details["flexies"]["ranking"] == 2) {
			array_push($html_strings["ranking"], "Flexies loser");
		}

		if ($event_details["details"]["round_robin"] == 0) {
			array_push($html_strings["ranking"], "Round Robin #1");
		} elseif ($event_details["details"]["round_robin"] == 1) {
			array_push($html_strings["ranking"], "Round Robin #2");
		} elseif ($event_details["details"]["round_robin"] == 2) {
			array_push($html_strings["ranking"], "Round Robin #3");
		}

		$html_strings["stats"] = [
			"🏆 Rickies" => [
				$event_details["rickies"]["correct"] . "/" . $event_details["rickies"]["count"] . " correct",
			],
			"💪 Flexies" => [
				$event_details["flexies"]["correct"] . "/" . $event_details["flexies"]["count"] . " correct",
				round_if_decimal($event_details["flexies"]["percentage"] * 100) . "% flexing power",
			],
		];

		// Add stat about Risky Pick
		if ($event_details["rickies"]["risky_correct"]) {
			array_push($html_strings["stats"]["🏆 Rickies"], "Risky Pick correct!");
		} else {
			array_push($html_strings["stats"]["🏆 Rickies"], "Risky Pick too risky");
		}

		// Add stat about points
		array_push($html_strings["stats"]["🏆 Rickies"], plural_points($event_details["rickies"]["points"]));

		// Add stats about coin flips
		if ($event_details["rickies"]["coin_toss_winner"] && $event_details["rickies"]["ranking"] == 0) {
			// Host won the Rickies and the coin flip
			array_push($html_strings["stats"]["🏆 Rickies"], "Won by coin flip");
		} elseif ($event_details["rickies"]["coin_toss_winner"] && $event_details["rickies"]["ranking"] == 1) {
			// Host is 2nd place and won the coin flip
			array_push($html_strings["stats"]["🏆 Rickies"], "2nd by coin flip");
		}

		if ($event_details["flexies"]["coin_toss_winner"] && $event_details["flexies"]["ranking"] == 0) {
			// Host won the flexies and the coin flip
			array_push($html_strings["stats"]["💪 Flexies"], "Won by coin flip");
		} elseif ($event_details["flexies"]["coin_toss_winner"] && $event_details["flexies"]["ranking"] == 1) {
			// Host is 2nd place and won the coin flip
			array_push($html_strings["stats"]["💪 Flexies"], "Saved by coin flip");
		}

		$output .=
			"
<li class='list_item host_details'>
	<div class='list_item_content'>
		<div class='item_graphic avatar placeholder' style='animation-delay: " .
			rand(-50, 0) .
			"s;'></div>
		<div class='list_item_labels'>
			<p>
				<a href='/leaderboard#" .
			strtolower($event_details["details"]["first_name"]) .
			"'>" .
			$event_details["details"]["first_name"] .
			"</a>
				<br />
				<span class='ranking'>" .
			implode(" • ", $html_strings["ranking"]) .
			"</span>
			</p>";
		if ($event_details["rickies"]["ranking"] !== false) {
			$output .= "
			<div class='mini_stats'>";
			foreach ($html_strings["stats"] as $stat_title => $stat_data) {
				$output .=
					"<div class='mini_stats--list'>
				<h4>$stat_title</h4>
				<p>" .
					implode("<br />", $stat_data) .
					"</p>
				</div>
				";
			}
			$output .= "</div>";
		}
		$output .= "
		</div>
	</div>
</li>
";
	}
	$output .= "</ul></div>";
	return $output;
}
