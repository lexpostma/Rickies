<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions.php';

// Is "billof" a URL parameter?
if ((isset($_GET['sub']) && $_GET['sub'] == 'billof') || $url_view == 'billof' || $url_view == 'charter') {
	// Does the URL include "thebillof" for The Bill of Rickies?
	$focus_site = 'billofrickies';
} else {
	// Default "rickies"
	$focus_site = 'rickies';
}

// Include the controller of get all the data before the HTML begins
include $incl_path . 'view_controllers/' . $focus_site . '_controller.php';
?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<?php include $incl_path . 'head.php'; ?>
	</head>
	<body>
		<div id="top" class="container">
		<?php
  include $include_body;
  echo '<script src="/scripts/index.umd.js?v=' . $refresh . '"></script>';
  echo '<script>' .
  	file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/share_and_search.js') .
  	file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/standalone.js') .
  	'</script>';
  ?>
		</div>
	</body>
</html>
