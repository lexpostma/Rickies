<div id="statusbar"></div>
<header class="leaderboard">
	<h1>Host Leaderboard</h1>
</header>

<?php
if (!isset($triple_j)) {
	echo navigation_bar('leaderboard');
} else {
	echo navigation_bar('leaderboard', true);
}

echo no_script_banner('Charts can’t be shown with Javascript disabled'),
	'<section>' . $introduction . '</section>',
	avatar_leaderboard($leaderboard_data);
?>

<nav class="nav_container leaderboard">
	<div id="statusbar"></div>
	<div id="nav_anchor"></div>
	<div id="nav_content_sticky" class="nav_content">
		<div class="nav_content--items">
<?php if ($url_view == 'leaderboard') { ?>
			<a class="menu_item js_link"
				id="menu_timeline"
				title="Chairman timeline"
				data-goatcounter-click="Show chairman timeline"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('timeline');">Timeline</a>
			<a class="menu_item js_link"
				id="menu_stats"
				title="Host stats"
				data-goatcounter-click="Show host stats"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('stats');">Stats</a>
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
<?php } else { ?>
			<a class="menu_item js_link"
				id="menu_stats"
				title="Host stats"
				data-goatcounter-click="Show host stats"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('stats');">Stats</a>
			<a class="menu_item js_link"
				id="menu_jason"
				title="Jason’s stats"
				data-goatcounter-click="Show Jason’s stats"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('jason');">Jason</a>
			<a class="menu_item js_link"
				id="menu_john"
				title="John’s stats"
				data-goatcounter-click="Show John’s stats"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('john');">John</a>
			<a class="menu_item js_link"
				id="menu_james"
				title="James’s stats"
				data-goatcounter-click="Show James’s stats"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('james');">James</a>
<?php } ?>
			<a class="menu_item js_link menu_top"
				title="Scroll to the top"
				onclick="window.scrollTo(0,0);"><?= file_get_contents(
    	$_SERVER['DOCUMENT_ROOT'] . '/images/buttons/button-menu-top.svg'
    ) ?></a>
		</div>
	</div>
</nav>

<?php
if (!isset($tripje_j)) {
	echo chairman_timeline($hosts_data__array, $timeline_array),
		'<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/timeline.js') . '</script>';
}
echo leaderboard_item_bundle($hosts_data__array),
	'<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/navigation.js') . '</script>';

