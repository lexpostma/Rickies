<?php

// Host Leaderboard _view_ controller

$hosts_data__params = [
	'sort' => [['field' => 'Order', 'direction' => 'asc']],
];
$all_host_details = true;

include '../includes/data_controllers/hosts_data_controller.php';
include '../includes/data_controllers/status_data_controller.php';

function leaderboard_item_bundle($input)
{
	$output =
		'<section class="large_columns navigate_with_mobile_menu leaderboard"><h2>Host Stats</h2><div class="section_grid">';
	$chart_script = '<script>';
	$column = 1;
	foreach ($input as $host_data) {
		$output .= leaderboard_item($host_data, $column);
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

function host_stats_item($title, $content, $column)
{
	return '
		<div class="host_stats column' .
		$column .
		'">
			<h4>' .
		$title .
		'</h4>
			' .
		$content .
		'
		</div>';
}

function leaderboard_item($host_data, $column = 1)
{
	// Open section
	// $output = '<div class="section_group--list host_stats">';
	$output =
		'<div id="' .
		strtolower($host_data['personal']['first_name']) .
		'" class="host_stats column' .
		$column .
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
		' • <a target="_blank" href="' .
		$host_data['personal']['twitter_url'] .
		'"
		data-goatcounter-click="' .
		$host_data['personal']['twitter_url'] .
		'"
		title="Go to @' .
		$host_data['personal']['twitter'] .
		'"
		data-goatcounter-referrer="' .
		current_url() .
		'">@' .
		$host_data['personal']['twitter'] .
		'</a>' .
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
	$output .= host_stats_item('Current titles', host_titles($host_data['titles']), $column);

	// Other Titles
	$output .= host_stats_item('Other titles', host_titles($host_data['titles_other']), $column);

	// Achievements
	$output .= host_stats_item(
		'Achievements',
		score_label_item($host_data['achievements'], $host_data['personal']['color']),
		$column
	);

	$output .= host_stats_item(
		'Rickies',
		score_label_item($host_data['stats']['rickies'], $host_data['personal']['color']),
		$column
	);

	$output .= host_stats_item(
		'Flexies',
		score_label_item($host_data['stats']['flexies'], $host_data['personal']['color']),
		$column
	);

	// Statistics
	$output .= host_stats_item(
		'Picks',
		score_chart_item($host_data['stats']['picks'], strtolower($host_data['personal']['first_name'])) .
			score_label_item($host_data['stats']['picks_strings'], $host_data['personal']['color']),
		$column
	);

	// Ahead of its time
	$output .= host_stats_item(
		'<span class="emoji pulse_orb" style="animation-delay: ' . rand(-2000, 0) . 'ms;">🔮</span>Ahead of his time',
		score_label_item($host_data['stats']['too_soon'], $host_data['personal']['color'], true),
		$column
	);

	// Coin flips
	$output .= host_stats_item(
		'<span class="emoji rotate_coin"><span style="animation-delay: ' .
			rand(-3000, 0) .
			'ms;">🪙</span></span>Coin flips',
		score_label_item($host_data['stats']['coin_flips'], $host_data['personal']['color'], true),
		$column
	);

	// Close host and content
	// $output .= '</div></div>';
	// $output .= '</div>';

	return $output;
}

function score_label_item($array, $color, $display_as_paragraph = false)
{
	$output = '<table class="full_stats">';
	if ($display_as_paragraph) {
		$output .= '<tr><td colspan="2" class="string" style="--highlight-color: var(--connected-' . $color . ');">';
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
				<td class="value" style="color: var(--connected-' .
					$color .
					');">' .
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

function chairman_timeline($host_data = [], $event_data = [])
{
	$months = [
		'January' => 31,
		'February' => 28,
		'March' => 31,
		'April' => 30,
		'May' => 31,
		'June' => 30,
		'July' => 31,
		'August' => 31,
		'September' => 30,
		'October' => 31,
		'November' => 30,
		'December' => 31,
	];
	$start = 1;
	$output = '
<section class="large_columns navigate_with_mobile_menu leaderboard">
	<div id="timeline" class="timeline--container">
		<h2>Chairman Timeline</h2>
		<div class="timeline--content">
			<div class="timeline--host-track legend">';
	foreach ($months as $month_name => $days) {
		$output .=
			'<div class="month" style="left: calc(' .
			$start .
			' * var(--day-width)); width: calc(' .
			$days .
			' * var(--day-width));">' .
			$month_name .
			'</div>';
		$start = $start + $days;
	}
	$output .= '</div>
			<div class="timeline--host-track host1">
				<div class="timeline--chairman annual">
					<div class="chairman" style="left: calc(107 * var(--day-width)); width: calc(4 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(40 * var(--day-width)); width: calc(3 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(70 * var(--day-width)); width: calc(2 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(102 * var(--day-width)); width: calc(4 * var(--day-width));"></div>
				</div>
				<div class="timeline--chairman keynote">
					<div class="chairman" style="left: calc(10 * var(--day-width)); width: calc(4 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(40 * var(--day-width)); width: calc(3 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(50 * var(--day-width)); width: calc(2 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(96 * var(--day-width)); width: calc(4 * var(--day-width));"></div>
				</div>
			</div>
			<div class="timeline--host-track host2">
				<div class="timeline--chairman annual">
					<div class="chairman" style="left: calc(157 * var(--day-width)); width: calc(4 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(45 * var(--day-width)); width: calc(3 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(72 * var(--day-width)); width: calc(2 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(128 * var(--day-width)); width: calc(4 * var(--day-width));"></div>
				</div>
				<div class="timeline--chairman keynote">
					<div class="chairman" style="left: calc(25 * var(--day-width)); width: calc(4 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(52 * var(--day-width)); width: calc(3 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(98 * var(--day-width)); width: calc(2 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(130 * var(--day-width)); width: calc(4 * var(--day-width));"></div>
				</div>
			</div>
			<div class="timeline--host-track host3">
				<div class="timeline--chairman annual">
					<div class="chairman" style="left: calc(137 * var(--day-width)); width: calc(4 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(46 * var(--day-width)); width: calc(3 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(73 * var(--day-width)); width: calc(2 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(122 * var(--day-width)); width: calc(4 * var(--day-width));"></div>
				</div>
				<div class="timeline--chairman keynote">
					<div class="chairman" style="left: calc(175 * var(--day-width)); width: calc(4 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(43 * var(--day-width)); width: calc(3 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(76 * var(--day-width)); width: calc(2 * var(--day-width));"></div>
					<div class="chairman" style="left: calc(120 * var(--day-width)); width: calc(4 * var(--day-width));"></div>
				</div>
			</div>
		</div>
	</div>
</section>';
	return $output;
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

	$set = [
		'name' => $host['personal']['first_name'],
		'winner' => false,
		'title' => implode('<br />', $title_array),
		'string' =>
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
			' FP</span>',
		'img_array' => [
			'type' => 'avatar',
			'name' => $host['personal']['first_name'],
			'src' => $host['images']['memoji']['happy'],
			'color' => $host['personal']['color'],
		],
	];
	if (strpos($set['title'], 'Mega Chairman') !== false || strpos($set['title'], 'Consolidated Champion') !== false) {
		$set['winner'] = 2;
	} elseif (strpos($set['title'], 'chairman') !== false) {
		$set['winner'] = true;
	}

	array_push($leaderboard_data, $set);
}

$introduction =
	'<p>With <b>' .
	$status_data__array['Completed'] .
	' graded</b> Rickies officially behind us, this is the leaderboard of overall wins, picks, risk, and <span title="Pokémon! 😉">flexing power (FP)</span> of the hosts of Connected.</p><p>The predictions charts and statistics include picks from all Rickies, including the <a href="/latest-keynote">latest Keynote Rickies</a> and <a href="/latest-annual">Annual Rickies</a>, picks from <a href="/ungraded"><b class="nowrap">' .
	digit_text($status_data__array['Ungraded']) .
	' ungraded</b></a> Rickies, and picks from ' .
	digit_text($status_data__array['Pre-Rickies']) .
	' earlier prediction episodes that predate the (<a href="/billof/keynote-sep-2018" title="The Bill of Rickies">Bill of</a>) Rickies as partial points had been awarded.</p>';

$head_custom = [
	'title' => 'Host Leaderboard • The Rickies',
	'description' =>
		'Charts, statistics, flexing power and other wonderful insights into the Rickies achievements of the Connected hosts.',
	'keywords' => ['leaderboard', 'achievement', 'statistics', 'titles'],
	'image' => domain_url() . '/images/hero-leaderboard.jpg',
	'theme-color' => '#222c32',
];
