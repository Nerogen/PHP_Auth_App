<?php

namespace App\Controllers;

class Validator
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
}