<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;

use App\Services\UserService;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(RegisterRequest $request)
    {
       $user= $this->userService->createUser($request->validated());

        $token = $user->createToken('LaravalPassportToken')->accessToken;
        return response()->json(['token' => $token], 201);
    }

}
