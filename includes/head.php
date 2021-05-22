<?php

if (isset($head_custom)) {
	if (array_key_exists('keywords', $head_custom)) {
		$head_custom['keywords'] = array_merge_recursive($head_defaults['keywords'], $head_custom['keywords']);
	}
	$head = array_merge($head_defaults, $head_custom);
} else {
	$head = $head_defaults;
}

if ($environment !== 'production') {
	$head['title'] = $head['title'] . ' [' . $environment . ']';
}
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no, viewport-fit=cover" />
<title><?= $head['title'] ?></title>
<base href="<?= current_url() ?>">
<link rel="canonical" href="<?= current_url() ?>" />

<!-- Icons -->
<link rel="icon" type="image/png" sizes="256x256" href="<?= $head['favicon'] . '?v=' . $refresh ?>" />

<!-- Standard SEO / Google -->
<meta name="description" content="<?= $head['description'] ?>" />
<meta name="keywords" content="<?= implode(',', $head['keywords']) ?>" />
<meta name="author" content="<?= $head['author'] ?>" />
<meta name="copyright" content="Copyright © <?= date('Y') ?> by <?= $head['author'] ?> and Relay FM" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?
	if($environment !== "production") {
		echo '<meta name="robots" content="noindex,nofollow" />';
	}
?>


<!-- Open Graph protocol / Facebook -->
<meta property="og:title" content="<?= $head['title'] ?>" />
<meta property="og:description" content="<?= $head['description'] ?>" />
<meta property="og:url" content="<?= current_url() ?>" />
<meta property="og:image" content="<?= $head['image'] ?>"/>
<meta property="og:image:secure_url" content="<?= $head['image'] ?>"/>
<meta property="og:type" content="website" />
<meta property="og:site_name" content="<?= $head['name'] ?>" />
<meta property="fb:admins" content="1308188724" />

<!-- Twitter (Cards) -->
<meta name="twitter:widgets:link-color" content="#106DC6" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="<?= $head['twitter_connected'] ?>" />
<meta name="twitter:creator" content="<?= $head['twitter_author'] ?>" />
<meta name="twitter:title" content="<?= $head['title'] ?>" />
<meta name="twitter:description" content="<?= $head['description'] ?>" />
<meta name="twitter:image" content="<?= $head['image'] ?>" />
<meta name="twitter:url" content="<?= current_url() ?>" />

<?include("ios_optimisation.php");?>

<!-- Style sheets -->
<link rel="stylesheet" href="/styles/normalize.css"> <!-- Normalize -->
<link rel="stylesheet" href="/styles/<?= $focus_site ?>.css?v=<?= $refresh ?>">
<noscript>
	<link rel="stylesheet" href="/styles/noscript.css?v=<?= $refresh ?>">
</noscript>

<!-- Goat Counter -->
<script data-goatcounter="<?= $head['site_goatcounter'] ?>/count" async src="//gc.zgo.at/count.js"></script>

<? if ($focus_site == 'rickies') { ?>

<!-- Canvas Confetti -->
<script src="/scripts/confetti.browser.min.js"></script>

<!-- JavaScript Cookie -->
<script src="/scripts/js.cookie.js"></script>

<? } if ($url_view == 'leaderboard') { ?>
<!-- Chart.js -->
<script src="/scripts/chart.min.js"></script>
<? }

