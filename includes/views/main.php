<?php

if (isset($back_to_overview)) {
	echo back_button();
}

include $include_subbody;
?>

<footer>
	<p>Designed and built with <?= random([
 	"💚",
 	"💛",
 	"🧡",
 	"❤️",
 	"💜",
 	"💙",
 ]) ?> by <a href="https://lexpostma.me">Lex Postma</a>,<br />listener and fan of the <a href="https://relay.fm/connected">Connected</a> podcast</p>
</footer>