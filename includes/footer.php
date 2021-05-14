<div class="footer_space"></div>
<footer id="footer">
	<p class="promote_webapp">This website is designed as a web app.<br />Add it to your home screen for the best experience.</p>
	<p class="refresh_page"><a href title="Refresh page" data-goatcounter-click="Refresh page" data-goatcounter-referrer="<?= current_url() ?>"onclick="refresh_inprogress(this), location.reload()">Refresh this page</a></p>
	<p>Designed and built with <?= random(['💚', '💛', '🧡', '❤️', '💜', '💙']) ?> by <a target="_blank" href="<?= $head[
 	'site_lex'
 ] ?>" <?= $head['site_lex_goat'] ?>><?= $head[
	'author'
] ?></a>,<br />listener and fan of the <a target="_blank" href="<?= $head['site_connected'] ?>" <?= $head[
	'site_connected_goat'
] ?>>Connected</a> podcast.</p>
	<a target="_blank" href="<?= $head['site_lex'] ?>" <?= $head['site_lex_goat'] ?> id="footer_corner">
		<img src="/images/lex-logo.svg" alt="<?= $head['author'] ?> logo"/>
    </a>
</footer>

<script>
	function refresh_inprogress(el) {
		el.innerText = "Refreshing…";
	}

	let footer = document.getElementById('footer');

	function promote_standalone() {
		if(
			(navigator.userAgent.indexOf('iPhone') != -1) ||
			(navigator.userAgent.indexOf('iPad') != -1)
		) {
			if(window.navigator.standalone == true){
				// Added to home screen, offer refresh
				footer.classList.add('is_standalone');
			} else {
				// Not added to home screen, promote web app
				footer.classList.add('isnot_standalone');
			}
		} else {
			// Not iOS
		}
	}

	promote_standalone()
</script>