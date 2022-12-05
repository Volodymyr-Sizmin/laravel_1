<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RecoveryPasswordRequest;
use App\Http\Requests\RegisterRequest;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Exception;

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
            return response()->json(null, 401);
        }
        return response()->json( $user->createToken('AccessToken'), 200);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->userService->storeResetToken($request->validated());

        return response()->json('Token sent to Email',200);
    }

    public function recoveryPassword(RecoveryPasswordRequest $request)
    {
        try{
            $this->userService->updatePassword($request->validated());
        } catch (Exception $e){
            return response()->json($e->getMessage(), 422);
        }
        return response()->json("password updated",200);
    }

    public function updateUser(UpdateUserRequest $request, User $user)
    {
       $this->userService->updateUser($user, $request->validated());
       return response()->json('updated', 200);
    }

    public function index()
    {
        $allUsersEmail = User::all()->pluck('email');
        return new UserResource($allUsersEmail);
    }

    public function show(ShowUserRequest $request,User $user)
    {
        return new UserResource($user);
    }
}
