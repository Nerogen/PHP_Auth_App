<?php

namespace App\Entities;

interface LoginValidationInterface
{
    public function loginValidation($login);
    public function passwordValidation($password);
}