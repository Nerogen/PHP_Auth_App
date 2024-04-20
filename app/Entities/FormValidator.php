<?php

namespace App\Entities;

use App\Models\Model;

class FormValidator extends RegistrationFormValidation
{

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