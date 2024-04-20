<?php

namespace App\Entities;

interface DBInterface
{
    public function __construct($dbPass);

    public function readFromDB();

    public function writeToDB($data);
}