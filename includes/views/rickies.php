<header class="home">
	<a target="_blank" href="<?= $head["site_relay"] ?>" id="corner_tag">
		<img id="relay_logo" src="/images/relay-logo.png" />
	</a>
	<div class="hero_content">
		<img id="trophy" src="/images/trophy.png" />
		<div class="hero_heading">
			<h1>The Rickies</h1>
			<p>Awards with risk, flexing, and passion.<br />On Connected at Relay FM.</p>
		</div>
	</div>
</header>

<nav class="nav_content">
	<a href="<?= billofrickies_url() ?>">The Bill of Rickies</a>
	<a href="/leaderboard">Host Leaderboard</a>
</nav>

<section>
	<div class="nav_anchor"></div>
	<p>The Rickies are a prediction award show on the <a target="_blank" href="<?= $head[
 	"site_connected"
 ] ?>">Connected</a> podcast on <a target="_blank" href="<?= $head[
	"site_relay"
] ?>">Relay FM</a>. Every year and every Apple event, Myke Hurley, Stephen Hackett, and Federico Viticci predict what Apple will announce next. Over the course of the show, the hosts have relied on <a href="<?= billofrickies_url() ?>">The Bill of Rickies</a> to keep the record straight. Some predictions are risky, some are just to flex, most are formed with passion.</p>
</section>

<section>
	<ul class="list_item_group">

<?php foreach ($rickies_events_array as &$event) {
	echo list_item($event);
} ?>

	</ul>
</section>