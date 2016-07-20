<?php

namespace App\Models\Repositories;

class UserRepository extends Repository
{
    private $user;

    public function test()
    {
        echo 'in UserRepository by use facade by class alias';
    }
}