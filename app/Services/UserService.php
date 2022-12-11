<?php

namespace App\Services;

use App\Mail\DeletedUserMail;
use App\Mail\PasswordResetMail;
use App\Models\ResetPassword;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService
{
    public function createUser($data)
    {
        return User::create($data);
    }

    public function storeResetToken($data)
    {
        $user = User::where('email', $data['email'])->first();
        $token = Str::random(50);

        Mail::to($data['email'])->send(new PasswordResetMail($token));

        return ResetPassword::updateOrInsert(
            ['user_id' => $user->id],
            ['token' => $token, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );
    }

    public function updatePassword($data)
    {
        $recovery = ResetPassword::where('token', $data['token'])->first();
        if (Carbon::now()->diffInHours($recovery->created_at)>2) {
            throw new \Exception("Token is expired");
        }
        $user= User::find($recovery->user_id);
        $user->update(['password'=> $data['password']]);
        $recovery->delete();
    }

    public function updateUser($user, $data)
    {
        return $user->update($data);
    }

    public function deleteUser($user)
    {
        $user->update(['status' => User::INACTIVE]);
        $pdf = PDF::loadView('emails.pdf_for_deleted_user')->output();
        Mail::to($user['email'])->send(new DeletedUserMail($pdf));
    }
}
