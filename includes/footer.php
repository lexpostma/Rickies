<div class="footer_space"></div>
<!-- <footer id="footer_links">
	<div >
		<p>
			<a href="/about">About Rickies.co</a><br/><br/>
			<a href="/latest">Latest Rickies</a><br/>
			<a href="/latest-keynote">Latest Keynote</a><br/>
			<a href="/latest-annual">Latest Annual</a>
		</p>
		<p>
			<b>Filter Rickies</b><br/>
			<a href="/annual">Annual Rickies</a><br/>
			<a href="/keynote">Keynote Rickies</a><br/>
			<a href="/wwdc">WWDC Rickies</a><br/>
			<a href="/ungraded">Ungraded Rickies</a>
		</p>
		<p>
			<b>Filter picks</b><br/>
			<a href="/?search=&eventually=on#results">Ahead of its time</a><br/>
			<a href="/?search=&reuse=on#results">Eligible for reuse</a><br/>
		</p>
	</div>
</footer> -->
<footer id="footer">
	<p id="promote_webapp">This website is designed as a web app.<br />Add it to your home screen for the best experience.</p>
	<p id="refresh_page"><button title="Refresh page" class="clean js_link" type="button" data-goatcounter-click="Refresh page" data-goatcounter-referrer="<?= current_url() ?>" onclick="refresh_inprogress(this), location.reload()">Refresh this page</button></p>
	<p>Designed and built with <img src="/images/sixheart.png" class="img_emoji" alt="love" /> by <a target="_blank" href="<?= $head[
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
