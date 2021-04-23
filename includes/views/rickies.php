<header class="home">
	<div id="corner_tag">
		<img id="relay_logo" src="/images/connected-globe.png" />
	</div>
	<img id="trophy" src="/images/trophy.png" />
	<h1>The Rickies</h1>
	<p>Awards with risk, flexing, and passion.<br />
On Connected at Relay FM.</p>
</header>

<nav>
	<a href="<?=billofrickies_url();?>">The Bill of Rickies</a>
	<a href="/leaderboard">Host Leaderboard</a>
</nav>

<section>
	<p>The Rickies are a prediction award show on the <a href="#">Connected</a> podcast on <a href="#">Relay FM</a>. Every year and every Apple event, Myke Hurley, Stephen Hackett, and Federico Viticci predict what Apple will announce next. Over the course of the show, the hosts have relied on <a href="#">The Bill of Rickies</a> to keep the record straight. Some predictions are risky, some are just to flex, most are formed with passion.</p>
</section>

<section>
	<ul class="list_item_group">

<?php

foreach ($rickies_events_array as &$event) {
	echo list_item($event);
};

?>

	</ul>
</section>