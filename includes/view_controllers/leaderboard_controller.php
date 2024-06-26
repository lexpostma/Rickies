<?php

// Host Leaderboard _view_ controller

$hosts_data__params = [
	'sort' => [['field' => 'Order', 'direction' => 'asc']],
];

if (!isset($triple_j)) {
	$hosts_data__params['filterByFormula'] = 'AND( {Host type} = "Official" )';
} else {
	$hosts_data__params['filterByFormula'] = 'AND( {Host type} = "Triple J" )';
}

$all_host_details = true;

include '../includes/data_controllers/hosts_data_controller.php';
include '../includes/data_controllers/status_data_controller.php';

function leaderboard_item_bundle($input, $triple_j = false)
{
	$output =
		'<section class="large_columns navigate_with_mobile_menu" id="stats"><h2>Host Stats</h2><div class="section_grid">';
	$chart_script = '<script>';
	$column = 1;
	foreach ($input as $host_data) {
		$output .= leaderboard_item($host_data, $column, $triple_j);
		$chart_script .= score_chart_script($host_data['stats']['picks'], $host_data['personal']['first_name']);
		$column++;
	}
	unset($column);
	$chart_script .= '</script>';
	$output .= '</div></section>';
	return $output . $chart_script;
}

function host_titles($title_array)
{
	$output = '<ul>';
	// First show the priority titles
	$title_count = 0;
	foreach ($title_array as $key => $value) {
		if (strpos($value, 'priority') !== false) {
			$output .= '<li>' . $value . '</li>';
			unset($title_array[$key]);
			$title_count++;
		}
	}
	// Shuffle and show random leftover titles, until the total is 4
	shuffle($title_array);
	foreach ($title_array as $key => $value) {
		if ($title_count == 4) {
			break;
		} else {
			$output .= '<li>' . $value . '</li>';
			$title_count++;
		}
	}
	$output .= '</ul>';
	return $output;
}

function host_stats_item($title, $content, $column, $host)
{
	return '
		<div class="host_stats column' .
		$column .
		' column_' .
		strtolower($host) .
		'">
			<h4>' .
		$title .
		'</h4>
			' .
		$content .
		'
		</div>';
}

function leaderboard_item($host_data, $column = 1, $triple_j = false)
{
	// Open section
	// $output = '<div class="section_group--list host_stats">';
	$output =
		'<div id="' .
		strtolower($host_data['personal']['first_name']) .
		'" class="host_stats column' .
		$column .
		' column_' .
		strtolower($host_data['personal']['first_name']) .
		' host_byline">';

	// Add avatar
	$img_array = [
		'type' => 'avatar',
		'name' => $host_data['personal']['first_name'],
		'src' => $host_data['images']['memoji']['neutral'],
		'color' => $host_data['personal']['color'],
	];
	$output .= list_item_graphic($img_array);

	// Name and personal details
	$output .=
		'<h3>' .
		$host_data['personal']['full_name'] .
		'</h3><p>' .
		$host_data['personal']['location'] .
		// ' • <a target="_blank" href="' .
		// $host_data['personal']['twitter_url'] .
		// '"
		// data-goatcounter-click="' .
		// $host_data['personal']['twitter_url'] .
		// '"
		// title="Go to @' .
		// $host_data['personal']['twitter'] .
		// '"
		// data-goatcounter-referrer="' .
		// current_url() .
		// '">@' .
		// $host_data['personal']['twitter'] .
		// '</a>' .
		' • <a target="_blank" class="nowrap" href="' .
		$host_data['personal']['website_url'] .
		'"
		data-goatcounter-click="' .
		$host_data['personal']['website_url'] .
		'"
		title="Visit ' .
		$host_data['personal']['website_name'] .
		'"
		data-goatcounter-referrer="' .
		current_url() .
		'">' .
		$host_data['personal']['website_name'] .
		'</a></p></div>';

	// Core Titles
	$output .= host_stats_item(
		'Current titles',
		host_titles($host_data['titles']),
		$column,
		$host_data['personal']['first_name']
	);

	// Other Titles
	$output .= host_stats_item(
		'Other titles',
		host_titles($host_data['titles_other']),
		$column,
		$host_data['personal']['first_name']
	);
	if (!$triple_j) {
		// Achievements
		$output .= host_stats_item(
			'Achievements',
			score_label_item($host_data['achievements'], $host_data['personal']['color']),
			$column,
			$host_data['personal']['first_name']
		);

		$output .= host_stats_item(
			'Rickies',
			score_label_item($host_data['stats']['rickies'], $host_data['personal']['color']),
			$column,
			$host_data['personal']['first_name']
		);

		$output .= host_stats_item(
			'Flexies',
			score_label_item($host_data['stats']['flexies'], $host_data['personal']['color']),
			$column,
			$host_data['personal']['first_name']
		);
	}
	// Statistics
	$output .= host_stats_item(
		'Picks',
		score_chart_item($host_data['stats']['picks'], strtolower($host_data['personal']['first_name'])) .
			score_label_item($host_data['stats']['picks_strings'], $host_data['personal']['color']),
		$column,
		$host_data['personal']['first_name']
	);

	// Ahead of its time
	$output .= host_stats_item(
		'<span class="emoji pulse_orb" style="animation-delay: ' . rand(-2000, 0) . 'ms;">🔮</span>Ahead of his time',
		score_label_item($host_data['stats']['too_soon'], $host_data['personal']['color'], true),
		$column,
		$host_data['personal']['first_name']
	);

	// Coin flips
	$output .= host_stats_item(
		'<span class="emoji rotate_coin"><span style="animation-delay: ' .
			rand(-3000, 0) .
			'ms;">🪙</span></span>Coin flips',
		score_label_item($host_data['stats']['coin_flips'], $host_data['personal']['color'], true),
		$column,
		$host_data['personal']['first_name']
	);

	// Close host and content
	// $output .= '</div></div>';
	// $output .= '</div>';

	return $output;
}

