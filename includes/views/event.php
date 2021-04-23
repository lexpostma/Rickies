<!-- <header class="details" style="--hero-image: url(/images/connected-map.png);">
	<h1>Keynote Rickies, April 2020</h1>
</header>
<div class="banner">
	<p>These Rickies are is not officially scored yet</p>
</div> -->

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
	<a href="#" class="active">The Rickies</a>
	<a href="#">The Flexies</a>
	<a href="#">Details</a>
</nav>

<section id="rickies">
	<h2>The Rickies</h2>
	<h3>Federico</h3>
	<ul>
		<li>Regular pick 1</li>
		<li>Regular pick 2</li>
		<li>Risky pick</li>
	</ul>

	<h3>Myke</h3>
	<ul>
		<li>Regular pick 1</li>
		<li>Regular pick 2</li>
		<li>Risky pick</li>
	</ul>

	<h3>Stephen</h3>
	<ul>
		<li>Regular pick 1</li>
		<li>Regular pick 2</li>
		<li>Risky pick</li>
	</ul>
</section>

<section id="flexies">
	<h2>The Flexies</h2>
	<h3>Federico</h3>
	<ul>
		<li>Flexy pick 1</li>
		<li>Flexy pick 2</li>
		<li>Flexy pick 3</li>
		<li>Flexy pick 4</li>
		<li>Flexy pick 5</li>
	</ul>

	<h3>Myke</h3>
	<ul>
		<li>Flexy pick 1</li>
		<li>Flexy pick 2</li>
		<li>Flexy pick 3</li>
		<li>Flexy pick 4</li>
		<li>Flexy pick 5</li>
	</ul>

	<h3>Stephen</h3>
	<ul>
		<li>Flexy pick 1</li>
		<li>Flexy pick 2</li>
		<li>Flexy pick 3</li>
		<li>Flexy pick 4</li>
		<li>Flexy pick 5</li>
	</ul>
</section>

<section id="details">
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

<?php
$event_details = [
	"Apple event",
	[
		"url" => "#",
		// "img_url"		=> "/images/bill-of-rickies-avatar.png",
		"label1" => "Apple Event, April 2020",
		"label2" => "Spring Loaded.",
		"label3" => "Aired on 30 June 2020",
	],
	"Podcast episodes",
	[
		"url" => "#",
		// "img_url"		=> "/images/bill-of-rickies-avatar.png",
		"label1" => "#123: The Rickies (Summer 2020)",
		"label2" => "Music is My Girlfriend",
		"label3" => "Aired on 28 June 2020",
		"tag" => "Predictions",
		"tag_color" => "purple",
	],
	[
		"url" => "#",
		// "img_url"		=> "/images/bill-of-rickies-avatar.png",
		"label1" => "#124: Hippopotamus As A Testing Title",
		"label3" => "Aired on 28 June 2020",
		"tag" => "Predictions",
		"tag_color" => "blue",
	],
	"More",
	[
		"url" => billofrickies_url(),
		"img_url" => "/images/bill-of-rickies-avatar.png",
		"label1" => "The Bill of Rickies",
	],
	[
		"url" => "#",
		// "img_url"		=> "/images/bill-of-rickies-avatar.png",
		"label1" => "Furkids",
		"label2" => "$125 donated by Stephen",
		"label3" => "Federico’s choice",
	],
];

echo list_item_bundle($event_details);
?>

</section>