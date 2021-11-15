<!-- Web App manifest, via https://web.dev/add-manifest/ -->
<link rel="manifest" href="/manifest.json">

<!-- Apple / iOS web app-->
<meta name="apple-mobile-web-app-title" content="Rickies" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<?php
if (array_key_exists('theme-color', $head) && array_key_exists('theme-color-dark', $head)) { ?>
<meta name="theme-color" media="(prefers-color-scheme: light)" content="<?= $head['theme-color'] ?>" />
<meta name="theme-color" media="(prefers-color-scheme: dark)"  content="<?= $head['theme-color-dark'] ?>" />
<?php } elseif (array_key_exists('theme-color', $head)) { ?>
<meta name="theme-color" content="<?= $head['theme-color'] ?>" />
<?php }

echo '
<!-- iOS home screen icons -->';
foreach ($appIconSizes as $device => $size) {
	echo '
<link rel="apple-touch-icon-precomposed" sizes="' .
		$size .
		'" href="' .
		$appIconDirectory .
		'icon-' .
		$size .
		'.png?v=' .
		$refresh .
		'" /> <!-- ' .
		$device .
		' -->';
}

echo '

<!-- iOS splash screens -->';
$splashScreenSizes = [
	'iPhone 5, 5s, SE' => [
		'width' => '320',
		'height' => '568',
		'ratio' => '2',
	],
	'iPhone 6, 6s, 7, 8, SE2' => [
		'width' => '375',
		'height' => '667',
		'ratio' => '2',
	],
	'iPhone [6, 6s, 7, 8] Plus' => [
		'width' => '414',
		'height' => '736',
		'ratio' => '3',
	],
	'iPhone X, XS, 11 Pro' => [
		'width' => '375',
		'height' => '812',
		'ratio' => '3',
	],
	'iPhone XR, 11' => [
		'width' => '414',
		'height' => '896',
		'ratio' => '2',
	],
	'iPhone 12, 13, [12, 13] Pro' => [
		'width' => '390',
		'height' => '844',
		'ratio' => '3',
	],
	'iPhone [XS, 11 Pro] Max' => [
		'width' => '414',
		'height' => '896',
		'ratio' => '3',
	],
	'iPhone [12, 13] mini' => [
		'width' => '360',
		'height' => '780',
		'ratio' => '3',
	],
	'iPhone [12, 13] Pro Max' => [
		'width' => '428',
		'height' => '926',
		'ratio' => '3',
	],
	'iPad 9.7 non-retina' => [
		'width' => '768',
		'height' => '1024',
		'ratio' => '1',
	],
	'iPad 9.7 retina' => [
		'width' => '768',
		'height' => '1024',
		'ratio' => '2',
	],
	'iPad Pro 10.2' => [
		'width' => '810',
		'height' => '1080',
		'ratio' => '2',
	],
	'iPad Pro 10.5, iPad Air 3rd' => [
		'width' => '834',
		'height' => '1112',
		'ratio' => '2',
	],
	'iPad Air 4th' => [
		'width' => '820',
		'height' => '1180',
		'ratio' => '2',
	],
	'iPad Pro 11' => [
		'width' => '834',
		'height' => '1194',
		'ratio' => '2',
	],
	'iPad Pro 12.9' => [
		'width' => '1024',
		'height' => '1366',
		'ratio' => '2',
	],
	'iPad mini 8.3' => [
		'width' => '744',
		'height' => '1133',
		'ratio' => '2',
	],
];

foreach ($splashScreenSizes as $device => $size) {
	echo '
<!-- ' .
		$device .
		' -->
<link rel="apple-touch-startup-image" href="/images/splashscreens/splash-portrait-' .
		$size['width'] .
		'x' .
		$size['height'] .
		'@' .
		$size['ratio'] .
		'x.png"   media="(device-width: ' .
		$size['width'] .
		'px)  and (device-height: ' .
		$size['height'] .
		'px)  and (orientation: portrait)  and (-webkit-device-pixel-ratio: ' .
		$size['ratio'] .
		')" />
<link rel="apple-touch-startup-image" href="/images/splashscreens/splash-landscape-' .
		$size['width'] .
		'x' .
		$size['height'] .
		'@' .
		$size['ratio'] .
		'x.png"   media="(device-width: ' .
		$size['width'] .
		'px)  and (device-height: ' .
		$size['height'] .
		'px)  and (orientation: landscape) and (-webkit-device-pixel-ratio: ' .
		$size['ratio'] .
		')" />';
}

echo '
<!-- Android -->
<meta name="mobile-web-app-capable" content="yes">';
foreach ($appIconSizes as $device => $size) {
	echo '
<link rel="shortcut icon" sizes="' .
		$size .
		'" href="' .
		$appIconDirectory .
		'icon-' .
		$size .
		'.png?v=' .
		$refresh .
		'" />';
}

