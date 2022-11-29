<?php

namespace Tests\Unit;

use App\Models\ResetPassword;
use App\Models\User;
use App\Services\RecoveryPasswordService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class RecoveryPasswordServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_recovery_password_service()
    {
        $updatePassword = new RecoveryPasswordService();
        $data = [
            'user_id' => 1,
            'token' => Str::random(50)
        ];
        $recovery = ResetPassword::create($data);
        $update = [
            $recovery['token'],
            'password' => 'test1234',
            'password_confirmation' => 'test1234'
        ];
            $user= User::create([
                'email' => 'test@test.com',
                'password' => 'TestTest',
                'password_confirmation' => 'TestTest'
            ]);
            $user->update([
                'password'=> $update['password']
            ]);
             $recovery->delete();
        }
    }
