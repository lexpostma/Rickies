
<div id="statusbar"></div>
<header class="about contain_img">
	<div class="gradient"></div>
	<img src="/images/rickies-trophy-glow.png" alt="Rickies trophy"/>
	<h1>Rickies trophies</h1>
</header>

<?= navigation_bar('trophies') ?>

<canvas id="3d_tricky"></canvas>

<section><?= $trickies ?></section>
<section><?= $magtrickies ?></section>

<script async src="https://unpkg.com/es-module-shims@1.3.6/dist/es-module-shims.js"></script>

<script type="importmap">
	{
		"imports": {
			"three": "/scripts/three.module.js"
		}
	}
</script>

<script type="module" ><?php include 'scripts/3d-tricky.js'; ?>
</script>
