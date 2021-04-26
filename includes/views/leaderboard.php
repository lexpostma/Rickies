<header class="leaderboard">
	<h1>Host Leaderboard</h1>
</header>

<section>
	<p>With 6 Rickies behind us, and 2 ahead, this is the leaderboard of overall wins, picks and flexing power (FP) for the hosts of Connected.</p>
</section>

<?php
$host_array = [
	[
		"name" => "Stephen",
		"winner" => false,
		"title" => "Document Maintainer",
		"string" => "3 points<br />Flexing 23%",
	],
	[
		"name" => "Myke",
		"winner" => false,
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

<section>
	<h3 id="myke">Myke Hurley</h3>

	<h4>Current titles</h4>
	<h4>Achievements</h4>
	<h4>Stats</h4>
</section>

<section>
	<h3 id="federico">Federico Viticci</h3>

	<h4>Current titles</h4>
	<h4>Achievements</h4>
	<h4>Stats</h4>
</section>

<section>
	<h3 id="stephen">Stephen Hackett</h3>

	<h4>Current titles</h4>
	<h4>Achievements</h4>
	<h4>Stats</h4>
</section>