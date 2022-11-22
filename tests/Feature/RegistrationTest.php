<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_registration()
    {
        $this->artisan('passport:install');
        $data =  [
            'email' => 'test10@test.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234'
            ];
        $response = $this->postJson('/api/users', $data);
        $response->assertStatus(201);
        $response->assertJsonStructure( ['token']);

    }
}
