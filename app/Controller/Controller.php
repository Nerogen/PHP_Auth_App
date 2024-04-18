<?php

namespace App\Controller;

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

    public function loginValidation(): string
    {
        $message = "";
        if (strlen($this->login) < 6) {
            $message =  "Login must be more than 5 characters";
        }
        return $message;
    }

    public function passwordValidation(): string
    {
        $message = "";
        if (strlen($this->pass) < 6) {
            $message = "Password must be more than 5 characters";
        } elseif (!ctype_alnum($this->pass) || (ctype_digit($this->pass) || ctype_alpha($this->pass))) {
            $message = "Password must contain letters and numbers";
        }
        return $message;
    }

    public function emailValidation(): string
    {
        $message = "";
        if ((strlen($this->email) < 2 || !preg_match("/^[A-Za-z]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", $this->email))) {
            $message = "Email must be more then 1 characters and with only letters";
        }
        return $message;
    }

    public function repeatPasswordValidation(): string
    {
        $message = "";
        if ($this->pass != $this->repeatPass) {
            $message = "Password does not match";
        }
        return $message;
    }

    public function isValidAuthData(): array
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

    public function isValidRegistrationData(): array
    {
        $errors = $this->isValidAuthData();
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
        if (!$this->repeatPass && !$this->email) {
            $result = $this->isValidAuthData();
        }
        else {
            $result = $this->isValidRegistrationData();
        }

        if ($result) {
            return json_encode(['error' => $result]);
        }
        else {
            return json_encode(['success' => true]);
        }
    }

}