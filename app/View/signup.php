<?php
session_start();
$login = $_POST['login'];
$pass = $_POST['password'];
$repeatPass = $_POST['confpass'];
$email = $_POST['email'];


if (strlen($login) < 6) {
    $_SESSION['Login incorrect'] = "Login must be more then 5 characters";
    header("location: ../register.php");
    exit;
} else if (strlen($pass) < 6) {
    $_SESSION['Password incorrect'] = "Password must be more then 5 characters";
    header("location: ../register.php");
    exit;
} else if (!ctype_alnum($pass) || (ctype_digit($pass) || ctype_alpha($pass))) {
    $_SESSION['Password incorrect'] = "Password must contain letters and numbers";
    header("location: ../register.php");
    exit;
} else if ($pass != $repeatPass) {
    $_SESSION['Password does not match'] = "Password does not match";
    header("location: ../register.php");
    exit;
} else if (strlen($email) < 2 || !preg_match("/^[A-Za-z]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", $email)) {
    $_SESSION['Email incorrect'] = "Email must be more then 1 characters and with only letters";
    header("location: ../register.php");
    exit;
}

$jsonData = file_get_contents('../db/db.json');
$data = json_decode($jsonData, true);

$flag = false;

foreach ($data as $id => $userInfo) {
    foreach ($userInfo as $key => $value) {

        if ($value == $login) {
            $_SESSION['Login incorrect'] = "Login must be unique";
            $flag = True;
            break;
        }
        if ($value == $email) {
            $_SESSION['Email incorrect'] = "Email must be unique";
            $flag = true;
            break;
        }
    }
    if ($flag) {
        break;
    }
}

if ($flag) {
    header("location: ../register.php");
} else {
    $index = count($data) + 1;

    $userData = array(
        "login" => $login,
        "password" => $pass,
        "confirm pass" => $repeatPass,
        "email" => $email
    );

    $data[$index] = $userData;


    file_put_contents('../db/db.json', json_encode($data));
    header("Location: ../login.php");
    exit;
}