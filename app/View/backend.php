<?php
session_start();

//Check if the request is an AJAX request
//if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
//    header('HTTP/1.0 403 Forbidden');
//    exit("Access denied");
//}

require_once "../../vendor/autoload.php";

$controller = new App\Controller\Controller($_POST['login'], $_POST['password'], $_POST['repeatPass'], $_POST['email']);
echo $controller->isValid();