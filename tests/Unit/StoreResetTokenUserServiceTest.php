<?php

namespace Tests\Unit;

use App\Models\ResetPassword;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class StoreResetTokenUserServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testStoreResetToken()
    {
        $userService = new UserService();

        $user = User::factory()->create();

        $data = ['email' => $user->email];

        $userService->storeResetToken($data);

        $token = Str::random(50);
        ResetPassword::create([
            'user_id' => $user->id,
            "token" => $token
        ]);
        $this->assertDatabaseHas('reset_password', ['token'=>$token]);

    }
}
