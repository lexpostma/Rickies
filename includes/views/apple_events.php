
<div id="statusbar"></div>
<header class="apple_events contain_img">
	<div class="gradient"></div>
	<h1>Apple Events</h1>
</header>

<?= navigation_bar('apple-events') ?>

<section><?= $introduction ?></section>

<section id="list">

<?php
echo '<ul class="list_item_group">';
foreach ($apple_events__array as $apple_event) {
	echo list_item($apple_event);
}
echo '</ul>';
?>
</section>
