<?php

namespace App\Models;

use App\Entities\CRUDDBInterface;

class Model implements CRUDDBInterface
{
    private string $dbPass;

    public function __construct($dbPass)
    {
        $this->dbPass = $dbPass;
    }

    public function readFromDB(): array
    {
        $jsonData = file_get_contents($this->dbPass);
        return json_decode($jsonData, true);
    }

    public function writeToDB($data): bool
    {
        $jsonData = json_encode($data);
        return file_put_contents($this->dbPass, $jsonData) !== false;
    }

    public function create(string $login, string $password, string $email): bool
    {
        $data = $this->readFromDB();

        // Generate unique ID for the new user
        $id = uniqid();

        // Create user data
        $userData = [
            'login' => $login,
            'password' => $password,
            'email' => $email
        ];

        // Add user data to the database
        $data[$id] = $userData;

        return $this->writeToDB($data);
    }

    public function readByLogin(string $login): ?array
    {

        $data = $this->readFromDB();

        foreach ($data as $userInfo) {  // find user by login
            if ($userInfo['login']) {
                if ($userInfo['login'] === $login) {
                    return $userInfo;
                }
            }
        }

        return null; // User not found
    }

    public function readByEmail(string $email): ?array
    {

        $data = $this->readFromDB();

        foreach ($data as $userInfo) {  // find user by login
            if ($userInfo['email'] === $email) {
                return $userInfo;
            }
        }

        return null; // User not found
    }

    public function update(string $login, string $password, string $email): bool
    {
        $data = $this->readFromDB();

        // Find the user by login
        foreach ($data as $id => $userInfo) {
            if ($userInfo['login'] === $login) {
                // Update user data
                $data[$id]['password'] = $password;
                $data[$id]['email'] = $email;

                return $this->writeToDB($data);
            }
        }

        return false; // User not found
    }

    public function delete(string $login): bool
    {
        $data = $this->readFromDB();

        // Find the user by login
        foreach ($data as $id => $userInfo) {
            if ($userInfo['login'] === $login) {
                // Remove user data from the database
                unset($data[$id]);

                return $this->writeToDB($data);
            }
        }

        return false; // User not found
    }
}