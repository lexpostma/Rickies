<?php
// Define the header
if (
	array_key_exists('img_url', $rickies_data) &&
	$rickies_data['artwork']['rickies'] == $rickies_data['img_url'] &&
	$rickies_data['artwork_background_color'] !== false
) {
	// Image is custom Rickies image + color is set -> contain image, with background color
	echo '<header class="details custom color" style="background-color: ' .
		$rickies_data['artwork_background_color'] .
		'; background-image: url(' .
		$rickies_data['img_url'] .
		');">';
} elseif (array_key_exists('img_url', $rickies_data) && $rickies_data['artwork']['event'] == $rickies_data['img_url']) {
	// Image is same as Apple Event image, use as background cover
	echo '<header class="details" style="background-image: url(' . $rickies_data['img_url'] . ');">';
} elseif (array_key_exists('img_url', $rickies_data)) {
	// Image exists, no exceptions -> place image above the title
	echo '<header class="details contain_img"><img src="' . $rickies_data['img_url'] . '" />';
} elseif ($rickies_data['type'] == 'Annual Rickies') {
	// No image, but Annual Rickies -> show year
	echo '<header class="details"><div class="big_year">' . strftime('%Y', $rickies_data['date']) . '</div>';
} else {
	// Else -> empty header
	echo '<header class="details">';
} ?>


	<div class="gradient"></div>
	<h1>
<?php if ($rickies_data['type'] == 'Keynote Rickies') {
	echo str_lreplace(' ', '&nbsp;', $rickies_data['name']);
} else {
	echo $rickies_data['name'];
} ?>
	</h1>
</header>

<?php
if (array_key_exists('tag', $rickies_data)) {
	echo banner($rickies_data['tag_banner'], $rickies_data['tag_color']);
}

if ($rickies_data['ranking']['rickies'] !== []) {
	echo avatar_leaderboard($leaderboard_data);
}
?>

<nav class="nav_container">
	<div class="nav_anchor"></div>
	<div class="nav_content">
		<div class="nav_content--items">
<? if(array_key_exists('Rickies', $picks_data__array)) {?>
			<a class="menu_item"
				id="menu_rickies"
				href="<?= current_url() ?>#rickies"
				data-goatcounter-click="Show Rickies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('rickies');">The Rickies</a>
<? } if(array_key_exists('Flexies', $picks_data__array)) {?>
			<a class="menu_item"
				id="menu_flexies"
				href="<?= current_url() ?>#flexies"
				data-goatcounter-click="Show Flexies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('flexies');">The Flexies</a>
<? } ?>
			<a class="menu_item"
				id="menu_hosts"
				href="<?= current_url() ?>#hosts"
				data-goatcounter-click="Show hosts"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('hosts');">Hosts</a>
			<a class="menu_item"
				id="menu_details"
				href="<?= current_url() ?>#details"
				data-goatcounter-click="Show details"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('details');">Details</a>
		</div>
	</div>
</nav>

<?= no_script_banner(), pick_item_bundle($picks_data__array) ?>

<section class="navigate_with_mobile_menu large_columns" id="hosts">
	<h2>Hosts</h2>
	<div class="section_group">
	<?= host_item_bundle($rickies_data['hosts'], $rickies_data['type']) ?>
	</div>
</section>

<section class="navigate_with_mobile_menu large_columns" id="details">
	<h2>Details</h2>

	<div class="section_group">
<?= list_item_bundle($rickies_data['details']) ?>
	</div>
</section>

<script><? include("scripts/navigation.js"); ?></script>