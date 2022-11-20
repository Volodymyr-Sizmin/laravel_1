<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        $token = $user->createToken('LaravalPassportToken')->accessToken;
        return response()->json(['token' => $token], 201);
    }

}
