<?php

if (isset($back_to_overview)) {
	echo "<a id='back_button' href='/'>";
	include('../public_html/images/back-button.svg');
	echo "</a>";
}

include($include_subbody);

?>

<footer>
	<p>Designed and built with <?=random_from(array("💚","💛","🧡","❤️","💜","💙"))?> by <a href="https://lexpostma.me">Lex Postma</a>,<br />listener and fan of the <a href="https://relay.fm/connected">Connected</a> podcast</p>
</footer>