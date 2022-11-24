<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create([
            'email' => 'test@admin.com',
            'password' => 'test1234'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@admin.com',
            'password' => 'test1234',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure( ['token']);
    }
}
