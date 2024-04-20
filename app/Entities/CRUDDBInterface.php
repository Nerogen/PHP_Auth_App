<?php

namespace App\Entities;

interface CRUDDBInterface extends DBInterface
{
    public function create(string $login, string $password, string $email);

    public function readByLogin(string $login);

    public function readByEmail(string $email);

    public function update(string $login, string $password, string $email);

    public function delete(string $login);
}