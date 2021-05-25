<?php

// Rickies _view_ controller, general

$include_body = $incl_path . 'views/main.php';

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
	case 'wwdc':
		$filter = 'WWDC';
		include '../includes/view_controllers/rickies_list_controller.php';
		$include_subbody = '../includes/views/rickies.php';
		break;
	case 'annual':
		$filter = 'Annual';
		include '../includes/view_controllers/rickies_list_controller.php';
		$include_subbody = '../includes/views/rickies.php';
		break;
	case 'keynote':
		$filter = 'Keynote';
		include '../includes/view_controllers/rickies_list_controller.php';
		$include_subbody = '../includes/views/rickies.php';
		break;
	case 'ungraded':
		$filter = 'Ungraded';
		include '../includes/view_controllers/rickies_list_controller.php';
		$include_subbody = '../includes/views/rickies.php';
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
				$txt = '<span>' . strftime('’%y', $img_array['date']) . '</span>';
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
		if (is_array($data['img_url'])) {
			$img_array = $data['img_url'];
		} else {
			// Set URL as img src
			$img_array['src'] = $data['img_url'];
			$img_array['type'] = 'background';

			// Set color, if defined
			if (array_key_exists('artwork_background_color', $data) && $data['artwork_background_color'] !== false) {
				$img_array['color'] = $data['artwork_background_color'];
			}
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
