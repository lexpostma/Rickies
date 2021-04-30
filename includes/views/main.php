<?php

if (isset($back_to_overview)) {
	echo back_button();
}

include $include_subbody;
?>

<footer>
	<p>Designed and built with <?= random([
 	'💚',
 	'💛',
 	'🧡',
 	'❤️',
 	'💜',
 	'💙',
 ]) ?> by <a target="_blank" href="https://lexpostma.me">Lex Postma</a>,<br />listener and fan of the <a target="_blank" href="<?= $head[
 	'site_connected'
 ] ?>">Connected</a> podcast</p>
</footer>

<script>
<?php
include 'scripts/confetti.js';
if ($url_view == 'main') {
	echo 'confetti_go()';
}
?>
</script>