<?php

namespace Tests\Unit;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user()
    {
        $this->artisan('passport:install');

        $create = new UserService();
        $data = [
            'email' => 'test20@test.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234'
        ];

        $create->createUser($data);

        $this->assertDatabaseHas('users', [
            'email'=>'test20@test.com'
        ]);

        $this->assertInstanceOf(UserService::class, $create);

    }
}
