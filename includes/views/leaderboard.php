<div id="statusbar"></div>
<header class="leaderboard triple_j">
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
<?php if (!isset($triple_j)) { ?>
			<a class="menu_item js_link"
				id="menu_timeline"
				title="Chairman timeline"
				data-goatcounter-click="Show chairman timeline"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('timeline');">Timeline</a>
<?php } ?>
			<a class="menu_item js_link"
				id="menu_stats"
				title="Host stats"
				data-goatcounter-click="Show host stats"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('stats');">Stats</a>
<?php foreach ($hosts_data__array as $host => $data) { ?>
			<a class="menu_item js_link menu_mobile_only"
				id="menu_<?= strtolower($host) ?>"
				title="<?= $host ?>’s stats"
				data-goatcounter-click="Show <?= $host ?>’s stats"
				data-goatcounter-referrer="<?= current_url() ?>"
				onclick="navigate_section('<?= strtolower($host) ?>');"><?= $host ?></a>
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
if (!isset($triple_j)) {
	echo chairman_timeline($hosts_data__array, $timeline_array);
	echo leaderboard_item_bundle($hosts_data__array);
} else {
	echo leaderboard_item_bundle($hosts_data__array, true);
}
echo '<script>
';
if (!isset($triple_j)) {
	echo 'const triple_j = false;';
} else {
	echo 'const triple_j = true;';
}

echo '

' .
	file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/navigation.js') .
	'</script>';

