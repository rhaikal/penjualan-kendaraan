<?php

namespace App\Http\Controllers;

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
}
