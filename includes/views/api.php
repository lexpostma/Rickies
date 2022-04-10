<div id="statusbar"></div>
<header class="about contain_img">
	<div class="gradient"></div>
	<img src="/images/memoji/api-hosts.png" alt="Lex’ Memoji"/>
	<h1>Rickies API</h1>
</header>

<?= navigation_bar('api') ?>

<section>
	<p>The Rickies API gives you access to different data points from the Rickies. The first one can be used via <code><a href="<?= domain_url() ?>/api/chairmen.json" target="_blank">/api/chairmen.json</a></code> which allows you to fetch who the current chairmen are. The response is formatted in JSON and looks like this:</p>
	<pre><?= json_encode($api__array, JSON_PRETTY_PRINT) ?></pre>
	<p>More APIs for other data points could come in the future.</p>
	<p>Are you using the API, or want to use it but are missing data? Please get in touch on Twitter <a href="https://twitter.com/lexpostma" target="_blank" data-goatcounter-click="https://twitter.com/lexpostma" title="Go to @lexpostma">@lexpostma</a>, via <a href="mailto:rickies@lexpostma.me" data-goatcounter-click="Feedback email" title="Email me">email</a> or in the Relay FM members <a href="https://discordapp.com/users/824348644509483028">Discord</a>.</p>
</section>

<section><?= list_item_bundle($api_consumers) ?></section>
