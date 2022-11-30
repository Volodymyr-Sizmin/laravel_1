<?php

namespace Tests\Unit;

use App\Models\ResetPassword;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdatePasswordUserServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testRecoveryPassword()
    {
        $userService = new UserService();
        $user = User::factory()->create();
        $resetPasswordData = [
            'user_id' => $user->id,
            'token' => Str::random(50)
        ];
        ResetPassword::create($resetPasswordData);
        $data = [
            'token' => $resetPasswordData['token'],
            'password' => 'test1234',
            'password_confirmation' => 'test1234'
        ];
        $userService->updatePassword($data);

        $this->assertInstanceOf(UserService::class, $userService);
    }
}
