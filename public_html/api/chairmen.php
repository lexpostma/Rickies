<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions.php';

header('Content-Type: application/json; charset=utf-8');

include $_SERVER['DOCUMENT_ROOT'] . '/../includes/data_controllers/magtricky_data_controller.php';
echo json_encode($api__array);
