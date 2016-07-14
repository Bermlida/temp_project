<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $user_repository;

    public function __construct(UserRepository $user_repository) 
    {
        $this->user_repository = $user_repository;
    }

    public function addUser(array $data)
    {
        $new_user = $this->user_repository->create($data);
        return $new_user;
    }

    public function updateUser(array $data, $id)
    {
        $user = $this->user_repository->update($data, $id);
        return $user;
    }
}

/* End of file UserService.php */
/* Location: .//home/tkb-user/projects/laravel/app/Services/UserService.php */