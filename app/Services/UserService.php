<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends Service
{
    protected $user_repository;

    public function __construct(UserRepository $user_repository) 
    {
        $this->user_repository = $user_repository;
    }

    public function addUser(array $data)
    {
        $user = $this->user_repository->create($data);
        $this->result_flag = true;
        $this->result_data = $user;
        return $this;
    }

    public function updateUser(array $data, $id)
    {
        $user = $this->user_repository->update($data, $id);
        
        if (!is_null($user)) {
            $this->result_flag = true;
            $this->result_data = $user;
        } else {
            $this->result_flag = false;
            $this->result_message = 'user not found, maybe user id incorrect';
        }
        return $this;
    }
}

/* End of file UserService.php */
/* Location: .//home/tkb-user/projects/laravel/app/Services/UserService.php */