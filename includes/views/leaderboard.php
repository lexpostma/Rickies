<div id="statusbar"></div>
<header class="leaderboard">
	<h1>Host Leaderboard</h1>
</header>

<?php
echo navigation_bar('leaderboard');
echo no_script_banner('Charts can’t be shown with Javascript disabled'),
	'<section>' . $introduction . '</section>',
	avatar_leaderboard($leaderboard_data);
?>


<nav class="nav_container">
	<div id="statusbar"></div>
	<div id="nav_anchor"></div>
	<div id="nav_content_sticky" class="nav_content">
		<div class="nav_content--items">
			<a class="menu_item js_link"
				id="menu_myke"
				title="Myke’s stats"
				data-goatcounter-click="Show Myke’s stats"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('myke');">Myke</a>
			<a class="menu_item js_link"
				id="menu_federico"
				title="Federico’s stats"
				data-goatcounter-click="Show Federico’s stats"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('federico');">Federico</a>
			<a class="menu_item js_link"
				id="menu_stephen"
				title="Stephen’s stats"
				data-goatcounter-click="Show Stephen’s stats"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('stephen');">Stephen</a>
			<a class="menu_item js_link menu_top"
				title="Scroll to the top"
				onclick="window.scrollTo(0,0);"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/button-menu-top.svg') ?></a>
		</div>
	</div>
</nav>	
	
<?php
echo leaderboard_item_bundle($hosts_data__array), '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/navigation.js') . '</script>';
