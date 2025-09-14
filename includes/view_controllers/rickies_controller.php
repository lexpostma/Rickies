<?php

// Rickies _view_ controller, general

$include_body = $incl_path . 'views/main.php';

switch ($url_view) {
	case 'main':
		// No query is defined, so the main overview is shown
		include '../includes/view_controllers/rickies_list_controller.php';
		$include_subbody = '../includes/views/rickies.php';
		break;
	case 'api':
		// API page
		include '../includes/view_controllers/api_controller.php';
		$include_subbody = '../includes/views/api.php';
		break;
	case '3j-leaderboard':
		// Leaderboard of Triple J Pickies
		$triple_j = true;
	case 'leaderboard':
		// Leaderboard query
		include '../includes/view_controllers/leaderboard_controller.php';
		$include_subbody = '../includes/views/leaderboard.php';
		break;
	case 'about':
		// About query
		include '../includes/view_controllers/about_controller.php';
		$include_subbody = '../includes/views/about.php';
		break;
	case '3j-archive':
		// Archive of Triple J Pickies
		$triple_j = true;
	case 'archive':
	case 'search':
		// Search query
		include '../includes/view_controllers/search_controller.php';
		$include_subbody = '../includes/views/search.php';
		$back_to_overview = true;
		break;
	case 'trophies':
		// Trophies query
		include '../includes/view_controllers/trophies_controller.php';
		$include_subbody = '../includes/views/trophies.php';
		$back_to_overview = true;
		break;
	case 'charities':
		// Charities query
		include '../includes/view_controllers/charities_controller.php';
		$include_subbody = '../includes/views/charities.php';
		$back_to_overview = true;
		break;
	case 'apple-events':
		// Apple Events query
		include '../includes/view_controllers/apple_events_controller.php';
		$include_subbody = '../includes/views/apple_events.php';
		$back_to_overview = true;
		break;
	case 'wwdc':
	case 'annual':
	case 'keynote':
	case 'ungraded':
	case 'pickies':
	case 'euies':
	case 'preview':
		switch ($url_view) {
			case 'wwdc':
				$rickies_filter = 'WWDC';
				break;
			case 'annual':
				$rickies_filter = 'Annual';
				break;
			case 'keynote':
				$rickies_filter = 'Keynote';
				break;
			case 'pickies':
				$triple_j = true;
				$rickies_filter = 'Pickies';
				break;
			case 'ungraded':
				$rickies_filter = 'Ungraded';
				break;
			case 'euies':
				$rickies_filter = 'EUies';
				break;
			case 'preview':
				$rickies_filter = 'Preview';
				$previewing_content = true;
				break;
		}
		include '../includes/view_controllers/rickies_list_controller.php';
		$include_subbody = '../includes/views/rickies.php';

	case 'latest':
	case 'latest-keynote':
	case 'latest-annual':
		switch ($url_view) {
			case 'latest':
				$auto_select_rickies = 'latest';
			case 'latest-keynote':
				$auto_select_rickies = 'keynote';
			case 'latest-annual':
				$auto_select_rickies = 'annual';
		}
		include '../includes/view_controllers/rickies_list_controller.php';
		break;
	default:
		// If non of the above, it's probably a Rickies event
		include '../includes/view_controllers/rickies_detail_controller.php';
		$include_subbody = '../includes/views/event.php';
		$back_to_overview = true;
}

