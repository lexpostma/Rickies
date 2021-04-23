<?php

require "../includes/functions.php";
include "../includes/Parsedown.php";

// Define Airtable integration
include "../includes/airtable/Airtable.php";
include "../includes/airtable/Request.php";
include "../includes/airtable/Response.php";
use TANIOS\Airtable\Airtable;

$airtable = new Airtable([
	"api_key" => getenv("AIRTABLE_API"),
	"base" => getenv("AIRTABLE_BASE"),
]);

// Define currently running environment
if (getenv("ENVIRONMENT") !== false) {
	$environment = getenv("ENVIRONMENT");
} else {
	$environment = "debug";
}

// What view is requested?
if (isset($_GET["view"])) {
	$url_view = $_GET["view"];
} else {
	$url_view = "main";
}

// What subdomain is being requested?
// This was done to enable a more dynamic URL
// The result will open the corresponder controller
if (in_array("thebillof", explode(".", $_SERVER["HTTP_HOST"]))) {
	// Does the subdomain include "thebillof" for The Bill of Rickies?
	$subdomain = "billofrickies";
} else {
	// Default "rickies"
	$subdomain = "rickies";
}

// Include the controller of get all the data before the HTML begins
include "../includes/controllers/" . $subdomain . "_controller.php";
?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<? include("../includes/head.php"); ?>
	</head>
	<body>
		<? include($include_body);?>
	</body>
</html>