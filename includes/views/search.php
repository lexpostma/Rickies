<div id="statusbar"></div>
<header class="search">
	<div class="gradient"></div>
	<h1><?= $head_custom['title'] ?></h1>
	<?= pick_filter_element($pick_filter, false, $categories__array) ?>

</header>

<?php
echo no_script_banner();
if (empty($picks_data__array)) {
	if (!empty($pick_filter['search'])) {
		echo '<section id="results"><p>No predictions match ‘<mark>' .
			$pick_filter['search']['string'] .
			'</mark>’.</p></section>';
	} else {
		echo '<section id="results"><p>No predictions match these filters.</p></section>';
	}
} else {

	echo '<div id="results" class="avatar_leaderboard">';
	foreach ($picks_chart__array as $host => $chart) {
		echo '<div class="host with_chart">';
		if ($chart['Total'] === 0) {
			echo '<img src="/images/memoji-' . strtolower($host) . '-disabled.png" class="no_results" />';
			echo '<div class="avatar chart-container no_results">';
		} else {
			echo '<img src="/images/memoji-' . strtolower($host) . '-default.png" />';
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
		echo '</div>';
	}
	echo '</div>';
	echo '<script>' . score_chart_script($picks_chart__array, 'search', '78%') . '</script>';
	?>

<nav class="nav_container">
	<div id="statusbar"></div>
	<div id="nav_anchor"></div>
	<div id="nav_content">
		<div class="nav_content--items">
<?php
if (array_key_exists('Rickies', $picks_data__array)) { ?>
			<a class="menu_item js_link"
				id="menu_rickies"
				title="Rickies"
				data-goatcounter-click="Show Rickies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('rickies');">Rickies</a>
<?php }
if (array_key_exists('Flexies', $picks_data__array)) { ?>
			<a class="menu_item js_link"
				id="menu_flexies"
				title="Flexies"
				data-goatcounter-click="Show Flexies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('flexies');">Flexies</a>
<?php }
?>
			<a class="menu_item js_link"
				id="menu_top"
				title="Search at the top"
				onclick="window.scrollTo(0,0); document.getElementById('search_input').focus()"><?= file_get_contents(
    	$_SERVER['DOCUMENT_ROOT'] . '/images/button-menu-search.svg'
    ) ?></a>
		</div>
	</div>
</nav>
<div id="picks"><?= pick_item_bundle($picks_data__array, false, ['search', 'categories', 'buzzkill', 'age']) ?></div>
<?php
echo '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/navigation.js') . '</script>';

if (!empty($pick_filter['search'])) {
	echo '<script src="/scripts/mark.min.js"></script>';
	echo '<script>
		var context = document.getElementById("results"); // requires an element with class "results" to exist
		var instance = new Mark(context);
		var mark_options = {
			"separateWordSearch": false,
			"exclude": [
				".no_results",
				".tag",
			]
		};
		instance.mark("' .
		$pick_filter['search']['string'] .
		'", mark_options); // will mark the search string keywords
	</script>';
}

}

echo '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/filter.js') . '</script>';

