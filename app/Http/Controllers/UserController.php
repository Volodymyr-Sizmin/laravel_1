<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RecoveryPasswordRequest;
use App\Http\Requests\RegisterRequest;

use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Services\RecoveryPasswordService;
use App\Services\ResetPasswordService;
use App\Services\UserService;
use Carbon\Carbon;

class UserController extends Controller
{
    protected UserService $userService;
    protected ResetPasswordService $resetPasswordService;
    protected RecoveryPasswordService $recoveryPasswordService;


    public function __construct(UserService $userService,
                                ResetPasswordService $resetPasswordService,
                                RecoveryPasswordService $recoveryPasswordService)
    {
        $this->userService = $userService;
        $this->resetPasswordService =  $resetPasswordService;
        $this->recoveryPasswordService = $recoveryPasswordService;
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

    public function reset_password(ResetPasswordRequest $request)
    {
        $this->resetPasswordService->storeResetToken($request->validated());

        return response('Token sent to Email');
    }

    public function recovery_password(RecoveryPasswordRequest $request)
    {
        $this->recoveryPasswordService->updatePassword($request->validated());
        return response('Password updated');
    }

}
