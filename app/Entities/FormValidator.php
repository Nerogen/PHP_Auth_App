<?php

namespace App\Entities;

use App\Models\Model;

class FormValidator extends RegistrationFormValidation
{

    private Model $model;
    private string $salt;

    public function __construct(string $passToDb, string $salt) {
        $this->model = new Model($passToDb);
        $this->salt = $salt;
    }
    private function isValidAuthData($login, $pass): array
    {
        $errors = [];
        $loginResult = $this->loginValidation($login);
        $passResult = $this->passwordValidation($pass);
        $loginIsInDB = $this->model->readByLogin($login);


        if ($loginResult) {
            $errors['login'] = $loginResult;
        }
        if (!$loginIsInDB) {
            $errors['login'] = "User isn't exist";
        }
        if ($passResult) {
            $errors['password'] = $passResult;
        }
        if (md5($this->salt . $pass) != $loginIsInDB['password']) {
            $errors['password'] = 'Password error';
        }
        return $errors;
    }

    private function isValidRegistrationData($login, $pass, $repeatPass, $email): array
    {
        $errors = [];

        $repeatPassResult = $this->repeatPasswordValidation($pass, $repeatPass);
        $emailResult = $this->emailValidation($email);
        $emailIsInDB = $this->model->readByEmail($email);
        $loginIsInDb = $this->model->readByLogin($login);
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