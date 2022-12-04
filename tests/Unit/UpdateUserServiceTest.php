<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $userService = new UserService();
        $this->artisan('passport:install');
        $user = User::factory()->create();

        $data = [
          'email' => 'test@test.com',
          'password' => 'test1234',
          'password_confirmation'=> 'test1234'
        ];

        $userService->updateUser($user, $data );

        $this->assertInstanceOf(UserService::class, $userService);
    }
}
