<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class IndexUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexUser()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->getJson('/api/auth/users/');
        $response->assertStatus(200);
    }
}
