<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(RegisterRequest $request)
    {
//        $users = User::create($request->validated());

        $users = new User();
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->password = Hash::make($request->input('password'));

        $users->save();

        $token = $users->createToken('LaravalPassportToken')->accessToken;
        return response()->json(['token' => $token], 201);
    }

}
