<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $data =  [
            'email' => 'test10@test.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234'
        ];

        $response = $this->putJson('/api/auth/users/{user}', $data );
        $response->assertStatus(200);
    }
}
