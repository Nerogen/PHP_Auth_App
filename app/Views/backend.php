<?php
session_start();
require_once "../../vendor/autoload.php";

//Check if the request is an AJAX request
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    header('HTTP/1.0 403 Forbidden');
    exit("Access denied");
}


$controller = new App\Controllers\Controller($_POST['login'], $_POST['password'], $_POST['repeatPass'], $_POST['email']);