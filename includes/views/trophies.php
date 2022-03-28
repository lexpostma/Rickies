
<div id="statusbar"></div>
<header class="trophies">
	<div class="gradient"></div>
	<h1>Rickies trophies</h1>
</header>

<?php
echo navigation_bar('trophies');
echo '<section class="article">' . $introduction . '</section>';
?>
<nav class="nav_container leaderboard">
	<div id="statusbar"></div>
	<div id="nav_anchor"></div>
	<div id="nav_content_sticky" class="nav_content">
		<div class="nav_content--items">
			<a class="menu_item js_link"
				id="menu_tricky"
				title="Tricky"
				data-goatcounter-click="Show Tricky"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('tricky');">Tricky</a>
			<a class="menu_item js_link"
				id="menu_magtricky"
				title="MagTricky"
				data-goatcounter-click="Show MagTricky"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('magtricky');">MagTricky</a>
			<a class="menu_item js_link"
				id="menu_ricky"
				title="Ricky"
				data-goatcounter-click="Show Ricky"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('ricky');">Ricky</a>
			<a class="menu_item js_link"
				id="menu_other"
				title="Other trophies"
				data-goatcounter-click="Show other trophies"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('other');">Other</a>
		</div>
	</div>
</nav>

<?php
foreach ($trophy_content as $id => $text) {
	echo '<section id="' .
		$id .
		'" class="navigate_with_mobile_menu article"><div class="section_article">' .
		$text .
		'</div></section>';
}

echo '<script>' .
	file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/magtricky.js') .
	file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/navigation.js') .
	'</script>';

