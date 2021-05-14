<header class="home">
	<a
		target="_blank"
		href="<?= $head['site_relay'] ?>"
		id="header_corner"
		<?= $head['site_relay_goat'] ?>
	>
		<img id="relay_logo" src="/images/relay-logo.png" alt="<?= $head['company'] ?> logo"/>
	</a>
	<div class="hero_content">
		<img id="trophy" src="/images/trophy.png" onclick="confetti_go()"/>
		<div class="hero_heading">
			<h1>The Rickies</h1>
			<?= $hero_tag ?>
		</div>
	</div>
</header>

<nav id="nav_content" class="home" style="animation-delay: <?= rand(-50, 0) ?>s;">
	<div class="nav_content--items">
		<a class="active" href="#list"><span class="need_space">The </span>Rickies</a>
		<a href="/billof"><span class="need_space">The </span>Bill of Rickies</a>
		<a href="/leaderboard"><span class="need_space">Host </span>Leaderboard</a>
		<a href="/about">About</a>
	</div>
</nav>

<?= no_script_banner() ?>

<section><?= $introduction ?></section>

<section id="list">
	<ul class="list_item_group">

<?php foreach ($rickies_events__array as $event) {
	echo list_item($event);
} ?>

	</ul>
</section>