<header class="home">
	<a target="_blank" href="<?= $head['site_relay'] ?>" id="header_corner" title="Visit <?= $head['company'] ?>">
		<img id="relay_logo" src="/images/relay-logo.png" alt="<?= $head['company'] ?> logo"/>
	</a>
	<div class="hero_content">
		<img id="trophy" src="/images/trophy.png" onclick="confetti_go()"/>
		<div class="hero_heading">
			<h1>The Rickies</h1>
			<p>Awards with risk, flexing, and passion.<br />On Connected at Relay FM.</p>
		</div>
	</div>
</header>

<nav class="nav_content home" style="animation-delay: <?= rand(-50, 0) ?>s;">
	<div class="nav_content--items">
		<a class="active" href="#list"><span class="need_space">The </span>Rickies</a>
		<a href="/leaderboard"><span class="need_space">Host </span>Leaderboard</a>
		<a href="<?= billofrickies_url() ?>">The Bill of Rickies</a>
		<a href="/about">About</a>
	</div>
</nav>

<?= no_script_banner() ?>

<section>
	<div class="nav_anchor"></div>
	<p>The Rickies are a prediction award show on the <a target="_blank" href="<?= $head[
 	'site_connected'
 ] ?>">Connected</a> podcast on <a target="_blank" href="<?= $head[
	'site_relay'
] ?>">Relay FM</a>. Every year and every Apple event, Myke Hurley, Stephen Hackett, and Federico Viticci predict what Apple will announce next. Over the course of the show, the hosts have relied on <a href="<?= billofrickies_url() ?>">The Bill of Rickies</a> to keep the record straight. Some predictions are risky, some are just to flex, most are formed with passion.</p>
</section>

<section id="list">
	<ul class="list_item_group">

<?php foreach ($rickies_events__array as $event) {
	echo list_item($event);
} ?>

	</ul>
</section>