<?php

namespace App\Services;

use App\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAuthAndRegister(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = $this->userRepository->create($data);

        $token = auth()->login($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }


}
