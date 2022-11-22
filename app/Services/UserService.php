<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function createUser($data)
    {
        $user = User::create($data);

        return $user;
    }

}
