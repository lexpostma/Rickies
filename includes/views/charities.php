
<div id="statusbar"></div>
<header class="about contain_img">
	<div class="gradient"></div>
	<img src="/images/rickies-trophy-glow.png" alt="Rickies trophy"/>
	<h1>Charities</h1>
</header>

<?= navigation_bar('charities') ?>

<section><p>Donated $<?= $total_donated ?> in total</p><p>St. Jude's fundraiser</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p></section>

<section id="list">

<?php
echo '<ul class="list_item_group">';
foreach ($charities__array as $charity) {
	echo list_item($charity);
}
echo '</ul>';
?>
</section>
