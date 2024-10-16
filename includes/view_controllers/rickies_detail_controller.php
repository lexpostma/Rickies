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
		'Jason' => 'Document Maintainer',
		'John' => 'One True John',
		'James' => 'The Dicy One',
		'ChatGPT' => 'AI Competition',
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
		if (!isset($triple_j)) {
			$added_host['title'][] = chairman_url($rickies_data['type']);
		} else {
			$added_host['title'][] = chairman_url($rickies_data['type'], true);
		}
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

	// If there's a Flexies ranking, and host is #1 -> Add title
	if ($host['flexies']['ranking'] !== false && $host['flexies']['ranking'] == 0) {
		$added_host['title'][] = $host['details']['flexy_title'];
	}

	// If there's a Flexies ranking, host is #1 and there is a charity -> Add title
	if (
		$host['flexies']['ranking'] !== false &&
		$host['flexies']['ranking'] == 0 &&
		array_key_exists('link_data_charity', $rickies_data['details'])
	) {
		$added_host['title'][] = 'Charity Chooser';
	} elseif ($host['flexies']['ranking'] !== false && $host['flexies']['ranking'] == 2) {
		// If there's a Flexies ranking, host is #3 and there is a charity -> Add title
		if (array_key_exists('link_data_charity', $rickies_data['details'])) {
			$added_host['title'][] = 'Generous Donor';
		}

		// If there's a Rickies ranking, host is not #1 there -> show sad memoji
		if ($host['rickies']['ranking'] !== false && $host['rickies']['ranking'] !== 0) {
			$added_host['img_array']['src'] = $host['details']['memoji']['sad'];
		}
	}

	// Fill title with default if empty
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

