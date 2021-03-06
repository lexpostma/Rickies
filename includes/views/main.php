<?php

if (isset($back_to_overview)) {
	echo back_button();
}
if ($url_view !== 'search' && $url_view !== 'archive' && $url_view !== '3j-archive') {
	if (!isset($triple_j)) {
		echo search_button();
	} else {
		echo search_button(true);
	}
}
echo share_button();
include $include_subbody;
include $incl_path . 'footer.php';

echo '<script>';
include 'scripts/confetti.js';
if ($url_view == 'main') { ?>

	document.addEventListener('DOMContentLoaded', function (event) {
		if(!Cookies.get('confetti_popped')) {
			confetti_go()
			Cookies.set('confetti_popped', 'true', { expires: 0.2, path: '/' })
		}
	});

<?php }
echo '</script>';

if ($url_view == 'search' || $url_view == 'archive') {
	echo '<script src="/scripts/accordion.js"></script>';
}

if ($url_view == 'search' || $url_view == 'archive' || $url_view == '3j-archive' || $url_view == 'about') { ?>

<script>
	var mainNav = document.querySelectorAll('.nav_content.multicolor')[0];
	document.addEventListener('DOMContentLoaded', function (event) {
		mainNav.scrollLeft = mainNav.scrollWidth;
	});
</script>

<?php }
