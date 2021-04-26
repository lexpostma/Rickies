<header class="details">
	<h1><?= $rickies_data["name"] ?></h1>
</header>
<?php
if ($rickies_data["winner"] == false) {
	echo "<div class='banner' style='background-color: var(--connected-" .
		$rickies_data["tag_color"] .
		");'><p>" .
		$rickies_data["tag_banner"] .
		"</p></div>";
}

$host_array = [
	[
		"name" => "Stephen",
		"winner" => false,
		"title" => "Document Maintainer",
		"string" => "3 points<br />Flexing 23%",
	],
	[
		"name" => "Myke",
		"winner" => true,
		"title" => "Keynote Chairman",
		"string" => "3 points<br />Flexing 23%",
	],
	[
		"name" => "Federico",
		"winner" => false,
		"title" => "Picker of Passion",
		"string" => "3 points<br />Flexing 23%",
	],
];

echo avatar_leaderboard($host_array);
?>

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

<?= picks_bundle($picks_data__array) ?>

<section class="mobile_split" id="details">
	<h2>Details</h2>
	<h3>Hosts</h3>
	<ul>
		<li>
			<span><a href="/leaderboard#myke">Myke</a></span>
			<h4>🏆 Rickies</h4>
			<h4>💪 Flexies</h4>
		</li>
	</ul>

	<ul>
		<li>
			<span><a href="/leaderboard#federico">Federico</a></span>
			<h4>🏆 Rickies</h4>
			<h4>💪 Flexies</h4>
		</li>
	</ul>

	<ul>
		<li>
			<span><a href="/leaderboard#stephen">Stephen</a></span>
			<h4>🏆 Rickies</h4>
			<h4>💪 Flexies</h4>
		</li>
	</ul>

<?= list_item_bundle($rickies_data["details"]) ?>

</section>

<script><? include("scripts/navigation.js")?></script>