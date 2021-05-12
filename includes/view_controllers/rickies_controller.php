<?php

// Rickies _view_ controller, general

$include_body = '../includes/views/main.php';

switch ($url_view) {
	case 'main':
		// No query is defined, so the main overview is shown
		include '../includes/view_controllers/rickies_list_controller.php';
		$include_subbody = '../includes/views/rickies.php';
		break;
	case 'leaderboard':
		// Leaderboard query
		include '../includes/view_controllers/leaderboard_controller.php';
		$include_subbody = '../includes/views/leaderboard.php';
		$back_to_overview = true;
		break;
	case 'about':
		// About query
		include '../includes/view_controllers/about_controller.php';
		$include_subbody = '../includes/views/about.php';
		$back_to_overview = true;
		break;
	default:
		// If non of the above, it's probably a Rickies event
		include '../includes/view_controllers/rickies_detail_controller.php';
		$include_subbody = '../includes/views/event.php';
		$back_to_overview = true;
}

function list_item_graphic($img_array = false, $avatar = false)
{
	// Image array types can be:
	// * background: fill the background with src, optional color
	// * color: use color as background
	// * annual: use text + random color background
	// * avatar: use <img> with memoji on a color background
	$class = ['item_graphic'];
	$style = [];

	if ($img_array == false) {
		$class[] = 'placeholder';
		$style[] = 'animation-delay: ' . rand(-50, 0) . 's;';
	} else {
		switch ($img_array['type']) {
			case 'background':
				$class[] = 'fill_image';
				if (isset($img_array['color'])) {
					$style[] = 'background-color: ' . $img_array['color'] . ';';
				}
				$style[] = 'background-image: url(' . $img_array['src'] . ');';
				break;
			case 'color':
				$style[] = 'background-color: var(--connected-' . $img_array['color'] . ')';
				break;
			case 'annual':
				$class[] = 'annual diagonal';
				$style[] = 'animation-delay: ' . rand(-50, 0) . 's;';
				$txt = '<span>' . strftime('’%y', $img_array['date']) . '</span>';
				break;
			case 'avatar':
				$class[] = 'avatar';
				$img = '<img src="' . $img_array['src'] . '" />';
				$style[] = 'background-color: var(--connected-' . $img_array['color'] . ')';
				break;
		}
	}

	if ($avatar == true) {
		$class[] = 'avatar';
	}

	$output = '<div class="' . implode(' ', $class) . '" ';

	if (!empty($style)) {
		$output .= 'style="' . implode(' ', $style) . '"';
	}

	$output .= '>';
	if (isset($img)) {
		$output .= $img;
	} elseif (isset($txt)) {
		$output .= $txt;
	}
	$output .= '</div>';
	return $output;
}