function host_item_bundle($host_event_data, $event_type, $triple_j = false)
{
	$output = '<section class="navigate_with_mobile_menu large_columns" id="hosts">
	<h2>Hosts</h2>
	<div class="section_group">
';

	$html_strings = [];

	foreach ($host_event_data as $host_event_key => $event_details) {
		$html_strings['ranking'] = [];
		if (!$triple_j) {
			if ($event_details['rickies']['ranking'] !== false && $event_details['rickies']['ranking'] == 0) {
				array_push(
					$html_strings['ranking'],
					'<b class="nowrap">Rickies winner</b> • ' . chairman_url($event_type)
				);
			} elseif ($event_details['rickies']['ranking'] !== false) {
				array_push(
					$html_strings['ranking'],
					'<span class="nowrap">Rickies ' .
						digit_placement($event_details['rickies']['ranking'] + 1) .
						' place</span>'
				);
			}

			if ($event_details['flexies']['ranking'] !== false && $event_details['flexies']['ranking'] == 0) {
				array_push(
					$html_strings['ranking'],
					'<span class="nowrap">' . $event_details['details']['flexy_title'] . '</span>'
				);
			} elseif ($event_details['flexies']['ranking'] == 2) {
				array_push($html_strings['ranking'], '<span class="nowrap">Flexies loser</span>');
			}

			array_push(
				$html_strings['ranking'],
				'<span class="nowrap">Picked ' .
					digit_placement($event_details['details']['round_robin'] + 1) .
					'</span>'
			);

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
				} elseif ($event_details['rickies']['coin_toss_loser']) {
					// Host is 2nd place and lost the coin flip
					array_push($html_strings['stats']['🏆 Rickies'], 'Lost by coin flip');
				}

				if ($event_details['rickies']['coin_toss_winner'] && $event_details['rickies']['ranking'] == 1) {
					// Host is 2nd place and won the coin flip
					array_push($html_strings['stats']['🏆 Rickies'], 'Saved by coin flip');
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
		} else {
			if ($event_details['rickies']['ranking'] !== false && $event_details['rickies']['ranking'] == 0) {
				array_push(
					$html_strings['ranking'],
					'<b class="nowrap">Pickies winner</b> • ' . chairman_url($event_type, true)
				);
			} elseif ($event_details['rickies']['ranking'] !== false) {
				array_push(
					$html_strings['ranking'],
					'<span class="nowrap">Pickies ' .
						digit_placement($event_details['rickies']['ranking'] + 1) .
						' place</span>'
				);
			}

			array_push(
				$html_strings['ranking'],
				'<span class="nowrap">Picked ' .
					digit_placement($event_details['details']['round_robin'] + 1) .
					'</span>'
			);

			$html_strings['stats'] = [];
			if ($event_details['rickies']['count'] !== 0) {
				$html_strings['stats']['🏆 Pickies'] = [
					$event_details['rickies']['correct'] . '/' . $event_details['rickies']['count'] . ' correct',
				];

				// TODO: Add stat about point doubler
				// if ($event_details['rickies']['risky_correct']) {
				// 	array_push($html_strings['stats']['🏆 Rickies'], 'Risky Pick correct!');
				// } else {
				// 	array_push($html_strings['stats']['🏆 Rickies'], 'Risky Pick too risky');
				// }

				// Add stat about points
				array_push($html_strings['stats']['🏆 Pickies'], plural_points($event_details['rickies']['points']));

				// TODO: Add stats about Pickies coin flips
				// if ($event_details['rickies']['coin_toss_winner'] && $event_details['rickies']['ranking'] == 0) {
				// 	// Host won the Rickies and the coin flip
				// 	array_push($html_strings['stats']['🏆 Rickies'], 'Won by coin flip');
				// 	// } elseif ($event_details['rickies']['coin_toss_winner'] && $event_details['rickies']['ranking'] == 1) {
				// 	// 	// Host is 2nd place and won the coin flip
				// 	// 	array_push($html_strings['stats']['🏆 Rickies'], 'Saved by coin flip');
				// } elseif ($event_details['rickies']['coin_toss_loser'] && $event_details['rickies']['ranking'] == 1) {
				// 	// Host is 2nd place and lost the coin flip
				// 	array_push($html_strings['stats']['🏆 Rickies'], 'Lost by coin flip');
				// }
			}
		}
		$avatar_img_array = [
			'type' => 'avatar',
			'name' => $event_details['details']['first_name'],
			'src' => $event_details['details']['memoji']['neutral'],
			'color' => $event_details['details']['color'],
		];

		if (!$triple_j) {
			$leaderboard_url = '/leaderboard#' . strtolower($event_details['details']['first_name']);
		} else {
			$leaderboard_url = '/3j-leaderboard#' . strtolower($event_details['details']['first_name']);
		}

		$output .=
			'
<div class="section_group--list">
	<ul class="list_item_group">
		<li class="list_item host_details">
			<div class="list_item_content">' .
			list_item_graphic($avatar_img_array) .
			'
				<div class="list_item_labels">
					<h3><a href="' .
			$leaderboard_url .
			'">' .
			$event_details['details']['full_name'] .
			'</a></h3>
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
	$output .= '	</div>
	</section>
	';
	return $output;
}

// Define SEO description
$description = 'The predictions show of Connected on Relay. ';
if (!isset($triple_j)) {
	$host_string = 'Myke, Stephen, and Federico';
	$annual_chairman = 'Annual Chairman';
	$keynote_chairman = 'Keynote Chairman';
} else {
	$host_string = 'the Triple J';
	$annual_chairman = 'Grand Admiral Pickerton';
	$keynote_chairman = 'Cupertino Shindig King';
}

if (
	$rickies_data['type'] == 'annual' &&
	($rickies_data['status'] == 'Ungraded' ||
		$rickies_data['status'] == 'Live' ||
		$rickies_data['status'] == 'Pending' ||
		$rickies_data['status'] == 'Preview')
) {
	// Annual and ungraded, so future
	$description .=
		'What will Apple announce in ' .
		$rickies_data['annual_year'] .
		'? And who will become ' .
		$annual_chairman .
		'?';
} elseif ($rickies_data['type'] == 'annual') {
	// Annual and graded, so past
	$description .=
		'What has Apple announced in ' .
		$rickies_data['annual_year'] .
		'? And how did ' .
		$host_string .
		' perform with their yearly predictions?';
} elseif (
	$rickies_data['special'] == 'EUies' &&
	($rickies_data['status'] == 'Ungraded' ||
		$rickies_data['status'] == 'Live' ||
		$rickies_data['status'] == 'Pending' ||
		$rickies_data['status'] == 'Preview')
) {
	// EUies and ungraded, so future
	$description .= 'How will Apple deal with the DMA in the European Union this time?';
} elseif ($rickies_data['special'] == 'EUies') {
	// EUies and graded, past
	$description .= 'How did Apple deal with the DMA in the European Union this time?';
} elseif (
	$rickies_data['status'] == 'Ungraded' ||
	$rickies_data['status'] == 'Live' ||
	$rickies_data['status'] == 'Pending' ||
	$rickies_data['status'] == 'Preview'
) {
	// Ungraded, so future keynote
	$description .=
		'What will Apple announce at the keynote on ' .
		date_to_string_label($rickies_data['details']['link_data_apple']['date'], false, true, false, false, false) .
		'? And who will become ' .
		$keynote_chairman .
		'?';
} else {
	// Graded keynote, past
	$description .=
		'What has Apple announced at the keynote on ' .
		date_to_string_label($rickies_data['details']['link_data_apple']['date'], false, true, false, false, false) .
		'? And how did ' .
		$host_string .
		' perform with their predictions for this event?';
}
if ($rickies_data['interactive']) {
	$description .= ' Follow along with this interactive scorecard.';
}

unset($host_string, $annual_chairman, $keynote_chairman);

$head_custom = [
	'title' => $rickies_data['name'],
	'description' => $description,
	'keywords' => ['wwdc', 'keynote', 'risky picks', 'Flexies', 'charity', 'chairman'],
];

switch ($rickies_data['status']) {
	case 'Ungraded':
		$head_custom['title'] = '🟠 ' . $head_custom['title'];
		if ($rickies_data['interactive']) {
			$head_custom['title'] = $head_custom['title'] . ' • Interactive scorecard';
		}
		break;
	case 'Live':
		$head_custom['title'] = '🔴 ' . $head_custom['title'] . ' • Live now';
		if ($rickies_data['interactive']) {
			$head_custom['title'] = $head_custom['title'] . ', interactive scorecard';
		}
		break;
	case 'Preview':
		$head_custom['title'] = '👁 ' . $head_custom['title'] . ' [PREVIEW]';
		break;
}

if ($rickies_data['artwork']['seo'] !== false) {
	$head_custom['image'] = $rickies_data['artwork']['seo'];
} elseif ($rickies_data['special'] == 'EUies') {
	$head_custom['image'] = domain_url() . '/images/seo/hero-euies-detail.jpg';
}

if ($rickies_data['artwork_background_color'] !== false) {
	$head_custom['theme-color'] = $rickies_data['artwork_background_color'];
} elseif ($rickies_data['special'] == 'EUies') {
	$head_custom['theme-color'] = '#001489';
}

if ($rickies_data['special'] == 'EUies') {
	$head_custom['keywords'] = ['EU', 'European Union', 'Digital Markets Act', 'DMA'];
}
