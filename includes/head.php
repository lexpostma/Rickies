<?
	$seo_title = "The Rickies";
	if($environment !== "production") {
		$seo_title .= " [".$environment."]";
	}
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no, viewport-fit=cover" />
<title><?= $seo_title ?></title>
<base href="<?= base_url() ?>">

<!-- Icons -->
<link rel="shortcut icon" type="image/ico" href="favicon.png" />

<!-- Standard SEO / Google -->
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="Lex Postma" />
<meta name="copyright" content="Copyright (c) 2020-<?= date("Y") ?> by Lex Postma" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?
	if($environment !== "production") {
		echo '<meta name="robots" content="noindex,nofollow" />';
	}
?>

<!-- Open Graph protocol / Facebook -->
<meta property="og:title" content="The Rickies" />
<meta property="og:description" content="" />
<meta property="og:url" content="<?= current_url() ?>" />
<meta property="og:image" content=""/>
<meta property="og:image:secure_url" content=""/>
<meta property="og:type" content="website" />
<meta property="og:site_name" content="The Rickies" />
<meta property="fb:admins" content="1308188724" />

<!-- Twitter (Cards) -->
<meta name="twitter:widgets:link-color" content="#106DC6" />
<meta name="twitter:url" content="<?= current_url() ?>">
<meta name="twitter:title" content="The Rickies">
<meta name="twitter:description" content="">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image:src" content="">
<meta name="twitter:creator" content="@lexpostma">
<meta name="twitter:site" content="@_connectedfm">

<?
	// include("ios_optimisation.php");
?>

<!-- Normalize and Google Font		 -->
<link rel="stylesheet" href="/styles/normalize.css">
<!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet"> -->

<!-- Style sheet -->
<link rel="stylesheet" href="/styles/global.css?v=<?= date("z") ?>">
<link rel="stylesheet" href="/styles/<?= $subdomain ?>.css?v=<?= date("z") ?>">

<!-- If it's a webapp, open links inside webapp instead of Safari https://stackoverflow.com/a/8173161 -->
<!-- <script>
	(
		function(element,userAgent,userAgentVar){
			if(userAgentVar in userAgent&&userAgent[userAgentVar]){
				var d,
					elementLocation=element.location,
					f=/^(a|html)$/i;

				element.addEventListener("click",function(element){
					elementTarget=element.target;
					while(!f.test(elementTarget.nodeName))elementTarget=elementTarget.parentNode;

					// links with target="_blank" should still open in Safari
					var newTabLink = elementTarget.attributes.getNamedItem("target");
					if(newTabLink && newTabLink.value == "_blank") return;

					// links that should with # in href should have default behaviour
					var anchorLink = elementTarget.attributes.getNamedItem("href");
					if(anchorLink && anchorLink.value.startsWith("#")) return;

					"href"in elementTarget&&(elementTarget.href.indexOf("http")||~elementTarget.href.indexOf(elementLocation.host))&&(element.preventDefault(),elementLocation.href=elementTarget.href)
				},!1)
			}
		}
	)(document,window.navigator,"standalone")
</script> -->