<?php

namespace App\Controllers;

use App\Entities\FormValidator;
use App\Models\Model;

class Controller
{

    private FormValidator $validator;
    private Model $model;
    private string $salt;

    public function __construct(string $passToDb, string $salt)
    {
        $this->validator = new FormValidator();
        $this->model = new Model($passToDb);
        $this->salt = $salt;
    }
    public function run($login, $pass, $repeatPass, $email): void
    {
        $validation = $this->validator->isValid($login, $pass, $repeatPass, $email);

        if ($validation['success'] && $repeatPass && $email) { // if registration form
            $this->model->create($login, md5($this->salt . $pass), $repeatPass, $email);
        } else if ($validation['success'] && !$repeatPass && !$email) {  // if login form
            $_SESSION['user'] = $login;
            $validation['user'] = $login;
            $cookie_name = "user";
            $cookie_value = $login;
            setcookie($cookie_name, $cookie_value, time() + (300), "/");
        }
        echo json_encode($validation);
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
$controller = new Controller('../../db/db.json', 'hello');
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    echo json_encode(["login" => "Access denied (request isn't from ajax)"]);
}
else if ($_POST['logout']) {
    $controller->logout();
}
else{
    $controller->run($_POST['login'], $_POST['password'], $_POST['repeatPass'], $_POST['email']);
}