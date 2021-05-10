<?php

$head_defaults = [
	'title' => 'The Rickies',
	'name' => 'The Rickies',
	'favicon' => 'favicon.png',
	'author' => 'Lex Postma',
	'company' => 'Relay FM',
	// TODO: Write SEO description
	'description' =>
		'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
	'keywords' => ['Apple', 'podcast', 'relay', 'predictions', 'awards', 'wwdc'],
	'site_relay' => 'https://relay.fm/',
	'site_relay_goat' =>
		' data-goatcounter-click="relay.fm" data-goatcounter-title="Go to Relay FM" data-goatcounter-referrer="' .
		current_url() .
		'" ',
	'site_connected' => 'https://relay.fm/connected',
	'site_connected_goat' =>
		' data-goatcounter-click="relay.fm/connected" data-goatcounter-title="Go to Connected" data-goatcounter-referrer="' .
		current_url() .
		'" ',
	'site_lex' => 'https://lexpostma.me',
	'site_lex_goat' =>
		' data-goatcounter-click="lexpostma.me" data-goatcounter-title="Go to Lex Postma" data-goatcounter-referrer="' .
		current_url() .
		'" ',
	'twitter_author' => '@lexpostma',
	'twitter_connected' => '@_connectedfm',
];

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
<base href="<?= base_url() ?>">

<!-- Icons -->
<link rel="shortcut icon" type="image/ico" href="<?= $head['favicon'] ?>" />

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
<meta property="og:image" content=""/>
<meta property="og:image:secure_url" content=""/>
<meta property="og:type" content="website" />
<meta property="og:site_name" content="<?= $head['name'] ?>" />
<meta property="fb:admins" content="1308188724" />

<!-- Twitter (Cards) -->
<meta name="twitter:widgets:link-color" content="#106DC6" />
<meta name="twitter:url" content="<?= current_url() ?>">
<meta name="twitter:title" content="<?= $head['title'] ?>">
<meta name="twitter:description" content="<?= $head['description'] ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image:src" content="">
<meta name="twitter:creator" content="<?= $head['twitter_author'] ?>">
<meta name="twitter:site" content="<?= $head['twitter_connected'] ?>">

<?
	// include("ios_optimisation.php");
?>

<!-- Normalize and Google Font		 -->
<link rel="stylesheet" href="/styles/normalize.css">
<!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet"> -->

<!-- Style sheet -->
<link rel="stylesheet" href="/styles/global.css?v=<?= date('z') ?>">
<link rel="stylesheet" href="/styles/<?= $subdomain ?>.css?v=<?= date('z') ?>">
<noscript>
	<link rel="stylesheet" href="/styles/noscript.css?v=<?= date('z') ?>">
</noscript>

<!-- Goat Counter -->
<? if ($subdomain == 'billofrickies') { ?>
<script>
	window.goatcounter = {
		path: function(p) {
			// Add 'billof' to path on subdomain
			return 'billof'+p
		},
	}
</script>

<? } if ($environment == 'production') { // Only track production ?>
<script data-goatcounter="https://rickies.goatcounter.com/count" async src="//gc.zgo.at/count.js"></script>
<? } else { // Track others elsewhere ?>
<script data-goatcounter="https://rickies-test.goatcounter.com/count" async src="//gc.zgo.at/count.js"></script>
<? } if ($subdomain == 'rickies') { ?>
<!-- Canvas Confetti -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>

<? } if ($url_view == 'leaderboard') { ?>
<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js" integrity="sha512-VMsZqo0ar06BMtg0tPsdgRADvl0kDHpTbugCBBrL55KmucH6hP9zWdLIWY//OTfMnzz6xWQRxQqsUFefwHuHyg==" crossorigin="anonymous"></script>
<? }

