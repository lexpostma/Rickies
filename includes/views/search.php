<div id="statusbar"></div>
<header class="search">
	<div class="gradient"></div>
	<h1><?= $head_custom['title'] ?></h1>
	<?= search_field($query) ?>

</header>


<?php
echo no_script_banner();
if (empty($picks_data__array)) {
	echo '<section class="results">No predictions match ‘<mark>' . $query . '</mark>’.</section>';
} else {
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
<div class="search_results"><?= pick_item_bundle($picks_data__array, false, true) ?></div>
<?php
echo '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/navigation.js') . '</script>';
echo '<script src="/scripts/mark.min.js"></script>';
echo '<script>
	var context = document.querySelector(".search_results"); // requires an element with class "search_results" to exist
	var instance = new Mark(context);
	instance.mark("' .
	$query .
	'"); // will mark the keyword "$query"
</script>';

}

