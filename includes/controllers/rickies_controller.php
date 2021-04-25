<?php

$include_body = "../includes/views/main.php";

switch ($url_view) {
	case "main":
		// No query is defined, so the main overview is shown
		include "../includes/controllers/rickies_list_controller.php";
		$include_subbody = "../includes/views/rickies.php";
		break;
	case "leaderboard":
		// Leaderboard query
		include "../includes/controllers/leaderboard_controller.php";
		$include_subbody = "../includes/views/leaderboard.php";
		$back_to_overview = true;
		break;
	default:
		// If non of the above, it's probably a Rickies event
		include "../includes/controllers/rickies_detail_controller.php";
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
	if (isset($data["url"])) {
		$output .=
			'<li class="list_item"><a class="list_item_content" href="' .
			$data["url"] .
			'">';
	} else {
		$output .= '<li class="list_item"><div class="list_item_content">';
	}

	// Is there an image, yes/no?
	if (isset($data["img_url"])) {
		$output .=
			'<div class="list_item_graphic image" style="background-image: url(' .
			$data["img_url"] .
			')"></div>';
	} else {
		$output .=
			'<div class="list_item_graphic placeholder" style="animation-delay: -' .
			rand(0, 50) .
			's;"></div>';
	}

	$output .=
		'<div class="list_item_labels"><span class="label1">' .
		$data["label1"] .
		"</span>";

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
				$output .= "</ul>";
			}
		} else {
			if (is_array($previous_value)) {
				$output .= "</ul>";
			}
			$output .= "<h3>" . $value . "</h3>";
		}
		$previous_value = $value;
	}
	return $output;
}

// Function to create the side-by-side host leaderboard component with avatars
function avatar_leaderboard($host_array)
{
	$output = '<div class="avatar_leaderboard">';
	foreach ($host_array as &$host) {
		if ($host["winner"]) {
			$output .= '<div class="host winner">
				<div class="avatar"><div class="ring"></div></div>';
		} else {
			$output .= '<div class="host">
				<div class="avatar"></div>';
		}
		$output .=
			'
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
