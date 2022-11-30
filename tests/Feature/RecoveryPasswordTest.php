<?php

namespace Tests\Feature;

use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $user = User::factory()->create();
        $resetData = [
            'user_id' => $user->id,
            'token' => Str::random(50)
        ];
        ResetPassword::create($resetData);
        $recovery = [
            'token' => $resetData['token'],
            'password' => 'TestTest',
            'password_confirmation' => 'TestTest',
        ];
        $response = $this->postJson('/api/recovery', $recovery);
        $response->assertStatus(200);
    }
}
