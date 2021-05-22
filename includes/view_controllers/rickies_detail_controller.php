<?php

// Rickies _view_ controller, event details page

// Get and merge event and host data
include '../includes/data_controllers/merge_hosts_event_data_controller.php';

// Define the data for the leaderboard at the top of the page
$leaderboard_data = [];
foreach ($rickies_data['hosts'] as $host) {
	// Set a default title for each host
	$filler_titles = [
		'Federico' => 'Picker of Passion',
		'Myke' => 'Risk Taker',
		'Stephen' => 'Document Maintainer',
	];

	// Define array
	$added_host = [
		'name' => $host['details']['first_name'],
		'winner' => false,
		'title' => [],
		'string' => [],
		'img_array' => [
			'type' => 'avatar',
			'name' => $host['details']['first_name'],
			'src' => $host['details']['memoji']['neutral'],
			'color' => $host['details']['color'],
		],
	];

	// Define Rickies part of leaderboard string
	if (array_key_exists('Rickies', $picks_data__array)) {
		$added_host['string'][] = 'Score: ' . plural_points($host['rickies']['points']);
	}

	// Define Flexies part of leaderboard string
	if (array_key_exists('Flexies', $picks_data__array)) {
		$added_host['string'][] = 'Flexing: ' . round_if_decimal($host['flexies']['percentage'] * 100) . '%';
	}

	// Combine leaderboard string parts
	$added_host['string'] = implode('<br />', $added_host['string']);

	// Define rank and winner in array
	if ($host['rickies']['ranking'] !== false && $host['rickies']['ranking'] == 0) {
		$added_host['winner'] = true;
		$added_host['title'][] = chairman_url($rickies_data['type']);
		$added_host['img_array']['src'] = $host['details']['memoji']['happy'];
		$added_host['ranking'] = 0;

		// If there's a winner, have a custom sorting order, just like a podium:
		//        1
		//   2  ■■■■■
		// ■■■■■■■■■■  3
		// ■■■■■■■■■■■■■■■
		$leaderboard_order = [1, 0, 2];
	} else {
		$added_host['ranking'] = $host['rickies']['ranking'];
	}

	// If there's a Flexies ranking, host is #1 and there is a charity -> Add title
	if (
		$host['flexies']['ranking'] !== false &&
		$host['flexies']['ranking'] == 0 &&
		array_key_exists('more_data_charity', $rickies_data['details'])
	) {
		$added_host['title'][] = 'Charity Chooser';
	} elseif ($host['flexies']['ranking'] !== false && $host['flexies']['ranking'] == 2) {
		// If there's a Flexies ranking, host is #3 and there is a charity -> Add title
		if (array_key_exists('more_data_charity', $rickies_data['details'])) {
			$added_host['title'][] = 'Generous Donor';
		}

		// If there's a Rickies ranking, host is not #1 there -> show sad memoji
		if ($host['rickies']['ranking'] !== false && $host['rickies']['ranking'] !== 0) {
			$added_host['img_array']['src'] = $host['details']['memoji']['sad'];
		}
	}

	// Fill title is default of empty
	if (empty($added_host['title'])) {
		$added_host['title'][] = $filler_titles[$added_host['name']];
	}

	// Create string from title array
	$added_host['title'] = implode('<br />', $added_host['title']);

	// Add to leaderboard array
	array_push($leaderboard_data, $added_host);
	unset($added_host);
}

if (isset($leaderboard_order)) {
	// If the custom order is set, sort the data by ranking
	usort($leaderboard_data, function ($a, $b) use ($leaderboard_order) {
		$pos_a = array_search($a['ranking'], $leaderboard_order);
		$pos_b = array_search($b['ranking'], $leaderboard_order);
		return $pos_a - $pos_b;
	});
}

// echo "<pre>", var_dump($leaderboard_data), "</pre>";

// Function to display picks
function pick_item($data, $interactive = false)
{
	if ($interactive) {
		$output = '<li class="pick_item interactive" onclick="update_pick(this)">';
	} else {
		$output = '<li class="pick_item">';
	}

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

function pick_item_bundle($data, $interactive = false)
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
				if ($value['status'] == 'Correct') {
					$score['correct'] = $score['correct'] + $value['factor'];
				}
				$pick_items .= pick_item($value, $interactive);
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
				'<span class="host_score">';
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
	if ($interactive) {
		$output .=
			'<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/interactive_picks.js') . '</script>';
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
			'name' => $event_details['details']['first_name'],
			'src' => $event_details['details']['memoji']['neutral'],
			'color' => $event_details['details']['color'],
		];

		$output .=
			'
<div class="section_group--list">
	<ul class="list_item_group">
		<li class="list_item host_details">
			<div class="list_item_content">' .
			list_item_graphic($avatar_img_array) .
			'
				<div class="list_item_labels">
					<p><a href="/leaderboard#' .
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
					'
						<div class="mini_stats--list">
							<h4>' .
					$stat_title .
					'</h4>
							<p>' .
					implode('<br />', $stat_data) .
					'</p>
						</div>';
			}
			$output .= '
					</div>';
		}
		$output .= '
				</div>
			</div>
		</li>
	</ul>
</div>
';
	}
	return $output;
}

// Define SEO description
$description = 'The predictions show of Connected on Relay FM. ';
if ($rickies_data['type'] == 'annual' && $rickies_data['status'] == 'Ungraded') {
	// Annual and ungraded, so future
	$description .=
		'What will Apple announce in ' .
		strftime('%Y', $rickies_data['date']) .
		'? And who will become Keynote Chairman? Follow along with this interactive scorecard';
} elseif ($rickies_data['type'] == 'annual') {
	// Annual and graded, so past
	$description .=
		'What has Apple announced in ' .
		strftime('%Y', $rickies_data['date']) .
		'? And how did Myke, Stephen, and Federico perform with their yearly predictions?';
} elseif ($rickies_data['status'] == 'Ungraded') {
	// Ungraded, so future keynote
	$description .= 'What will Apple announced at the ';

	// if (!empty($rickies_data['details']['event_data']['label2'])) {
	// 	$description .= '“' . $rickies_data['details']['event_data']['label2'] . '” ';
	// }

	$description .=
		'keynote on ' .
		date_to_string_label($rickies_data['details']['event_data']['date']) .
		'? And who will become Annual Chairman? Follow along with this interactive scorecard.';
} else {
	// Graded keynote, past
	$description .= 'What has Apple announced at the ';
	// if (!empty($rickies_data['details']['event_data']['label2'])) {
	// 	$description .= '“' . $rickies_data['details']['event_data']['label2'] . '” ';
	// }
	$description .=
		'keynote on ' .
		date_to_string_label($rickies_data['details']['event_data']['date']) .
		'? And how did Myke, Stephen, and Federico perform with their predictions for this event?';
}

$head_custom = [
	'title' => $rickies_data['name'],
	'description' => $description,
	'keywords' => ['wwdc', 'keynote', 'risky picks', 'Flexies', 'charity', 'chairman'],
];

if ($rickies_data['status'] == 'Ungraded') {
	$head_custom['title'] = '🟠 ' . $head_custom['title'] . ' • Interactive scorecard';
}

if ($rickies_data['artwork']['seo'] !== false) {
	$head_custom['image'] = $rickies_data['artwork']['seo'];
}