function score_label_item($array, $color, $display_as_paragraph = false)
{
	$output = '<table class="full_stats" style="--highlight-color: var(--connected-' . $color . ');">';
	if ($display_as_paragraph) {
		$output .= '<tr><td colspan="2" class="string">';
	}
	foreach ($array as $stat) {
		if ($display_as_paragraph) {
			if ($stat['value'] !== false && !($stat['value'] == 0 && array_key_exists('0hide', $stat))) {
				$output .= $stat['string'] . ' ';
			}
		} else {
			if ($stat['value'] !== false && !($stat['value'] == 0 && array_key_exists('0hide', $stat))) {
				if ($stat['value'] == 1 && array_key_exists('label1', $stat)) {
					$stat['label'] = $stat['label1'];
				}
				if (array_key_exists('unit', $stat)) {
					if ($stat['unit'] == '%') {
						$stat['value'] = $stat['value'] . '%';
					} elseif ($stat['unit'] == '$') {
						$stat['value'] = '$' . $stat['value'];
					} elseif ($stat['value'] == 1 && array_key_exists('unit1', $stat)) {
						$stat['value'] = $stat['value'] . $stat['unit1'];
					} else {
						$stat['value'] = $stat['value'] . $stat['unit'];
					}
				}
				$output .=
					'<tr>
				<td class="value">' .
					$stat['value'] .
					'</td>
				<td>' .
					$stat['label'] .
					'</td>
				</tr>';
			}
		}
	}
	if ($display_as_paragraph) {
		$output .= '</td></tr>';
	}

	$output .= '</table>';
	return $output;
}

function frequent_in_array($array, $amount = 2, $sort = 'desc')
{
	$cat_groups = ['Hardware', 'Software', 'Services', 'People'];

	// Remove the groups from the array
	// Via https://stackoverflow.com/a/10455129
	$clean_array = array_diff($array, $cat_groups);

	// Get most frequent values
	// Via https://stackoverflow.com/a/30626836
	$values = array_count_values($clean_array);
	if ($sort == 'desc') {
		arsort($values);
	} else {
		asort($values);
	}

	return array_slice(array_keys($values), 0, $amount, true);
}

