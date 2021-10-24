<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions.php';

$errors = [
	400 => ['Bad Request', 'The server could not understand the request due to invalid syntax.'],
	401 => ['Unauthenticated', 'You must authenticate yourself to get the requested response.'],
	403 => [
		'Forbidden',
		'You do not have access rights to the content; that is, it is unauthorized, so the server is refusing to give the requested resource.',
	],
	404 => [
		'Not Found',
		'The Rickies you are looking for do not exist. Maybe they are in the future, or they have not been added to the website yet because of timezone differences or other circumstances.

All available Rickies can be found on [the main overview](/).',
	],
	406 => [
		'Not Acceptable',
		'This response is sent when the web server, after performing server-driven content negotiation, doesn’t find any content that conforms to the criteria given by the user agent.',
	],
	409 => ['Conflict', 'This response is sent when a request conflicts with the current state of the server.'],
	413 => ['Payload Too Large', 'Request entity is larger than limits defined by server.'],
	414 => ['URI Too Long', 'The URI requested by the client is longer than the server is willing to interpret.'],
	500 => ['Internal Server Error', 'The server has encountered a situation it doesn’t know how to handle.'],
	501 => ['Not Implemented', 'The request method is not supported by the server and cannot be handled.'],
	502 => [
		'Bad Gateway',
		'This error response means that the server, while working as a gateway to get a response needed to handle the request, got an invalid response.',
	],
	503 => [
		'Service Unavailable',
		'The server is not ready to handle the request. Common causes are a server that is down for maintenance or that is overloaded.

In this case it probably means that Airtable is down or under maintenance. [Check Airtable’s status](https://status.airtable.com) to be sure.',
	],
	504 => [
		'Gateway Timeout',
		'This error response is given when the server is acting as a gateway and cannot get a response in time.',
	],
];

if (!isset($error_code)) {
	$error_code = 404;
}

header('HTTP/1.0 ' . $error_code . ' ' . ucfirst($errors[$error_code][0]));
$focus_site = 'error';

$head_custom = [
	'title' => $errors[$error_code][0] . ' • The Rickies',
	'description' => $error_code . ': ' . strip_tags(markdown($errors[$error_code][1])),
];
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <?php include $incl_path . 'head.php'; ?>
    </head>
    <body>
		<div class="container">
	        <?= back_button() . search_button() ?>
	        <header class="details">
	            <div class="gradient"></div>
	            <div class="big_year"><?= $error_code ?></div>
	            <h1><?= $errors[$error_code][0] ?></h1>
	        </header>
	        <section>
	            <?= markdown($errors[$error_code][1]) ?>
				<p><i>More about <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Status">HTTP response status codes</a> at Mozilla.</i></p>
	        </section>
<?php
include $incl_path . 'footer.php';
echo '<script>' . file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/standalone.js') . '</script>';
?>
		</div>
    </body>
</html>
