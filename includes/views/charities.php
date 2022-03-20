
<div id="statusbar"></div>
<header class="about contain_img">
	<div class="gradient"></div>
	<img src="/images/rickies-trophy-glow.png" alt="Rickies trophy"/>
	<h1>Charities</h1>
</header>

<?= navigation_bar('charities') ?>

<section><?= $introduction ?></section>

<section id="list">

<?php
echo '<ul class="list_item_group">';
foreach ($charities__array as $charity) {
	echo list_item($charity);
}
echo '</ul>';
?>
</section>
