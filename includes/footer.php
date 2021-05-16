<div class="footer_space"></div>
<footer id="footer">
	<p id="promote_webapp" class="offer_sheet">This website is designed as a web app.<br /><button class="clean js_link" type="button" data-goatcounter-click="Add to home" title="Add it to your home screen" data-goatcounter-referrer="<?= current_url() ?>" onclick="open_share_sheet()">Add it to your home screen</button> for the best experience.</p>
	<p id="refresh_page"><button title="Refresh page" class="clean js_link" type="button" data-goatcounter-click="Refresh page" data-goatcounter-referrer="<?= current_url() ?>" onclick="refresh_inprogress(this), location.reload()">Refresh this page</button></p>
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
	<? echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/standalone.js')?>
</script>