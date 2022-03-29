
<div id="statusbar"></div>
<header class="charities">
	<div class="gradient"></div>
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
