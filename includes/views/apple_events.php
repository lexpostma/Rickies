
<div id="statusbar"></div>
<header class="apple_events contain_img">
	<div class="gradient"></div>
	<h1>Apple Events</h1>
</header>

<?= navigation_bar('apple-events') ?>

<section><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p></section>

<section id="list">

<?php
echo '<ul class="list_item_group">';
foreach ($apple_events__array as $apple_event) {
	echo list_item($apple_event);
}
echo '</ul>';
?>
</section>
