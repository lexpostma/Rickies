<div id="statusbar"></div>
<header class="about contain_img">
	<div class="gradient"></div>
	<img src="/images/lex_memoji.png" alt="Lex’ Memoji"/>
	<h1>Search Rickies</h1>
</header>

<div class="filters">
	<form>
		<input type="text" name="search" placeholder="Search for picks" value="<?= $query ?>"/>
		<button type="submit">Search</button>
	</form>
</div>

<nav class="nav_container">
	<div id="statusbar"></div>
	<div id="nav_anchor"></div>
	<div id="nav_content">
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
?>
			<a class="menu_item js_link"
				id="menu_top"
				title="Scroll to the top"
				onclick="window.scrollTo(0,0);"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-menu-top.svg') ?></a>
		</div>
	</div>
</nav>

<?php
echo no_script_banner();
echo pick_item_bundle($picks_data__array, false, true);
echo '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/navigation.js') . '</script>';

