<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUserServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $userService = new UserService();
        $this->artisan('passport:install');
        $user = User::factory()->create();

        $userService->deleteUser($user);
        $this->assertDatabaseHas('users', ['status'=>User::INACTIVE]);
    }
}
