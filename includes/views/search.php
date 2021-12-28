<div id="statusbar"></div>
<header class="search">
	<div class="gradient"></div>
	<h1><?= $head_custom['title'] ?></h1>
	<?= pick_filter_element($pick_filter, false, $categories__array, $rickies_events_options) ?>

</header>

<?php
if (!isset($triple_j)) {
	echo navigation_bar($url_view);
} else {
	echo navigation_bar($url_view, true);
}

echo no_script_banner();

if (empty($picks_data__array)) {
	if (!empty($pick_filter['search'])) {
		echo '<section id="results"><p>No predictions match ‘<mark>' .
			htmlentities($pick_filter['search']['string'], ENT_QUOTES, 'UTF-8') .
			'</mark>’.</p></section>';
	} else {
		echo '<section id="results"><p>No predictions match these filters.</p></section>';
	}
} else {

	// Define charts
	echo '<div id="results" class="avatar_leaderboard">';
	foreach ($picks_chart__array as $host => $chart) {
		echo '<div class="host with_chart">';
		if ($chart['Total'] === 0) {
			echo '<img src="/images/memoji/memoji-' . strtolower($host) . '-disabled.png" class="no_results" />';
			echo '<div class="avatar chart-container no_results">';
		} else {
			echo '<img src="/images/memoji/memoji-' . strtolower($host) . '-default.png" />';
			echo '<div class="avatar chart-container">';
		}

		echo '<canvas id="' . define_score_chart_id('search', $host) . '"></canvas></div>';
		echo '<span class="name">' . $host . '</span><span class="string">';
		switch ($chart['Total']) {
			case 0:
				echo 'No picks';
				break;
			case 1:
				echo '1 pick';
				break;
			default:
				echo $chart['Total'] . ' picks';
		}
		echo '</span>';
		if ($chart['Total'] !== 0) {
			$sub_title_string = '<span class="title">';

			// Number of correct picks
			if ($chart['Correct'] !== 0 && $chart['Correct'] == $chart['Total']) {
				$sub_title_string .= 'All&nbsp;correct';
			} elseif ($chart['Correct'] !== 0) {
				$sub_title_string .= $chart['Correct'] . '&nbsp;correct';
			}

			// Separator
			if ($chart['Correct'] !== 0 && $chart['Wrong'] + $chart['Eventually'] !== 0) {
				$sub_title_string .= ' • ';
			}

			// Number of wrong picks
			if ($chart['Wrong'] !== 0 && $chart['Wrong'] == $chart['Total']) {
				$sub_title_string .= 'All&nbsp;wrong';
			} elseif ($chart['Wrong'] + $chart['Eventually'] !== 0) {
				$sub_title_string .= $chart['Wrong'] + $chart['Eventually'] . '&nbsp;wrong';
			}

			// Number of picks ahead of its time
			if ($chart['Eventually'] === 1 && $chart['Eventually'] + $chart['Wrong'] === 1) {
				$sub_title_string .= ', which was ahead&nbsp;of its&nbsp;time';
			} elseif ($chart['Eventually'] !== 0 && $chart['Eventually'] == $chart['Eventually'] + $chart['Wrong']) {
				$sub_title_string .= ', all&nbsp;of which were ahead&nbsp;of its&nbsp;time';
			} elseif ($chart['Eventually'] === 1) {
				$sub_title_string .= ', ' . $chart['Eventually'] . '&nbsp;of which was ahead&nbsp;of its&nbsp;time';
			} elseif ($chart['Eventually'] !== 0) {
				$sub_title_string .= ', ' . $chart['Eventually'] . '&nbsp;of which were ahead&nbsp;of its&nbsp;time';
			}
			$sub_title_string .= '</span>';
			echo $sub_title_string;
			unset($sub_title_string);
		}
		echo '</div>';
	}
	echo '</div>';
	echo '<script>' . score_chart_script($picks_chart__array, 'search', '78%') . '</script>';
	?>

<nav class="nav_container">
	<div id="statusbar"></div>
	<div id="nav_anchor"></div>
	<div id="nav_content_sticky" class="nav_content">
		<div class="nav_content--items">
<?php
if (array_key_exists('Rickies', $picks_data__array)) { ?>
			<a class="menu_item js_link"
				id="menu_rickies"
				title="Rickies"
				data-goatcounter-click="Show Rickies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('rickies');"><?= $picks_type_count['Rickies'] ?></a>
<?php }
if (array_key_exists('Flexies', $picks_data__array)) { ?>
			<a class="menu_item js_link"
				id="menu_flexies"
				title="Flexies"
				data-goatcounter-click="Show Flexies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('flexies');"><?= $picks_type_count['Flexies'] ?></a>
<?php }
if (array_key_exists('Pickies', $picks_data__array)) { ?>
			<a class="menu_item js_link"
				id="menu_pickies"
				title="Pickies"
				data-goatcounter-click="Show Pickies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('pickies');"><?= $picks_type_count['Pickies'] ?></a>
<?php }
if (array_key_exists('Lightning Round', $picks_data__array)) { ?>
			<a class="menu_item js_link"
				id="menu_lightning_round"
				title="Lightning Rounds"
				data-goatcounter-click="Show Lightning Rounds"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('lightning_round');"><?= $picks_type_count['Lightning Round'] ?></a>
<?php }
?>
			<a class="menu_item js_link menu_top"
				title="Search at the top"
				onclick="window.scrollTo(0,0); document.getElementById('search_input').focus()"><?= file_get_contents(
    	$_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-menu-search.svg'
    ) ?></a>
			<a class="menu_item js_link menu_top"
				title="Scroll to the top"
				onclick="window.scrollTo(0,0);"><?= file_get_contents(
    	$_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-menu-top.svg'
    ) ?></a>
		</div>
	</div>
</nav>
<div id="picks"><?= pick_item_bundle($picks_data__array, false, $pick_display) ?></div>
<?php
echo '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/navigation.js') . '</script>';

if (!empty($pick_filter['search'])) {
	echo '<script src="/scripts/mark.min.js"></script>';
	echo '<script>
		var context = document.getElementById("picks"); // requires an element with class "results" to exist
		var instance = new Mark(context);
		var mark_options = {
			"separateWordSearch": false,
			"exclude": [
				".no_results",
				".tag",
			]
		};
		instance.mark("' .
		htmlentities($pick_filter['search']['string'], ENT_QUOTES, 'UTF-8') .
		'", mark_options); // will mark the search string keywords
	</script>';
}

}

echo '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/filter.js') . '</script>';

