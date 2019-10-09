<?php
namespace App\Entity;

class User
{
    private $id;
    private $name;

    public function setName($name)
    {
        $this->name = $name;
    }
}