<?php
// Add custom CSS if available
if ($rickies_data['custom_css'] !== false) {
	echo '<style>' . $rickies_data['custom_css'] . '</style>';
}

// Define the header
if ($rickies_data['artwork']['hero'] !== false && $rickies_data['artwork_background_color'] !== false) {
	// Hero image is set + color is set -> contain image, with background color
	echo '<header class="details custom color" style="background-color: ' .
		$rickies_data['artwork_background_color'] .
		'; background-image: url(' .
		$rickies_data['artwork']['hero'] .
		');"><div class="gradient"></div>';
} elseif ($rickies_data['artwork']['hero'] !== false) {
	// Hero image is set, but no background color -> use image to fill header
	echo '<header class="details" style="background-image: url(' .
		$rickies_data['artwork']['hero'] .
		');"><div class="gradient"></div>';
} elseif (key_exists('img_url', $rickies_data) && $rickies_data['artwork_background_color'] !== false) {
	// Some other image is set + color is set -> place image above title, with background color
	echo '<header class="details contain_img custom color" style="background-color: ' .
		$rickies_data['artwork_background_color'] .
		'; "><div class="gradient"></div><img src="' .
		$rickies_data['img_url'] .
		'" />';
} elseif (key_exists('img_url', $rickies_data)) {
	// Some other image is set, but no background color -> place image above the title
	echo '<header class="details contain_img"><div class="gradient"></div><img src="' .
		$rickies_data['img_url'] .
		'" />';
} elseif ($rickies_data['type'] == 'annual') {
	// No image, but Annual Rickies -> show year
	echo '<header class="details"><div class="gradient"></div><div class="big_year">' .
		$rickies_data['annual_year'] .
		'</div>';
} elseif ($rickies_data['special'] == 'EUies') {
	// No image, but EUies -> show EUies hero
	echo '<header class="details euies">';
} else {
	// Else -> empty header
	echo '<header class="details"><div class="gradient"></div>';
}
?>

	<h1>
<?php if ($rickies_data['type'] == 'keynote') {
	echo str_lreplace(' ', '&nbsp;', $rickies_data['name']);
} elseif ($rickies_data['special'] == 'EUies') {
	echo str_lreplace('EUies', '<span class="lowercase_caps">EUies</span>', $rickies_data['name']);
} else {
	echo $rickies_data['name'];
} ?>
	</h1>
</header>

<?php
if (array_key_exists('tag', $rickies_data)) {
	foreach ($rickies_data['tag'] as $banner) {
		echo banner($banner['banner'], $banner['color']);
	}
}

if ($rickies_data['ranking']['rickies'] !== []) {
	echo avatar_leaderboard($leaderboard_data);
}
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
				title="The Rickies"
				data-goatcounter-click="Show Rickies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('rickies');"><span class="need_space--xs">The </span>Rickies</a>
<?php }
if (array_key_exists('Flexies', $picks_data__array)) { ?>
			<a class="menu_item js_link"
				id="menu_flexies"
				title="The Flexies"
				data-goatcounter-click="Show Flexies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('flexies');"><span class="need_space--xs">The </span>Flexies</a>
<?php }
if (array_key_exists('Pickies', $picks_data__array)) { ?>
			<a class="menu_item js_link"
				id="menu_pickies"
				title="The Pickies"
				data-goatcounter-click="Show Pickies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('pickies');"><span class="need_space--xs">The </span>Pickies</a>
<?php }
if (array_key_exists('Lightning Round', $picks_data__array)) { ?>
			<a class="menu_item js_link"
				id="menu_lightning_round"
				title="Lightning Round"
				data-goatcounter-click="Show Lightning Round"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('lightning_round');">Lightning<span class="need_space--xs"> Round</span></a>
<?php }
if (array_key_exists('EUies', $picks_data__array)) { ?>
			<a class="menu_item js_link"
				id="menu_euies_round"
				title="EUies"
				data-goatcounter-click="Show EUies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('lightning_round');"><span class="need_space--xs">The </span>EUies</a>
<?php }
if (
	array_key_exists('Rickies', $picks_data__array) ||
	array_key_exists('Flexies', $picks_data__array) ||
	array_key_exists('EUies', $picks_data__array) ||
	array_key_exists('Lightning Round', $picks_data__array) ||
	array_key_exists('Pickies', $picks_data__array)
) { ?>
			<a class="menu_item js_link"
				id="menu_hosts"
				title="Hosts and ranking"
				data-goatcounter-click="Show hosts"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('hosts');">Hosts</a>
<?php }
?>
			<a class="menu_item js_link"
				id="menu_details"
				title="Details about these Rickies"
				data-goatcounter-click="Show details"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('details');">Details</a>
			<a class="menu_item js_link menu_top"
				title="Scroll to the top"
				onclick="window.scrollTo(0,0);"><?= file_get_contents(
    	$_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-menu-top.svg'
    ) ?></a>
		</div>
	</div>
</nav>

<?php
echo no_script_banner();
echo '<script>';
if (!isset($triple_j)) {
	echo 'const triple_j = false;';
} else {
	echo 'const triple_j = true;';
}
echo '</script>';

echo pick_item_bundle($picks_data__array, $rickies_data['interactive'], ['ahead_of_its_time', 'amendment', 'buzzkill']);

if (
	array_key_exists('Rickies', $picks_data__array) ||
	array_key_exists('Flexies', $picks_data__array) ||
	array_key_exists('EUies', $picks_data__array) ||
	array_key_exists('Lightning Round', $picks_data__array) ||
	array_key_exists('Pickies', $picks_data__array)
) {
	if (!isset($triple_j)) {
		echo host_item_bundle($rickies_data['hosts'], $rickies_data['type']);
	} else {
		echo host_item_bundle($rickies_data['hosts'], $rickies_data['type'], true);
	}
}
?>


<section class="navigate_with_mobile_menu large_columns" id="details">
	<h2>Details</h2>
	<div class="section_group">
<?= list_item_bundle($rickies_data['details']) ?>

	</div>
</section>

<?php
echo '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/navigation.js') . '</script>';

// Change some strings to originals before the terms Rickies/Flexies were coined
if (
	$rickies_data['special'] == 'Pre-Rickies' ||
	$rickies_data['date'] < $rickies_start ||
	$rickies_data['date'] < $flexies_start
) {
	echo '<script>';

	if ($rickies_data['special'] == 'Pre-Rickies' || $rickies_data['date'] < $rickies_start) {
		echo "var rickies_alt = 'Predictions';";
	}

	if ($rickies_data['date'] < $flexies_start) {
		echo "var flexies_alt = 'Bragging Rights';";
	}

	echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/pre-rickies.js') . '</script>';
}

