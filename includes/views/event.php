<header class="details">
	<h1>Keynote Rickies, April 2020</h1>
</header>
<div class="banner">
	<p>These Rickies are is not officially scored yet</p>
</div>

<?php $host_array = [
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
// echo avatar_leaderboard($host_array);
?>

<nav>
	<a href="<?= current_url() ?>#rickies" class="active">The Rickies</a>
	<a href="<?= current_url() ?>#flexies">The Flexies</a>
	<a href="<?= current_url() ?>#details">Details</a>
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

<?= list_item_bundle(reset($rickies_events_array)["details"]) ?>

</section>