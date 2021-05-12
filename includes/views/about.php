<header class="about contain_img">
	<div class="gradient"></div>
	<img src="/images/lex_memoji.png" />
	<h1>About this website</h1>
</header>
<section>
	<?= markdown('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
')
// TODO: Write About text
?>
</section>

<section>
	<h2>Other resources</h2>
	<ul class="list_item_group">
<?php // TODO: Add intro
foreach ($resources as $item) {
	echo list_item($item);
} ?>
	</ul>
</section>