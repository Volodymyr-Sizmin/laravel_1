<?php

namespace Tests\Feature;

use App\Mail\PasswordResetMail;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Mockery;
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
        Mail::fake();
        $data= ['email' => 'test@admin.com', 'password' => 'test1234'];
        User::create($data);

        $response = $this->postJson('/api/reset', $data);
        Mail::assertSent(PasswordResetMail::class);
        $this->assertCount(1, ResetPassword::all());
        $response->assertStatus(200);
    }
}
