<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

use App\Models\User;
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

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if(!auth()->attempt($request->validated())) {
            return response (null, 401);
        }
        return response( $user->createToken('AccessToken'), 200);
    }
}
