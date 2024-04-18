<?php

namespace App\Controllers;

class Controller
{
    private string|null $login;
    private string|null $pass;
    private string|null $repeatPass;
    private string|null $email;

    public function __construct($login, $pass, $repeatPass, $email)
    {
        $this->login = $login;
        $this->pass = $pass;
        $this->repeatPass = $repeatPass;
        $this->email = $email;
    }
    public function run(): void
    {
        session_start();
        $validation = $this->isValid();

        if ($validation['success'] && $this->repeatPass && $this->email) {
            $model = new App\Model\Model('../../db/db.json');
            $model->create($this->login, $this->pass, $this->repeatPass, $this->email);
        }
        else if ($validation['success'] && !$this->repeatPass && !$this->email) {
            $_SESSION['user'] = $this->login;
            $cookie_name = "user";
            $cookie_value = $this->login;
            setcookie($cookie_name, $cookie_value, time() + (300), "/");
        }
        else {
            echo $validation;
        }

    }

    private function checkAjaxRequest(): string
    {
        $message = "";
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            $message = "Access denied (request isn't from ajax)";
        }
        return $message;
    }

    private function loginValidation(): string
    {
        // return "" -> false   || "Login must be more than 5 characters" -> true
        // (error not occurred) || (error occurred)
        $message = "";
        if (strlen($this->login) < 6) {
            $message = "Login must be more than 5 characters";
        }
        return $message;
    }

    private function passwordValidation(): string
    {
        $message = "";
        if (strlen($this->pass) < 6) {
            $message = "Password must be more than 5 characters";
        } elseif (!ctype_alnum($this->pass) || (ctype_digit($this->pass) || ctype_alpha($this->pass))) {
            $message = "Password must contain letters and numbers";
        }
        return $message;
    }

    private function emailValidation(): string
    {
        $message = "";
        if ((strlen($this->email) < 2 || !preg_match("/^[A-Za-z]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", $this->email))) {
            $message = "Email must be more then 1 characters and with only letters";
        }
        return $message;
    }

    private function repeatPasswordValidation(): string
    {
        $message = "";
        if ($this->pass != $this->repeatPass) {
            $message = "Password does not match";
        }
        return $message;
    }

    private function isValidAuthData(): array
    {
        $errors = [];
        $loginResult = $this->loginValidation();
        $passResult = $this->passwordValidation();
        if ($loginResult) {
            $errors['login'] = $loginResult;
        }
        if ($passResult) {
            $errors['password'] = $passResult;
        }
        return $errors;
    }

    private function isValidRegistrationData(): array
    {
        $errors = $this->isValidAuthData(); // call check on (login, pass)
        $repeatPassResult = $this->repeatPasswordValidation();
        $emailResult = $this->emailValidation();

        if ($repeatPassResult) {
            $errors['repeatPass'] = $repeatPassResult;
        }
        if ($emailResult) {
            $errors['email'] = $emailResult;
        }

        return $errors;
    }

    public function isValid(): false|string
    {
        // define form for validation
        // registration -> 4 fields | auth -> 2 fields
        if (!$this->repeatPass && !$this->email) {
            $result = $this->isValidAuthData();
        } else {
            $result = $this->isValidRegistrationData();
        }

        if ($result) {
            return json_encode(['error' => $result]);
        } else {
            return json_encode(['success' => true]);
        }
    }

}