// Define the data for the leaderboard at the top of the page
$leaderboard_data = [];
foreach ($hosts_data__array as $host) {
	// First show all priority titles
	// $title_count = 0;
	$title_array = [];
	foreach ($host['titles'] as $key => $value) {
		if (strpos($value, 'priority') !== false) {
			$title_array[] = $value;
			unset($host['titles'][$key]);
		}
	}
	// Show next titles, until the total is 2
	foreach ($host['titles'] as $key => $value) {
		if (count($title_array) < 2) {
			$title_array[] = $value;
			unset($host['titles'][$key]);
		} else {
			break;
		}
	}
	if (!isset($triple_j)) {
		$string =
			'Won ' .
			($host['achievements']['annual_rickies_wins']['value'] +
				$host['achievements']['keynote_rickies_wins']['value']) .
			" Rickies<br />
	" .
			$host['stats']['picks']['Overall']['Rate'] .
			"% correct picks<br />
	" .
			$host['stats']['picks_strings']['scored_points']['value'] .
			'&nbsp;points • <span class="nowrap" title="Flexing Power">' .
			$host['stats']['picks_strings']['correct_flexies']['value'] .
			' FP</span>';
	} else {
		$string =
			$host['stats']['picks']['Overall']['Rate'] .
			"% correct picks<br />
		" .
			$host['stats']['picks_strings']['scored_points']['value'] .
			'&nbsp;points • <span class="nowrap" title="Lightning Power">' .
			$host['stats']['picks_strings']['correct_flexies']['value'] .
			' LP</span>';
	}
	$set = [
		'name' => $host['personal']['first_name'],
		'winner' => false,
		'title' => implode('<br />', $title_array),
		'string' => $string,
		'img_array' => [
			'type' => 'avatar',
			'name' => $host['personal']['first_name'],
			'src' => $host['images']['memoji']['happy'],
			'color' => $host['personal']['color'],
		],
	];
	unset($string);

	if (
		strpos($set['title'], 'Mega Chairman') !== false ||
		strpos($set['title'], 'Consolidated Champion') !== false ||
		strpos($set['title'], 'Ricky Benchman') !== false ||
		(strpos($set['title'], 'Apple Park Prince') && strpos($set['title'], 'Admiral Pickerton'))
	) {
		// Combined winner
		$set['winner'] = 2;
	} elseif (
		strpos($set['title'], 'chairman') !== false ||
		strpos($set['title'], 'Shindig King') ||
		strpos($set['title'], 'Apple Park Prince') ||
		strpos($set['title'], 'Admiral Pickerton')
	) {
		// Single winner
		$set['winner'] = true;
	}

	array_push($leaderboard_data, $set);
}

$head_custom = [
	'keywords' => ['leaderboard', 'achievement', 'statistics', 'titles', 'timeline'],
	'theme-color' => '#222c32',
];

if (!isset($triple_j)) {
	include_once $incl_path . 'timeline_functions.php';

	$introduction =
		'<p>With <b>' .
		$status_data__array['Completed']['rickies'] .
		' graded</b> Rickies officially behind us, this is the leaderboard of overall wins, picks, risk, and <span title="Pokémon! 😉">flexing power (FP)</span> of the hosts of Connected.</p><p>The predictions charts and statistics include picks from all Rickies, including the <a href="/latest-keynote">latest Keynote Rickies</a> and <a href="/latest-annual">Annual Rickies</a>, picks from <a href="/ungraded"><b class="nowrap">' .
		digit_text($status_data__array['Ungraded']['rickies'] + $status_data__array['Live']['rickies']) .
		' ungraded</b></a> Rickies, and picks from ' .
		digit_text($status_data__array['Total']['pre-rickies']) .
		' earlier prediction episodes that predate the (<a href="/billof/keynote-sep-2018" title="The Bill of Rickies">Bill of</a>) Rickies as partial points had been awarded.</p>';

	$head_custom['title'] = 'Host Leaderboard • The Rickies';
	$head_custom['description'] =
		'Charts, statistics, flexing power and other wonderful insights into the Rickies achievements of the Connected hosts.';
	$head_custom['image'] = domain_url() . '/images/seo/hero-leaderboard.jpg';
} else {
	$introduction =
		'<p>This is the leaderboard of overall wins, picks, fractions, and <span title="Pokémon! 😉">lightning power (LP)</span> of the Triple J. The predictions charts and statistics include picks from all Pickies.</p>';

	$head_custom['title'] = 'Triple J Leaderboard • The Pickies';
	$head_custom['description'] =
		'Charts, statistics, lightning power and other wonderful insights into the Pickies achievements of the Triple J.';
	$head_custom['image'] = domain_url() . '/images/seo/hero-3j-leaderboard.jpg';
}
