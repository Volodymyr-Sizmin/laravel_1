<?php

namespace Tests\Feature;

use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testResetPassword()
    {
        $data= ['email' => 'test@admin.com', 'password' => 'test1234'];
        $user = User::create($data);
        $token = Str::random(50);

        $resetTokenSave = ['user_id' => $user->id, 'token' => $token];

        ResetPassword::create($resetTokenSave);
        $response = $this->postJson('/api/reset', $data);
        $response->assertStatus(200);

    }
}
