<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions.php';

// Define Airtable integration
include $incl_path . 'airtable/Airtable.php';
include $incl_path . 'airtable/Request.php';
include $incl_path . 'airtable/Response.php';
use TANIOS\Airtable\Airtable;

$airtable = new Airtable([
	'api_key' => getenv('AIRTABLE_API'),
	'base' => getenv('AIRTABLE_BASE'),
]);

// Is "billof" a URL parameter?
if ((isset($_GET['sub']) && $_GET['sub'] == 'billof') || $url_view == 'billof') {
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
		<? include($incl_path.'head.php'); ?>
	</head>
	<body>
		<? include($include_body);
		echo '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/share_button.js') . '</script>';
		?>
	</body>
</html>