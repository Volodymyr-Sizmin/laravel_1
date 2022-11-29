<?php

namespace App\Services;

use App\Models\ResetPassword;
use App\Models\User;
use Carbon\Carbon;

class RecoveryPasswordService
{
    public function updatePassword($data)
    {
        $recovery = ResetPassword::where('token', $data['token'])->first();
        $date1 = Carbon::parse($recovery->created_at);
        $date2 = Carbon::now();
        if ($date1->diffInMinutes($date2)<2){
            $user= User::find($recovery['user_id']);
            $user->update([
                'password'=> $data['password']
            ]);
            return $recovery->delete();
        }
        return response(null, 404);

    }
}
