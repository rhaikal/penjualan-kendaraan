<?php

namespace App\Services;

use App\Repository\UserRepository;
use Illuminate\Auth\AuthenticationException;

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

    public function getAuthByLogin(array $credentials, bool $remember)
    {
        $auth = [];

        if($remember) {
            $auth['exp'] = 720;
            auth()->factory()->setTTL(720);
        }

        $auth['token'] = auth()->attempt($credentials);
        if(!(!!$auth['token'])) throw new AuthenticationException();

        $auth['user'] = auth()->user();

        return $auth;
    }
}
