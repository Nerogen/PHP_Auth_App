<?php

namespace App\Controllers;

use App\Models\Model;

class Controller
{
    public function run($login, $pass, $repeatPass, $email): void
    {
        $validator = new Validator();
        $validation = $validator->isValid($login, $pass, $repeatPass, $email);

        if ($validation['success'] && $repeatPass && $email) {
            $model = new Model('../../db/db.json');
            $salt = 'hello';
            $model->create($login, md5($salt . $pass), $repeatPass, $email);
            echo json_encode($validation);
        } else if ($validation['success'] && !$repeatPass && !$email) {
            $_SESSION['user'] = $login;
            $cookie_name = "user";
            $cookie_value = $login;
            setcookie($cookie_name, $cookie_value, time() + (300), "/");
            $validation['user'] = $login;
            echo json_encode($validation);
        } else {
            echo json_encode($validation);
        }
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        $cookie_name = "user";
        setcookie($cookie_name, '', time() - 3600, '/');
        session_destroy();

        echo json_encode(['logout' => true]);
    }
}

session_start();
require_once "../../vendor/autoload.php";
$controller = new Controller();
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    echo json_encode(["login" => "Access denied (request isn't from ajax)"]);
}
else if ($_POST['logout']) {
    $controller->logout();
}
else{
    $controller->run($_POST['login'], $_POST['password'], $_POST['repeatPass'], $_POST['email']);
}