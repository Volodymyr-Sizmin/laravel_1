<?php

namespace Tests\Feature;

use App\Mail\PasswordResetMail;
use App\Models\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
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
    public function test_reset_password()
    {
        $data= [
            'email' => 'test@admin.com',
            'password' => 'test1234'
        ];
        $user = User::create($data);
        $token = Str::random(50);

        Mail::to($data['email'])->send(new PasswordResetMail($token));

        $store = ResetPassword::updateOrInsert(
            ['user_id' => $user['id']],
            ['token' => $token, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );
        $response = $this->postJson('/api/reset', $data);
        $response->assertStatus(200);

    }
}
