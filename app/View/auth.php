<?php
session_start();
$login = $_POST['login'];
$pass = $_POST['password'];

if (strlen($login) < 6) {
    $_SESSION['Login incorrect'] = "Login must be more then 5 characters";
    header("location: ../login.php");
    exit;
} else if (strlen($pass) < 6) {
    $_SESSION['Password incorrect'] = "Password must be more then 5 characters";
    header("location: ../login.php");
    exit;
} else if (!ctype_alnum($pass) || (ctype_digit($pass) || ctype_alpha($pass))) {
    $_SESSION['Password incorrect'] = "Password must contain letters and numbers";
    header("location: ../login.php");
    exit;
}
$jsonData = file_get_contents('../db/db.json');
$data = json_decode($jsonData, true);
$index = -1;

$log = false;
$pas = false;

foreach ($data as $id => $userInfo) {
    foreach ($userInfo as $key => $value) {
        if ($key == "login" && $value == $login)
            $log = true;
        if ($key == "password" && $value == $pass)
            $pas = true;
    }
    if ($log && $pas) {
        $index = $id;
        break;
    } else if ($log && !$pas)
        $pas = false;
    else if (!$log && $pas)
        $log = false;
}

if ($index == -1) {
    $_SESSION['Login incorrect'] = "User with this login does not exist";
    header("location: ../login.php");
} else {

    $_SESSION["user"] = [
        "id" => $index,
        "login" => $data[$index]["login"]
    ];

    header("location: ../index.php");
}
exit;