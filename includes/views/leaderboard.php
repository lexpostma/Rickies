<header class="leaderboard">
	<h1>Host Leaderboard</h1>
</header>

<section>
	<!-- TODO: Rickies count as variable in the text  -->
	<p>With 6 Rickies behind us, and 2 ahead, this is the leaderboard of overall wins, picks and flexing power (FP) for the hosts of Connected.</p>
</section>


<?php
echo avatar_leaderboard($leaderboard_data);
echo leaderboard_item_bundle($hosts_data__array);

