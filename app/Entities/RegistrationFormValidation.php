<?php

namespace App\Entities;

class RegistrationFormValidation extends LoginFormValidation
{
    public function emailValidation($email): string
    {
        $message = "";
        if ((strlen($email) < 2 || !preg_match("/^[A-Za-z]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", $email))) {
            $message = "Email must be more then 1 characters and with only letters";
        }
        return $message;
    }

    public function repeatPasswordValidation($pass, $repeatPass): string
    {
        $message = "";
        if ($pass != $repeatPass) {
            $message = "Password does not match";
        }
        return $message;
    }
}