/* Function to create a list_item component.
EXAMPLE: $data = array(
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
	$output = '';
	if (isset($data['url']) && $data['url'] !== false) {
		if ($data['url'][0] == '/' || isset($data['url_internal'])) {
			$href = 'href="' . $data['url'] . '"';
		} else {
			$href =
				'target="_blank"
				data-goatcounter-click="' .
				$data['url'] .
				'"
				data-goatcounter-title="' .
				$data['label1'] .
				'"
				data-goatcounter-referrer="' .
				current_url() .
				'"
				href="' .
				$data['url'] .
				'"';
		}
		$output .= '<li class="list_item"><a class="list_item_content" ' . $href . '>';
	} else {
		$output .= '<li class="list_item"><div class="list_item_content">';
	}

	// Is there an image, yes/no?
	if (isset($data['img_url']) && $data['img_url'] !== false) {
		// Set URL as img src
		$img_array['src'] = $data['img_url'];
		$img_array['type'] = 'background';

		// Set color, if defined
		if (array_key_exists('artwork_background_color', $data) && $data['artwork_background_color'] !== false) {
			$img_array['color'] = $data['artwork_background_color'];
		}
	} elseif (array_key_exists('type', $data) && $data['type'] == 'annual') {
		// No image, but annual, so include the date/year
		$img_array['type'] = 'annual';
		$img_array['date'] = $data['date'];
	} else {
		$img_array = false;
	}

	$output .= list_item_graphic($img_array);
	$output .= '<div class="list_item_labels"><p class="label1">' . $data['label1'] . '</p>';

	// Is there an 2nd label, yes/no?
	if (isset($data['label2'])) {
		$output .= '<p class="label2">' . $data['label2'] . '</p>';
	}

	// Is there an 3nd label OR tag, yes/no?
	if (isset($data['tag']) || isset($data['label3'])) {
		$output .= '<p class="secondary_string">';
		if (isset($data['tag'])) {
			// Does the tag have a color defined, yes/no?
			$data['tag_class'] = 'tag';
			if (!isset($data['tag_color'])) {
				$data['tag_color'] = 'red';
			} elseif ($data['tag_color'] == 'yellow') {
				$data['tag_class'] .= ' contrast';
			}
			$output .=
				'<span class="' .
				$data['tag_class'] .
				'" style="--tag-color: var(--connected-' .
				$data['tag_color'] .
				')">' .
				$data['tag'] .
				'</span>';
		}
		if (isset($data['label3'])) {
			$output .= '<span class="label3">' . $data['label3'] . '</span>';
		}
		$output .= '</p>';
	}
	$output .= '</div>';

	if (isset($data['url'])) {
		$output .= '</a>';
	} else {
		$output .= '</div>';
	}
	$output .= '</li>';
	return $output;
}

// Combine the list_item() with <ul> and <h3> to auto-build a list from an array
function list_item_bundle($data)
{
	$previous_value = null;
	$output = '';
	foreach ($data as $key => $value) {
		if (is_array($value)) {
			if (!is_array($previous_value)) {
				$output .= '<ul class="list_item_group">';
			}
			$output .= list_item($value);
			if ($key == count($data) - 1) {
				$output .= '</ul></div>';
			}
		} else {
			if (is_array($previous_value)) {
				$output .= '</ul></div>';
			}
			$output .= '<div class="section_group--list"><h3>' . $value . '</h3>';
		}
		$previous_value = $value;
	}
	return $output;
}

// Tune the episode data
function episode_data($episode)
{
	if (array_key_exists('label1', $episode) && $episode['label1'] !== false) {
		// Add episode number to title
		$episode['label1'] = '#' . $episode['number'] . ': ' . $episode['label1'];
		if ($episode['img_url'] == false) {
			// No custom image, fallback to local default
			if ($episode['number'] < 304) {
				// Old artwork
				$episode['img_url'] = '/images/connected-artwork-old.jpg';
			} else {
				// New artwork
				$episode['img_url'] = '/images/connected-artwork.jpg';
			}
		}

		return $episode;
	} else {
		return false;
	}
}

// Function to create the side-by-side host leaderboard component with avatars
function avatar_leaderboard($host_array)
{
	$output = '<div class="avatar_leaderboard">';
	foreach ($host_array as &$host) {
		if ($host['winner']) {
			$output .= '<div class="host winner" onclick="confetti_go()">';
		} else {
			$output .= '<div class="host">';
		}
		$output .= list_item_graphic($host['img_array'], true);
		$output .=
			'<span class="name">' .
			$host['name'] .
			'</span>
			<span class="title">' .
			$host['title'] .
			'</span>
			<span class="string">' .
			$host['string'] .
			'</span>
		</div>';
	}
	$output .= '</div>';
	return $output;
}

// Function to display picks
function pick_item($data)
{
	$output = '<li class="pick_item">';

	// If it's not a Flexy, the picks are in 3 rounds
	if ($data['type'] !== 'Flexy') {
		$output .= '<span class="round">' . $data['round'] . '</span>';
	}

	// Define the pick label
	$output .= '<p class="pick"><span class="label">' . $data['pick'] . '</span>';

	// Define the point score
	$output .= '<span class="points ' . strtolower($data['type']) . ' ' . strtolower($data['status']) . '">';
	if ($data['status'] == false) {
		$output .= '?';
	} elseif ($data['points'] > 0 && $data['type'] == 'Flexy') {
		$output .= '💪';
	} elseif ($data['type'] == 'Flexy') {
		$output .= '👎';
	} elseif ($data['points'] >= 1) {
		$output .= '+' . $data['points'];
	} elseif ($data['points'] > 0) {
		$output .= $data['points'];
	} else {
		$output .= $data['points'];
	}
	$output .= '</span>';

	$output .= '</p>';

	// Add optional note
	if ($data['note']) {
		$output .= '<div class="note">' . markdown($data['note']) . '</div>';
	}
	$output .= '</li>';
	return $output;
}

function pick_item_bundle($data)
{
	$output = '';

	// Split the data by type (Rickies or Flexies)
	foreach ($data as $type => $hosts) {
		$output .=
			'<section class="navigate_with_mobile_menu large_columns" id="' .
			strtolower($type) .
			'"><h2 class="section_title">The ' .
			$type .
			'</h2><div class="section_group">';

		// Split the data by host
		foreach ($hosts as $host => $picks) {
			$pick_items = '';
			$score = [
				'count' => 0,
				'correct' => 0,
				'points' => 0,
			];

			// Get the picks for this host
			foreach ($picks as $key => $value) {
				// Count the scores of the picks for this host
				$score['count']++;
				$score['points'] = $score['points'] + $value['points'];
				if ($value['status'] == 'Correct' || $value['status'] == 'Half') {
					$score['correct']++;
				}
				$pick_items .= pick_item($value);
			}
			if ($score['count'] !== 0) {
				// Calculate the ratio of correct picks, if not 0 picks, and round it
				$score['percentage'] = round_if_decimal(($score['correct'] / $score['count']) * 100);
			}

			// Output the gathered data
			$output .=
				'<div class="host_picks section_group--list" id="' .
				strtolower($type) .
				'_' .
				strtolower($host) .
				'"><h3>' .
				$host .
				'<span>';
			if ($type == 'Rickies') {
				// Rickies have points
				$output .= plural_points($score['points']) . ' • ' . $score['correct'] . '/' . $score['count'];
			} elseif ($score['count'] !== 0) {
				// Flexies have ratio, but only for more than 0 picks
				$output .= $score['percentage'] . '% • ' . $score['correct'] . '/' . $score['count'];
			}

			$output .= '</span></h3><ul class="list_item_group">' . $pick_items . '</ul></div>';
		}
		$output .= '</div></section>';
	}
	return $output;
}

function host_item_bundle($host_event_data, $event_type)
{
	$output = '';

	$html_strings = [];

	foreach ($host_event_data as $host_event_key => $event_details) {
		$html_strings['ranking'] = [];

		if ($event_details['rickies']['ranking'] !== false && $event_details['rickies']['ranking'] == 0) {
			array_push($html_strings['ranking'], '<b class="nowrap">Rickies winner</b> • ' . chairman_url($event_type));
		} elseif ($event_details['rickies']['ranking'] == 1) {
			array_push($html_strings['ranking'], '<span class="nowrap">Rickies 2nd place</span>');
		} elseif ($event_details['rickies']['ranking'] == 2) {
			array_push($html_strings['ranking'], '<span class="nowrap">Rickies 3rd place</span>');
		}

		if ($event_details['flexies']['ranking'] !== false && $event_details['flexies']['ranking'] == 0) {
			array_push($html_strings['ranking'], '<span class="nowrap">Flexies winner</span>');
		} elseif ($event_details['flexies']['ranking'] == 2) {
			array_push($html_strings['ranking'], '<span class="nowrap">Flexies loser</span>');
		}

		if ($event_details['details']['round_robin'] == 0) {
			array_push($html_strings['ranking'], '<span class="nowrap">Round Robin #1</span>');
		} elseif ($event_details['details']['round_robin'] == 1) {
			array_push($html_strings['ranking'], '<span class="nowrap">Round Robin #2</span>');
		} elseif ($event_details['details']['round_robin'] == 2) {
			array_push($html_strings['ranking'], '<span class="nowrap">Round Robin #3</span>');
		}

		$html_strings['stats'] = [];
		if ($event_details['rickies']['count'] !== 0) {
			$html_strings['stats']['🏆 Rickies'] = [
				$event_details['rickies']['correct'] . '/' . $event_details['rickies']['count'] . ' correct',
			];

			// Add stat about Risky Pick
			if ($event_details['rickies']['risky_correct']) {
				array_push($html_strings['stats']['🏆 Rickies'], 'Risky Pick correct!');
			} else {
				array_push($html_strings['stats']['🏆 Rickies'], 'Risky Pick too risky');
			}

			// Add stat about points
			array_push($html_strings['stats']['🏆 Rickies'], plural_points($event_details['rickies']['points']));

			// Add stats about Rickies coin flips
			if ($event_details['rickies']['coin_toss_winner'] && $event_details['rickies']['ranking'] == 0) {
				// Host won the Rickies and the coin flip
				array_push($html_strings['stats']['🏆 Rickies'], 'Won by coin flip');
				// } elseif ($event_details['rickies']['coin_toss_winner'] && $event_details['rickies']['ranking'] == 1) {
				// 	// Host is 2nd place and won the coin flip
				// 	array_push($html_strings['stats']['🏆 Rickies'], 'Saved by coin flip');
			} elseif ($event_details['rickies']['coin_toss_loser'] && $event_details['rickies']['ranking'] == 1) {
				// Host is 2nd place and lost the coin flip
				array_push($html_strings['stats']['🏆 Rickies'], 'Lost by coin flip');
			}
		}
		if ($event_details['flexies']['count'] !== 0) {
			$html_strings['stats']['💪 Flexies'] = [
				$event_details['flexies']['correct'] . '/' . $event_details['flexies']['count'] . ' correct',
				round_if_decimal($event_details['flexies']['percentage'] * 100) . '% flexing power',
			];

			// Add stats about Flexies coin flips
			if ($event_details['flexies']['coin_toss_winner'] && $event_details['flexies']['ranking'] == 0) {
				// Host won the flexies and the coin flip
				array_push($html_strings['stats']['💪 Flexies'], 'Won by coin flip');
			} elseif ($event_details['flexies']['coin_toss_winner'] && $event_details['flexies']['ranking'] == 1) {
				// Host is 2nd place and won the coin flip
				array_push($html_strings['stats']['💪 Flexies'], 'Saved by coin flip');
			} elseif ($event_details['flexies']['coin_toss_loser']) {
				array_push($html_strings['stats']['💪 Flexies'], 'Lost by coin flip');
			}
		}

		$avatar_img_array = [
			'type' => 'avatar',
			'src' => $event_details['details']['memoji']['neutral'],
			'color' => $event_details['details']['color'],
		];

		$output .=
			'
<div class="section_group--list">
	<ul class="list_item_group">
	<li class="list_item host_details">
		<div class="list_item_content">' .
			list_item_graphic($avatar_img_array, true) .
			'
			<div class="list_item_labels">
				<p>
					<a href="/leaderboard#' .
			strtolower($event_details['details']['first_name']) .
			'">' .
			$event_details['details']['full_name'] .
			'</a></p>
					<p class="ranking">' .
			implode(' • ', $html_strings['ranking']) .
			'</p>';
		if ($event_details['rickies']['ranking'] !== false || $event_details['flexies']['ranking'] !== false) {
			$output .= '
				<div class="mini_stats">';
			foreach ($html_strings['stats'] as $stat_title => $stat_data) {
				$output .=
					'<div class="mini_stats--list">
					<h4>' .
					$stat_title .
					'</h4>
					<p>' .
					implode('<br />', $stat_data) .
					'</p>
					</div>';
			}
			$output .= '</div>';
		}
		$output .= '
				</div>
			</div>
		</li>
	</ul>
</div>
';
	}
	$output .= '</ul></div>';
	return $output;
}
