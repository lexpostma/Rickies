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
	$output = '<section class="large_columns"><div class="section_group">';
	$chart_script = '<script>';
	foreach ($input as $host_data) {
		$output .= leaderboard_item($host_data);
		$chart_script .= score_chart_script($host_data['stats']['picks'], $host_data['personal']['first_name']);
	}
	$chart_script .= '</script>';
	$output .= '</div></section>';
	return $output . $chart_script;
}

function leaderboard_item($host_data)
{
	// Open section
	$output = '<div class="section_group--list host_stats">';

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
		'<div class="host_item_content">
		<h3 id="' .
		strtolower($host_data['personal']['first_name']) .
		'">' .
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
		'</a></p>';

	// Title
	$output .= '<h4>Current titles</h4><ul>';

	// First show the priority titles
	$title_count = 0;
	foreach ($host_data['titles'] as $key => $value) {
		if (strpos($value, 'priority') !== false) {
			$output .= '<li>' . $value . '</li>';
			unset($host_data['titles'][$key]);
			$title_count++;
		}
	}
	// Shuffle and show random leftover titles, until the total is 5
	shuffle($host_data['titles']);
	foreach ($host_data['titles'] as $key => $value) {
		if ($title_count == 5) {
			break;
		} else {
			$output .= '<li>' . $value . '</li>';
			$title_count++;
		}
	}
	$output .= '</ul>';

	// Achievements
	$output .= '<h4>Achievements</h4>';
	$output .= score_label_item($host_data['achievements'], $host_data['personal']['color']);

	$output .= '<h4>Successes</h4>';
	$output .= score_label_item($host_data['stats']['events'], $host_data['personal']['color']);

	// Statistics
	$output .= '<h4>Picks</h4>';
	$output .= score_chart_item($host_data['stats']['picks'], strtolower($host_data['personal']['first_name']));
	$output .= score_label_item($host_data['stats']['picks_strings'], $host_data['personal']['color']);

	// Ahead of its time
	$output .= '<h4>Ahead of his time 🔮</h4>';
	$output .= score_label_item($host_data['stats']['too_soon'], $host_data['personal']['color'], true);

	// Coin flips
	$output .= '<h4>Coin flips 🪙</h4>';
	$output .= score_label_item($host_data['stats']['coin_flips'], $host_data['personal']['color'], true);

	// Close host and content
	$output .= '</div></div>';

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
	' graded</b> Rickies officially behind us, this is the leaderboard of overall wins, picks, risk, and <span title="Pokémon! 😉">flexing power (FP)</span> of the hosts of Connected.</p><p>The predictions charts and statistics also include picks from <b class="nowrap">' .
	digit_text($status_data__array['Ungraded']) .
	' ungraded</b> Rickies, and picks from ' .
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
