<?php

namespace Tests\Feature;

use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class RecoveryPasswordTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_recovery_password()
    {
        $resetData = [
            'user_id' => 1,
            'token' => Str::random(50)
        ];
        $store = ResetPassword::create($resetData);
        $data= [
            'email' => 'test@admin.com',
            'password' => 'test1234',
//            'password_confirmation' => 'test1234',
        ];
        User::create($data);
        $recovery = [
            'token' => $resetData['token'],
            'password' => 'TestTest',
            'password_confirmation' => 'TestTest',
        ];
        $store->delete();
        $response = $this->postJson('/api/recovery', $recovery);
        $response->assertStatus(200);
    }
}
