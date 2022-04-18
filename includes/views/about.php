
<div id="statusbar"></div>
<header class="about contain_img">
	<div class="gradient"></div>
	<img src="/images/memoji/memoji-lex.png" alt="Lex’ Memoji"/>
	<h1>About Rickies.co</h1>
</header>

<?= navigation_bar('about') ?>

<section class="article"><?= $introduction ?></section>

<section class="large_columns">
	<div class="section_group">
		<?= list_item_bundle($resources) ?>
	</div>
</section>
