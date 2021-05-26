<div id="statusbar"></div>
<header class="leaderboard">
	<h1>Host Leaderboard</h1>
</header>

<?php echo no_script_banner('Charts can’t be shown with Javascript disabled'),
	'<section>' . $introduction . '</section>',
	avatar_leaderboard($leaderboard_data),
	leaderboard_item_bundle($hosts_data__array);
