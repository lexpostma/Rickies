<?php

if (isset($back_to_overview)) {
	echo back_button();
}
if ($url_view !== 'search' && $url_view !== 'archive') {
	echo search_button();
}
echo share_button();
include $include_subbody;
include $incl_path . 'footer.php';

if ($url_view !== 'search' && $url_view !== 'archive') {
	echo '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/search.js') . '</script>';
}

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
echo '</script>
<script src="/scripts/accordion.js"></script>';
