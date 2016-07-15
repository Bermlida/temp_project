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

    public function showUserList()
    {
        $users = $this->user_repository->find();
        $this->result_data = $users;
        $this->result_flag = true;
        return $this->result;
    }

    public function showUser($id)
    {
        $user = $this->user_repository->get($id);
        if (!is_null($user)) {
            $this->result_flag = true;
            $this->result_data = $user;
        } else {
            $this->result_flag = false;
            $this->result_message = 'user not found, maybe user id incorrect';
        }
        return $this;
    }

    public function addUser(array $data)
    {
        $user = $this->user_repository->create($data);
        $this->result_flag = true;
        $this->result_data = $user;
        return $this->result;
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

    public function deleteUser($id)
    {
        $user = $this->user_repository->delete($id);
        if (!is_null($user)) {
            $this->result_flag = true;
            $this->result_message = 'user delete';
        } else {
            $this->result_flag = false;
            $this->result_message = 'user not found, maybe user id incorrect';
        }
        return $this;
    }
}

/* End of file UserService.php */
/* Location: .//home/tkb-user/projects/laravel/app/Services/UserService.php */