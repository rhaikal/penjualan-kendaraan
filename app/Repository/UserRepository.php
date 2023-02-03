<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }
}