function list_item_graphic($img_array = false)
{
	// Image array types can be:
	// * background: fill the background with src, optional color
	// * app: same as background, but more rounded
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
			case 'app':
				$class[] = 'app_shape';
			case 'background':
				$class[] = 'fill_image';
				if (isset($img_array['color']) && $img_array['color'] == 'random') {
					$class[] = 'placeholder';
					$style[] = 'animation-delay: ' . rand(-50, 0) . 's;';
				} elseif (isset($img_array['color']) && is_int($img_array['color'])) {
					$class[] = 'placeholder';
					$style[] = 'animation-delay: -' . $img_array['color'] . 's;';
				} elseif (isset($img_array['color'])) {
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
				$txt = '<span>’' . substr($img_array['date'], -2) . '</span>';
				break;
			case 'avatar':
				$class[] = 'avatar';
				$img =
					'<div class="ring" style="animation-delay: ' .
					rand(-20, 0) .
					's;"></div><img src="' .
					$img_array['src'] .
					'" alt="' .
					$img_array['name'] .
					'’s Memoji avatar"/>';
				$style[] = 'background-color: var(--connected-' . $img_array['color'] . ')';
				break;
		}
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
			$href = 'href="' . $data['url'] . '" title="' . $data['label1'] . '"';
		} else {
			$href =
				'target="_blank"
				data-goatcounter-click="' .
				$data['url'] .
				'"
				title="' .
				strip_tags($data['label1']) .
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
		if (is_array($data['img_url'])) {
			$img_array = $data['img_url'];
		} else {
			// Set URL as img src
			$img_array['src'] = $data['img_url'];
			$img_array['type'] = 'background';

			// Set color, if defined
			if (array_key_exists('artwork_background_color', $data) && $data['artwork_background_color'] !== false) {
				$img_array['color'] = $data['artwork_background_color'];
			} elseif (array_key_exists('special', $data) && $data['special'] == 'EUies') {
				$img_array['color'] = 'random';
			}
		}
	} elseif (array_key_exists('type', $data) && $data['type'] == 'annual') {
		// No image, but annual, so include the date/year
		$img_array['type'] = 'annual';
		$img_array['date'] = $data['annual_year'];
	} else {
		$img_array = false;
	}

	$output .= list_item_graphic($img_array);
	$output .= '<div class="list_item_labels"><p class="label1">' . $data['label1'] . '</p>';

	// Is there an 2nd label, yes/no?
	if (isset($data['label2'])) {
		$output .= '<p class="label2">' . $data['label2'] . '</p>';
	}

	// Is there a 3rd label OR tag, yes/no?
	if (isset($data['tag']) || isset($data['label3'])) {
		$output .= '<p class="secondary_string">';
		if (isset($data['tag'])) {
			$output .= '<span class="tag_group">';
			foreach ($data['tag'] as $tag) {
				// Does the tag have a color defined, yes/no?
				$tag['class'] = 'tag';
				if (!isset($tag['color'])) {
					$tag['color'] = 'red';
				} elseif ($tag['color'] == 'yellow') {
					$tag['class'] .= ' contrast';
				} elseif ($tag['color'] == 'eu') {
					$tag['class'] .= ' euies';
					$tag['color'] = 'blue';
				}
				$output .=
					'<span class="' .
					$tag['class'] .
					'" style="--tag-color: var(--connected-' .
					$tag['color'] .
					')">' .
					$tag['label'] .
					'</span>';
			}
			$output .= '</span>';
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
	$i = 0;
	$len = count($data);
	foreach ($data as $key => $value) {
		if (!is_array($value)) {
			if (is_array($previous_value)) {
				// Previous was list item, so close the list first
				$output .= '
			</ul>
		</div>';
			}
			// Not a list item, so title and open new list
			$output .=
				'
		<div class="section_group--list">
			<h3 id="' .
				str_replace(' ', '_', strtolower($value)) .
				'">' .
				$value .
				'</h3>
			<ul class="list_item_group">';
		} else {
			// List item, so add to new list
			$output .= list_item($value);
			if ($i == $len - 1) {
				// If last item in foreach is list item/array, close the list
				$output .= '
			</ul>
		</div>';
			}
		}
		$i++;
		$previous_value = $value;
	}
	return $output;
}

// Tune the episode data
function episode_data($episode, $state = false)
{
	// $state = [ live | future ]
	if ($state == 'live') {
		$episode['label1'] = '<span class="emoji">🔴&nbsp;</span>Live now';
		$episode['label2'] = 'Tune in live to enjoy the show!';
		$episode['label3'] = 'On air';
	} elseif ($state == 'future') {
		$episode['label1'] = 'Future episode…';
		$episode['label2'] = 'See schedule for recording time';
	}

	if (array_key_exists('label1', $episode) && $episode['label1'] !== false) {
		// Add episode number to title
		if ($episode['number'] !== false && $state !== 'live') {
			$episode['label1'] = '#' . $episode['number'] . ': ' . $episode['label1'];
		}
		if ($episode['img_url'] == false) {
			// No custom image, fallback to local default
			if ($episode['number'] && $episode['number'] < 304) {
				// Old artwork
				$episode['img_url'] = '/images/connected-artwork-until-303.jpg';
			} elseif ($episode['number'] && $episode['number'] < 537) {
				// Old artwork
				$episode['img_url'] = '/images/connected-artwork-until-536.jpg';
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
	foreach ($host_array as $host) {
		if ($host['winner'] === 2) {
			$output .= '<div class="host winner mega_winner" onclick="confetti_go()">';
		} elseif ($host['winner']) {
			$output .= '<div class="host winner" onclick="confetti_go()">';
		} else {
			$output .= '<div class="host">';
		}
		$output .= list_item_graphic($host['img_array']);
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
function pick_item($data, $interactive = false, $view = [])
{
	if ($interactive) {
		$output =
			'<li id="pick' .
			$data['id'] .
			'" class="pick_item interactive" onclick="update_pick(this)" data-goatcounter-click="Interactive picks" title="Update pick state" data-goatcounter-referrer=' .
			current_url() .
			'>';
	} else {
		$output = '<li id="pick' . $data['id'] . '" class="pick_item">';
	}

	// In the search/archive view, show link to Rickies + the round it was picked in
	// If it's not a Flexy, the picks are in 3 rounds
	if (in_array('search', $view)) {
		$pick_link =
			'<a href="/' .
			$data['url'] .
			'#' .
			str_replace(' ', '_', strtolower($data['type_group'])) .
			'">' .
			$data['rickies'] .
			'</a>';
	}

	if (in_array('search', $view) && $data['type'] !== 'Flexy' && $data['type'] !== 'Lightning') {
		$output .= '<span class="round">' . $pick_link . ' • <span class="nowrap">' . $data['round'] . '</span></span>';
	} elseif (in_array('search', $view)) {
		$output .= '<span class="round">' . $pick_link . '</span>';
	} elseif ($data['type'] !== 'Flexy' && $data['type'] !== 'Lightning') {
		$output .= '<span class="round">' . $data['round'] . '</span>';
	}

	// Define the pick label with copy button
	// $output .= '<p class="pick"><span class="label">' . $data['pick'] . '</span>';
	// TODO: Add copy button to picks
	$output .= '<p class="pick"><span class="label">' . $data['pick'] . copy_url_button($data['anchor']) . '</span>';

	// Define the point score

	// Count decimals and if more than 2 decimals, round to 3.
	// This was added for Pickies 2022 which had 16 decimal values
	// e.g. "-0.7142857142857142" -> "-0.714"
	$decimal_count = strlen(substr(strrchr($data['points'], '.'), 1));
	if ($decimal_count >= 2) {
		$data['points_full'] = $data['points'];
		$data['points'] = round($data['points'], 3);
	}

	$output .=
		'<span class="points ' .
		strtolower($data['type']) .
		' ' .
		strtolower($data['status']) .
		' round' .
		$data['round_number'];
	if ($data['status_later'] && in_array('ahead_of_its_time', $view)) {
		$output .= ' eventually';
	}
	if ($data['type'] == 'Risky' && $data['risky_conditions']) {
		$output .= ' condition' . $data['risky_conditions'];
	}

	// Make the circle elongated, to fit 3 decimals
	if ($decimal_count >= 2 && $data['type'] !== 'Flexy') {
		$output .= ' long';
	}
	$output .= '" ';

	// Add title to the rounded values, to show the original precise value
	if ($decimal_count >= 2) {
		$output .= ' title="Precise points: ' . $data['points_full'] . '" ';
	}

	$output .= '>';

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
	} elseif ($data['points'] == 0) {
		$output .= '0';
	} elseif ($data['points'] == '') {
		$output .= '—';
	} else {
		$output .= $data['points'];
	}
	$output .= '</span>';

	$output .= '</p>';

	// Add optional note
	if (
		$data['note'] ||
		$data['regrade_note'] ||
		($data['status_later'] && in_array('ahead_of_its_time', $view)) ||
		($data['categories'] && in_array('categories', $view)) ||
		($data['reusability'] && in_array('reusability', $view)) ||
		($data['buzzkill'] && in_array('buzzkill', $view)) ||
		($data['amendment'] && in_array('amendment', $view))
	) {
		$output .= '<div class="note">';
		if ($data['note']) {
			$output .= markdown($data['note']);
		}
		if ($data['regrade_note']) {
			$output .= markdown($data['regrade_note']);
		}
		if ($data['status_later'] && in_array('ahead_of_its_time', $view)) {
			$output .= markdown($data['status_later']);
		}
		if ($data['categories'] && in_array('categories', $view)) {
			$output .= '<p class="tag_group">';
			foreach ($data['categories'] as $cat_data) {
				$output .=
					'<a class="tag ' .
					$cat_data['color'] .
					'" href="' .
					domain_url() .
					'?search=&category%5B%5D=' .
					$cat_data['value'] .
					'">' .
					$cat_data['string'] .
					'</a>';
			}
			$output .= '</p>';
		}
		if ($data['reusability'] && in_array('reusability', $view)) {
			$output .= markdown($data['reusability']);
		}
		if ($data['buzzkill'] && in_array('buzzkill', $view)) {
			$output .= markdown($data['buzzkill']);
		}
		if ($data['amendment'] && in_array('amendment', $view)) {
			$output .= markdown($data['amendment']);
		}

		$output .= '</div>';
	}

	// $output .= copy_url_button($data['anchor']);
	$output .= '</li>';
	return $output;
}

function pick_item_bundle($data, $interactive = false, $view = [])
{
	$output = '';

	// Split the data by type (Rickies or Flexies)
	foreach ($data as $type => $hosts) {
		$output .=
			'<section class="navigate_with_mobile_menu large_columns" id="' .
			str_replace(' ', '_', strtolower($type)) .
			'"><h2 class="section_title">';
		if (!in_array('search', $view) && $type !== 'Lightning Round') {
			$output .= 'The ';
		}
		$output .= $type . '</h2><div class="section_group">';

		// Split the data by host
		foreach ($hosts as $host => $picks) {
			$pick_items = '';
			$score = [
				'count' => 0,
				'correct' => 0,
				'points' => 0,
			];

			// Get the picks for this host
			if (!empty($picks)) {
				foreach ($picks as $key => $value) {
					// Count the scores of the picks for this host
					$score['count']++;
					$score['points'] = $score['points'] + $value['points'];
					if ($value['status'] == 'Correct') {
						$score['correct'] = $score['correct'] + $value['factor'];
					}
					$pick_items .= pick_item($value, $interactive, $view);
				}
				if ($score['count'] !== 0) {
					// Calculate the ratio of correct picks, if not 0 picks, and round it
					$score['percentage'] = round_if_decimal(($score['correct'] / $score['count']) * 100);
				}
			} else {
				if (in_array('search', $view)) {
					$pick_items .=
						'<li class="pick_item no_results">No ' . $type . ' about this predicted by ' . $host . '.</li>';
				} else {
					if (in_array('fixed_picks', $view)) {
						$pick_items .= '<li class="pick_item no_results">No ' . $type . ' from ' . $host . '</li>';
					} else {
						if ($type == 'Flexies') {
							$pick_items .= '<li class="pick_item no_results">Waiting for ' . $host . '’s Flexies…</li>';
						} else {
							$pick_items .=
								'<li class="pick_item no_results">Waiting for ' . $host . '’s first pick…</li>';
						}
					}
				}
			}

			// Output the gathered data
			$output .=
				'<div class="host_picks section_group--list" id="' .
				strtolower($type) .
				'_' .
				strtolower($host) .
				'"><h3>' .
				$host;

			if ($type == 'Rickies' || $type == 'Flexies' || $type == 'EUies') {
				// TODO: Define scoring for Pickies
				$output .= '<span class="host_score">';
				if ($type == 'Rickies' || $type == 'EUies') {
					// if ($type == 'Rickies' || $type == 'Pickies' || $type == 'Lightning') {
					// Rickies have points
					$output .= plural_points($score['points']) . ' • ' . $score['correct'] . '/' . $score['count'];
				} elseif ($score['count'] !== 0) {
					// Flexies have ratio, but only for more than 0 picks
					$output .= $score['percentage'] . '% • ' . $score['correct'] . '/' . $score['count'];
				}
				$output .= '</span>';
			}

			$output .= '</h3><ul class="list_item_group">' . $pick_items . '</ul></div>';
		}
		$output .= '</div></section>';
	}
	if ($interactive) {
		$output .=
			'<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/interactive_picks.js') . '</script>';
	}
	return $output;
}
