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
		');"><div class="gradient"></div>';
} elseif (array_key_exists('img_url', $rickies_data) && $rickies_data['artwork']['event'] == $rickies_data['img_url']) {
	// Image is same as Apple Event image, use as background cover
	echo '<header class="details" style="background-image: url(' .
		$rickies_data['img_url'] .
		');"><div class="gradient"></div>';
} elseif (array_key_exists('img_url', $rickies_data)) {
	// Image exists, no exceptions -> place image above the title
	echo '<header class="details contain_img"><div class="gradient"></div><img src="' .
		$rickies_data['img_url'] .
		'" />';
} elseif ($rickies_data['type'] == 'annual') {
	// No image, but Annual Rickies -> show year
	echo '<header class="details"><div class="gradient"></div><div class="big_year">' .
		strftime('%Y', $rickies_data['date']) .
		'</div>';
} else {
	// Else -> empty header
	echo '<header class="details"><div class="gradient"></div>';
}

// Add custom CSS is available
if ($rickies_data['custom_css'] !== false) {
	echo '<style>' . $rickies_data['custom_css'] . '</style>';
}
?>

	<h1>
<?php if ($rickies_data['type'] == 'keynote') {
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
	<div id="statusbar"></div>
	<div id="nav_anchor"></div>
	<div id="nav_content">
		<div class="nav_content--items">
<? if(array_key_exists('Rickies', $picks_data__array)) {?>
			<a class="menu_item"
				id="menu_rickies"
				href="#rickies"
				data-goatcounter-click="Show Rickies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('rickies');">The Rickies</a>
<? } if(array_key_exists('Flexies', $picks_data__array)) {?>
			<a class="menu_item"
				id="menu_flexies"
				href="#flexies"
				data-goatcounter-click="Show Flexies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('flexies');">The Flexies</a>
<? } ?>
			<a class="menu_item"
				id="menu_hosts"
				href="#hosts"
				data-goatcounter-click="Show hosts"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('hosts');">Hosts</a>
			<a class="menu_item"
				id="menu_details"
				href="#details"
				data-goatcounter-click="Show details"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('details');">Details</a>
			<a class="menu_item menu_fix"
				id="menu_back"
				title="Go back to Rickies overview"
				href="/"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-menu-back.svg') ?></a>
			<a class="menu_item menu_fix"
				id="menu_top"
				title="Scroll to the top"
				href="#top"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-menu-top.svg') ?></a>
		</div>
	</div>
</nav>

<?php
echo no_script_banner();
if ($rickies_data['status'] == 'Ungraded') {
	echo pick_item_bundle($picks_data__array, true);
} else {
	echo pick_item_bundle($picks_data__array);
}
?>

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

<script><? echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/navigation.js'); ?></script>

<?

// Change some strings to originals before the terms Rickies/Flexies were coined
if (
	$rickies_data['status'] == 'Pre-Rickies' ||
	$rickies_data['date'] < $rickies_start ||
	$rickies_data['date'] < $flexies_start
) {
	echo '<script>';

	if ($rickies_data['status'] == 'Pre-Rickies' || $rickies_data['date'] < $rickies_start) {
		echo "var rickies_alt = 'Predictions';";
	}

	if ($rickies_data['date'] < $flexies_start) {
		echo "var flexies_alt = 'Bragging Rights';";
	}

	echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/pre-rickies.js') . '</script>';
}
