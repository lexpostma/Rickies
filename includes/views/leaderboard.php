<header class="leaderboard">
	<h1>Host Leaderboard</h1>
</header>

<section>
	<p>With 6 Rickies behind us, and 2 ahead, this is the leaderboard of overall wins, picks and flexing power (FP) for the hosts of Connected.</p>
</section>

<?= avatar_leaderboard($avatar_leaderboard_array) ?>

<section>
	<div class="section_group">
<?php foreach ($hosts_data__array as $host_data) {
	echo leaderboard_item($host_data);
} ?>
	</div>
</section>
