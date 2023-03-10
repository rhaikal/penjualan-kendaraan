<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $registerRequest)
    {
        $validatedData = $registerRequest->validated();

        $auth = $this->userService->getAuthAndRegister($validatedData);
        return new UserResource($auth, 'Berhasil registrasi');
    }

    public function login(LoginRequest $loginRequest)
    {
        $validatedData = $loginRequest->validated();

        $auth = $this->userService->getAuthByLogin([
            'email' => $validatedData['email'],
            'password' => $validatedData['password']
        ], $validatedData['remember']);

        return new UserResource($auth, 'Berhasil login');
    }

    public function data()
    {
        return new UserResource($this->userService->getAuthUser(), 'Berhasil mendapatkan data user');
    }

    public function logout()
    {
        $this->userService->logout();

        return response()->json(['message' => 'Berhasil logout']);
    }

    public function refresh()
    {
        $auth = $this->userService->refreshToken();

        return new UserResource($auth, 'Berhasil merefresh token');
    }
}
