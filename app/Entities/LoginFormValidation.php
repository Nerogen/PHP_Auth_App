<?php

namespace App\Entities;


class LoginFormValidation implements LoginValidationInterface
{
    private int $minFieldsLength = 6;

    public function loginValidation($login): string
    {
        // return "" -> false   || "Login must be more than 5 characters" -> true
        // (error not occurred) || (error occurred)
        $message = "";

        if (strlen($login) < $this->minFieldsLength) {
            $message = "Login must be more or equal to {$this->minFieldsLength} characters";
        }
        return $message;
    }

    public function passwordValidation($password): string
    {
        $message = "";
        if (strlen($password) < $this->minFieldsLength) {
            $message = "Password must be more or equal to {$this->minFieldsLength} characters";
        } elseif (!ctype_alnum($password) || (ctype_digit($password) || ctype_alpha($password))) {
            $message = "Password must contain letters and numbers";
        }
        return $message;
    }
}