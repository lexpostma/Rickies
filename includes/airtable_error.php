<?php
// Response from Airtable is not countable, so it's probably an error instead of an empty array
// Continue with 503 error
$error_code = 503;
include $incl_path . 'error.php';
die();
