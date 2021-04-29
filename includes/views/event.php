<header class="details">
	<h1>
<?php if ($rickies_data["type"] == "Keynote Rickies") {
	echo str_lreplace(" ", "&nbsp;", $rickies_data["name"]);
} else {
	echo $rickies_data["name"];
} ?>
	</h1>
</header>

<?php if ($rickies_data["winner"] == false) {
	echo "<div class='banner' style='background-color: var(--connected-" .
		$rickies_data["tag_color"] .
		");'><p>" .
		$rickies_data["tag_banner"] .
		"</p></div>";
} else {
	echo avatar_leaderboard($leaderboard_data);
} ?>

<nav class="nav_container">
	<div class="nav_anchor"></div>
	<div class="nav_content">
		<a class="menu_item"
			id="menu_rickies"
			href="<?= current_url() ?>#rickies"
			onclick="navigate_section('rickies');">The Rickies</a>
		<a class="menu_item"
			id="menu_flexies"
			href="<?= current_url() ?>#flexies"
			onclick="navigate_section('flexies');">The Flexies</a>
		<a class="menu_item"
			id="menu_details"
			href="<?= current_url() ?>#details"
			onclick="navigate_section('details');">Details</a>
	</div>
</nav>

<?= pick_item_bundle($picks_data__array) ?>

<section class="navigate_with_mobile_menu large_columns" id="details">
	<h2>Details</h2>
	<div class="section_group">
<?php
echo host_item_bundle($rickies_data["hosts"]);
echo list_item_bundle($rickies_data["details"]);
?>
	</div>
</section>

<script><? include("scripts/navigation.js")?></script>