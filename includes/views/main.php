<?php

if (isset($back_to_overview)) {
	echo back_button();
}
echo share_button();
include $include_subbody;
include $incl_path . 'footer.php';
?>

<script>
<?php
include 'scripts/confetti.js';
if ($url_view == 'main') {?>

	document.addEventListener('DOMContentLoaded', function (event) {
		if(!Cookies.get('confetti_popped')) {
			confetti_go()
			Cookies.set('confetti_popped', 'true', { expires: 2, path: '/' })
		}
	});

<? } ?>



</script>