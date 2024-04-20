<?php

namespace App\Controllers;

use App\Models\Model;

class Validator
{
    private function loginValidation($login): string
    {
        // return "" -> false   || "Login must be more than 5 characters" -> true
        // (error not occurred) || (error occurred)
        $message = "";

        if (strlen($login) < 6) {
            $message = "Login must be more than 5 characters";
        }
        return $message;
    }

    private function passwordValidation($pass): string
    {
        $message = "";
        if (strlen($pass) < 6) {
            $message = "Password must be more than 5 characters";
        } elseif (!ctype_alnum($pass) || (ctype_digit($pass) || ctype_alpha($pass))) {
            $message = "Password must contain letters and numbers";
        }
        return $message;
    }

    private function emailValidation($email): string
    {
        $message = "";
        if ((strlen($email) < 2 || !preg_match("/^[A-Za-z]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", $email))) {
            $message = "Email must be more then 1 characters and with only letters";
        }
        return $message;
    }

    private function repeatPasswordValidation($pass, $repeatPass): string
    {
        $message = "";
        if ($pass != $repeatPass) {
            $message = "Password does not match";
        }
        return $message;
    }

    private function isValidAuthData($login, $pass): array
    {
        $errors = [];
        $model = new Model('../../db/db.json');
        $salt = 'hello';

        $loginResult = $this->loginValidation($login);
        $passResult = $this->passwordValidation($pass);
        $loginIsInDB = $model->readByLogin($login);


        if ($loginResult) {
            $errors['login'] = $loginResult;
        }
        if (!$loginIsInDB) {
            $errors['login'] = "User isn't exist";
        }
        if ($passResult) {
            $errors['password'] = $passResult;
        }
        if (md5($salt . $pass) != $loginIsInDB['password']) {
            $errors['password'] = 'Password error';
        }
        return $errors;
    }

    private function isValidRegistrationData($login, $pass, $repeatPass, $email): array
    {
        $model = new Model('../../db/db.json');
        $errors = [];

        $repeatPassResult = $this->repeatPasswordValidation($pass, $repeatPass);
        $emailResult = $this->emailValidation($email);
        $emailIsInDB = $model->readByEmail($email);
        $loginIsInDb = $model->readByLogin($login);
        $loginResult = $this->loginValidation($login);
        $passResult = $this->passwordValidation($pass);

        if ($loginResult) {
            $errors['login'] = $loginResult;
        }
        if ($loginIsInDb) {
            $errors['login'] = "User already exist!";
        }
        if ($passResult) {
            $errors['password'] = $passResult;
        }
        if ($repeatPassResult) {
            $errors['repeatPass'] = $repeatPassResult;
        }
        if ($emailResult) {
            $errors['email'] = $emailResult;
        }
        if ($emailIsInDB) {
            $errors['email'] = 'Email already exist!';
        }

        return $errors;
    }

    public function isValid($login, $pass, $repeatPass, $email): array
    {
        // define form for validation
        // registration -> 4 fields | auth -> 2 fields
        if (!$repeatPass && !$email) {
            $result = $this->isValidAuthData($login, $pass);
        } else {
            $result = $this->isValidRegistrationData($login, $pass, $repeatPass, $email);
        }

        if ($result) {
            return ['error' => $result];
        } else {
            return ['success' => true];
        }
    }
}