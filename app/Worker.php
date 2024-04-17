<?php

namespace app;

class Worker
{
    public string $name;
    public string $age;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setAge(string $age): void
    {
        $this->age = $age;
    }
}

$worker = new Worker();
$worker->setName("Andy");
$worker->setAge("11");
echo $worker->name.'<br>';
echo $worker->age.'<br>';