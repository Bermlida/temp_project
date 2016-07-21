<?php

namespace App\Models\Repositories;

use App\Models\Foundations\Repository;

class UserRepository extends Repository
{
    private $user;

    public function test()
    {
        echo 'in UserRepository by use facade by class alias';
    }
}