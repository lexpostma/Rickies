<?php
	require '../includes/functions.php';

	include('../includes/Parsedown.php');
	include('../includes/airtable/Airtable.php');
	include('../includes/airtable/Request.php');
	include('../includes/airtable/Response.php');

	use TANIOS\Airtable\Airtable;

	$airtable = new Airtable(array(
		'api_key'   => getenv("AIRTABLE_API"),
		'base'      => getenv("AIRTABLE_BASE")
	));

	if(getenv("ENVIRONMENT") !== false) {
		$environment = getenv("ENVIRONMENT");
	} else {
		$environment = "debug";
	}

	if(isset($_GET['view'])){
		$url_view = $_GET['view'];
	} else {
		$url_view = "main";
	}

	if (in_array("thebillof", explode(".", $_SERVER['HTTP_HOST']))) {
		$subdomain = "billofrickies";
	} else {
		$subdomain = "rickies";
	};
	include("../includes/controllers/".$subdomain."_controller.php");

// echo "<br />".current_url();
// echo "<br /><pre>",var_dump($_SERVER),"</pre>";

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