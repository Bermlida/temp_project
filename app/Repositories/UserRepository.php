<?php

namespace App\Repositories;

use App\Repositories\Entities\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create(array $data)
    {
        $user = $this->user->create($data);
        return $user;
    }

    public function update(array $data, int $id)
    {
        $user = $this->user->find($id);

        if (!is_null($user)) {
            foreach ($data as $key => $value) {
                if (isset($user->$key)) {
                    $user->$key = $value;
                }
            }
            $user->save();
        }
        
        return $user;
    }
}

/* End of file UserRepository.php */
/* Location: .//home/tkb-user/projects/laravel/app/Repositories/UserRepository.php */